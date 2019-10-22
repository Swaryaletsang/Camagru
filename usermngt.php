<?php
// $ccc = New dbhandler extends dbhandler();
// $ccc->connect();
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
        $stmt->bindParam(":passwd", $this->passw);
        $stmt->execute();
        echo "qwe";
    }
    public function __destruct(){
        $this->conns = NULL;
    }
}
?>