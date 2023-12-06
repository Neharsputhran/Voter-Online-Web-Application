<?php
session_start();
include 'connect.php';

// Get values from the form
@$votes = $_POST['gvotes'];
@$total_votes = $votes + 1;
@$gid = $_POST['gid'];
@$uid = $_SESSION['userdata']['id']; // Corrected line

// Use prepared statements to prevent SQL injection
$update_votes = mysqli_prepare($con, "UPDATE user SET votes = ? WHERE id = ?");
$update_status = mysqli_prepare($con, "UPDATE user SET status = 1 WHERE id = ?");

mysqli_stmt_bind_param($update_votes, 'ii', $total_votes, $gid);
mysqli_stmt_bind_param($update_status, 'i', $uid);

// Execute the prepared statements
$result_votes = mysqli_stmt_execute($update_votes);
$result_status = mysqli_stmt_execute($update_status);

if ($result_votes && $result_status) {
    // Fetch candidates data after the vote is successful
    $candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate'");
    $candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);

    // Update session data
    $_SESSION['userdata']['status'] = 1;
    $_SESSION['candidatesdata'] = $candidatesdata;

    // Redirect with a success message
    ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Success!",
                                text: "Voted successful",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "../routes/dashboard.php";
                            });
                        });
                    </script>
                    <?php
} else {
    // Handle the case where the update fails
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Some error occured!",
             
                icon: "error",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "../routes/dashboard.php";
            });
        });
    </script>
    <?php
}

// Close the prepared statements and database connection
mysqli_stmt_close($update_votes);
mysqli_stmt_close($update_status);
mysqli_close($con);
?>
