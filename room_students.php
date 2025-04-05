<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students in a Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        form, table {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            margin-top: 15px;
            padding: 8px 16px;
            font-size: 16px;
        }

        ul {
            background-color: white;
            padding: 35px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            list-style-type: disc;
            margin-top: 20px;
            margin-left: 0px;
        }
        li {
            padding: 6px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Select a Hotel Room</h1>

<form action="room_students.php" method="post">
    <label for="room_num">Choose a room number:</label><br>
    <select name="room_num" id="room_num" required>
        <option value="" disabled selected>Select one</option>

        <?php
        $query = "SELECT num FROM Room ORDER BY num";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            echo '<option value="' . $row["num"] . '">' . $row["num"] . '</option>';
        }
        ?>
    </select><br><br>
    <input type="submit" value="View Students">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["room_num"])) {
    $roomNum = $_POST["room_num"];

    echo "<h2>Students in Room $roomNum</h2>";

    $query = 'SELECT A.attendee_id, A.fname, A.lname 
              FROM Attendee A
              JOIN Student S ON A.attendee_id = S.attendee_id
              WHERE S.room_num = :roomNum';

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':roomNum', $roomNum);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch()) {
            echo "<li>{$row['fname']} {$row['lname']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No students found in this room.</p>";
    }
}
$connection = null;
?>

<p style="margin-top: 30px;">
    <a href="conference.php" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #0077cc;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    ">Go Back</a>
</p>

</body>
</html>
