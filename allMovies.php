<?php
include 'config.php';
include 'index.php';
?>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
        </tr>
        <body>
            <?php
            $query = ("select mov_id, mov_name, date from movies left outer join date on movies.date_id = date.date_id;");
            $stmt = $con->prepare($query);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>'.$row['mov_id'].'</td>';
                echo '<td>'.$row['mov_name'].'</td>';
                echo '<td>'.$row['date'].'</td>';
                echo '</tr>';
            }
            ?>
    </table>
</body>
</html>
