<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Attendee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .form-section {
            display: none;
            margin-top: 15px;
        }
        input, select {
            margin-bottom: 10px;
            width: 100%;
            padding: 8px;
        }
    </style>
    <script>
        function showSection() {
            const type = document.querySelector('input[name="type"]:checked').value;
            document.getElementById("student-section").style.display = type === "student" ? "block" : "none";
            document.getElementById("professional-section").style.display = type === "professional" ? "block" : "none";
            document.getElementById("sponsor-section").style.display = type === "sponsor" ? "block" : "none";
        }
    </script>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Add a New Attendee</h1>

<form method="post" action="add_attendee.php">
    <label>Attendee Type:</label><br>
    <input type="radio" name="type" value="student" onclick="showSection()" required> Student
    <input type="radio" name="type" value="professional" onclick="showSection()"> Professional
    <input type="radio" name="type" value="sponsor" onclick="showSection()"> Sponsor

    <div class="form-section" id="student-section">
        <label>Room Number (optional):</label>
        <select name="room_num">
            <option value="">-- Select a room --</option>
            <?php
            $roomQuery = "SELECT num FROM Room ORDER BY num";
            $rooms = $connection->query($roomQuery);
            while ($r = $rooms->fetch()) {
                echo "<option value=\"{$r['num']}\">Room {$r['num']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-section" id="sponsor-section">
        <label>Company Name:</label>
        <select name="company_name">
            <option value="">-- Select a company --</option>
            <?php
            $compQuery = "SELECT company_name FROM Company ORDER BY company_name";
            $comps = $connection->query($compQuery);
            while ($c = $comps->fetch()) {
                echo "<option value=\"{$c['company_name']}\">{$c['company_name']}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Shared fields -->
    <label>Attendee ID:</label>
    <input type="text" name="attendee_id" required>

    <label>First Name:</label>
    <input type="text" name="fname" required>

    <label>Last Name:</label>
    <input type="text" name="lname" required>

    <label>Registration Fee:</label>
    <input type="number" name="fee" step="0.01" required>

    <input type="submit" value="Add Attendee">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["attendee_id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $fee = $_POST["fee"];
    $type = $_POST["type"];

    // Insert into Attendee table
    $query = "INSERT INTO Attendee VALUES (:id, :fee, :fname, :lname)";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ':id' => $id,
        ':fee' => $fee,
        ':fname' => $fname,
        ':lname' => $lname
    ]);

    // Then insert into the respective role table
    if ($type === "student") {
        $room = $_POST["room_num"] ?: NULL;
        $query2 = "INSERT INTO Student(attendee_id, room_num) VALUES (:id, :room)";
        $stmt2 = $connection->prepare($query2);
        $stmt2->bindParam(':id', $id);
        $stmt2->bindParam(':room', $room);
        $stmt2->execute();
    } elseif ($type === "professional") {
        $query2 = "INSERT INTO Professional(attendee_id) VALUES (:id)";
        $stmt2 = $connection->prepare($query2);
        $stmt2->execute([':id' => $id]);
    } elseif ($type === "sponsor") {
        $company = $_POST["company_name"];
        $query2 = "INSERT INTO Sponsor(attendee_id, company_name) VALUES (:id, :company)";
        $stmt2 = $connection->prepare($query2);
        $stmt2->execute([':id' => $id, ':company' => $company]);
    }

    echo "<p>✅ Attendee successfully added.</p>";
}
$connection = null;
?>

<!-- Go Home Button -->
<p style="margin-top: 30px;">
    <a href="conference.php" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #0077cc;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    "> ↩️ Go Home</a>
</p>

</body>
</html>
