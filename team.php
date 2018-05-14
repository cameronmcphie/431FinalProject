<?php
  session_start();
  require_once('functions/html_base.php');
  do_header("CSUF Baskeketball");


  // Add to page
  // Welcome to site name $username (get from session data)

  // Show on the left games with opponent and score that links to the game stats/boxscore
  // Show on the right the team roster try to sort by active and inactive players and show if they are avtive or inactive
  // This should link to a page that shows the individual player with his game stats

  echo $_SESSION['valid_user'];
  echo $_SESSION['user_id'];
  echo $_SESSION['username'];
  echo $_SESSION['role'];
?>
<div class="logged-in-header">
  <a href="changepassword.php">Change Password</a>
  </br>
  <?php
    if($_SESSION['role'] == 1) {
    echo '</br><a href="addplayer.php">Add Player to Roster</a>';
    echo '</br><a href="addgame.php">Add Game Stats</a>';
    }
  ?>

</div>
<div style="text-align: center;">
  <h2>Welcome to CSUF Baskball <?php echo $_SESSION['username']?></h2>
</div>

<div class="team-container">
  <h3>CSUF Baskball Games</h3>
  <?php
  require_once('dbconnect.php');
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  if (mysqli_connect_error() == 0) {
    $query = "SELECT Id, OpposingTeam FROM Games";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($gameId, $oppTeam);
  }
  $stmt->data_seek(0);
  while($stmt->fetch()) {
    echo "<a href=\"game.php?gameId=$gameId\"> CSUF vs. $oppTeam</a></br>";
  }
   ?>
</div>

<div class="team-container" style="float: right;">
  <h3>CSUF Baskball Roster</h3>
  <?php
  require_once('dbconnect.php');
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  if (mysqli_connect_error() == 0) {
    $query = "SELECT PersonId,
              		   FirstName,
                     LastName
              FROM Player
              LEFT JOIN Person
              ON PersonId = Id
              WHERE Active = 1;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($personId, $firstname, $lastname);
  }
  echo "<strong>Active Players</strong></br>";
  $stmt->data_seek(0);
  while($stmt->fetch()) {
    echo "<a href=\"player.php?personId=$personId\">$firstname $lastname</a></br>";
  }


  if (mysqli_connect_error() == 0) {
    $query = "SELECT PersonId,
              		   FirstName,
                     LastName
              FROM Player
              LEFT JOIN Person
              ON PersonId = Id
              WHERE Active = 0;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($personId, $firstname, $lastname);
  }
  echo "</br><strong>Inactive Players</strong></br>";
  $stmt->data_seek(0);
  while($stmt->fetch()) {
    echo "<a href=\"player.php?personId=$personId\">$firstname $lastname</a></br>";
  }
   ?>


</div>


<?php
  require_once('functions/html_base.php');
  do_footer();
 ?>
