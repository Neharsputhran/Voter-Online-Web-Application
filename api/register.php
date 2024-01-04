<?php
include_once 'connect.php';
// print_r($_POST);

function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['con'], trim($input));
}

// Function to display error message and redirect
function showErrorAndRedirect($errorMessage) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Error!",
                text: "<?php echo $errorMessage; ?>",
                icon: "error",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "../routes/registration.html";
            });
        });
    </script>
    <?php
    exit(); // Stop further execution
}

// Validate and sanitize input
$name = sanitizeInput($_POST['name']);
$mobile = sanitizeInput($_POST['mobile']);
$password = sanitizeInput($_POST['password']);
$confirm = sanitizeInput($_POST['confirm']);
$usn = sanitizeInput($_POST['usn']);
$role = sanitizeInput($_POST['role']);
$role = mysqli_real_escape_string($con, $_POST['role']);
$position = '';
$descript = sanitizeInput($_POST['descript']);

if ($role == 'candidate' && isset($_POST['position'])) {
    $position = sanitizeInput($_POST['position']);

    if (empty($position)) {
        showErrorAndRedirect("Please select a position.");
    }
}


if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
    showErrorAndRedirect("Name should only contain alphabetic characters.");
}

if (!preg_match("/^[0-9]{10}$/", $mobile)) {
    showErrorAndRedirect("Mobile should contain only 10 numeric digits.");
}
if (!preg_match("/^\d[a-zA-Z]{2}\d{2}[a-zA-Z]{2}\d{3}$/", $usn)) {
    showErrorAndRedirect("Enter proper usn.");
}
// Check if the user with the same USN already exists
$check_existing_user = mysqli_query($con, "SELECT * FROM user WHERE usn='$usn'");
if (mysqli_num_rows($check_existing_user) > 0) {
    // User with the same USN already exists
    showErrorAndRedirect("User with the same USN already exists.");
} else {
    // User does not exist, proceed with registration
    if ($password == $confirm) {
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $temp_name = $_FILES['photo']['tmp_name']; // Add this line to get the temporary file name
            $image = $_FILES['photo']['name']; // Add this line to get the original file name        
            $destination = "../uploads/" . basename($image);

            if (move_uploaded_file($temp_name, $destination)) {
                // ... (previous code)

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insert = mysqli_query($con, "INSERT INTO user (name, mobile, password, usn, photo, role, position, descript, status, votes, voted_positions_pre, voted_positions_vicepre, voted_positions_sec, voted_positions_jnsec) VALUES ('$name','$mobile','$hashed_password','$usn','$image','$role','$position','$descript',0,0,0,0,0,0)");

                // ... (remaining code)

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
            // print_r($_FILES);
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
