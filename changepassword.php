<?php
  session_start();

  require_once('funtions/html_base.php');
  do_header("Forgot Password");
?>

<form action="changepassword_proc.php" method="post">
  <div class="form">
    <h2>Change Your Password</h2>

    <p>
      <label for="currentpassword">Current Password: </label>
      <input type"text" name="currentpassword" id="currentpassword" required>
    <p>
    <p>
      <label for="newpassword">New Password: </label>
      <input type"text" name="newpassword" id="newpassword" required>
    <p>
    <p>
      <label for="newpassword2">Confirm Password: </label>
      <input type"text" name="newpassword2" id="newpassword2" required>
    <p>
    <button type="submit">Change Password</button>
  </div>

<?php
  require_once('funtions/html_base.php');
  do_footer();
 ?>
