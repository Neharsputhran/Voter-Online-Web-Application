<?php
   session_start();
   if(!isset($_SESSION['userdata'])){
    header('location:../');
   }
   $userdata = $_SESSION['userdata'];
   $candidatesdata = $_SESSION['candidatesdata'];
   if($_SESSION['userdata']['status']==0){
    $status = "<b style='color:red'>Not Voted</b>";
   }
   else{
    $status = "<b style='color:green'>Voted</b>";
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System-Dashboard</title>
    <link rel="stylesheet" href="../css/stylesheet2.css">
    <link rel="icon" type="image/png" href="../Online_voting_logo.png"/>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="mainsection">
        <div class="headersection">
        <a  href="../" style="float:left"><button class="back">Back</button> </a>
        <a  href="logout.php" style="float:right"><button class="logout"> Logout</button></a>
        <h1>Online Voting System</h1>

        </div>
    
    <div class="lowersection">
    <div id="profile">
        <center><h1>Profile</h1></center>

        <center><img src="../uploads/<?php echo $userdata['photo']?>" height="150px" width="150px"></center>
        <br><br><p><b>Name: </b><?php echo $userdata['name']?></p>
        <br><p><b>Mobile: </b><?php echo $userdata['mobile']?></p>
        <br><p><b>USN:</b> <?php echo $userdata['usn']?></p>
        <br><p><b>Status: </b><?php echo $status?>
</p>
</div>
<div id="candidate">
<center><h1>Candidates List</h1></center>

<?php
if ($_SESSION['candidatesdata']) {
    for ($i = 0; $i < count($candidatesdata); $i++) {
        ?>
        <div class="each">
            <img style="float:right" src="../uploads/<?php echo $candidatesdata[$i]['photo'] ?>" height="100px" width="100px" >
            <br><b>Candidate name: </b><?php echo $candidatesdata[$i]['name'] ?><br><br>
            <b>Votes: </b><?php echo $candidatesdata[$i]['votes'] ?><br>
            <form action="../api/vote.php" method="post">
                <input type="hidden" name="gvotes" value="<?php echo $candidatesdata[$i]['votes'] ?>">
                <input type="hidden" name="gid" value="<?php echo $candidatesdata[$i]['id'] ?>">
                <?php
                if ($_SESSION['userdata']['status'] == 0) {
                    ?>
                    <input type="submit" name="votebutton" value="Vote" id="votebutton">
                    <?php
                } else {
                    ?>
                    <button disabled type="button" id="voted" name="votebutton" value="Voted">Voted</button>
                    <?php
                }
                ?>
            </form>
        </div>
        <hr>
        <?php
    }
} else {
    // Handle the case where there are no candidates.
}
?>


</div>
</div>

    </div>

    
    
    
</body>
</html>