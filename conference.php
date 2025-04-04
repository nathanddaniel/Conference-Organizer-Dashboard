<!-- conference.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Conference Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .nav-section {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 600px;
            max-width: 100%;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .logo {
            width: 100px;
        }
    </style>
</head>

<?php
include 'connectdb.php';
?>


<body>
    <img class="logo" src="conference_logo.png" alt="Conference Logo">
    <h1>Welcome to the Conference Management Portal</h1>

    <div class="nav-section">
        <h2>Navigation</h2>
        <ul>
            <li><a href="view_subcommittee.php">View Members of a Subcommittee</a></li>
            <li><a href="room_students.php">View Students in a Room</a></li>
            <li><a href="schedule_by_day.php">View Conference Schedule by Day</a></li>
            <li><a href="sponsors_list.php">List Sponsors and Their Levels</a></li>
            <li><a href="company_jobs.php">Jobs Posted by a Company</a></li>
            <li><a href="attendee_lists.php">View Attendees by Type</a></li>
            <li><a href="add_attendee.php">Add a New Attendee</a></li>
            <li><a href="intake_summary.php">View Conference Income Summary</a></li>
            <li><a href="add_sponsor.php">Add a New Sponsor</a></li>
            <li><a href="delete_sponsor.php">Delete a Sponsor and Attendees</a></li>
            <li><a href="update_session.php">Update a Session's Time or Location</a></li>
        </ul>
    </div>
</body>
</html>
