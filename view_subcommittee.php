<!-- view_subcommittee.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Subcommittee Members</title>
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

<?php
include 'connectdb.php';
?>

<h1>Select a Subcommittee</h1>

<form action="view_subcommittee.php" method="post">
    <label for="subcommittee">Choose a subcommittee:</label><br>
    <select name="subcommittee_name" id="subcommittee" required>
        <option value="" disabled selected>Select one</option>

        <?php
        // Populate dropdown menu from database
        $query = "SELECT subcommittee_name FROM Subcommittee ORDER BY subcommittee_name";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            echo '<option value="' . $row["subcommittee_name"] . '">' . $row["subcommittee_name"] . '</option>';
        }
        ?>
    </select><br><br>
    <input type="submit" value="View Members">
</form>

<?php
// If a subcommittee has been selected and submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subcommittee_name"])) {
    $selected = $_POST["subcommittee_name"];

    echo "<h2>Members of '$selected'</h2>";

    $query = 'SELECT Member.fname, Member.lname 
              FROM Member
              JOIN Subcommittee_Member ON Member.member_id = Subcommittee_Member.member_id
              WHERE Subcommittee_Member.subcommittee_name = :selected';

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':selected', $selected);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table><tr><th>First Name</th><th>Last Name</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr><td>{$row['fname']}</td><td>{$row['lname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No members found for this subcommittee.</p>";
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
    ">↩️ Go Home</a>
</p>

</body>
</html>
