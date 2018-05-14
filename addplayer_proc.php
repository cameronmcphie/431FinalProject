<?php

  session_start();
  require_once('functions/validate_data.php');

  $email = htmlspecialchars(trim($_POST['email']));
  $firstname = htmlspecialchars(trim($_POST['firstname']));
  $lastname = htmlspecialchars(trim($_POST['lastname']));
  $street = htmlspecialchars(trim($_POST['street']));
  $city = htmlspecialchars(trim($_POST['city']));
  $country = htmlspecialchars(trim($_POST['country']));
  $zipcode = htmlspecialchars(trim($_POST['zipcode']));
  $height = htmlspecialchars(trim($_POST['height']));
  $weight = htmlspecialchars(trim($_POST['weight']));

  try {

    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    require_once('dbconnect.php');
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
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssssss', $firstname, $lastname, $street, $city, $country, $zipcode, $email);
        $stmt->execute();

        $id = $db->insert_id;

        $query = "INSERT INTO Player
                  SET PersonId = ?,
                      Height = ?,
                      Weight = ?,
                      LastModifiedBy = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iiii', $id, $height, $weight, $_SESSION['user_id']);
        $stmt->execute();
      }
    else {
      throw new Exception('Could not add player - please try again later.');
    }

    require_once('functions/html_base.php');
    do_header('Added Player');
    echo 'The player was added successfully!';
    echo '<br><a href="team.php">Return to Home</a><br>';
    do_footer();

  }
  catch (Exception $e) {
    require_once('functions/html_base.php');
    do_header('Problem');
    echo $e->getMessage();
    echo '<br><a href="addplayer.php">Try Again</a><br>';
    do_footer();
  }
?>
