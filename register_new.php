<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once('funtions/html_base.php');
  require_once('funtions/validate_data.php');

  $email = htmlspecialchars(trim($_POST['email']));
  $username = htmlspecialchars(trim($_POST['username']));
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $firstname = htmlspecialchars(trim($_POST['firstname']));
  $lastname = htmlspecialchars(trim($_POST['lastname']));
  $street = htmlspecialchars(trim($_POST['street']));
  $city = htmlspecialchars(trim($_POST['city']));
  $country = htmlspecialchars(trim($_POST['country']));
  $zipcode = htmlspecialchars(trim($_POST['zipcode']));



  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try   {
    // check forms filled in

    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    // email address not valid
    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    // passwords not the same
    if ($password != $password2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($password) < 6) || (strlen($password) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters. Please go back and try again.');
    }

    // $unamecheck = 'test';
    // attempt to register
    require_once('dbconnect.php');
    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

    if(mysqli_connect_error() == 0)  // Connection succeeded
      {
        $query = "SELECT UserName FROM User WHERE UserName = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
      }
    else {
      throw new Exception('Could not execute query');
    }

    if ($stmt->num_rows > 0) {
      throw new Exception('That username is taken - go back and choose another one.');
    }

    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
    if(mysqli_connect_error() == 0)
      {
        $query = "INSERT INTO Person
                  SET FirstName = ?,
                      LastName = ?,
                      Street = ?,
                      City = ?,
                      Country = ?,
                      Zipcode = ?,
                      Email = ?";
        //$stmt = $db->prepare($query);
        if($stmt = $db->prepare($query)) {
            $stmt->bind_param('sssssss', $firstname, $lastname, $street, $city, $country, $zipcode, $email);
            $stmt->execute();
        }
        else {
          printf('errno: %d, error: %s', $db->errno, $db->error);
          die;
        }

        $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
        $query = "INSERT INTO User
                  SET PersonId = last_insert_id(),
                      Username = ?,
                      Password = ?;";
        if ($stmt = $db->prepare($query))
        {
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        }
        else {
          printf('errno: %d, error: %s', $db->errno, $db->error);
          die;
        }

      }
    else {
      throw new Exception('Could not register you - please try again later.');
    }

    // register session variable
    $_SESSION['valid_user'] = $username;

    // provide link to members page
    do_header('Registration successful');
    echo 'Your registration was successful.';
    echo '<br><a href="index.php">login</a><br>';

   // end page
   do_footer();
  }
  catch (Exception $e) {
     do_header('Problem');
     echo $e->getMessage();
     do_footer();
     exit;
  }
?>
