<?php
session_start();
include_once 'connect.php';
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['con'], trim($input));
}

@$usn = sanitizeInput($_POST['usn']);
@$password = sanitizeInput($_POST['password']);
@$role = sanitizeInput($_POST['role']);

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
                            // For other roles (voter, candidate)
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
        }} else {
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
