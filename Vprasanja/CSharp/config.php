<?php


   define('DB_SERVER', '127.0.0.1');
   define('DB_USERNAME', 'vprasanja');
   define('DB_PASSWORD', 'vprasanja');
   define('DB_DATABASE', 'vprasanja_psia');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


   //
   // define('DB_SERVER', 'localhost');
   // define('DB_USERNAME', 'root');
   // define('DB_PASSWORD', '');
   // define('DB_DATABASE', 'vprasanjaodgovori');
   // $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

?>
