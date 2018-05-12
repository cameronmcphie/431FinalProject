<?php

function db_connect() {

   $db = new mysqli('localhost', 'User', 'withheld', 'CsufBasketball');

   if (!$result) {
     throw new Exception('Could not connect to database server');
   }
   else {
     return $result;
   }
}
?>
