<?php

   define("URL", str_replace("routes.php", "", (isset($_SERVER['HTTPS'])? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

   const HOST_NAME = "localhost";
   const DB_NAME = "oriteddies";
   const USER_NAME = "root";
   const PASSWORD = "admin";
