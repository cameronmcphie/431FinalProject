<?php
  session_start();
  require_once('functions/html_base.php');
  do_header("View Game");

  $gameId = $_GET['gameId'];

  require_once 'dbconnect.php';
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  // Check connection
  if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  $query = "SELECT OpposingTeam, OpposingTeamScore, WonGame, SUM(Points)
            FROM Games
            JOIN StatsPerGame
            ON Id = GameId
            Where Id = ?
            GROUP BY OpposingTeam, OpposingTeamScore, WonGame";
 $stmt = $db->prepare($query);
 $stmt->bind_param('i', $gameId);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($opposingteam, $opposingteamscore, $wongame, $csufscore);

while ($stmt->fetch()){
  echo '<div style="text-align: center;">';
  echo "<h1>CSUF vs $opposingteam</h1>";
  echo "<h2>$csufscore - $opposingteamscore</h2>";
  echo "</div>";
}
?>

  <table style="border:1px solid black; border-collapse:collapse;" cellpadding=10>
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Player</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Time on Court</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Points Scored</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Assists</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Rebounds</th>
      </tr>

<?php

$query = "SELECT FirstName,
              		LastName,
                  TimeMin,
                  TimeSec,
                  Points,
                  Assists,
                  Rebounds
              FROM Person
              LEFT JOIN StatsPerGame
              ON Id = PlayerId
              WHERE GameId = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $gameId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($firstname, $lastname, $timemin, $timesec, $points, $assists, $rebounds);

$fmtstyle = 'style="vertical-align:top; text-align:center; border:1px solid black;"';

while ($stmt->fetch()){

  echo "<tr>";
  echo "<td $fmtstyle>$firstname $lastname</td>";
  echo "<td $fmtstyle>$timemin:$timesec</td>";
  echo "<td $fmtstyle>$points</td>";
  echo "<td $fmtstyle>$assists</td>";
  echo "<td $fmtstyle>$rebounds</td>";
  echo "</tr>";
}
 ?>
</table>

<?php
  require_once('functions/html_base.php');
  do_footer();
?>
