<?php
    //include('./create_table.php');
    require_once("./userauth.php");
    class usermanagment{
        private $conns;
        private $uname;
        private $fullname;
        private $emails;
        private $passwd;
        
        public function __construct()
        {
            include('./connection.php');
            $this->conns = $conn;
        }
        
        public function setdata($uname, $fullname, $email, $passwd)
        {
            $this->uname = $uname;
            $this->firstname = $fullname;
            $this->emails = $email;
            $this->passwd = $passwd;
        }

        public function adduser()
        {
            try{
                $sql = 'INSERT INTO users (username, fullname, email, passwd)
                        VALUES ( :username, :fullname, :email, :passwd)';
                $aa = $this->conns->prepare($sql);
    
                $aa->bindParam(':username', $this->uname);
                $aa->bindParam(':fullname', $this->fullname);
                $aa->bindParam(':email', $this->emails);
                $aa->bindParam(':passwd', $this->passwd);
                $aa->execute();
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage() . "\n";
            }
            $confirm = new userauth();
            $confirm->emailconfo($this->emails);
        }
        
        /* function to delete of remove user from the database /*/  
        public function deluser($userid)
        {   
            try{
                $sql = 'DELETE FROM users WHERE userid=:userid';
                $aa = $this->conns->prepare($sql);
                $aa->bindParam(':userid', $userid);
                $aa->execute();
                echo "Record deleted successfully\n";
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
        
        /* function to update user information in the database */
        public function moduser($userid)
        {   
            try{
                $sql = 'UPDATET users 
                        SET username = :username
                        SET firstname = :fullname
                        SET email = :email
                        SET passwd = :passwd
                        WHERE userid = :userid';
                $aa = $conns->prepare($sql);
                $aa->bindParam(':username', $this->uname);
                $aa->bindParam(':firstname', $this->fullname);
                $aa->bindParam(':email', $this->emails);
                $aa->bindParam(':passwd', $this->passwd);
                $aa->bindParam(':userid', $this->userid);
                $aa->execute();
                echo "Record updated successfully\n";
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
        }

        /* select all data for user from the database */
        public function selectuser($userid)
        {   
            try{
                $sql = 'SELECT * FROM users
                        WHERE userid = :usserid';
                $aa = $this->conns->prepare($sql);
                $aa->bindParam(':userid', $userid);
                $aa->execute();
                //echo "Record selected successfully\n";
                $aa->setFetchMode(PDO::FETCH_ASSOC);
                return ($stmt->fetchAll());
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
        }

        public function __destruct(){
            $conns = NULL;
        }
    }
?>