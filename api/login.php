<?php
session_start();
include_once 'connect.php';
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['con'], trim($input));
}
@$usn = sanitizeInput($_POST['usn']);
@$password = sanitizeInput($_POST['password']);
@$role = sanitizeInput($_POST['role']);
@$id = sanitizeInput($_POST['id']);

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
                window.location.href = "../loginpage.html";
            });
        });
    </script>
    <?php
    exit(); // Stop further execution
}
if (!preg_match("/^\d[a-zA-Z]{2}\d{2}[a-zA-Z]{2}\d{3}$/", $usn)) {
    showErrorAndRedirect("Enter proper usn.");
}
// Fetch the user record based on usn and role
$sql = mysqli_query($con, "SELECT * FROM user WHERE usn='$usn' AND role='$role'");
if ($sql) {
    if (mysqli_num_rows($sql)) {
        $userdata = mysqli_fetch_array($sql);

        // Verify the input password against the stored hashed password
        if (password_verify(trim($password), trim($userdata['password']))) {
            $candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate'");
            $candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);
            $_SESSION['userdata'] = $userdata;
            $_SESSION['candidatesdata'] = $candidatesdata;
                        // Check if the user is an admin
                        if ($role == 'admin') {
                            ?>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Login successful",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "../api/result.php"; // Redirect to the admin dashboard
                                    });
                                });
                            </script>
                            <?php
                        } else {
                                    if (!isset($_SESSION['voted_positions'])) {
                                        $_SESSION['voted_positions'] = array();
                                    }
                                    $voted_positions_data = array(); // Initialize the variable
                                    if (!empty($usn)) {
                                        $check_voted_positions = mysqli_prepare($con, "SELECT voted_positions_pre, voted_positions_vicepre, voted_positions_sec, voted_positions_jnsec FROM user WHERE usn = ?");
                                        mysqli_stmt_bind_param($check_voted_positions, "s", $usn);
                                        mysqli_stmt_execute($check_voted_positions);
                                        $result = mysqli_stmt_get_result($check_voted_positions);
                                        $voted_positions_data = mysqli_fetch_assoc($result);
                                        mysqli_stmt_close($check_voted_positions);
                                    } else {
                                        showErrorAndRedirect("Invalid USN");
                                    }
                                    
                                    // Set status based on fetched voted positions
                                    if ($voted_positions_data['voted_positions_pre'] == 1 &&
                                        $voted_positions_data['voted_positions_vicepre'] == 1 &&
                                        $voted_positions_data['voted_positions_sec'] == 1 &&
                                        $voted_positions_data['voted_positions_jnsec'] == 1) {
                                        $_SESSION['userdata']['status'] = 1;
                                    } else {
                                        $_SESSION['userdata']['status'] = 0;
                                    }

                            ?>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Login successful",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "../routes/dashboard.php"; // Redirect to the general dashboard
                                    });
                                });
                            </script>
                            <?php
                       }
            } else {
            // Incorrect password
            ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid password",
                        showConfirmButton: true
                    }).then(function() {
                        window.location.href = "../loginpage.html";
                    });
                });
            </script>
            <?php
        }
    } else {
        // No matching user found
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "No matching user found",
                    showConfirmButton: true
                }).then(function() {
                    window.location.href = "../loginpage.html";
                });
            });
        </script>
        <?php
    }
} else {
    // SQL query error
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Error: <?php echo mysqli_error($con); ?>",
                showConfirmButton: true
            }).then(function() {
                window.location.href = "../";
            });
        });
    </script>
    <?php
}
mysqli_close($con);
?>