<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Sponsor Company</title>
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
            max-width: 500px;
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

<h1>Add a New Sponsoring Company</h1>

<form action="add_sponsor_company.php" method="post">
    <label>Company Name:</label>
    <input type="text" name="company_name" required>

    <label>Sponsorship Level:</label>
    <select name="sponsorship_level" required>
        <option value="">--Select a level--</option>
        <option value="Platinum">Platinum</option>
        <option value="Gold">Gold</option>
        <option value="Silver">Silver</option>
        <option value="Bronze">Bronze</option>
    </select>

    <label>Emails Sent (optional):</label>
    <input type="number" name="emails_sent" min="0">

    <input type="submit" value="Add Company">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = $_POST["company_name"];
    $level = $_POST["sponsorship_level"];
    $emails = $_POST["emails_sent"];

    $emails = ($emails === "") ? null : intval($emails);

    try {
        $query = "INSERT INTO Company (company_name, emails_sent, sponsorship_level)
                  VALUES (:name, :emails, :level)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':name', $company);
        $stmt->bindParam(':emails', $emails);
        $stmt->bindParam(':level', $level);
        $stmt->execute();

        echo "<p> Company <strong>$company</strong> added successfully!</p>";
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
