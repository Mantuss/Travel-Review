<?php

$BrowTitle = "Reset Your Password";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require('./config.php');

// if the user submits the email and enters the submit button
if(isset($_POST['submit'])){
// the email is store in an variable
$email = $_POST['email'];
// query to check if the email is in the database or not 
$sql = "SELECT * FROM traveluser WHERE UserName = '$email'";
$checkdb = mysqli_query($conn, $sql) or die( mysqli_error($conn));
$check = mysqli_num_rows($checkdb);
$row = mysqli_fetch_array($checkdb,MYSQLI_ASSOC);

// if the email is in the database the program sends email to the user 
if($check = 1){

    $mail = new PHPMailer(); 
    $mail->From = 'postmaster@sandbox9ba264aa6ce8422b80eeca22bff85f6e.mailgun.org';
    $mail->FromName = 'Travel Project';
    $mail->addAddress('npress.software@gmail.com');     // Add a recipient 
    $mail->addReplyTo('sitaula.nujan@gmail.com');                               // Set email format to HTML
    
    $mail->Subject = 'Password Reset For Travel Project';
    $mail->Body    = 'Your current password is <b>'. $row['Pass'] . '</b>. Login to your account to change your password.';
    
    // if there is any problem sending the mail then it shows error
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } 
    // else there will be a message that the mail has been sent
    else {
        echo 'Message has been sent';
    }
}

// if the email is not in the database then error message is posted in the page
else{
    $errorEmail = "<h1>No User With This Email Found.</h1>";
}
}

?>

// form to reset the users password
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./forgetpassword.php" method="post">
        <input type="email" placeholder="Email" name="email">
        <input type="submit" value="Reset" name="submit">
    </form>
</body>

</html>