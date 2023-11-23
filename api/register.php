<?php
    include_once 'connect.php';

    @$name = $_POST['name'];
    @$mobile = $_POST['mobile'];
    @$password = $_POST['password'];
    @$comfirm = $_POST['comfirm'];
    @$usn = $_POST['usn'];
    @$image = $_FILES['photo']['name'];
    @$temp_name = $_FILES['photo']['tmp_name'];
    @$role = $_POST['role'];

    if($password == $comfirm) {
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $destination = "../uploads" . basename($image);

            if (move_uploaded_file($temp_name, $destination)) {
                $insert = mysqli_query($con, "INSERT INTO user (name, mobile, password, usn, photo, role, status, votes) VALUES ('$name','$mobile','$password','$usn','$image','$role',0,0)");

                if($insert) {
                    echo '<script>
                            alert("Registration Successful");
                            window.location= "../index.html";
                          </script>';
                } else {
                    echo '<script>
                            alert("Some error occurred!");
                            window.location= "../routes/registration.html";
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
                    alert("Error uploading file");
                    window.location.href = "../routes/registration.html";
                  </script>';
        }
    } else {
        echo '<script>
                alert("Password does not match with confirm password"); 
                window.location.href = "../routes/registration.html";
              </script>';
    }
?>