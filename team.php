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
<div class = "logged-in-header">
  <a href="changepassword.php">Change Password</a>
  </br>
  <?php
    if($_SESSION['role'] == 1) {
    echo '</br><a href="addplayer.php">Add Player to Roster</a>';
    echo '</br><a href="addgame.php">Add Game Stats</a>';
    }
  ?>
</div>

<?php
  require_once('functions/html_base.php');
  do_footer();
 ?>
