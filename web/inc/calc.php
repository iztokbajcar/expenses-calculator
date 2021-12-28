<?php
    include "mysql.php";
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = file_get_contents('php://input');
        $array = json_decode($input, true);
        
        $cat = $array["category"];
        if (strlen($cat) == 0) {  // return the sum of all expenses
            echo sumAll();
        } else {
            echo sumByCategory($cat);
        }
    } 
?>