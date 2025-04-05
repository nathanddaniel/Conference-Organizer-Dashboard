<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Conference Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<?php include 'connectdb.php'; ?>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Navigation</h2>
            <ul>
                <li><a href="view_subcommittee.php">View Members of a Subcommittee</a></li>
                <li><a href="room_students.php">View Students in a Room</a></li>
                <li><a href="schedule_by_day.php">View Conference Schedule by Day</a></li>
                <li><a href="sponsors_list.php">List Sponsors and Their Levels</a></li>
                <li><a href="company_jobs.php">Jobs Posted by a Company</a></li>
                <li><a href="attendee_lists.php">View Attendees by Type</a></li>
                <li><a href="add_attendee.php">Add a New Attendee</a></li>
                <li><a href="total_intake.php">View Conference Income Summary</a></li>
                <li><a href="add_sponsor_company.php">Add a New Sponsor</a></li>
                <li><a href="delete_sponsor_company.php">Delete a Sponsor and Attendees</a></li>
                <li><a href="update_session.php">Update a Session's Time or Location</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="header">
                <h1>Welcome to the Conference Dashboard</h1>
                <img class="logo" src="queens_logo.png" alt="Queen's University Logo">
            </div>

            <p style="margin-top: 1.5rem; color: #6b7280;">
                Use the navigation menu to manage attendees, sessions, sponsors, and more.
            </p>

            <div class="stats-grid">
                <div class="stat-card">
                    <?php
                    $result = $connection->query("SELECT COUNT(*) AS total FROM Attendee");
                    $row = $result->fetch();
                    echo "<h3>{$row['total']}</h3><p>Total Attendees</p>";
                    ?>
                </div>

                <div class="stat-card">
                    <?php
                    $result = $connection->query("SELECT COUNT(*) AS total FROM ConferenceSession");
                    $row = $result->fetch();
                    echo "<h3>{$row['total']}</h3><p>Sessions</p>";
                    ?>
                </div>

                <div class="stat-card">
                    <?php
                    $result = $connection->query("SELECT COUNT(*) AS total FROM Sponsor");
                    $row = $result->fetch();
                    echo "<h3>{$row['total']}</h3><p>Sponsor Representatives</p>";
                    ?>
                </div>

                <div class="stat-card">
                    <?php
                    $result = $connection->query("SELECT COUNT(*) AS total FROM JobAd");
                    $row = $result->fetch();
                    echo "<h3>{$row['total']}</h3><p>Open Job Listings</p>";
                    ?>
                </div>
            </div>

            <div class="image-row">
                <figure class="image-box">
                    <img src="conference_photo.jpg" alt="Conference Photo" class="dashboard-img">
                    <figcaption>A recent session held during the annual conference event.</figcaption>
                </figure>

                <figure class="image-box">
                    <img src="queens_map.png" alt="Campus Map" class="dashboard-img">
                    <figcaption>Location of the conference venue on Queen's University campus.</figcaption>
                </figure>
            </div>
        </div>
    </div>
</body>
</html>
