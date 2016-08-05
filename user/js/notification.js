document.addEventListener('DOMContentLoaded', function () 
{
    
	if (Notification.permission !== "granted")
	{
		Notification.requestPermission();
	}
}

function notifyBrowser(title,desc,url) 
{
	if (!Notification) {
		console.log('Desktop notifications not available in your browser..'); 
		return;
	}
	if (Notification.permission !== "granted")
	{
		Notification.requestPermission();
	}
	else {
			var notification = new Notification(title, {
				icon:'../../images/logo_nav.png',
				body: desc,
			});

			// Remove the notification from Notification Center when clicked.
			notification.onclick = function () {
				window.open(url);      
			};

			// Callback function when the notification is closed.
			notification.onclose = function () {
				console.log('Notification closed');
			};

	}
}