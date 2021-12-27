<?php
    function connect() {
        $conn = new PDO("mysql:host=mysql", "root", getenv("MYSQL_ROOT_PASSWORD"));
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    function connectToDB($dbname) {
        $conn = new PDO("mysql:host=mysql;dbname=" . $dbname, "root", getenv("MYSQL_ROOT_PASSWORD"));
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    // create the database if needed
    function initDB() {
        try {
            $conn = connectToDB("expenses");
        } catch (PDOException $e) {
            $conn = connect();
            $conn -> query("CREATE DATABASE IF NOT EXISTS expenses");
            $conn -> query("USE expenses");
            $conn -> query("CREATE TABLE IF NOT EXISTS expense (id INT(6) AUTO_INCREMENT PRIMARY KEY, description VARCHAR(50), category INT(6) NOT NULL DEFAULT 1, date DATE NOT NULL DEFAULT CURRENT_DATE, amount DECIMAL(7,2) NOT NULL DEFAULT 0.00)");
            $conn -> query("CREATE TABLE IF NOT EXISTS category (id INT(6) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50))");
            $conn -> query("INSERT INTO category (name) VALUES ('Other')");
        }
    }

    function getExpenses() {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT DATE_FORMAT(date, \"%d/%m/%Y\") AS Date, description AS Description, amount AS Amount, name AS Category FROM expense INNER JOIN category ON expense.category = category.id");
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        return $result;
    }

    // describes a key-value array as an HTML table
    function createTableFromArray($array) {
        if (count($array) == 0) {
            return;
        }

        $keys = array_keys($array[0]);

        $res = "<table>";
        $res .= "<tr>";
        for ($i = 0; $i < count($keys); $i++) {
            $res .= "<th>" . $keys[$i] . "</th>";
        }
        $res .= "</tr>";
        for ($i = 0; $i < count($array); $i++) {
            $vals = array_values($array[$i]);
            var_dump($vals);
            $res .= "<tr>";
            for ($j = 0; $j < count($vals); $j++) {
                $res .= "<td>" . $vals[$j] . "</td>";
            }
            $res .= "</tr>";
        }
        $res .= "</table>";
        return $res;
    }
?>