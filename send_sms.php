<?php


	$mobile = '8427836228';
	$name = 'Jahil';
	$otp = '000000';

		$sendsms ="";
		 $url = "http://2factor.in/API/V1/3df7017f-5193-11e6-a8cd-00163ef91450/ADDON_SERVICES/SEND/TSMS";

		//Prepare you post parameters
		    $postData = array(  
		    	'From' => 'WCarPs',     
		        'To' => $mobile,
		        'TemplateName' => 'wcarps',
		        'VAR1' => $name,
		        'VAR2' => $otp
		    );


		    //We need to URL encode the values
		    foreach($postData as $key=>$val)
		    {
			    $sendsms.= $key."=".urlencode($val);
			    $sendsms.= "&"; //append the ampersand (&) sign after each parameter/value
		    }


			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $sendsms,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  // echo "cURL Error #:" . $err;
				return false;
			} else {
			  // echo $response;
				return true;
			}








?>