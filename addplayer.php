<?php
  session_start();
  require_once('functions/html_base.php');
  do_header("Add Player");
?>

<form method="post" action="addplayer_proc.php">

 <div class="form">
    <h2>Register Now</h2>

    <p><label for="email">Email Address:</label><br/>
    <input type="email" name="email" id="email" size="30" maxlength="100" required /></p>

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

    <p><label for="height">Height (In Inches):</label><br/>
    <input type="text" name="height" id="height" size="10" maxlength="10" required /></p>

    <p><label for="weight">Weight (In Pounds):</label><br/>
    <input type="text" name="weight" id="weight" size="10" maxlength="10" required /></p>

    <button type="submit">Add Player</button>

   </div>

  </form>

<?php
  require_once('functions/html_base.php');
  do_footer();
?>
