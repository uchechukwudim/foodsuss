<html>
<head>
<title>PHPMailer - SMTP basic test with authentication</title>
</head>
<body>

<?php
echo "this";
//error_reporting(E_ALL);
error_reporting(E_STRICT);



require_once('class.phpmailer.php');
//require_once("https://s3-us-west-2.amazonaws.com/cdprinceton.com/cdmail/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = "Mail from cdprinceton";
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
$mail->SMTPDebug  = 465;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                          // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "ssl://smtp.gmail.com"; // sets the SMTP server
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "uchechukwu.dim@gmail.com"; // SMTP account username
$mail->Password   = "Crackcocain1986";        // SMTP account password

//$mail->SetFrom('uchechukwu.dim@gmail.com', 'Uche');

$mail->AddReplyTo("info@cdprinceton.com",'C.D Princeton');

$mail->Subject    = "Testing ";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "info@cdprinceton.com";
$mail->AddAddress($address, "me");

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
