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
            $conn -> query("CREATE TABLE IF NOT EXISTS category (id INT(6) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL)");
            $conn -> query("INSERT INTO category (name) VALUES ('Other')");
        }
    }

    function getExpenses() {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT expense.id, DATE_FORMAT(date, \"%d/%m/%Y\") AS Date, description AS Description, amount AS Amount, name AS Category FROM expense INNER JOIN category ON expense.category = category.id");
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        return $result;
    }

    function addExpense($category, $description, $amount) {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("INSERT INTO expense (category, description, amount) VALUES (:cat, :desc, :amount);");
        $sql -> bindParam(":cat", $category, PDO::PARAM_INT);
        $sql -> bindParam(":desc", $description, PDO::PARAM_STR);
        $sql -> bindParam(":amount", $amount, PDO::PARAM_STR);
        $sql -> execute();
    }

    function deleteExpense($id) {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("DELETE FROM expense WHERE id = :id;");
        $sql -> bindParam(":id", $id, PDO::PARAM_INT);
        $sql -> execute();
    }

    function getCategories() {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT * FROM category;");
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        return $result;
    }

    function addCategory($name) {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("INSERT INTO category (name) VALUES (:name);");
        $sql -> bindParam(":name", $name, PDO::PARAM_STR);
        $sql -> execute();
    }

    function sumAll() {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT SUM(amount) AS total FROM expense;");
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        return $result[0]["total"];
    }

    function sumByCategory($cat) {
        $conn = connectToDB("expenses");
        $sql = $conn -> prepare("SELECT SUM(amount) AS total FROM expense WHERE category = :cat;");
        $sql -> bindParam(":cat", $cat, PDO::PARAM_INT);
        $sql -> execute();
        $sql -> setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql -> fetchAll();
        return $result[0]["total"];
    }

?>