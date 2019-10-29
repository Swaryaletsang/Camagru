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
        $mail = new send_mail("$this->email","<a href=http://localhost:8080/camagru/email_verify.php?vkey=$vkey>click</a>" ,"confirmation");
        $mail->send_mail();
        $sql = 'UPDATE users SET vkey = :vkey WHERE username = :username'; echo 'a';
        $stmt = $this->conns->prepare($sql); echo 'b';
        $stmt->bindParam(":vkey", $vkey);  echo 'c';
        $stmt->bindParam(":username", $this->uname);
        $stmt->execute(); echo 'g';
        header("location: message.php");
        echo "qwe";
    }
    public function tbuser()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users(userid  INT(10) AUTO_INCREMENT PRIMARY KEY, username VARCHAR(150) NOT NULL, fullname VARCHAR(150) NOT NULL, email VARCHAR(150) NOT NULL, passwd VARCHAR(150) NOT NULL, vkey VARCHAR(50), verify INT(1) DEFAULT(0))";
        $stmt = $this->conns->prepare($sql);
        $stmt->execute();
    }
    public function update_profile($id){
        $sql = 'UPDATE users SET username = :username, fullname = :fullname, email = :email, passwd = :passwd WHERE userid = :userid';
        $stmt = $this->conns->prepare($sql);
        $stmt->bindParam(":username", $this->uname);
        $stmt->bindParam(":fullname", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwd", hash("md5",$this->passw));
        $stmt->bindParam(":userid", $id);
        $stmt->execute();
        echo "updated";
    }
    public function __destruct(){
        $this->conns = NULL;
    }
}
?>