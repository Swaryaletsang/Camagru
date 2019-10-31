<?php

    class saveimg{
        private $con;

        public function __construct()
        {
            include('./connection.php');
            $this->con = $conn;
        }

        public function saveimg($image, $userid)
        {
            try{
                $sql = 'INSERT INTO userimage (userid, images, timess) VALUES (:users, :images, :timess)';
                $aa = $this->con->prepare($sql);
                $aa->bindParam(':users', $userid);
                $aa->bindParam(':images', $image, PDO::PARAM_LOB);
                $aa->bindParam(':timess', time());
                $aa->execute();
                $sql = 'DELETE FROM tempsave';
                $aa = $this->con->prepare($sql);
                $aa->execute();
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage() . "\n";
            }
        }
    }
?>