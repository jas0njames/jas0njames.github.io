<?php
if(!isset($_POST['submit']))
{
  //This page should not be accessed directly. Need to submit the form.
  echo "error; you need to submit the form!";
}
$first = $_POST['FirstName'];
$last = $_POST['LastName'];
$email = $_POST['Email'];
$work = $_POST['Work'];
$workurl = $_POST['WorkURL'];
$portfolio = $_POST['PortfolioURL'];
$twitter = $_POST['TwitterURL'];

//Validate first
if(empty($email)||empty($portfolio))
{
    echo "Email and portfolio are mandatory!";
    exit;
}

if(IsInjected($email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'apply@chi-p-d.com';
$email_subject = "New ChiPD Applicant";
$email_body = "You have received a new message from $first $last at $email. \n".
    "Here are the details:\n $first \n $last \n $email \n $work \n $workurl \n $portfolio \n $twitter ";

$to = "victoria@chi-p-d.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to success page.
header('Location: success.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>