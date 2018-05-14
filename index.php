<?php
  session_start();
  // TO ADD
  // If already have session redirect to Team.php
  require_once('functions/html_base.php');
  do_header("Login");
?>
  <h1>Welcome to CSUF BasketBall Stats!</h1>

  <form method="post" action="login_proc.php">

  <div class="login-form">
    <h2>Log In</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="username" id="username" /></p>

    <p><label for="password">Password:</label><br/>
    <input type="password" name="password" id="password" /></p>

    <button type="submit">Log In</button>

    <p><a href="forgotpassword.php">Forgot your password?</a></p>
    <p><a href="register.php">Not a member?</a></p>
  </div>

 </form>

 <?php
   require_once('functions/html_base.php');
   do_footer();
  ?>
