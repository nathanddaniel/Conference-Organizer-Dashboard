<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Total Conference Intake</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        table {
            background: white;
            border-collapse: collapse;
            width: 500px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #0077cc;
            color: white;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'connectdb.php'; ?>

<h1>Total Conference Intake</h1>

<?php
$regResult = $connection->query("SELECT SUM(fee) AS total_registration FROM Attendee");
$regRow = $regResult->fetch();
$registrationTotal = $regRow['total_registration'] ?? 0;

$levelRates = [
    "Platinum" => 5000,
    "Gold" => 2500,
    "Silver" => 1000,
    "Bronze" => 500
];

$sponsorshipTotal = 0;
$companyData = [];

$query = "SELECT sponsorship_level, COUNT(*) AS sponsor_count FROM Company GROUP BY sponsorship_level";
$result = $connection->query($query);

while ($row = $result->fetch()) {
    $level = $row["sponsorship_level"];
    $count = $row["sponsor_count"];
    $rate = $levelRates[$level] ?? 0;
    $amount = $count * $rate;
    $sponsorshipTotal += $amount;

    $companyData[] = [
        "level" => $level,
        "count" => $count,
        "rate" => $rate,
        "amount" => $amount
    ];
}
?>

<h2>Registration Fees</h2>
<table>
    <tr><th>Total Collected</th><td>$<?= number_format($registrationTotal, 2) ?></td></tr>
</table>

<h2>Sponsorship Income</h2>
<table>
    <tr>
        <th>Level</th>
        <th>Companies</th>
        <th>Rate</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($companyData as $entry): ?>
    <tr>
        <td><?= $entry['level'] ?></td>
        <td><?= $entry['count'] ?></td>
        <td>$<?= number_format($entry['rate'], 2) ?></td>
        <td>$<?= number_format($entry['amount'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="total">
        <td colspan="3">Total Sponsorship</td>
        <td>$<?= number_format($sponsorshipTotal, 2) ?></td>
    </tr>
</table>

<h2>Total Conference Intake</h2>
<table>
    <tr class="total">
        <td>Total Intake</td>
        <td>$<?= number_format($registrationTotal + $sponsorshipTotal, 2) ?></td>
    </tr>
</table>

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
