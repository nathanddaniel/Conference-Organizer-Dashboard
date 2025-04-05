<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Sponsoring Company</title>
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

<h1>Delete a Sponsoring Company</h1>

<form method="post" action="delete_sponsor_company.php">
    <label>Select a company to delete:</label>
    <select name="company_name" required>
        <option value="" disabled selected>-- Select a company --</option>
        <?php
        $query = "SELECT company_name FROM Company ORDER BY company_name";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            $name = htmlspecialchars($row["company_name"]);
            echo "<option value=\"$name\">$name</option>";
        }
        ?>
    </select>

    <input type="submit" value="Delete Sponsoring Company">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["company_name"])) {
    $company = $_POST["company_name"];

    try {
        $query = "DELETE FROM Company WHERE company_name = :company";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':company', $company);
        $stmt->execute();

        echo "<p> Successfully deleted <strong>$company</strong> and its associated attendees.</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'> Error: " . $e->getMessage() . "</p>";
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
