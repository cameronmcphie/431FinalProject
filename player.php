<?php
  require_once('functions/html_base.php');
  do_header("Add Player");
    // Connect to database
    require_once('dbconnect.php');
    $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

    if(mysqli_connect_error() == 0)
      {
      // Build query to retrieve player's name, address, and averaged statistics from the joined Team Roster and Statistics tables
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
                  Person.Name_Last,
                  Person.Name_First
                ORDER BY
                  Person.Name_Last,
                  Person.Name_First";

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

      echo "<p> Number of Players " .$stmt->num_rows."</p>";

      while($stmt->fetch()) {
        echo "<p>Last Name: ".$Name_Last;
        echo "<br /> First Name: ".$Name_First;
        echo "<br /> Street: ".$Street;
        echo "<br /> City: ".$City;
        echo "<br /> State: ".$State;
        echo "<br /> Country: ".$Country;
        echo "<br /> Zipcode: ".$Zipcode;
        echo "<br /> Email: ".$Email."</p>";

      }
    }
  ?>
