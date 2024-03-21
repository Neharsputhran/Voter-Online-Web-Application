<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other head elements -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include the connection file
    include __DIR__ . "/connect.php";

    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Check if email exists in the database
        $checkEmailSql = "SELECT * FROM user WHERE email = ?";
        $checkEmailStmt = $con->prepare($checkEmailSql);

        if (!$checkEmailStmt) {
            die('Error in prepare statement: ' . $con->error);
        }

        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $checkEmailResult = $checkEmailStmt->get_result();
        $userExists = $checkEmailResult->fetch_assoc();

        $checkEmailStmt->close();

        if (!$userExists) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: "error",
                        title: "Email not found",
                        showConfirmButton: true
                    }).then(function () {
                        window.location.href = "./passwordreset.php";
                    });
                });
            </script>
        <?php
        } else {
            // Generate token and update the database
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

            $updateTokenSql = "UPDATE user
                            SET resettoken = ?,
                                resettokenexpired = ?
                            WHERE email = ?";

            $updateTokenStmt = $con->prepare($updateTokenSql);

            if (!$updateTokenStmt) {
                die('Error in prepare statement: ' . $con->error);
            }

            $updateTokenStmt->bind_param("sss", $token_hash, $expiry, $email);
            $updateTokenStmt->execute();

            if ($updateTokenStmt->affected_rows) {
                $mail = require __DIR__ . "/mailer.php";

                $mail->setFrom("noreply@example.com");
                $mail->addAddress($email);
                $mail->Subject = "Password Reset Request";

                // Email Body
                $mail->Body = <<<EOT
                    <html>
                    <body>
                        <p>Hello,</p>
                        <p>We received a request to reset your password. If you didn't make this request, you can ignore this email.</p>
                        <p>To reset your password, click the button below:</p>
                        <a href="http://localhost/registration/team_project_final/api/reset_password.php?token=$token" style="display:inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; font-weight: bold; border-radius: 5px;">Reset Password</a>
                        <p>If the button above doesn't work, you can also click on the following link:</p>
                        <a href="http://localhost/registration/team_project_final/api/reset_password.php?token=$token">http://localhost/registration/team_project_final/api/reset_password.php?token=$token</a>
                        <p>This link will expire in 30 minutes for security reasons.</p>
                        <p>If you didn't request a password reset, no further action is needed.</p>
                        <p>Thank you!</p>
                    </body>
                    </html>
                EOT;
                

                
                try {
                    $mail->send();
                    ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "Success!",
                                text: "Email sent successfully!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function () {
                                window.location.href = "./send-password-reset.php"; // Redirect to the admin dashboard
                            });
                        });
                    </script>
                <?php
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                }
            }

            $updateTokenStmt->close();
        }
    } 
    ?><p>Check your mail for reset link</p>
    <?php
    $con->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
