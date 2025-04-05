<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Conference Schedule by Day</title>
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
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>View Conference Schedule</h1>

<form action="schedule_by_day.php" method="post">
    <label for="session_date">Choose a date:</label><br>
    <select name="session_date" id="session_date" required>
        <option value="" disabled selected>Select a date</option>

        <?php
        $query = "SELECT DISTINCT session_date FROM ConferenceSession ORDER BY session_date";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            $date = $row["session_date"];
            echo "<option value=\"$date\">$date</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="View Schedule">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["session_date"])) {
    $selectedDate = $_POST["session_date"];
    echo "<h2>Schedule for $selectedDate</h2>";

    $query = 'SELECT CS.session_location, CS.stime, CS.etime, A.fname, A.lname
              FROM ConferenceSession CS
              JOIN Speaker S ON CS.speaker_id = S.attendee_id
              JOIN Attendee A ON S.attendee_id = A.attendee_id
              WHERE CS.session_date = :selectedDate
              ORDER BY CS.stime';

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':selectedDate', $selectedDate);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table><tr><th>Time</th><th>Location</th><th>Speaker</th></tr>";
        while ($row = $stmt->fetch()) {
            $time = $row["stime"] . " - " . $row["etime"];
            $location = $row["session_location"];
            $speaker = $row["fname"] . " " . $row["lname"];
            echo "<tr><td>$time</td><td>$location</td><td>$speaker</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>There are no sessions that have been scheduled for this date.</p>";
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
    ">Go Home</a>
</p>

</body>
</html>
