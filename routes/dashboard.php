<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header('location:../');
}
$userdata = $_SESSION['userdata'];
$candidatesdata = $_SESSION['candidatesdata'];
if ($_SESSION['userdata']['status'] == 0) {
    $status = "<b style='color:red'>Not Voted</b>";
} else {
    $status = "<b style='color:green'>Voted</b>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System-Dashboard</title>
    <link rel="icon" type="image/png" href="../logodone.jpeg"/>
    <link rel="stylesheet" href="../css/stylesheet2.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <div class="mainsection">
        <div class="headersection">
            <a href="../" style="float:left"><button class="back">Back</button> </a>
            <a href="logout.php" style="float:right"><button class="logout"> Logout</button></a>
            <h1>Online Voting System</h1>
        </div>
        <div class="lowersection">
            <div id="profile">
                <center>
                    <h1>Profile</h1>
                </center>
                <center><img src="../uploads/<?php echo $userdata['photo'] ?>" height="150px" width="150px"></center>
                <br><br>
                <p><b>Name: </b><?php echo $userdata['name'] ?></p>
                <br>
                <p><b>Email: </b><?php echo $userdata['email'] ?></p>
                <br>
                <p><b>USN:</b> <?php echo $userdata['usn'] ?></p>
                <br>
                <p><b>Status: </b><?php echo $status ?></p>
            </div>
            <div id="candidate">
                <?php
                if ($_SESSION['candidatesdata']) {
                    $positions = array("President", "Vice President", "Secretary", "Joint Secretary");

                    foreach ($positions as $position) {
                        $candidatesForPosition = array_filter($candidatesdata, function ($candidate) use ($position) {
                            return $candidate['position'] == $position;
                        });

                        if (!empty($candidatesForPosition)) {
                            ?>
                            <div class="position-section">
                                <center><h1><?php echo $position; ?></h1></center>
                                <?php
                                foreach ($candidatesForPosition as $candidate) {
                                    ?>
                                    <div class="each-candidate">
                                        <img style="float:right" src="../uploads/<?php echo $candidate['photo'] ?>" height="100px" width="100px">
                                        <br><b>Candidate name: </b><?php echo $candidate['name'] ?><br><br>
                                        <form action="../api/vote.php" method="post">
                                            <input type="hidden" name="gvotes" value="<?php echo $candidate['votes'] ?>">
                                            <input type="hidden" name="gid" value="<?php echo $candidate['id'] ?>">
                                            <input type="hidden" name="position" value="<?php echo $position; ?>">
                                            
                                            <?php
                                            $buttonName = "votebutton_" . strtolower(str_replace(" ", "_", $position));
                                            $buttonClass = ($_SESSION['userdata']['status'] == 0) ? "vote-button" : "voted-button";

                                            // Check if the user has already voted for this position
                                            if (isset($_SESSION['voted_positions']) && in_array($position, $_SESSION['voted_positions'])) {
                                                $buttonClass = "voted-button";
                                            }
                                            ?>

                                            <input type="submit" name="<?php echo $buttonName; ?>" value="Vote" class="<?php echo $buttonClass; ?>">
                                        </form>
                                    </div>
                                    <hr>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                } else {
                    // Handle the case where there are no candidates.
                    echo "<p>No candidates available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>