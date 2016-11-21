<?php
    require_once __DIR__ . "/class.twt.php";
    
    $twt = new Twt();
    
    /**
      * twitter
      * xauth @username , @password
      *
     **/
     
     echo $twt->__xauth('username', 'password');
     
