<?php
  require_once('functions/validate_data.php');

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

  try   {


    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    if ($password != $password2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }


    if ((strlen($password) < 6) || (strlen($password) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters. Please go back and try again.');
    }

    require_once('dbconnect.php');
    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

    if(mysqli_connect_error() == 0)
      {
        $query = "SELECT Username FROM Users WHERE Username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
      }
    else {
      throw new Exception('Could not register you - please try again later.');
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
            if($stmt->execute() == false)
            {
              throw new Exception('Could not register you - please try again later.');
            }
        }
        else {
          // printf('errno: %d, error: %s', $db->errno, $db->error);
          // die;
          throw new Exception('Could not register you - please try again later.');
        }

        $id = $db->insert_id;
        $password = sha1($password);
        $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
        $query = "INSERT INTO Users
                  SET PersonId = ?,
                      Username = ?,
                      Password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iss', $id, $username, $password);
        if($stmt->execute() == false)
          {
            //die('execute() failed: ' . htmlspecialchars($stmt->error));
            throw new Exception('Could not register you - please try again later.');
          }
      }
    else {
      throw new Exception('Could not register you - please try again later.');
    }
    require_once('functions/html_base.php');
    do_header('Registration Successful');
    echo 'Your registration was successful.';
    echo '<br><a href="index.php">login</a><br>';
    do_footer();
  }
  catch (Exception $e) {
    require_once('functions/html_base.php');
    do_header('Problem');
    echo $e->getMessage();
    echo '<br><a href="register.php">Try Again</a><br>';
    do_footer();
  }
?>
