<?php

$email    = htmlspecialchars(trim($_POST['email']));
$username = htmlspecialchars(trim($_POST['username']));

try {
    require_once('dbconnect.php');
    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

    if (mysqli_connect_error() == 0) {
        $query = "SELECT Email, Username
                    FROM Person, Users
                    WHERE Email = ?
                    AND Username = ?";
        $stmt  = $db->prepare($query);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {

            $words = preg_split('//', 'abcdefghi49378', 0);
            shuffle($words);
            $words = substr(implode($words), 0, 16);
            $newPassword = $words;

            $newPassword = sha1($newPassword);
            if(mysqli_connect_error() == 0)
              {
              $query = "UPDATE Users
                        SET Password = ?
                        WHERE Username = ?";
              $stmt  = $db->prepare($query);
              $stmt->bind_param('ss', $newPassword, $username);
              if ($stmt->execute()) {

                $from = "From: quiksilver980@gmail.com \r\n";
                $mesg = "Your CSUF Basketball password has been changed to ".$words."\r\n";
                  if (mail($email, 'CsufBasketBall', $mesg, $from)) {
                      require_once('functions/html_base.php');
                      do_header('Success');
                      echo '<p>Please, check your email for your new password!<p>';
                      echo '<br><a href="index.php">Login</a><br>';
                      do_footer();
                } else {
                    throw new Exception('Could not send email.');
                }
            }
          }
        }
        else {
            throw new Exception('Please try again later.');
        }
    }
}

catch (Exception $e) {
    require_once('functions/html_base.php');
    do_header('Problem');
    echo $e->getMessage();
    echo '<br><a href="forgotpassword.php">Try Again</a><br>';
    do_footer();
}
?>
