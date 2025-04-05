<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>List of Sponsors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 600px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Sponsoring Companies</h1>

<?php
$query = "SELECT company_name, sponsorship_level FROM Company ORDER BY sponsorship_level DESC";
$result = $connection->query($query);

if ($result->rowCount() > 0) {
    echo "<table>";
    echo "<tr><th>Company Name</th><th>Sponsorship Level</th></tr>";
    while ($row = $result->fetch()) {
        echo "<tr><td>{$row['company_name']}</td><td>{$row['sponsorship_level']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No sponsors found in the system.</p>";
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
    "> Go Back</a>
</p>

</body>
</html>
