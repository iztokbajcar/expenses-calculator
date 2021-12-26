<?php
    // create the database if needed
    function initDB() {
        $conn = new PDO("mysql:host=mysql;", "root", getenv("MYSQL_ROOT_PASSWORD"));
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = <<<EOT
CREATE DATABASE IF NOT EXISTS expenses;
USE expenses;
CREATE TABLE IF NOT EXISTS expense (id INT(6) AUTO_INCREMENT PRIMARY KEY, description VARCHAR(100), category INT(6) NOT_NULL, date DATE NOT NULL);
CREATE TABLE IF NOT EXISTS category (id INT(6) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50));
INSERT INTO category (name) VALUES ("Other");
EOT;
        try {
            $sql = $conn -> prepare($query);
            $sql -> execute();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        } finally {
            $conn = null;
        }
    }
?>