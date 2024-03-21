<?php
include 'connect.php';

// Fetch data for candidates in descending order of votes, grouped by position
$candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate' ORDER BY position, votes DESC");
$candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);

// Group candidates by position
$groupedCandidates = [];
foreach ($candidatesdata as $candidate) {
    $position = $candidate['position'];
    $groupedCandidates[$position][] = $candidate;
}

$desiredOrder = ['President', 'Vice President', 'Secretary', 'Joint Secretary'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <link rel="stylesheet" href="../css/result.css">
    <link rel="icon" type="image/png" href="../logodone.jpeg"/>
</head>
<body>
    <div class="mainsection">
        <div class="headersection">
            <a href="../" style="float:left"><button class="back">Back</button></a>
            <a  href="../routes/logout.php" style="float:right"><button class="logout"> Logout</button></a>
            <h1>Online Voting System</h1>
        </div>

        <center><h1 class="heading">Winners</h1></center>
        <div class="winnersection">
            
        <?php
        // Iterate over the desired order
        foreach ($desiredOrder as $position) {
            if (isset($groupedCandidates[$position])) {
                $candidatesForPosition = $groupedCandidates[$position];
                if (!empty($candidatesForPosition)) {
                    $topCandidateForPosition = $candidatesForPosition[0]; // Assuming the first candidate has the highest vote
                    ?>
                     <div class="topCandidateSection">
                        <center><h2><?php echo $position; ?></h2></center>
                        <?php
                        echo "<div>";
                        echo "<center><img  src='../uploads/" . $topCandidateForPosition['photo'] . "' alt='Top Candidate Photo' style='width: 150px; height: 150px;'></center>";
                        echo "<center><p style='font-size: 20px;'><b>Candidate Name:</b><br> " . $topCandidateForPosition['name'] . "</p></center>";
                        echo "<div class='flex'>";
                        echo "<p><b>USN:</b> " . $topCandidateForPosition['usn'] . "</p>";
                        echo "<p><b>Votes:</b> " . $topCandidateForPosition['votes'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                    </div>
                    <?php
                }
            }
        }
        ?>
        </div>
  
        <!-- Display tables for each position -->
        <?php
        // Iterate over the desired order
        foreach ($desiredOrder as $position) {
            if (isset($groupedCandidates[$position])) {
                $candidatesForPosition = $groupedCandidates[$position];
                ?>
                <div class="resultsection">
                    <h2><?php echo $position; ?></h2>
                    <table>
                        <tr>
                            <th>Candidate photo</th>
                            <th>Candidate Name</th>
                            <th>Candidate USN</th>
                            <th>Votes</th>
                        </tr>
                        <?php
                        foreach ($candidatesForPosition as $candidate) {
                            echo "<tr>";
                            echo "<td data-label='Candidate photo'><img src='../uploads/" . $candidate['photo'] . "' alt='Candidate Photo' style='width: 100px; height: 100px;'></td>";
                            echo "<td data-label='Candidate Name'>" . $candidate['name'] . "</td>";
                            echo "<td data-label='Candidate USN'>" . $candidate['usn'] . "</td>";
                            echo "<td data-label='Votes'>" . $candidate['votes'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                <?php
            }
        }
        ?>
    </div>
</body>
</html>
