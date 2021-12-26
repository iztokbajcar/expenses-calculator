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
            $conn -> query("CREATE TABLE IF NOT EXISTS expense (id INT(6) AUTO_INCREMENT PRIMARY KEY, description VARCHAR(200), category INT(6) NOT NULL, date DATE NOT NULL)");
            $conn -> query("CREATE TABLE IF NOT EXISTS category (id INT(6) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50))");
            $conn -> query("INSERT INTO category (name) VALUES ('Other')");
        }
    }

    function getAll() {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT * FROM category");
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        var_dump($result);
    }
?>