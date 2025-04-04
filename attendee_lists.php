<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendee Lists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        .section {
            background-color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        ul {
            list-style-type: disc;
            margin-left: 25px;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Conference Attendees</h1>

<div class="section">
    <h2>Students</h2>
    <ul>
        <?php
        $query = "SELECT fname, lname FROM Attendee 
                  JOIN Student ON Attendee.attendee_id = Student.attendee_id";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            echo "<li>{$row['fname']} {$row['lname']}</li>";
        }
        ?>
    </ul>
</div>

<div class="section">
    <h2>Professionals</h2>
    <ul>
        <?php
        $query = "SELECT fname, lname FROM Attendee 
                  JOIN Professional ON Attendee.attendee_id = Professional.attendee_id";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            echo "<li>{$row['fname']} {$row['lname']}</li>";
        }
        ?>
    </ul>
</div>

<div class="section">
    <h2>Sponsors</h2>
    <ul>
        <?php
        $query = "SELECT fname, lname FROM Attendee 
                  JOIN Sponsor ON Attendee.attendee_id = Sponsor.attendee_id";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            echo "<li>{$row['fname']} {$row['lname']}</li>";
        }
        ?>
    </ul>
</div>

<?php $connection = null; ?>

<p style="margin-top: 30px;">
    <a href="conference.php" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #0077cc;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    ">↩️ Go Home</a>
</p>

</body>
</html>
