<?php
$name=$_POST['name'];
$email=$_POST['email'];
$feedback=$_POST['feedback'];

$toaddress = "feedback@example.com";
$subject = "Feedback from web site";

$mailcontent = "Customer name: ".filter_var($name)."\n".
               "Customer email: ".$email. "\n".
               "Customer comments:\n".$feedback. "\n";

$fromaddress = "From: webserver@example.com";

mail($toaddress, $subject, $mailcontent, $fromaddress);

?>

<!DOCTYPE html>
<html>
<head>
  <title> CSUF BasketBall - Feedback Submitted</title>
</head>
<body>

  <h1> Feedback submitted </h1>
  <p> Your feedback has been sent. </p>

</body>
</html>
