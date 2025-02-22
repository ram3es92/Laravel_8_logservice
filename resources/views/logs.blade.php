<!DOCTYPE html>

    <!--<html style="background: #2C2820;">-->

    <head>

        <meta charset="UTF-8">

        <title>Логи</title>

        <style>
            td:nth-child(5),
            td:nth-child(6) {
                text-align: center;
            }

            table {
                position: absolute;
                border-spacing: 0;
                border-collapse: collapse;
                width: 70%;
                box-shadow: 8px 4px 10px rgba(255, 255, 255, 0.25);
            }

            td,
            th {
                padding: 10px;
                border: 1px solid #282828;
            }

            tr:nth-child(odd) {
                background-color: #C18787;
            }

                {
                background-color: #C18787;
            }
        </style>

    </head>

    <body>

        <?php

try {

    $db = new PDO('sqlite:C:\Users\ЕвгенийП\web\gb-laravel-lesson-1\gb-laravel8\log-service\database\database.sqlite');

    $sql = "SELECT id, time, duration, ip, url, method, input FROM logs";

    $statement = $db->prepare($sql);

    $statement->execute();

    $result_array = $statement->fetchAll();

    echo "<div class=\"table\">";

    echo "<table><tr><th>id</th><th>time</th><th>duration</th><th>ip</th><th>url</th><th>method</th><th>input</th></tr>";

    foreach ($result_array as $result_row) {

        echo "<tr>";
        echo "<td align=\"center\">", $result_row["id"] . "</td>";
        echo "<td align=\"center\">" . $result_row["time"] . "</td>";
        echo "<td align=\"center\">" . $result_row["duration"] . "</td>";
        echo "<td align=\"center\">" . $result_row["ip"] . "</td>";
        echo "<td align=\"center\">", $result_row["url"] . "</td>";
        echo "<td align=\"center\">", $result_row["method"] . "</td>";
        echo "<td align=\"center\">" . $result_row["input"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} catch (PDOException $e) {
    echo 'Ошибка при создании записи в базе данных: ' . $e->getMessage();
}

$db = null;

?>


    </body>

</html>