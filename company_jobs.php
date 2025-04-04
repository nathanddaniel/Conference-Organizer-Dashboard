<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jobs by Company</title>
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
            max-width: 700px;
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
            margin-top: 10px;
            padding: 8px 16px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Job Listings</h1>

<form action="company_jobs.php" method="post">
    <label for="company_name">Choose a company:</label><br>
    <select name="company_name" id="company_name">
        <option value="" disabled selected>Select one</option>

        <?php
        // Get all companies for the dropdown
        $query = "SELECT company_name FROM Company ORDER BY company_name";
        $result = $connection->query($query);
        while ($row = $result->fetch()) {
            $name = htmlspecialchars($row["company_name"]);
            echo "<option value=\"$name\">$name</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="view_company_jobs" value="View Jobs">
    <input type="submit" name="view_all_jobs" value="List All Jobs">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["view_company_jobs"]) && !empty($_POST["company_name"])) {
        // Handle company-specific job listings
        $company = $_POST["company_name"];
        echo "<h2>Jobs at $company</h2>";

        $query = 'SELECT title, salary, job_location 
                  FROM JobAd 
                  WHERE company_name = :company';

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':company', $company);
        $stmt->execute();
    } elseif (isset($_POST["view_all_jobs"])) {
        // Handle listing all jobs
        echo "<h2>All Available Jobs</h2>";

        $query = 'SELECT title, salary, job_location, company_name 
                  FROM JobAd 
                  ORDER BY company_name';

        $stmt = $connection->prepare($query);
        $stmt->execute();
    }

    if (isset($stmt) && $stmt->rowCount() > 0) {
        echo "<table><tr><th>Title</th><th>Salary</th><th>Location</th>";
        if (isset($_POST["view_all_jobs"])) echo "<th>Company</th>";
        echo "</tr>";

        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['title']}</td>
                    <td>$" . number_format($row['salary']) . "</td>
                    <td>{$row['job_location']}</td>";
            if (isset($_POST["view_all_jobs"])) {
                echo "<td>{$row['company_name']}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } elseif (isset($stmt)) {
        echo "<p>No job postings found.</p>";
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
