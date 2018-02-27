<?php
include 'index.php';
include 'config.php';
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Search</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form method="post">
            Film Index: <input type="text" name="mov_id" placeholder="1,2,3,4,5,6,7"/><br>
            Aktueller Monat: <input type="checkbox" name="cur_month" value="ON"/><br>
            <input type="submit" value="Search" name="search"/>
        </form> 
    </body>

    <?php
    include 'config.php';
    if (isset($_POST['search']) && !isset($_POST['cur_month'])) {
        try {
            $mov_id = $_POST['mov_id'];
            $query = ("select mov_id, mov_name, date from movies
                        left outer join date
                        on movies.date_id = date.date_id
                        where mov_id = :mov_id;");

            $stmt = $con->prepare($query);
            $stmt->bindValue(':mov_id', $mov_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                echo 'Es wurde kein Film gefunden, leider';
            } else {
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Name</th>';
                echo '<th>Date</th>';
                echo '</tr>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['mov_id'] . '</td>';
                    echo '<td>' . $row['mov_name'] . '</td>';
                    echo '<td>' . $row['date'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        } catch (PDOException $ex) {
            echo "Something messed up!"; //Some user friendly message
            write_error_to_log($ex->getMessage()); //This is a function which you can create yourself to write errors to an external log file.
        }
    }
    ?>

    <?php
    include 'config.php';
    if (isset($_POST['search']) && isset($_POST['cur_month'])) {
        try {
            $mov_id = $_POST['mov_id'];
            $query = ("select mov_id, mov_name, date from movies
                        left outer join date
                        on movies.date_id = date.date_id
                        where mov_id = :mov_id
                        AND
                        SUBSTRING(date, 4, 2) = MONTH(CURDATE()) AND SUBSTRING(date, 7, 4) = YEAR(CURDATE());");

            $stmt = $con->prepare($query);
            $stmt->bindValue(':mov_id', $mov_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                echo 'Es wurde kein Film gefunden, leider';
            } else {

                echo '<table border="1">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Name</th>';
                echo '<th>Date</th>';
                echo '</tr>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['mov_id'] . '</td>';
                    echo '<td>' . $row['mov_name'] . '</td>';
                    echo '<td>' . $row['date'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        } catch (PDOException $ex) {
            echo "Something messed up!"; //Some user friendly message
            write_error_to_log($ex->getMessage()); //This is a function which you can create yourself to write errors to an external log file.
        }
    }
    ?>
</html>
