<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
             margin: 0; padding: 0;
        }
        body{
            height: 100vh;
            background-color:  #2AAFB6;
        }
        form{
            height:fit-content;
            width:300px;
            padding:50px;
            background-color:white;
            margin:60px auto;
            border-radius:10px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .headersection {
            padding: 10px;
            text-align: center;
            height: 100px;
            background-color: rgba(255, 255, 255, 0.5);        
            font-size: 30px;
        }
        #send{
            padding: 5px;
            border-radius:5px;
            background-color:black;
            color:white;
        }
        #email{
            margin-top:10px;
            width:100%;
            padding:5px;
            border-radius:5px;
        }
        @media(max-width:480px){
            .headersection {
                font-size: 15px;
            }
            form{
                width:250px;
            }

        }
    </style>
</head>


<body>
<div class="headersection">
            <h1>Online Voting System</h1>
        </div>
    <form action="./send-password-reset.php" method="POST" enctype="multipart/form-data">
        <h1>Reset password</h1><br>
        Email: <input type="text" name="email" id="email"><br><br>
        <input id="send" name="password_reset_link" type="submit" value="Send Password Reset link">
        <p class="error"><?php if(!empty($msg)){echo $msg;}?></p>

    </form>
</body>
</html>