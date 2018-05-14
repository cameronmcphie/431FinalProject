<?php
    session_start();
    $numofplayers = htmlspecialchars(trim($_POST['numofrows']));
    $oppteam = htmlspecialchars(trim($_POST['oppteam']));
    $oppteamscore = htmlspecialchars(trim($_POST['oppteamscore']));
    if(isset($_POST['wongame'])) {
      $wongame = 1;
    }
    else{
      $wongame = 0;
    }


    try {
      require_once('dbconnect.php');
      $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

      if (mysqli_connect_error() == 0) {
        $query = "INSERT INTO Games
                  SET WonGame = ?,
                      OpposingTeam = ?,
                      OpposingTeamScore = ?,
                      LastUpdatedBy = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('isii', $wongame, $oppteam, $oppteamscore, $_SESSION['user_id']);
        if($stmt->execute() == false)
          {
            //die('execute() failed: ' . htmlspecialchars($stmt->error));
            throw new Exception('Unable to add game stats.');
          }
      }
      else {
          throw new Exception('Unable to add game stats.');
      }

    $insertid = $db->insert_id;
    $counter = 0;
    while($numofplayers > $counter)
    {
      $time = explode(':', $_POST["time$counter"]);
      if( count($time) >= 2 )
      {
        $minutes = (int)$time[0];
        $seconds = (int)$time[1];
      }
      else if( count($time) == 1 )
      {
        $minutes = (int)$time[0];
        $seconds = null;
      }
      else
      {
        $minutes = null;
        $seconds = null;
      }

      if (mysqli_connect_error() == 0) {
        $query = "INSERT INTO StatsPerGame
                  SET PlayerId = ?,
                      GameId = ?,
                      TimeMin = ?,
                      TimeSec = ?,
                      Points = ?,
                      Assists = ?,
                      Rebounds = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iiiiiii', $_POST["id$counter"], $insertid, $minutes, $seconds, $_POST["points$counter"], $_POST["assists$counter"], $_POST["rebounds$counter"]);
        if($stmt->execute() == false)
          {
            throw new Exception('Unable to add game stats.');
          }
      }
      else {
        throw new Exception('Unable to add game stats.');
      }
      $counter++;
    }

    require_once('functions/html_base.php');
    do_header('Added Game');
    echo 'The game and stats were added successfully!';
    echo '<br><a href="team.php">Return to Home</a><br>';
    do_footer();
  }
    catch (Exception $e) {
      require_once('functions/html_base.php');
      do_header('Problem');
      echo $e->getMessage();
      echo '<br><a href="addgame.php">Try Again</a><br>';
      do_footer();
    }
?>
