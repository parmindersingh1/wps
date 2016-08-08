<?php

require_once dirname(__FILE__).'/dbconfig.php';

class VEHICLE
{	

	private $conn;	
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;		
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lastID()
	{
		$stmt = $this->runQuery("SELECT MAX(vehicleID) AS max FROM tbl_vehicles");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ)->max;
	}
	
	public function save($name,$type,$model,$chassis,$photo,$color,$userID)
	{
		try
		{	
			$stmt = $this->conn->prepare("INSERT INTO tbl_vehicles(name,type,model_no,chassis_no, photo, color, user_id) 
			   VALUES(:name, :type, :model_no,:chassis_no, :photo, :color,:user_id)");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":type",$type);
			$stmt->bindparam(":model_no",$model);
			$stmt->bindparam(":chassis_no",$chassis);
			$stmt->bindparam(":photo",$photo);
			$stmt->bindparam(":color",$color);
			$stmt->bindparam(":user_id",$userID);
			
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			//logToFile($ex->getMessage());
			return false;
		}
	}

	public function update($name,$type,$model,$chassis,$photo,$color,$vehicleID)
	{
		try
		{				
			$stmt = $this->conn->prepare("UPDATE tbl_vehicles SET 
				name = :name,
				type = :type,
				model_no = :model_no,
				chassis_no = :chassis_no,
				photo = :photo,
				color = :color
				WHERE vehicleID = :vehicle_id");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":type",$type);
			$stmt->bindparam(":model_no",$model);
			$stmt->bindparam(":chassis_no",$chassis);
			$stmt->bindparam(":photo",$photo);
			$stmt->bindparam(":color",$color);
			$stmt->bindparam(":vehicle_id",$vehicleID);			

			$stmt->execute();
			
			return $stmt->rowCount() ? true : false;			 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function delete($vehicleID) {
		try
		{				
			$stmt = $this->conn->prepare("DELETE FROM tbl_vehicles WHERE vehicleID = :vehicle_id");	
			$stmt->bindparam(":vehicle_id",$vehicleID);			

			$stmt->execute();
			
			return $stmt;			 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	public function search($query) {		
		try
		{		
		   $stmt = $this->conn->prepare("SELECT v.vehicleID,  u.* FROM tbl_users as u JOIN tbl_vehicles as v on v.user_id = u.userID  WHERE  (LOWER(REPLACE(REPLACE(model_no, ' ', ''),'-','')) = LOWER(REPLACE(:query, ' ', ''))  OR  LOWER(REPLACE(chassis_no, ' ', '')) = LOWER(REPLACE(:query, ' ', ''))) AND u.userStatus = 'Y'");	

				
			$stmt->bindparam(":query",$query);			

			$stmt->execute();
			
			return $stmt->fetch(PDO::FETCH_ASSOC);		 
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}

	
	public function isSubscribedTracker($vehicleID) 
	{
		$stmt = $this->conn->prepare("SELECT * FROM tbl_vehicles WHERE vehicleID = :vehicle_id AND (imei_no IS NOT NULL AND imei_no <> '') AND  DATE(`subscriptiondate`) BETWEEN DATE_SUB(CURDATE(),INTERVAL 1 YEAR) AND CURDATE()");	
		$stmt->bindparam(":vehicle_id",$vehicleID);			

		$stmt->execute();
		
		return $stmt->rowCount() ? true : false;			
	}

	public function subscribeVehicle($vehicleID,$imei, $subdate){
		try
		{				
			$stmt = $this->conn->prepare("UPDATE tbl_vehicles SET 
				imei_no = :imei,
				subscriptiondate = :subdate
				WHERE vehicleID = :vehicle_id");
			$stmt->bindparam(":imei",$imei);
			$stmt->bindparam(":subdate",$subdate);
			$stmt->bindparam(":vehicle_id",$vehicleID);			

			$stmt->execute();
			
			return $stmt->rowCount() ? true : false;			 
		}
		catch(PDOException $ex)
		{
			return false;
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

	public function isValidVehicleNumber($veh_no) {
		return preg_match('/^[a-zA-Z]{2}[ -]?[0-9]{1,2}(?:\s?[a-zA-Z])?(?:\s?[a-zA-Z]*)?\s?[0-9]{4}$/',$veh_no);
	}
	
	
	public function url(){	    
	    return "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
	}
	public function apiurl(){	    
	    return "http://".$_SERVER['SERVER_NAME'].dirname(dirname($_SERVER["REQUEST_URI"].'?')).'/';
	}
	 public function userVehicles($userID) {
	 	try
		{				
			$stmt = $this->conn->prepare("SELECT v1.*, IF((SELECT COUNT(*) FROM tbl_vehicles as v2 WHERE v2.vehicleID = v1.vehicleID AND (v2.imei_no IS NOT NULL AND v2.imei_no <> '') AND DATE(v2.subscriptiondate) BETWEEN DATE_SUB(CURDATE(),INTERVAL 1 YEAR) AND CURDATE() ),'true','false') as is_subscribed FROM tbl_vehicles as v1 WHERE v1.user_id = :userId");	
			$stmt->bindparam(":userId",$userID, PDO::PARAM_INT);			

			$stmt->execute();
			
			return $stmt->fetchAll(PDO::FETCH_ASSOC);			 
		}
		catch(PDOException $ex)
		{
			return false;
		}
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
