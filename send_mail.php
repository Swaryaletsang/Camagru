<?php
    class send_mail{
        public $to;
        public $message;
        public $subject;
        public function __construct($to, $message, $subject){
            $this->to = $to;
            $this->message = $message;
            $this->subject = $subject;
        }
        public function send_mail(){
            mail($this->to, $this->subject, $this->message, "From: camagru@camagru.com");
        }
    }
?>