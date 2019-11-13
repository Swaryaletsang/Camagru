<?php
// $ccc = New dbhandler extends dbhandler();
// $ccc->connect();
include("send_mail.php");
class createuser{
    private $email;
    private $name;
    private $uname;
    private $passw;
    private $conns;
    public function __construct($email, $name, $uname, $passw)
    {
        include('./connection.php');
        $this->conns = $conn;
        $this->email = $email;
        $this->name = $name;
        $this->uname = $uname;
        $this->passw = $passw;
    }    
    public function add_user(){
        $sql = 'INSERT INTO users (username, fullname, email, passwd) VALUES (:username, :fullname, :email, :passwd)';
        $stmt = $this->conns->prepare($sql);
        $stmt->bindParam(":username", $this->uname);
        $stmt->bindParam(":fullname", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwd", hash("md5",$this->passw));
        $stmt->execute();
        $vkey = md5(time());
        $mail = new send_mail("$this->email","<a href=http://localhost:8080/GURUREPO/email_verify.php?vkey=$vkey>click</a>" ,"confirmation");
        $mail->send_mail(); 
        $sql = 'UPDATE users SET vkey = :vkey WHERE username = :username'; echo 'a';
        $stmt = $this->conns->prepare($sql); echo 'b';
        $stmt->bindParam(":vkey", $vkey);  echo 'c';
        $stmt->bindParam(":username", $this->uname);
        $stmt->execute(); echo 'g';
        header("location: message.php");
    }
    public function tbuser()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users(userid  INT(10) AUTO_INCREMENT PRIMARY KEY, username VARCHAR(150) NOT NULL, fullname VARCHAR(150) NOT NULL, email VARCHAR(150) NOT NULL, passwd VARCHAR(150) NOT NULL, vkey VARCHAR(50), verify INT(1) DEFAULT(0), pref TINYINT(1) DEFAULT(1))";
        $stmt = $this->conns->prepare($sql);
        $stmt->execute();
    }
    public function update_profile($id){
        $sql = 'UPDATE users SET username = :username, fullname = :fullname, email = :email, passwd = :passwd WHERE userid = :userid';
        $stmt = $this->conns->prepare($sql);
        $stmt->bindParam(":username", $this->uname);
        $stmt->bindParam(":fullname", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwd", $this->passw);
        $stmt->bindParam(":userid", $id);

        $stmt->execute();
    }
 
    public function __destruct(){
        $this->conns = NULL;
    }
}
class images{
    
    private $conns;
    public function __construct()
    {
        include('./connection.php');
        $this->conns = $conn;
    } 

    public function tbphotos()
    {
        $sql = "CREATE TABLE IF NOT EXISTS photos(id  INT(10) AUTO_INCREMENT PRIMARY KEY, userid  INT(10) NOT NULL, img VARCHAR(150) NOT NULL, txt TEXT, imgDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
        $stmt = $this->conns->prepare($sql);
        $stmt->execute();
    }
    public function uploadImg($uid, $img, $txt)
    {
        echo $uid;
        $sql = 'INSERT INTO photos (userid, images, txt) VALUES (:userid, :img, :txt)';
        $stmt = $this->conns->prepare($sql);
        $stmt->bindParam(":userid", $uid);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":txt", $txt);
        $stmt->execute();
    }
    public function displayImage($userid)
        {
            try{
                $sql = 'SELECT * FROM photos WHERE userid = :userid ORDER BY imgDate DESC';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":userid", $userid);
                $stmt->execute();
                $result = $stmt->FetchAll();
                return $result;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
        }
    public function __destruct(){
        $this->conns = NULL;
    }
    public function deletepost($uid,$pid)
    {
        $sql = 'DELETE FROM userimage WHERE num = :pid AND userid = :users';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":pid", $pid);
                $stmt->bindParam(":users", $uid);
                $stmt->execute();
    }
}

?>