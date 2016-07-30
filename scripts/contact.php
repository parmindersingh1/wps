<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['contactname']) && !empty($_POST['contactemail']) && !empty($_POST['contactmessage'])) {

	   
		$to = "info@wcarps.com"; // Your e-mail address here.
		$body = "\nName: {$_POST['contactname']}\nEmail: {$_POST['contactemail']}\n\n\n{$_POST['contactmessage']}\n\n";
		$subject = "Message from wcarps.com";

		$headers = "From: ".$_POST['contactemail']."\r\n";
	    $headers .= "Reply-To: info@wcarps.com\r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	    mail($to,$subject,$body,$headers);		
		
    }
}
?>