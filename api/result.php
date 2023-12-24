<?php
include 'connect.php';

// Fetch data for all candidates in descending order of votes
$candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate' ORDER BY votes DESC");
$candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);

// Fetch data for the candidate with the highest votes
$topCandidate = mysqli_query($con, "SELECT * FROM user WHERE role='candidate' ORDER BY votes DESC LIMIT 1");
$topCandidateData = mysqli_fetch_assoc($topCandidate);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System - Results</title>
    <link rel="stylesheet" href="../css/result.css">
    <link rel="icon" type="image/png" href="../Online_voting_logo.png"/>
</head>
<body>
    <div class="mainsection">
        <div class="headersection">
            <a href="../" style="float:left"><button class="back">Back</button></a>
            <a  href="../routes/logout.php" style="float:right"><button class="logout"> Logout</button></a>
            <h1>Online Voting System - Results</h1>
        </div>

        <div class="topCandidateSection">
            <center><h2>Winner</h2></center>
            <?php
            if ($topCandidateData) {
                echo "<div>";
                echo "<center><img src='../uploads/" . $topCandidateData['photo'] . "' alt='Top Candidate Photo' style='width: 200px; height: 200px;'></center>";
                echo "<center><p><b>Candidate Name:</b> " . $topCandidateData['name'] . "</p></center>";
                echo "<p style='float:left;'><b>USN:</b> " . $topCandidateData['usn'] . "</p>";
                echo "<p style='float:right;'><b>Votes:</b> " . $topCandidateData['votes'] . "</p>";
                echo "</div>";
            } else {
                echo "<div>No data available</div>";
            }
            ?>
        </div>
        <div class="resultsection">
            <h2>Candidate's Votes</h2>
            <table>
                <tr>
                    <th>Candidate Name</th>
                    <th>Votes</th>
                </tr>
                <?php
                foreach ($candidatesdata as $candidate) {
                    echo "<tr>";
                    echo "<td>" . $candidate['name'] . "</td>";
                    echo "<td>" . $candidate['votes'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>


        
    </div>
</body>
</html>
