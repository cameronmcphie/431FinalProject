<?php
  require_once('functions/html_base.php');
  do_header("Forgot Password");
?>

<form action="forgotpassword_proc.php" method="post">

 <div class="form">
    <h2>Forgot Your Password?</h2>

      <p>
        <label for="email">Enter Your Email:</label>
        <br/>
        <input type="text" name="email" id="email" required />
      </p>
      <p>
        <label for="username">Enter Your Username:</label><br/>
        <input type="text" name="username" id="username" required />
      </p>
      <button type="submit">Change Password</button>

   </div>

<?php
  require_once('functions/html_base.php');
  do_footer();
 ?>
