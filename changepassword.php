<?php
  session_start();

  require_once('functions/html_base.php');
  do_header("Forgot Password");
?>

<form action="changepassword_proc.php" method="post">
  <div class="form">
    <h2>Change Your Password</h2>

    <p>
      <label for="currentpassword">Current Password: </label>
      <input type="password" name="currentpassword" id="currentpassword" required>
    <p>
    <p>
      <label for="newpassword">New Password: </label>
      <input type="password" name="newpassword" id="newpassword" required>
    <p>
    <p>
      <label for="newpassword2">Confirm New Password: </label>
      <input type="password" name="newpassword2" id="newpassword2" required>
    <p>
    <button type="submit">Change Password</button>
  </div>

<?php
  require_once('functions/html_base.php');
  do_footer();
 ?>
