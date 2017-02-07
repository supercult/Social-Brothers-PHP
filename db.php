<?php
class User {
	private $DatabaseHost     = "localhost";
	private $DatabaseUsername = "root";
	private $DatabasePassword = "";
	private $DatabaseName     = "testdb";
	private $DatabaseTable    = 'users';
	
	function __construct(){
		if(!isset($this->db)){
            $connect = new mysqli($this->DatabaseHost, $this->DatabaseUsername, $this->DatabasePassword, $this->DatabaseName);
            if($connect->connect_error){
                die("Failed to connect with MySQL: " . $connect->connect_error);
            }else{
                $this->db = $connect;
            }
        }
	}
	
	function checkUser($userData = array()) { 
		if(!empty($userData)) {
			$FirstQuery = "SELECT * FROM ".$this->DatabaseTable." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
			$FirstResult = $this->db->query($FirstQuery);
			if($FirstResult->num_rows > 0) {
				$query = "UPDATE ".$this->DatabaseTable." SET first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
				$update = $this->db->query($query);
			}else{
				$query = "INSERT INTO ".$this->DatabaseTable." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'";
				$insert = $this->db->query($query);
			}
			
			$result = $this->db->query($FirstQuery);
			$userData = $result->fetch_assoc();
		}
		
		return $userData;
	}
}
?>