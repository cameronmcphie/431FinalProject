<?php
  require_once('functions/html_base.php');
  do_header("Register");
?>

<form method="post" action="register_proc.php">

 <div class="register-form">
    <h2>Register Now</h2>

    <p><label for="email">Email Address:</label><br/>
    <input type="email" name="email" id="email"
      size="30" maxlength="100" required /></p>

    <p><label for="username">Username <br>(max 16 chars):</label><br/>
    <input type="text" name="username" id="username"
      size="16" maxlength="16" required /></p>

    <p><label for="password">Password <br>(between 6 and 16 chars):</label><br/>
    <input type="password" name="password" id="password"
      size="16" maxlength="16" required /></p>

    <p><label for="password2">Confirm Password:</label><br/>
    <input type="password" name="password2" id="password2"
      size="16" maxlength="16" required /></p>

    <p><label for="firstname">First Name:</label><br/>
    <input type="text" name="firstname" id="firstname" size="16" maxlength="30" required /></p>

    <p><label for="lastname">Last Name:</label><br/>
    <input type="text" name="lastname" id="lastname" size="16" maxlength="30" required /></p>

    <p><label for="street">Street:</label><br/>
    <input type="text" name="street" id="street" size="30" maxlength="250" required /></p>

    <p><label for="city">City:</label><br/>
    <input type="text" name="city" id="city" size="30" maxlength="100" required /></p>

    <p><label for="country">Country:</label><br/>
    <input type="text" name="country" id="country" size="30" maxlength="100" required /></p>

    <p><label for="zipcode">Zipcode:</label><br/>
    <input type="text" name="zipcode" id="zipcode" size="10" maxlength="10" required /></p>

    <button type="submit">Register</button>

   </div>

  </form>

<?php
  require_once('functions/html_base.php');
  do_footer();
?>
