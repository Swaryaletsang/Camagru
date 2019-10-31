<?php

    class userauth{
        private $conns;

        /* connecting to the database */
        public function __construct()
        {
            include('./connection.php');
            $this->conns = $conn;
        }


        /* check if the user provided the correct log in information */
        public function checklogin($uname, $passwd)
        {
            // if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $passwd))
            //      return 0; 
               
            if (preg_match('/[A-Za-z0-9]{6,}/', $uname)){
                try{
                    $a = "1";
                    $sql = 'SELECT * FROM users WHERE username = :uname && passwd = :passwd && OK = :a';
                    $stmt = $this->conns->prepare($sql);
                    $stmt->bindParam(":uname", $uname);
                    $stmt->bindParam(":passwd", $passwd);
                    $stmt->bindParam(":a", $a);
                    $stmt->execute();
                    $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if (count($stmt->fetchAll()))
                        return 1;
                }catch (PDOException $e)
                {
                    echo "Selection failed: " . $e->getMessage();
                }
            }
            if(filter_var($uname, FILTER_VALIDATE_EMAIL)){
                try{
                    $a = "1";
                    $sql = 'SELECT * FROM users WHERE email = :uname && passwd = :passwd && OK = :a';
                    $stmt = $this->conns->prepare($sql);
                    $stmt->bindParam(":uname", $uname);
                    $stmt->bindParam(":passwd", $passwd);
                    $stmt->bindParam(":a", $a);
                    $stmt->execute();
                    $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if (count($stmt->fetchAll()))
                        return 1;
                }catch (PDOException $e)
                {
                    echo "Selection failed: " . $e->getMessage();
                }
             }
             return 0;
        }

        /*  */
        public function getuserid($email)
        {
            try{
                $sql = 'SELECT userid FROM users WHERE email = :email';
                $exe = $this->conns->prepare($sql);
                $exe->bindParam(':email', $email);
                $exe->execute();
                $val = $exe->setFetchMode(PDO::FETCH_ASSOC);
                return ($exe->fetchAll());
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            return (0);
        }

        /*  */
        public function getuserid2($username)
        {
            try{
                $sql = 'SELECT userid FROM users WHERE username = :username';
                $exe = $this->conns->prepare($sql);
                $exe->bindParam(':username', $username);
                $exe->execute();
                $val = $exe->setFetchMode(PDO::FETCH_ASSOC);
                return ($exe->fetchAll());
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            return (0);
        }
        

        /* send email to the user if the $username||$email provided is correct */
        public function passwordreset($email)
        {

            $selec = bin2hex(random_bytes(8));
            $token = bin2hex(random_bytes(32));

            $url = "http://www.localhost:8080/camagru/create_new_password.php?selec=".$selec."&validator=".$token;
            $exp = date("U") + 1800;
            $to = $email;
            $subject = "Reset your passord for camagru";

            $message =  "We revieved a password reset request. The link to reset your password\n";
            $message .= '<a href="'. $url . '">'. $url.'</a>';

            $headers .= "Content-type: text/html\r\n";
            if (mail($to,$subject, $message,$headers))
            {
                $val = $this->getuserid($email);
                try{
                    $sql = 'INSERT INTO auth (userid, selec, token, date)
                            VALUES ( :userid, :selec, :token, :date)';
                    $aa = $this->conns->prepare($sql);
        
                    $aa->bindParam(':userid', $val[0]['userid']);
                    $aa->bindParam(':selec', $selec);
                    $aa->bindParam(':token', $token);
                    $aa->bindParam(':date', $exp);
                    $aa->execute();
                }catch (PDOException $e)
                {
                    echo $sql . "<br>" . $e->getMessage() . "\n";
                }
            }

            //header("location: login.html");

        }
        public function emailconfo($email)
        {
            $selec = bin2hex(random_bytes(32));

            $url = "http://www.localhost:8080/camagru/conf.php?selec=".$selec;
            $to = $email;
            $subject = "Email confirmation link";

            $message =  "The link to comfirm your email\n";
            $message .= '<a href="'. $url . '">'. $url.'</a>';
            $headers = "Content-type: text/html\r\n";
            if (mail($to,$subject, $message,$headers))
            {
                $val = $this->getuserid($email);
                try{
                    $sql = 'INSERT INTO emailconfirm (userid, selec)
                            VALUES ( :userid, :selec)';
                    $aa = $this->conns->prepare($sql);
                    $aa->bindParam(':userid', $val[0]['userid']);
                    $aa->bindParam(':selec', $selec);
                    $aa->execute();
                }catch (PDOException $e)
                {
                    echo $sql . "<br>" . $e->getMessage() . "\n";
                }
            }
        }

        public function checkemail($selec)
        {
            try{
                $sql = 'SELECT userid FROM emailconfirm WHERE selec = :selec;';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":selec", $selec);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $ret = $stmt->fetchAll();
                $sql = "UPDATE users SET OK = 1 WHERE userid=:userid;";
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":userid", $ret[0]['userid']);
                $stmt->execute();
                $sql = 'DELETE FROM emailconfirm WHERE userid = :userid;';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(':userid', $ret[0]['userid']);
                $stmt->execute();
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }


        /*    */
        public function test_user($uname)
        {
            if (!preg_match('/[A-Za-z0-9]{6,}/', $uname))
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

        /*  */
        public function checktoken($selec, $token)
        {
            try{
                $sql = 'SELECT userid FROM auth WHERE selec = :selec && token = :token';
                $exe = $this->conns->prepare($sql);
                $exe->bindParam(':selec', $selec);
                $exe->bindParam(':token', $token);
                $exe->execute();
                $val = $exe->setFetchMode(PDO::FETCH_ASSOC);
                if ($uid = $exe->fetchAll())
                {
                    $sql = 'DELETE FROM auth WHERE selec = :selec && token = :token';
                    $exe = $this->conns->prepare($sql);
                    $exe->bindParam(':selec', $selec);
                    $exe->bindParam(':token', $token);
                    $exe->execute();
                    return $uid;
                }
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            return (0);
        }

        public function updatepass($passwd, $userid, $re_passwd)
        {
            if (strcmp($passwd, $re_passwd))
                return 0;
            try{
                $sql = "UPDATE users SET passwd= :passwd WHERE userid=:userid";
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":passwd", $passwd);
                $stmt->bindParam(":userid", $userid);
                $stmt->execute();
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }

        /* disconnecting from the database */
        function __destruct(){
            $conns = NULL;
        }
    }
?>