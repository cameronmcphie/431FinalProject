<?php
session_start();
require_once('functions/html_base.php');
do_header("Add Game");
?>

<form method="post" action="addgame_proc.php">
  <div class="form">
    <h2>Add Game Stats</h2>

    <p><label for="oppteam">Opposing Team: </label><br/>
    <input type="text" name="oppteam" id="oppteam" size="30" maxlength="100" required /></p>

    <p><label for="oppteamscore">Opposing Team Score: </label><br/>
    <input type="text" name="oppteamscore" id="oppteamscore" size="3" maxlength="3" required /></p>

    <p><label for="wongame">CSUF Basketball Won? </label><br/>
    <input type="checkbox" name="wongame" id="wongame" /></p>

    <table style="border:1px solid black; border-collapse:collapse;" cellpadding=10>
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Name</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Time on Court</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Points Scored</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Number of Assists</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Number of Rebounds</th>
      </tr>

    <?php
    try {
      require_once('dbconnect.php');
      $db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

      if(mysqli_connect_error() == 0)
        {
          $query = "SELECT FirstName, LastName, Id
                    FROM Person
                    RIGHT JOIN Player
                    ON PersonId = Id
                    WHERE Active = 1";
          $stmt = $db->prepare($query);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($firstname, $lastname, $id);
        }
      else {
        throw new Exception('Was not able to retreive players');
      }
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }


    $fmtstyle = 'style="vertical-align:top; text-align:center; border:1px solid black;"';
    $counter = 0;

    $stmt->data_seek(0);

    while ($stmt->fetch())
    {

      $inputtime = 'input type="text" name="time'.$counter.'" id="time" size="5" maxlength="5" required';
      $inputpoints = 'input type="text" name="points'.$counter.'" id="points" size="3" maxlength="3" required';
      $inputassists = 'input type="text" name="assists'.$counter.'" id="assists" size="3" maxlength="3" required';
      $inputrebounds = 'input type="text" name="rebounds'.$counter.'" id="rebounds" size="3" maxlength="3" required';


      echo "<tr>";
      echo "<td $fmtstyle>$firstname $lastname</td>";
      echo "<td $fmtstyle><$inputtime></td>";
      echo "<td $fmtstyle><$inputpoints></td>";
      echo "<td $fmtstyle><$inputassists></td>";
      echo "<td $fmtstyle><$inputrebounds></td>";
      echo '<input type="hidden" name="id'.$counter.'" value="'.$id.'">';
      echo "</tr>";
      $counter++;
    }
    echo '<input type="hidden" name="numofrows" value="'.$stmt->num_rows.'">';
    ?>
  </table>
  </br>
  <button type="submit">Add Stats</button>

  <?php
    require_once('functions/html_base.php');
    do_footer();
  ?>
