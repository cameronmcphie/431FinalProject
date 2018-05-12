<?php
  session_start();
  // TO ADD
  // If already have session redirect to Team.php
  require_once('funtions/html_base.php');
  do_header("Login");
?>
  <h1>Welcome to CSUF BaskeketBall Stats!</h1>

  <form method="post" action="auth.php">

  <div class="login-form">
    <h2>Log In</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="username" id="username" /></p>

    <p><label for="passwd">Password:</label><br/>
    <input type="password" name="password" id="password" /></p>

    <button type="submit">Log In</button>

    <p><a href="forgot_form.php">Forgot your password?</a></p>
    <p><a href="register.php">Not a member?</a></p>
  </div>

 </form>

 <?php
   require_once('funtions/html_base.php');
   do_footer();
  ?>
