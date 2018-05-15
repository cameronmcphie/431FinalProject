<?php
  require_once('functions/html_base.php');
  do_header("View Players");

  $playerId = $_GET['personId'];

  require_once('dbconnect.php');
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  if(mysqli_connect_error() == 0)
    {
    $query = "SELECT FirstName, LastName
              FROM Person
              WHERE Id = ?;";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $playerId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($firstname, $lastname);
  }


  while ($stmt->fetch()){
    echo "<h1 style=\"text-align: center;\">$firstname $lastname</h1></br>";
  }
?>
<h2>Game Log</h2></br>

<table style="border:1px solid black; border-collapse:collapse;" cellpadding=10>
    <tr>
      <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Opposing Team</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Time on Court</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Points Scored</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Assists</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Rebounds</th>
    </tr>
<?php
  $query = "SELECT OpposingTeam,
            		   TimeMin,
                   TimeSec,
                   Points,
                   Assists,
                   Rebounds
            FROM StatsPerGame
            LEFT JOIN Games
            ON GameId = Id
            WHERE PlayerId = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('i', $playerId);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($opposingteam, $timemin, $timesec, $points, $assists, $rebounds);

  $fmtstyle = 'style="vertical-align:top; text-align:center; border:1px solid black;"';

  while ($stmt->fetch()){

    echo "<tr>";
    echo "<td $fmtstyle>$opposingteam</td>";
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
