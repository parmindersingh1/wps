<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
	$to = 'info@wcarps.com'; // Your e-mail address here.
	$body = "\nName: {$_POST['name']}\nEmail: {$_POST['email']}\n\n\n{$_POST['message']}\n\n";
	mail($to, "Message from yoursite.com", $body, "From: {$_POST['email']}"); // E-Mail subject here.
    }
}
?>