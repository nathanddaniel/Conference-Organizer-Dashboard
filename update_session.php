<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Session</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        form {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            font-family: inherit;
        }
        label {
            font-weight: 600;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Update a Conference Session</h1>

<form method="post" action="update_session.php">
    <label>Select Session to Update:</label>
    <select name="old_session" required>
        <option value="" disabled selected>-- Select a session --</option>
        <?php
        $query = "SELECT session_location, session_date, stime FROM ConferenceSession ORDER BY session_date, stime";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            $value = $row['session_location'] . "|" . $row['session_date'] . "|" . $row['stime'];
            $label = "{$row['session_location']} on {$row['session_date']} at {$row['stime']}";
            echo "<option value=\"$value\">$label</option>";
        }
        ?>
    </select>

    <label>New Location:</label>
    <input type="text" name="new_location" required>

    <label>New Date:</label>
    <input type="date" name="new_date" required>

    <label>New Start Time:</label>
    <input type="time" name="new_stime" required>

    <label>New End Time:</label>
    <input type="time" name="new_etime" required>

    <input type="submit" value="Update Session">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["old_session"])) {
    list($old_location, $old_date, $old_stime) = explode("|", $_POST["old_session"]);

    $new_location = $_POST["new_location"];
    $new_date = $_POST["new_date"];
    $new_stime = $_POST["new_stime"];
    $new_etime = $_POST["new_etime"];

    try {
        $fetchSpeaker = $connection->prepare("SELECT speaker_id FROM ConferenceSession WHERE session_location = :loc AND session_date = :date AND stime = :stime");
        $fetchSpeaker->execute([
            ':loc' => $old_location,
            ':date' => $old_date,
            ':stime' => $old_stime
        ]);
        $speakerRow = $fetchSpeaker->fetch();
        $speaker_id = $speakerRow['speaker_id'];

        $delete = $connection->prepare("DELETE FROM ConferenceSession WHERE session_location = :loc AND session_date = :date AND stime = :stime");
        $delete->execute([
            ':loc' => $old_location,
            ':date' => $old_date,
            ':stime' => $old_stime
        ]);

        $insert = $connection->prepare("INSERT INTO ConferenceSession (session_location, session_date, stime, etime, speaker_id) VALUES (:loc, :date, :stime, :etime, :speaker)");
        $insert->execute([
            ':loc' => $new_location,
            ':date' => $new_date,
            ':stime' => $new_stime,
            ':etime' => $new_etime,
            ':speaker' => $speaker_id
        ]);

        echo "<p> Session updated successfully!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'> Error: " . $e->getMessage() . "</p>";
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
