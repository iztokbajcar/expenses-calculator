<?php
    include "mysql.php";
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = file_get_contents('php://input');
        $array = json_decode($input, true);
        
        $cat = $array["category"];
        $desc = $array["description"];
        $amount = $array["amount"];

        addExpense($cat, $desc, $amount);
    }
?>