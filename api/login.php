<?php
session_start();
include_once 'connect.php';

@$usn = $_POST['usn'];
@$password = $_POST['password'];
@$role = $_POST['role'];

// Debugging: Print input values
echo "Input values: USN=$usn, Password=$password, Role=$role<br>";

// Fetch the user record based on usn and role
$sql = mysqli_query($con, "SELECT * FROM user WHERE usn='$usn' AND role='$role'");
if ($sql) {
    if (mysqli_num_rows($sql)) {
        $userdata = mysqli_fetch_array($sql);

        // Debugging: Print hashed password values
        // echo "Stored hashed password: {$userdata['password']}<br>";
        // echo "Hashed input password: " . password_hash($password, PASSWORD_DEFAULT) . "<br>";

        // Verify the input password against the stored hashed password
        if (password_verify(trim($password), trim($userdata['password']))) {
            $candidates = mysqli_query($con, "SELECT * FROM user WHERE role='candidate'");
            $candidatesdata = mysqli_fetch_all($candidates, MYSQLI_ASSOC);
            $_SESSION['userdata'] = $userdata;
            $_SESSION['candidatesdata'] = $candidatesdata;

            echo '<script>
                    alert("Login successful");
                    window.location.href = "../routes/dashboard.php";
                  </script>';
        } else {
            // Incorrect password
            echo '<script>
                    alert("Invalid password"); 
                    window.location.href = "../";
                  </script>';
        }
    } else {
        // No matching user found
        echo '<script>
                alert("No matching user found"); 
                window.location.href = "../";
              </script>';
    }
} else {
    // SQL query error
    echo '<script>
            alert("Error: ' . mysqli_error($con) . '"); 
            window.location.href = "../";
          </script>';
}

mysqli_close($con);
?>
