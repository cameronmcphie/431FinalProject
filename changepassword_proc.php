<?php

  session_start();
  require_once('functions/validate_data.php');

  $oldpassword = sha1($_POST['currentpassword']);
  $newpassword = $_POST['newpassword'];
  $newpassword2 = $_POST['newpassword2'];

  try {
    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    if ($newpassword != $newpassword2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    if ((strlen($newpassword) < 6) || (strlen($newpassword) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters. Please go back and try again.');
    }

    require_once('dbconnect.php');
    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

    // Check if it the same password
    if(mysqli_connect_error() == 0)
      {
        $query= "SELECT * FROM Users
                WHERE Username = ?
                AND Password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $_SESSION['username'], $newpassword);
        $stmt->execute();
        $stmt->store_result();
      }
      if ($stmt->num_rows == 1)
      {
        throw new Exception('The new password is the same as the old password.');
      }

      // Set new password
      $newpassword = sha1($newpassword);
      if(mysqli_connect_error() == 0)
      {
        $query = "UPDATE Users
                  SET Password = ?
                  WHERE Username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $newpassword, $_SESSION['username']);
        if($stmt->execute()) {
          require_once('functions/html_base.php');
          do_header("Success");
          echo '<p>Your password has been changed!<p>';
          echo '<br><a href="team.php">Return to Home</a><br>';
          do_footer();
        }
        else {
          throw new Exception('Failed to change password. Please try again later.');
        }
      }
  }
  catch (Exception $e) {
    require_once('functions/html_base.php');
    do_header("Problem");
    echo $e->getMessage();
    echo '<br><a href="changepassword.php">Try Again</a><br>';
    do_footer();
  }


?>
