<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineVotingSystem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/png" href="./logodone.jpeg"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins&family=Raleway:ital,wght@1,300&family=Ubuntu:wght@700&family=Yanone+Kaffeesatz&display=swap"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300&display=swap" rel="stylesheet"> 
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background-color: #2AAFB6;
        }

        nav {
            height: 70px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);        
            text-align: right;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: flex-end;
            align-items: center; /* Add this line for vertical center alignment */
        }

        nav ul li {
            margin-right: 20px;
            padding: 10px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-weight: bold;
            text-align: center;
        }

        nav ul li a {
            text-decoration: none;
            color: black;

        }
        .fa-solid.fa-bars{
            font-size: 30px; /* Adjust the size as needed */
        }
        .fa-solid.fa-xmark{
            font-size: 30px;
        }

        nav ul li :hover{
            text-decoration: underline dashed;
            text-underline-offset: 5px;
        }
        .logo{
            float:left;
            height: 80px;
        }
        #openmenu{
            border-radius:50%;
            position: fixed;
            top: 30px;
            right: 40px;
            cursor:pointer;
            z-index: 100;
            display:none;

        }
        #full h2 {

            font-size: 70px;
            font-family: 'Comfortaa', sans-serif; margin-top: 70px;
            margin-left: 40px;
        }

        #full h3 {
            font-size: 30px;
            font-family: 'Chakra Petch', sans-serif; 
            margin-top: 30px;
            margin-left: 40px;
        }

        #full {
            display: flex;
            justify-content: space-between;
            height:100vh;
        }

        .homebg {
            height: 600px;
        }
        .resimg{
            margin-top:120px;
            height:250px;
            width: 250px;
            display: none;
        }
        #canddesc{
            
            min-height:100vh;
            padding: 20px;
        }
        #canddesc h1{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .position-section {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap; 
        }
            .candidate-details {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            display: flex;
            flex-direction: column;
            padding: 20px;
            width: 250px;
            background-color: aliceblue;
            gap: 5px;
            font-size: 15px;
            text-align: left;
            border-radius: 5px;
            margin-bottom:10px;
            transition: transform 0.3s ease; 
        }
        .candidate-details:hover {
            transform: scale(1.1); /* Scale up the size on hover */
            z-index: 1; /* Bring to the front */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle box-shadow on hover */
        }
        .candidate-details p {
            white-space: normal;
            word-wrap: break-word;
        }
        .know{
            font-size:50px;
            font-family:"Lucida Console", "Courier New", monospace;

        }
        #contactsection{
            display: flex;
            align-items: center;
            background-color:#176B87;
            gap: 100px;
            padding:100px;
        }
        .contact-info {
            
            flex: 1;
            text-align: justify;
        }

        .contact-info h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .contact-info p {
            line-height: 1.5;
        }
        form {
            width: 325px;
            /* flex: 1; */
            display: flex;
            flex-direction: column;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        .form-group {
        margin-bottom: 15px;
        }

        .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        }
        input{
            width: 90%;
        }

        input, textarea {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        outline: none;
        }

        textarea {
        height: 150px;
        }

        button {
        background-color: #333;
        color: #fff;
        padding: 10px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        }

        button:hover {
        background-color: #555;
        }
        #closemenu {
            border-radius: 50%;
            position: fixed;
            top: 30px;
            right: 40px;
            cursor: pointer;
            z-index: 100;
            display: none; /* Initially hide the closemenu icon */
        }

       @media(max-width:890px){
            .homebg{
            height:350px;
            width:fit-content;

        }
        nav ul {
            flex-direction: column;
            
        }
        #contactsection{
            display: flex;
            align-items: center;
            /* justify-content: center; */
            gap: 100px;
            padding:60px;
            /* height:100vh; */
            border-radius: 5px;
        }
        .menubox ul li a{
            color:#000;
            text-decoration:none;
        }
        #openmenu{
            display:block;
        }
        .menubox ul {
            list-style: none;
            display: flex;
            text-align:center;
            flex-direction: column;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            height: 100%; /* Fill the entire height */
        }

        .menubox ul li {
            margin-right: 0px;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-size: 30px;
            text-shadow: 0 0 0 #2AAFB6;
        }

        .menubox ul li:hover {
            text-shadow: -3px 3px 0 #2AAFB6;
            transform: translateY(-6px);
        }
        .menubox{
            width:0;
            height:0;
            background:rgba(255, 255, 255, 0.8);
            position: fixed;
            top:0;
            right: 0;
            display: flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            border-bottom-left-radius:100;
            transition:width 0.5s,height 0.5s,border-radius 0.5s;
        }

        .menubox.open-menu{
            width:100%;
            height:100vh;
            border-bottom-left-radius:0;
        }
        }

        @media(max-width:635px){
           
        #full {
            height: fit-content;
            display: inline;
        } 
        .homebg{
            height:350px;
            width:fit-content;
            float: right;
        }
        h2 {
            font-size: 60px;
        }
        h3 {
            font-size: 20px;
        }
    }
        @media(max-width:480px){
            #canddesc h1{

                font-size:30px;
            }
            #canddecs{
                padding: 30px;
                background-color:#f8f8f8;
            }
            #contactsection{
            display: flex;
            flex-direction:column;
            }
            #full h2 {
                font-size: 50px;
            }
            #full h3 {
                font-size: 25px;
            }
            .homebg{
                display: none;
            }
            .resimg{
                display: inline;
            }
        }
        
    </style>
