<?php
if(!isset($_POST['submit']))
{
  //This page should not be accessed directly. Need to submit the form.
  echo "error; you need to submit the form!";
}
$companyname = $_POST['CompanyName'];
$companytwitter = $_POST['CompanyTwitter'];
$companyurl = $_POST['CompanyURL'];
$postername = $_POST['JobPosterName'];
$posteremail = $_POST['JobPosterEmail'];
$jobtitle = $_POST['JobTitle'];
$jobdescript = $_POST['JobDescription'];
$typeofjob = $_POST['typeofjob'];

//Validate first
if(empty($companyname)||empty($posteremail))
{
    echo "Company name and email are mandatory!";
    exit;
}

if(IsInjected($posteremail))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'jobs@chi-p-d.com';
$email_subject = "New ChiPD Job Post";
$email_body = "You have received a new message from $postername at $posteremail. \n".
    "Here are the details:\n $companyname \n $companytwitter \n $companyurl \n $postername \n $posteremail \n $jobtitle \n $jobdescript \n $typeofjob ";

$to = "victoria@chi-p-d.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $posteremail \r\n";
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