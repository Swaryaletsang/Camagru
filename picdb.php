<?php

class picdb{
    private $co;
    public function __construct()
    {
        include('./connection.php');
        $this->co = $conn;
    }

    public function tempsave($image)
    {
        try{
            $sql = 'INSERT INTO tempsave (images) VALUES (:images)';
            $aa = $this->co->prepare($sql);
            $aa->bindParam(':images', $image, PDO::PARAM_LOB);
            $aa->execute();
        }catch (PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage() . "\n";
        }
    }

    public function getsave()
    {
        try{
            $sql = 'SELECT * FROM tempsave';
            $stmt = $this->co->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }
    public function getall()
    {
        $numperpage = 5;
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * $numperpage) - $numperpage;
        }
        try{
            $sql = "SELECT * FROM userimage ORDER BY timess DESC LIMIT {$page},{$numperpage}";
            $stmt = $this->co->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }
    public function getuser($userid)
    {
        $numperpage = 5;
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * $numperpage) - $numperpage;
        }
        try{
            $sql = "SELECT * FROM userimage WHERE userid = :userid ORDER BY timess DESC LIMIT {$page},{$numperpage}";
            
            // $sql = 'SELECT userimage.images, userimage.timess As time FROM userimage where userimage.userid = ? UNION SELECT photos.images, photos.imgDate As time FROM photos where photos.userid = ? ORDER BY time';
            $stmt = $this->co->prepare($sql);
            $stmt->bindParam(':userid', $userid);
            // $stmt->bindParam(1, $userid);
            // $stmt->bindParam(2, $userid);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }

    public function __distruct()
    {
        $conn = NULL;
    }
}
?>