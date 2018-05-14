
  <?php

  do_header("View Game");

  require_once 'dbconnect.php';
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  // Check connection
  if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  $query = "SELECT PersonId FROM Player WHERE Active = (SELECT Id FROM Games WHERE WonGame = ?)";

  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $player_id);
  $stmt->execute();
  $stmt->bind_result($game_id);
  $stmt->fetch();
  $stmt->free_result();

  if($stmt->execute() == false)
            {
              die('execute() failed: ' . htmlspecialchars($stmt->error));
              }

  $query = "SELECT PersonId, Height, Weight, Active FROM Player, Games,
  (SELECT Id FROM Games LEFT JOIN PLAY ON Id = Points WHERE StatsPerGame IS NULL AND GameId = ?)
  ORDER BY PersonId


  ";

  $stmt = $db->prepare($query);
  $stmt->bind_param('ii', $game_id, $game_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result(
    $WonGame,
    $OpposingTeam,
    $OpposingTeamScore,
    $LastUpdatedBy
  );
  if($stmt->execute() == false)
            {
              die('execute() failed: ' . htmlspecialchars($stmt->error));
              }
  ?>

  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr class="info">
        <th scope="col">GAME ID</th>
        <th scope="col">PLAYER ID</th>
        <th scope="col">WON GAME</th>
      </tr>
  </thead>

  <?php

  $toggle = "table-active";
  $switch_color = false;
  while ($stmt->fetch()){
    if ($switch_color) {
        $toggle = "table-success";
        $switch_color = false;
      } else {
        $toggle = "table-light";
        $switch_color = true;
      }
    echo "<tr class=\"$toggle\">\n";
    echo "<th scope=\"row\">".$game_id."</th>\n";
    echo "<td>".$player_id."</td>\n";
    echo "<td>".$first_name."</td>\n";
    echo "<td>".$last_name."</td>\n";
    echo "<td>";
    echo "<a name=\"$player_id-$game_id\"  href='addplayer.php?player_id=".$player_id."&game_id=".$game_id."'>ADD</a>";
    echo "<span> / </span>";
    echo "</td>";

    echo "</tr>";
  }
 ?>
</table>

  </body>
</html>
