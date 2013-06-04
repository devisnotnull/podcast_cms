<?php

/* 

	GMG PDO CLASS
	vesrsion V2.0
	PDO Prefrence method
	ALTERED FOR GMG PODCAST CMS

*/

class database_instance{
	
	private static $db_instance;
	private static $pdo_instance;
	private static $pdo_previous_query;
	private static $pdo_previous_row_count;
	
	private static $pdo_error_collect = array();
	
		private function __construct(){
		
			self::connect();
	
		}
		
		private function errorCollect($e){
		
		}
		
		/*
		 * 	@function 			__getInstance		Singleton Method Returns instance
		* 	@description 		Implements Singelton Returns Instance Object
		* 	@params 			None
		* 	@return 			return Instance;
		*/
		public static function __getInstance(){
			
			if(!self::$db_instance) self::$db_instance = new database_instance;
			return self::$db_instance;
			
		}
		
		/*
		 * 	@function 			connect		 To Connect To A Database Object This Method Must Be Called,
		 * 	@description 		An Array Should Be Passed To Overide Defaults 
		 * 	@params 			function connect(array($Server_name, $Database_name, $Database_user, $Database_password))
		 * 	@return 			return value True;
		 */
		
		public static function connect($connection_options = null){
			
			// Make Database Config Global Scope Options Avaliable.
			$dbConnString = "mysql:host=" . 'localhost' . 
							"; dbname=" .  'botb_podcast' ;
			
			
			//$dbConnString = "mysql:host=" . 'mediatpc.db.10667776.hostedresource.com' . 
							//"; dbname=" .  'mediatpc' ;
			
			try{
				self::$pdo_instance = new PDO($dbConnString, 'gmgpodcastdbuser','gmg_PoD@stUs$r' );
				// Tell PDO To Throw Exceptions !
				self::$pdo_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return true;
				
			} catch (PDOException $e) {
				echo $e;
				die();
			}
		}
		
		public static function pdoDirect(){
			
			self::connect();
			return self::$pdo_instance;
			
		}
		
		/*
		 * 	@function 			query		 To Connect To A Database Object This Method Must Be Called,
		 * 	@description 		An Array Should Be Passed To Overide Defaults 
		 * 	@params 			function connect(array($Server_name, $Database_name, $Database_user, $Database_password))
		 * 	@return 			return value True;
		 */
		
		public static function query($querystring){
			
			try{
			
				$hey = self::$pdo_instance->query($querystring);
				$main = $hey->fetchAll(PDO::FETCH_ASSOC);
				self::$pdo_previous_query = $querystring;
				return $main;
				
			} catch (Exception $e) {
				//echo $e;
				return false;
			
			}
			
		}
		
		/*
		 * 	@function 			rowCount		 Returns a row count, if there is no query specified then it will return a wor count of the last query
		 * 	@description 		An String Should Be Passed To Overide Defaults 
		 * 	@params 			function connect($querystring = nul)
		 * 	@return 			return rowCount;
		 */
		
		public static function rowCount($querystring = null){
			
			$querystring = ($querystring == null) ? self::$pdo_previous_query : $querystring;
			
			try{
				$main = self::$pdo_instance->prepare($querystring);
				$main->execute();
				return $main->rowCount();
				
			} catch(PDOException $e){
				//echo $e;
				return false;
			
			}		
		}
		
		/*
		 * 	@function 			execRowCount		 Returns a row count, if there is no query specified then it will return a wor count of the last query
		 * 	@description 		An String Should Be Passed To Overide Defaults 
		 * 	@params 			function connect($querystring = nul)
		 * 	@return 			return rowCount;
		 */
		
		public static function execRowCount($querystring = null){
		
			try{
				$querystring = ($querystring == null) ? self::$pdo_previous_query : $querystring;
				return self::$pdo_instance->exec($querystring);
				
			} catch(PDOException $e){
				//echo $e;
				return false;
			}
			
		}
		
		
		/*
		 * 	@function 			exceptionHandel		 Handel the PDO Exceptions
		 * 	@description 		Pass The Exception error and parse to email and log
		 * 	@params 			function exceptionHandel($exception)
		 * 	@return 			
		 */
		
		private function exceptionHandel($e){
		}
		
		/*
		 * 	@function 			__clone		 Simply Mask The Magic Clone Command
		 * 	@description 		Pass The Exception error and parse to email and log
		 * 	@params 			function exceptionHandel($exception)
		 * 	@return 			
		 */
		public function __clone(){
			trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);
		}
		
		/*
		 * 	@function 			__get		 Simply Mask The Magic __get Command
		 * 	@description 		Mask The __get command
		 * 	@params 			function __get()
		 * 	@return 			
		 */
		public function __get($name){
			trigger_error('Magic __get Function is forbidden.', E_USER_ERROR);
		}
		
		/*
		 * 	@function 			__set		 Simply Mask The Magic __set Command
		 * 	@description 		Mask The __set command
		 * 	@params 			function __set()
		 * 	@return 			
		 */
		public function __set($name,$val){
			trigger_error('Magic __set Function is forbidden.', E_USER_ERROR);
		}
		
		public function __destruct(){
			
			self::$db_instance = null;
			
		}
		
	};
	