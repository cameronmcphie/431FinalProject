<?php

  $username = htmlspecialchars(trim($_POST['username']));
  $password = sha1($_POST['password']);

try {
  session_start();

  require_once('dbconnect.php');
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);


  if(mysqli_connect_error() == 0)
    {
    $query= "SELECT * FROM Users
            WHERE Username = ?
            AND Password = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid, $username, $password, $role);
    while($stmt->fetch()) {
      $userid = $userid;
      $role = $role;
    }

    if ($stmt->num_rows == 0) {
       throw new Exception('Could not log you in.');
    }

    if ($stmt->num_rows == 1) {
      // Add session variables
      $_SESSION['valid_user'] = true;
      $_SESSION['user_id'] = $userid;
      $_SESSION['username'] = $username;
      $_SESSION['role'] = $role;

      header('Location: team.php');
    } else {
       throw new Exception('Could not log you in.');
    }
  }
}
catch (Exception $e) {
    require_once('functions/html_base.php');
    do_header('Problem');
    echo $e->getMessage();
    echo '<br><a href="index.php">Try Again</a><br>';
    do_footer();
}
?>
