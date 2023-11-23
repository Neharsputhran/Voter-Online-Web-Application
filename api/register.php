<?php
    include 'connect.php';
    // echo "</pre>";print_r($_POST);
    // exit;

//     if(isset($image ) ||isset($temp_name ))
// {
    @$name = $_POST['name'];
    @$mobile = $_POST['mobile'];
    @$password = $_POST['password'];
    @$comfirm = $_POST['comfirm'];
    @$usn = $_POST['usn'];
    @$image = $_FILES['name']['photo'];
    @$temp_name = $_FILES['temp_name']['photo'];
    @$role = $_POST['role'];

    if($password==$comfirm)
    {
                move_uploaded_file($temp_name, "../uploads/$image");
                $insert = mysqli_query($con, "INSERT INTO user (name, mobile, password, usn, photo, role, status, votes) VALUES ('$name','$mobile','$password','$usn','$image','$role',0,0)");
                if($insert)
                {
                    echo '
                    <script>
                    alert("Registration Successful");
                    window.location= "../index.html";
                    <script> 
                    ';
                }
                else
                {
                    echo '
                    <script>
                    alert("Some error occured!");
                    window.location= "../routes/registration.html";
                    <script> 
                    ';
                }

    }
    else
    {
        echo '
        <script>
           alert("Password doesnot macth with confirm password");
           window.location= "../routes/registration.html";
        <script> 
        ';
    }
// }    
?>