</head>
<body>
    <nav>
          <img class="logo" src="./logodone-removebg-preview.png" alt="">
            <i id="openmenu" class="fa-solid fa-bars"></i>
            
        <div class="menubox" id="menubox">
        <i id="closemenu" class="fa-solid fa-xmark"></i>
        <ul>
            
            <!-- <li><button onclick="location.href='loginpage.html';">Login</button></li>
            <li><button onclick="location.href='routes/registration.html';">Register</button></li> -->
            <li><a href="routes/registration.html">Register Here!</a></li>
            <li><a href="#canddesc">Know your Candidate</a></li>
            <li><a href="#contactsection">Contact us</a></li>
        </ul>
        </div>
    </nav>
    <div id="full">
        <div class="text">
            <h2>Online Voting System</h2>
            <h3>Cast your valuable votes</h3>
        </div>

        <img class="homebg" src="13091-removebg-preview.png" alt="">
        <center><img class="resimg" src="./votebg-removebg-preview.png" alt=""></center>
    </div>
    <div id="canddesc">
        <br><br>
        <center><h1 class="know">Know your Candidate</h1></center>
        <?php
include_once './api/connect.php';

// Fetch distinct positions from the database
$positionsResult = mysqli_query($con, "SELECT DISTINCT position FROM user WHERE role='candidate'");
$positions = mysqli_fetch_all($positionsResult, MYSQLI_ASSOC);

// Define the desired order of positions
$desiredOrder = ['President', 'Vice President', 'Secretary', 'Joint Secretary'];

?>

<!-- ... (your HTML and CSS code) ... -->


    <?php
    // Loop through each desired position
    foreach ($desiredOrder as $position) {
        // Check if the position exists in the fetched positions
        $positionExists = false;
        foreach ($positions as $positionData) {
            if ($positionData['position'] == $position) {
                $positionExists = true;
                break;
            }
        }

        if ($positionExists) {
            ?>
            <br><br>
            <h1><center><?php echo $position; ?></center></h1><br>
            <div class="position-section">
                <?php
                // Fetch candidates for the current position
                $candidatesResult = mysqli_query($con, "SELECT * FROM user WHERE role='candidate' AND position='$position'");
                $candidatesForPosition = mysqli_fetch_all($candidatesResult, MYSQLI_ASSOC);

                // Display candidate details for the current position
                foreach ($candidatesForPosition as $candidate) {
                    ?>
                    <div class="candidate-details">
                        <center><img src="uploads/<?php echo $candidate['photo']; ?>" alt="Candidate Photo" style="width: 200px; height: 200px; border-radius: 5%;"></center>
                        <p><b>Candidate Name:</b> <?php echo $candidate['name']; ?></p>
                        <p><?php echo $candidate['descript'];?></p>
                        <!-- Add more details as needed -->
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
</div>

<!-- ... (remaining HTML and JavaScript) ... -->

    </div>


    <div id="contactsection">  
  <div class="contact-info">
    <!-- <img src="https://images.unsplash.com/photo-1552058574-d6f0a364fa1c?ixlib=rb-1.2.1&ixid=MnwxMjIzMTE5MHwxYWxlYXNmEER4Y2xlYWN0aWN5ZWxsaWN5LWFuZ3VsZ8&auto=format&fit=crop&w=750&q=80" alt="Modern office building with plants"> -->
    <h2>Reach Out to Us</h2>
    <p>We're always happy to hear from you! <br> Whether you have a question, suggestion, or just want to say hello,<br> feel free to send us a message using the form below.</p>
  </div>
  <form action="https://api.web3forms.com/submit" method="POST">

<input type="hidden" name="access_key" value="0d0afa93-cacf-4e14-8be3-be229b4dc573">
    <div class="form-group">
      <label for="name">Your Name:</label>
      <input type="text" name="name" id="name" required>
    </div>
    <div class="form-group">
      <label for="email">Your Email:</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
      <label for="message">Your Message:</label>
      <textarea name="message" id="message" rows="2" cols="40" required></textarea>
    </div>
    <button type="submit">Send Message</button>
  </form>



    </div>

    <script>
    let menubox = document.getElementById("menubox");
    let openmenu = document.getElementById("openmenu");
    let closemenu = document.getElementById("closemenu");

    openmenu.onclick = function () {
        menubox.classList.add("open-menu");
        openmenu.style.display = "none";
        closemenu.style.display = "block";
    };

    closemenu.onclick = function () {
        menubox.classList.remove("open-menu");
        openmenu.style.display = "block";
        closemenu.style.display = "none";
    };
    
    window.addEventListener("scroll", function () {
        // Get the current scroll position
        let scrollY = window.scrollY || window.pageYOffset;

        // Check if the scroll position is at the top and the window width is less than 890px
        if (scrollY === 0 && window.innerWidth < 890) {
            openmenu.style.display = "block";
        } else {
            openmenu.style.display = "none";
            // Close the menu if it's open when scrolling down
            menubox.classList.remove("open-menu");
            closemenu.style.display = "none";
        }
    });
</script>

    <script src="https://kit.fontawesome.com/f4e815f78b.js" crossorigin="anonymous"></script>
</body>

</html>