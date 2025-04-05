<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Attendee</title>
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
        input[type="radio"] {
            width: auto;
        }
        label {
            margin-bottom: 8px;
            display: block;
        }
        .form-section {
            display: none;
        }
        .success {
            background-color: #e0ffe0;
            padding: 10px;
            border: 1px solid #00cc00;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error {
            background-color: #ffe0e0;
            padding: 10px;
            border: 1px solid #cc0000;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
    <script>
        function showSection() {
            const type = document.querySelector('input[name="type"]:checked').value;
            
            document.getElementById("student-section").style.display = "none";
            document.getElementById("sponsor-section").style.display = "none";

            if (type === "student") {
                document.getElementById("student-section").style.display = "block";
            } else if (type === "sponsor") {
                document.getElementById("sponsor-section").style.display = "block";
            }
        }
    </script>

</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Add a New Attendee</h1>

<form method="post" action="add_attendee.php">
    <label><strong>Attendee Type:</strong></label>
    <label><input type="radio" name="type" value="student" onclick="showSection()" required> Student</label>
    <label><input type="radio" name="type" value="professional" onclick="showSection()"> Professional</label>
    <label><input type="radio" name="type" value="sponsor" onclick="showSection()"> Sponsor</label>

    <label><strong>Attendee ID:</strong></label>
    <input type="text" name="attendee_id" required>

    <label><strong>First Name:</strong></label>
    <input type="text" name="fname" required>

    <label><strong>Last Name:</strong></label>
    <input type="text" name="lname" required>

    <label><strong>Registration Fee:</strong></label>
    <input type="number" name="fee" step="0.01" required>

    <div class="form-section" id="student-section">
        <label><strong>Room Number (optional):</strong></label>
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
        <label><strong>Company Name:</strong></label>
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

    <input type="submit" value="Add Attendee">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["attendee_id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $fee = $_POST["fee"];
    $type = $_POST["type"];

    try {
        $stmt = $connection->prepare("INSERT INTO Attendee VALUES (:id, :fee, :fname, :lname)");
        $stmt->execute([
            ':id' => $id,
            ':fee' => $fee,
            ':fname' => $fname,
            ':lname' => $lname
        ]);

        if ($type === "student") {
            $room = $_POST["room_num"] ?: null;
            $stmt2 = $connection->prepare("INSERT INTO Student(attendee_id, room_num) VALUES (:id, :room)");
            $stmt2->bindParam(':id', $id);
            $stmt2->bindParam(':room', $room);
            $stmt2->execute();
        } elseif ($type === "professional") {
            $stmt2 = $connection->prepare("INSERT INTO Professional(attendee_id) VALUES (:id)");
            $stmt2->execute([':id' => $id]);
        } elseif ($type === "sponsor") {
            $company = $_POST["company_name"];
            $stmt2 = $connection->prepare("INSERT INTO Sponsor(attendee_id, company_name) VALUES (:id, :company)");
            $stmt2->execute([':id' => $id, ':company' => $company]);
        }

        echo "<div class='success'> Attendee <strong>$fname $lname</strong> added successfully!</div>";
    } catch (PDOException $e) {
        echo "<div class='error'> Error: " . $e->getMessage() . "</div>";
    }

    $connection = null;
}
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