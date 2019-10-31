<?php
    function auth($login, $passwd)
    {
        if ($login && $passwd)
        {
            $accounts = unserialize(file_get_contents('../private/passwd'));
            $log = "";
            $pass = "";
            
            for($i = 0; $i < count($accounts); $i++)
            {    
                foreach ($accounts[$i] as $key => $value)
                {
                    if ($key == 'login' && $value == $login)
                        $log = $value;
                    elseif ($key == 'passwd' && $value == hash('md5',$passwd))
                        $pass = $value;
                }
            }
            if ($log == $login && $pass == hash('md5', $passwd))
                return 1;
        }else
            return 0;
    }
?>