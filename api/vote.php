<?php
function exitWithError($message) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: "Error!",
                text: "<?php echo $message; ?>",
                icon: "error",
                confirmButtonText: "OK"
            }).then(function () {
                window.location.href = "../routes/dashboard.php";
            });
        });
    </script>
    <?php
    exit;
}
?>

<?php
session_start();
include 'connect.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get values from the form
    $votes = isset($_POST['gvotes']) ? intval($_POST['gvotes']) : 0;
    $total_votes = $votes + 1;
    $gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $uid = isset($_SESSION['userdata']['id']) ? intval($_SESSION['userdata']['id']) : 0;

    // Check if the user has already voted for this position (using database)
    $check_voted = mysqli_query($con, "SELECT * FROM user WHERE id = $uid");
    $user_data = mysqli_fetch_assoc($check_voted);
    switch ($position) {
        case 'President':
            if ($user_data['voted_positions_pre'] == 1) {
                exitWithError("You have already voted for President.");
            }
            break;
        case 'Vice President':
            if ($user_data['voted_positions_vicepre'] == 1) {
                exitWithError("You have already voted for Vice President.");
            }
            break;
        case 'Secretary':
            if ($user_data['voted_positions_sec'] == 1) {
                exitWithError("You have already voted for Secretary.");
            }
            break;
        case 'Joint Secretary':
            if ($user_data['voted_positions_jnsec'] == 1) {
                exitWithError("You have already voted for Joint Secretary.");
            }
            break;
    }

    // Use prepared statements to prevent SQL injection
    $update_votes = mysqli_prepare($con, "UPDATE user SET votes = ? WHERE id = ?");
    $update_status = mysqli_prepare($con, "UPDATE user SET status = 1 WHERE id = ?");
    $update_voted_positions = mysqli_prepare($con, "UPDATE user SET voted_positions_pre = ?, voted_positions_vicepre = ?, voted_positions_sec = ?, voted_positions_jnsec = ? WHERE id = ?");

    if (!$update_votes || !$update_status || !$update_voted_positions) {
        die('Error in prepared statement: ' . mysqli_error($con));
    }

    // Bind parameters to the prepared statements
    mysqli_stmt_bind_param($update_votes, 'ii', $total_votes, $gid);
    mysqli_stmt_bind_param($update_status, 'i', $uid);

    // Execute the prepared statements
    $result_votes = mysqli_stmt_execute($update_votes);
    $result_status = mysqli_stmt_execute($update_status);

    // ... (rest of the code remains the same)

if ($result_votes && $result_status) {
    // Fetch candidates data after the vote is successful
    $candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate'");
    $candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);

    // Update session data

    $_SESSION['candidatesdata'] = $candidatesdata;

    // Update voted positions in the database (corrected code)
    $position_voted = $_POST['position'];
    $voted_position_value = 1; // Set the value to 1 for the voted position

    // Prepare the appropriate update statement based on position
    if ($position_voted === 'President') {
        $voted_position_name = 'voted_positions_pre';
    } elseif ($position_voted === 'Vice President') {
        $voted_position_name = 'voted_positions_vicepre';
    } elseif ($position_voted === 'Secretary') {
        $voted_position_name = 'voted_positions_sec';
    } elseif ($position_voted === 'Joint Secretary') {
        $voted_position_name = 'voted_positions_jnsec';
    } else {
        die('Invalid position'); // Handle invalid positions
    }

    $update_voted_positions = mysqli_prepare($con, "UPDATE user SET $voted_position_name = ? WHERE id = ?");

    
    // Bind parameters and execute
    mysqli_stmt_bind_param($update_voted_positions, 'ii', $voted_position_value, $uid);
    mysqli_stmt_execute($update_voted_positions);

    $check_voted_positions = mysqli_query($con, "SELECT voted_positions_pre, voted_positions_vicepre, voted_positions_sec, voted_positions_jnsec FROM user WHERE id = $uid");
    $voted_positions_data = mysqli_fetch_assoc($check_voted_positions);

    // Update status based on voted positions
    if ($voted_positions_data['voted_positions_pre'] == 1 &&
        $voted_positions_data['voted_positions_vicepre'] == 1 &&
        $voted_positions_data['voted_positions_sec'] == 1 &&
        $voted_positions_data['voted_positions_jnsec'] == 1) {
        $_SESSION['userdata']['status'] = 1;
    } else {
        $_SESSION['userdata']['status'] = 0;
    }

    // Display SweetAlert instead of redirecting
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>';
    echo 'Swal.fire({
        title: "Success!",
        text: "Your vote has been successfully cast!",
        icon: "success"
    });';
    echo '</script>';
    header('Location: ../routes/dashboard.php');
    exit;
} else {
    // Handle database update errors
    // ...
}

}
?>