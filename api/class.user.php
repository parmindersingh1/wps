<?php

require_once dirname(__FILE__).'/dbconfig.php';

class USER
{	

	private $conn;
	public $roles;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
		$this->roles = array('admin','user');
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->runQuery('SELECT MAX(userID) AS max FROM tbl_users');
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ)->max;
	}
	
	public function register($uname,$email,$upass,$fname,$lname,$dob,$gender,$phone,$adhar_card_info,$user_photo,$adhar_card,$pan_card,$voter_card,$code, $role, $licence)
		// ,$name,$type,$model,$chassis,$photo,$colour)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,first_name, last_name, date_of_birth, gender, phone, adhar_card_info, photo, adhar_card_no, pan_card_no, voter_card_no, tokenCode, role, licence_no) 
			   VALUES(:user_name, :user_mail, :user_pass,:first_name, :last_name, :date_of_birth,:gender,:phone,:adhar_card_info,:photo,:adhar_card,:pan_card,:voter_card,:active_code,:role,:licence)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":first_name",$fname);
			$stmt->bindparam(":last_name",$lname);
			$stmt->bindparam(":date_of_birth",$dob, PDO::PARAM_STR);
			$stmt->bindparam(":gender",$gender);
			$stmt->bindparam(":phone",$phone);
			$stmt->bindparam(":adhar_card_info",$adhar_card_info);
			$stmt->bindparam(":photo",$user_photo);
			$stmt->bindparam(":adhar_card",$adhar_card);
			$stmt->bindparam(":voter_card",$pan_card);
			$stmt->bindparam(":pan_card",$voter_card);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":role",$role);
			$stmt->bindparam(":licence",$licence);
			$stmt->execute();	
			
			if($stmt) {
				$userId = $this->lasdID();
				$stmt = $this->conn->prepare("INSERT INTO tbl_users_demos(user_id) values(:user_id)");
				$stmt->bindparam(":user_id",$userId, PDO::PARAM_INT);
				$stmt->execute();
				return $stmt;
			} else {
				return false;
			}
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}
	

	public function update($email,$fname,$lname,$dob,$gender,$phone,$photo,$userId,$pan,$voter)
	{
		try
		{				
			$stmt = $this->conn->prepare("UPDATE tbl_users SET 
				userEmail = :user_mail,
				first_name = :first_name,
				last_name = :last_name,
				date_of_birth = :date_of_birth,
				gender = :gender,
				phone = :phone,
				photo = :photo,
				pan_card_no = :pan,
				voter_card_no = :voter
				WHERE userID = :user_id");
			$stmt->bindparam(":first_name",$fname);
			$stmt->bindparam(":last_name",$lname);
			$stmt->bindparam(":date_of_birth",$dob);
			$stmt->bindparam(":gender",$gender);
			$stmt->bindparam(":phone",$phone);
			$stmt->bindparam(":photo",$photo);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_id",$userId);	
			$stmt->bindparam(":pan",$pan);
			$stmt->bindparam(":voter",$voter);		

			$stmt->execute();
			
			return $stmt->rowCount() > 0 ? true : false;		 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function updatePassword($oldpass,$upass,$cpass,$userId)
	{
		try
		{	
		    $password = md5($upass);
			$stmt = $this->conn->prepare("UPDATE tbl_users SET 
			userPass = :user_pass WHERE userID = :user_id");
		
			$stmt->bindparam(":user_pass",$password);	
			$stmt->bindparam(":user_id",$userId);			

			$stmt->execute();
			return $stmt;
				
							 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}
	
	public function login($login,$upass)
	{
		try
		{
			if($this->isValidPhone($login)) {
				$sql = "SELECT * FROM tbl_users WHERE phone=:phone";
				$data = array(":phone"=>$login);
			} else if($this->isValidEmail($login)) {
				$sql = "SELECT * FROM tbl_users WHERE userEmail=:email_id";
				$data = array(":email_id"=>$login);
			} else {
				header("Location: login.php?error");
				exit;
			}	
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($data);
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				$id= base64_encode($userRow['userID']);
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: login.php?error");
						exit;
					}
				}
				else
				{
					header("Location: login.php?inactive&id=".$id);
					exit;
				}	
			}
			else
			{
				header("Location: login.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function loginApi($login,$upass)
	{
		try
		{
			if($this->isValidPhone($login)) {
				$sql = "SELECT * FROM tbl_users WHERE phone=:phone";
				$data = array(":phone"=>$login);
			} else if($this->isValidEmail($login)) {
				$sql = "SELECT * FROM tbl_users WHERE userEmail=:email_id";
				$data = array(":email_id"=>$login);
			} else {
				return false;
			}	
			$stmt = $this->conn->prepare($sql);
			$res = $stmt->execute($data);
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			// file_put_contents( 'debug' . time() . '.log', var_export($stmt->fetch(), true));
			if($stmt->rowCount() == 1) {
				return $userRow;
			} else {				
				return false;				
			}
			
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function send_sms($mobile, $name, $otp) {
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

	}

	public function deactivate($userID) {
		try
		{					
			$stmt = $this->conn->prepare("INSERT INTO tbl_archived_users SELECT * FROM tbl_users WHERE userID=:userID");	
			$stmt->bindparam(":userID",$userID, PDO::PARAM_INT);			

			$stmt->execute();

			$stmt = $this->conn->prepare("INSERT INTO tbl_archived_vehicles SELECT * FROM tbl_vehicles WHERE user_id=:userID");	
			$stmt->bindparam(":userID",$userID, PDO::PARAM_INT);			

			$stmt->execute();

			$stmt = $this->conn->prepare("DELETE FROM tbl_vehicles WHERE user_id=:userID");	
			$stmt->bindparam(":userID",$userID, PDO::PARAM_INT);			

			$stmt->execute();

			$stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE userID=:userID");	
			$stmt->bindparam(":userID",$userID, PDO::PARAM_INT);			

			$stmt->execute();


			return $stmt->rowCount() ? true : false;	 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function destroy($userID) {
		try
		{				
			$stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE userID=:userID");	
			$stmt->bindparam(":userID",$userID);			

			$stmt->execute();
			
			return $stmt->rowCount() ? true : false;	 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function updateUserGcmRegId($regId, $userId) {
		try
		{				
			$stmt = $this->conn->prepare("UPDATE tbl_users SET gcm_regid = :regID WHERE userID=:userID");	
			$stmt->bindparam(":regID",$regId);
			$stmt->bindparam(":userID",$userId);			

			$stmt->execute();
			
			return $stmt->rowCount() ? true : false;	 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function isValidPhone($login) {		
		return preg_match("/^[7-9][0-9]{9}$/", $login);    
	}

	public function isValidEmail($login) {
		return filter_var($login, FILTER_VALIDATE_EMAIL);
	}

	public function isPhoneExists($phone) {
		$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE phone=:phone");
		$stmt->execute(array(":phone"=>$phone));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;		
	}

	public function isEmailExists($email) {
		$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
		$stmt->execute(array(":email_id"=>$email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $stmt->rowCount() > 0;		
	}
	
	public function isLicenceExists($licence) {
		$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE licence_no=:licence");
		$stmt->execute(array(":licence"=>$licence));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $stmt->rowCount() > 0;		
	}
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}

	public function add_notifications($notification_id){
		$stmt = $this->conn->prepare("SELECT userID FROM tbl_users");
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		var_dump($data);
		$sql = 'INSERT INTO tbl_users_notifications (user_id, notification_id) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach ($data as $user_id) {
		    $insertQuery[] = '(?, ?)';
		    $insertData[] = $user_id;
		    $insertData[] = $notification_id;
		}

		if (!empty($insertQuery)) {
		    $sql .= implode(', ', $insertQuery);
		    $stmt = $this->conn->prepare($sql);
		    $stmt->execute($insertData);
		}
	} 
	
	function send_mail($email,$message,$subject)
	{	
		$headers = "From: info@wcarps.com\r\n";
	    $headers .= "Reply-To: info@wcarps.com\r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	     // $headers= "from: wcarps\r\n";
      //    $headers .= "MIME-Version: 1.0\r\n";
      //    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";  
         mail($email,$subject,$message,$headers);					
		// require_once(dirname(__FILE__).'/../mailer/class.phpmailer.php');
		// $mail = new PHPMailer();
		// $mail->IsSMTP(); 
		// $mail->SMTPDebug  = 0;                     
		// $mail->SMTPAuth   = true;                  
		// $mail->SMTPSecure = "ssl";                 
		// $mail->Host       = "smtp.gmail.com";      
		// $mail->Port       = 465;             
		// $mail->Addadhar_card_info($email);
		// $mail->Username="your_gmail_id_here@gmail.com";  
		// $mail->Password="your_gmail_password_here";            
		// $mail->SetFrom('your_gmail_id_here@gmail.com','Coding Cage');
		// $mail->AddReplyTo("your_gmail_id_here@gmail.com","Coding Cage");
		// $mail->Subject    = $subject;
		// $mail->MsgHTML($message);
		// $mail->Send();
	}	
	public function url(){	    
	    return "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
	}
	public function apiurl(){	    
	    return "http://".$_SERVER['SERVER_NAME'].dirname(dirname($_SERVER["REQUEST_URI"].'?')).'/';
	}

	public function logToFile($msg)
	   { 
	     // open file
	     $fd = fopen('../mylog.log', "a");
	     // append date/time to message
	     $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . (string)$msg; 
	     // write string
	     fwrite($fd, $str . "\n");
	     // close file
	     fclose($fd);
	   }
}
