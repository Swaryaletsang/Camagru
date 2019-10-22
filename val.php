<?php
    class va{
        private $conns;
        public function __construct()
        {
            include('./connection.php');
            $this->conns = $conn;
        }

        /*    */
        public function test_user($uname)
        {
            if (!preg_match('/[A-Za-z0-9]{10}/', $uname))
                return 0;
            try{
                $sql = 'SELECT * FROM users WHERE username = :uname;';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":uname", $uname);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }

        /*     */
        public function test_password($password)
        {
            if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password))
                return 0;
            return 1;
        }

        /*      */
        public function test_email($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return 0;
            try{
                $sql = 'SELECT * FROM users WHERE email = :email;';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }
    }
?>