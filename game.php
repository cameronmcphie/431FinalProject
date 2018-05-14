<?php
  session_start();
  require_once('functions/html_base.php');
  do_header("View Game");

  require_once 'dbconnect.php';
  $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  // Check connection
  if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  $query = "SELECT OpposingTeam, OpposingTeamScore, WonGame
            FROM Games
            LEFT JOIN Player
            ON PersonId = Id
            WHERE Active = 1";
 $stmt = $db->prepare($query);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($opposingteam, $opposingteamscore, $wongame);


 $query = "SELECT PlayerId, GameId TimeMin, TimeSec, Points, Assists, Rebounds
           FROM StatsPerGame
           LEFT JOIN Person
           ON PersonId = Id";

  $stmt = $db->prepare($query);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result(
    $playerid,
    $gameid,
    $timemin,
    $timesec,
    $points,
    $assists,
    $rebounds
  );


  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr class="info">
        <th scope="col">PLAYER ID</th>
        <th scope="col">GAME ID</th>
        <th scope="col">TIME MIN</th>
        <th scope="col">TIME SEC</th>
        <th scope="col">POINTS</th>
        <th scope="col">ASSISTS</th>
        <th scope="col">REBOUNDS</th>

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
    echo "<td>".$playerid."</td>\n";
    echo "<td>".$gameid."</td>\n";
    echo "<td>".$timemin."</td>\n";
    echo "<td>".$timesec."</td>\n";
    echo "<td>".$points."</td>\n";
    echo "<td>".$assists."</td>\n";
    echo "<td>".$rebounds."</td>\n";
    echo "<span> / </span>";
    echo "</td>";
    echo "</tr>";
  }
 ?>
</table>

  </body>
</html>
