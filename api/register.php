<?php
include_once 'connect.php';
// print_r($_POST);


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
    ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Oh no!",
                                text: "User with same USN already exist",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "../routes/registration.html";
                            });
                        });
                    </script>
                    <?php
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
                    ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Success!",
                                text: "Registration successful",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "../loginpage.html";
                            });
                        });
                    </script>
                    <?php

                } else {
                    ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Error: ' . mysqli_error($con) . '",
                             
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "../routes/registration.html";
                            });
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error moving uploaded file to destination",
                        
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "../routes/registration.html";
                        });
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error uploading file: ' . $_FILES['photo']['error'] . '",
                      
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "../routes/registration.html";
                    });
                });
            </script>
            <?php
            // Output additional debugging information if needed
            print_r($_FILES);
        }
    } else {
        ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Password does not match with confirm password",
                      
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "../routes/registration.html";
                    });
                });
            </script>
            <?php
    
    }
}

mysqli_close($con);
?>
