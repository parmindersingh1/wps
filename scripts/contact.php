<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
		$to = "info@wcarps.com"; // Your e-mail address here.
		$body = "\nName: {$_POST['name']}\nEmail: {$_POST['email']}\n\n\n{$_POST['message']}\n\n";
		$subject = "Message from wcarps.com";

		$headers = "From: ".$_POST['email']."\r\n";
	    $headers .= "Reply-To: info@wcarps.com\r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	    $res = mail($to,$subject,$body,$headers);		
	    file_put_contents( 'debug' . time() . '.log', var_export( $res, true));
		
    }
}
?>