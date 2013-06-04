<?php

/* 

	GMG SESSION  CLASS
	vesrsion V1
	Created by alex brown C=

*/

class session {
	
	private static $_sessionid;
	private static $_sessionusername = null;
	private static $_sessionremoteip;
	private static $_userlevel = 'standard';
	private static $session_instance;
	
	private static $_auth_all = 0;
	private static $_auth_wri = 0;
	private static $_auth_read = 0;
	private static $_auth_del = 0;
	private static $_auth_level = 0;
	
	private static $tempSalt = "9mYKzmxtM4eNTYCHiwrD4VIZTmwYbQXwJP6tNT0CF_SkESlvzjMGaVmkZVvUYZn36VxU2qMFz0WnCFQ6LIiQxhEgFvj3oRZGvnOD";
	
	
	/*
	* 	@function 			__construct 
	* 	@description 		This class implements the singleton approach so the session construct is off limits to all but child classes
	* 	@params 			
	* 	@return 			starts off the class
	*/
	protected function __construct(){
		self::startSession();
	}
	
	/*
	* 	@function 			__getInstance 
	* 	@description 		Returns the class instance, this is used in-stead of the standard constrct, It limits one connection per user and only one level of authentication can be applies.
	* 	@params 			
	* 	@return 			Returns session class set as a var
	*/
	public static function __getInstance(){
		
		if(!self::$session_instance) self::$session_instance = new session;
		return self::$session_instance;
		
	}

	/*
	* 	@function 			startSession 
	* 	@description 		Stsrats the session, if user session already set then check with DB that session exists, if not then set to guest with noe auth level
	* 	@params 			
	* 	@return 			Return true or false;
	*/
	private static function startSession(){ 
	
		session_start();
		self::$_sessionid = session_id();
		self::$_sessionremoteip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION['username'])){
			self::$_sessionusername = $_SESSION['username']; 
			$db_connect = database_instance::__getInstance();
			$podcast_items = $db_connect->query("SELECT user_access_level FROM podcast_users WHERE user_name = '{$_SESSION['username']}'");
			$podcast_permisions = $db_connect->query("SELECT * FROM podcast_access_levels");
			
			foreach($podcast_permisions as $perm):
			
				if($perm['user_access_level'] == $podcast_items[0]['user_access_level']):
					
					if($perm['user_podcast_all'] == 1)  self::$_auth_all = 100;
					else self::$_auth_all = false;
					
					if($perm['user_access_write'] == 1)  self::$_auth_wri = 100;
					else self::$_auth_all = false;
					
					if($perm['user_access_delete'] == 1)  self::$_auth_del = 100;
					else self::$_auth_all = false;
					
					if($perm['user_access_read'] == 1)  self::$_auth_read = 100;
					else self::$_auth_all = false;
				
				endif;
			
			endforeach;
			
			return true;
		}
		else return false;

	}

	/*
	* 	@function 			ses_crypto 
	* 	@description 		Encrypt Compare, global salt is currently used but this will be changed to a DB call
	* 	@params 			
	* 	@return 			Return encrypted password;
	*/
	public static function ses_crypto($pass){
	
		$salt = sha1(self::$tempSalt);
		$salt = sha1($salt.$pass);
		$pass = sha1($pass.$salt);

		return $pass;
		
	}
	
	/*
	* 	@function 			ses_login 
	* 	@description 		This function runs all the login logic, it checks if the username exists, if so then true is returned. Access restrictions are set once the page is reloaded
	* 	@params 			
	* 	@return 			Return Bool;
	*/
	public static function ses_login($username, $pass){
		
		global $db_connect;
		
		try{
			// Hash The Password
			$pass = self::ses_crypto($pass);
			// Get PDO asset Directly
			$connectionDbAsset = $db_connect->pdoDirect();
			$category_asset = $connectionDbAsset->prepare("SELECT user_name FROM podcast_users WHERE user_name = ? AND user_hash = ?");
			// BIND PARAMS TO PDO
			$category_asset->bindParam( 1 , $username);
			$category_asset->bindParam( 2 , $pass); 
			// EXECUTE PDO
			$category_asset->execute();
			// Login Barrier Check
			if($category_asset->rowCount() > 0) $podcast_items = true;
			else $podcast_items = false;
			
			if($podcast_items){
				self::$_sessionusername == $username;
				$_SESSION['loggedin'] = 'Y';
				$_SESSION['username'] = $username;
				return true;
			 }
			 else return false;
		 }
		 catch (Exception $e) {
				header("HTTP/1.1 400 Internal Error !");
				echo "Unable To Login User";
				echo $e;
				return false;
		}
		
	}

	/*
	* 	@function 			ses_get_username 
	* 	@description 		Simply return the session
	* 	@params 			
	* 	@return 			Return $username;
	*/
	public static function ses_get_username(){
		return self::$_sessionusername;
	}
	
	public static function ses_auth_root(){
		return self::$_auth_all;
	}
	
	public static function ses_auth_delete(){
		return self::$_auth_del;
	}
	
	public static function ses_auth_write(){
		return self::$_auth_wri;
	}
	
	public static function ses_auth_read(){
		return self::$_auth_read;
	}
	
	public static function ses_check_login(){
	
		if(empty(self::$_sessionusername)) return false;
		else return true;
	
	}

	/*
	* 	@function 			ses_logout 
	* 	@description 		Kills the session, manuanlly unsets all the sessions vars after its been regened, then the session is destroyed.
	* 	@params 			
	* 	@return 			Return Bool;
	*/
	public static function ses_logout(){
		
		session_regenerate_id();
		foreach ($_SESSION as $var => $val) {
			  $_SESSION[$var] = null;
		  }
		session_unset();
		session_destroy();
		session_regenerate_id();

	}
}