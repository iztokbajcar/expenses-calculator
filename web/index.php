<?php
    include "inc/mysql.php";

    function catsToDropdown($categories) {
        if (count($categories) == 0) {
            return "<select class='form-control' id='category' name='category'><option value='1'>(not available)</option></select>";
        }
        $res = "<select id='category' name='category'>";
        for ($i = 0; $i < count($categories); $i++) {
            $res .= "<option " . (($i == 0) ? "selected " : " ") . "value='" . $categories[$i]["id"] ."'>" . $categories[$i]["name"] . "</option>";
        }
        $res .= "</select>";
        return $res;
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
            if ($keys[$i] != "id") {
                $res .= "<th>" . $keys[$i] . "</th>";
            }
        }
        $res .= "<th></th>";  // delete buttons
        $res .= "</tr>";
        for ($i = 0; $i < count($array); $i++) {
            $vals = array_values($array[$i]);
            $res .= "<tr>";
            for ($j = 0; $j < count($vals); $j++) {
                if ($keys[$j] != "id") {
                    $res .= "<td>" . $vals[$j] . "</td>";
                }
            }
            // delete button
            $res .= "<td style=\"cursor: pointer; font-weight: bolder;\" onclick=\"deleteEntryConfirm(" . $array[$i]["id"] . ", \'" . $array[$i]["Description"] . "\')\">[X]</td>";
            $res .= "</tr>";
        }
        $res .= "</table>";
        return $res;
    }

    function refreshTable() {
        $expenses = getExpenses();
        if (count($expenses) == 0) {
            // Array is empty
            echo "<script>document.getElementById('expenses-table').innerHTML = 'The database is currently empty.';</script>";
        } else {
            if (count($expenses) > 20) {
                
            }
            echo "<script>document.getElementById('expenses-table').innerHTML = '" . createTableFromArray($expenses) . "';</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Expenses calculator</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            h1 {
                text-align: center;
            }

            table {
                border: 5px solid black;
                margin-left: auto;
                margin-right: auto;
                width: 85%;
            }

            th, td {
                border: 1px solid black;
                font-family: monospace;
                padding: 8px;
            }

            th {
                border-bottom: 2px solid black;
                font-size: 20px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1>Expenses calculator</h1>
        <?php 
            initDB();
            $categories = getCategories();
        ?>

        <div class="card" style="padding: 10px;">
            <h2>Add entry</h2>
            <div class="form-group">
                <div class="col-xs-2">
                    <label for="category">Choose category:</label>
                    <?php echo catsToDropdown($categories); ?><br>
                    <label for="description">Enter description:</label>
                    <input id="description" name="description" type="text" maxlength="50" /><br>
                    <label for="description">Enter amount:</label>
                    <input id="amount" name="amount" type="number" min="0.01" value="0.01" step=".01" /><br>
                    <input type="button" value="Add" onclick="addEntry();" />
                </div>
            </div>
        </div>

        <div class="card" style="padding: 10px;">
            <h2>Add category</h2>
            <div class="form-group">
                <div class="col-xs-2">
                    <label for="name">Name:</label>
                    <input id="name" type="text" maxlength="50" /><br>
                    <input type="button" value="Add" onclick="addCategory();" />
                </div>
            </div>
        </div>

        <div id="expenses-table">
        </div>

        <?php refreshTable(); ?>
        <script>
            function addEntry() {
                var cat = document.getElementById("category").value;
                var desc = document.getElementById("description").value;
                var amount = document.getElementById("amount").value;

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location = window.location;  // refresh the page
                    }
                };
                xhr.open("POST", "/inc/addEntry.php", true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify({
                    category: cat,
                    description: desc,
                    amount: amount
                }));
            }

            function addCategory() {
                var name = document.getElementById("name").value;

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location = window.location;  // refresh the page
                    }
                };
                xhr.open("POST", "/inc/addCategory.php", true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify({
                    name: name
                }));
            }

            function deleteEntryConfirm(id, desc) {
                if (confirm("You are about to delete entry '" + desc + "'.\nPress OK to confirm.")) {
                    deleteEntry(id);
                }
            }

            function deleteEntry(id) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location = window.location;  // refresh the page
                    }
                };
                xhr.open("POST", "/inc/deleteEntry.php", true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify({
                    id: id
                }));
            }

        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>