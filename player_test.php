<!DOCTYPE html>
<html>
  <head>
    <title>schedule</title>
  </head>
  <body>

    <?php
      require_once('./dbconnect.php');
      // Connect to database

      /* Attempt to connect to MySQL database */
      $link = mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

      // Check connection
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      $query = "SELECT
                  Person.Id,
                  Person.FirstName,
                  Person.LastName,
                  Person.Street,
                  Person.City,
                  Person.State,
                  Person.Country,
                  Person.ZipCode,
                  Person.Email

                  COUNT(StatsPerGame.PlayerId),
                  COUNT(StatsPerGame.GameId),
                  AVG(StatsPerGame.TimeMin),
                  AVG(StatsPerGame.TimeSec),
                  AVG(StatsPerGame.Points),
                  AVG(StatsPerGame.Assists),
                  AVG(StatsPerGame.Rebounds)
                FROM Person LEFT JOIN StatsPerGame ON
                  StatsPerGame.PlayerId = Person.ID
                GROUP BY
                  Person.LastName,
                  Person.FirstName
                ORDER BY
                  Person.LastName,
                  Person.FirstName";

      // Prepare, execute, store results, and bind results to local variables
      $stmt = $db->prepare($query);
      // no query parameters to bind
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($Name_ID,
                         $FirstName,
                         $LastName,
                         $Street,
                         $City,
                         $State,
                         $Country,
                         $ZipCode,
                         $Email,

                         $GamesPlayed,
                         $PlayingTimeMin,
                         $PlayingTimeSec,
                         $Points,
                         $Assists,
                         $Rebounds);


       if($stmt->execute() == false)
             {
               die('execute() failed: ' . htmlspecialchars($stmt->error));
               }
       ?>
    <?php
      $row = (int) $stmt->num_rows / 2;
      echo "Total Games:  ".$row. "<br/>";
    ?>


    <table class="table table-bordered table-hover">
      <thead class="thead-dark">
        <tr class="info">
          <th scope="col">CSUF</th>
          <th scope="col">VS</th>
          <th scope="col">OPPTeam</th>
          <th scope="col">PLAYER STATS</th>

        </tr>
      </thead>
      <?php
        // $toggle = "table-active";
        // $switch_color = false;
        while($stmt->fetch()){
          // if ($switch_color) {
          //   $toggle = "table-success";
          //   $switch_color = false;
          // } else {
          //   $toggle = "table-light";
          //   $switch_color = true;
          // }
          // echo "<tr class=\"$toggle\">\n";
          echo "<tr>\n";
          echo "<th scope=\"row\" style=\"background: #ffff004a\">".$FirstName."</th>\n";
          echo "<td style=\"background: #ffff004a\">".$LastName."</td>\n";
          echo "<td style=\"background: #ffff004a\">".$GamesPlayed."</td>\n";

          echo "<td style=\"background: #007cff78\">".$PlayingTimeMin."</td>\n";
          echo "<td style=\"background: #007cff78\">".$PlayingTimeSec."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Points."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Assists."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Rebounds."</td>\n";

          $stmt->fetch();
          echo "<td style=\"background: #007cff78\">".$PlayingTimeMin."</td>\n";
          echo "<td style=\"background: #007cff78\">".$PlayingTimeSec."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Points."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Assists."</td>\n";
          echo "<td style=\"background: #007cff78\">".$Rebounds."</td>\n";
          echo "</tr>";

        }

        $stmt->free_result();

        $link->close();

      ?>

    </table>


  </body>
</html>
