<?php
include_once 'connect.php';
print_r($_POST);


$name = mysqli_real_escape_string($con, $_POST['name']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$confirm = mysqli_real_escape_string($con, $_POST['confirm']);
$usn = mysqli_real_escape_string($con, $_POST['usn']);
$image = $_FILES['photo']['name'];
$temp_name = $_FILES['photo']['tmp_name'];
$role = mysqli_real_escape_string($con, $_POST['role']);

// Check if the user with the same USN already exists
$check_existing_user = mysqli_query($con, "SELECT * FROM user WHERE usn='$usn'");
if (mysqli_num_rows($check_existing_user) > 0) {
    // User with the same USN already exists
    echo '<script>
            alert("User with the same USN already exists");
            window.location.href = "../routes/registration.html";
          </script>';
} else {
    // User does not exist, proceed with registration
    if ($password == $confirm) {
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $destination = "../uploads/" . basename($image);

            if (move_uploaded_file($temp_name, $destination)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                echo "Hashed Password: $hashed_password, Confirm: $confirm";
                

          $insert = mysqli_query($con, "INSERT INTO user (name, mobile, password, usn, photo, role, status, votes) VALUES ('$name','$mobile','$hashed_password','$usn','$image','$role',0,0)");


                if($insert) {
                    echo '<script>
                            alert("Registration Successful");
                            window.location= "../index.html";
                          </script>';
                } else {
                    echo '<script>
                            alert("Error: ' . mysqli_error($con) . '");
                            window.location.href = "../routes/registration.html";
                          </script>';
                }
            } else {
                echo '<script>
                        alert("Error moving uploaded file to destination");
                        window.location.href = "../routes/registration.html";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Error uploading file: ' . $_FILES['photo']['error'] . '");
                    window.location.href = "../routes/registration.html";
                  </script>';
            // Output additional debugging information if needed
            print_r($_FILES);
        }
    } else {
        echo '<script>
                alert("Password does not match with confirm password"); 
                window.location.href = "../routes/registration.html";
              </script>';
    }
}

mysqli_close($con);
?>
