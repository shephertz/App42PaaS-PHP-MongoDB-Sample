<?php 

class DBManager {

	public $client;
	public $db;
	public $collecion;
	
	public function __construct() {
		$lines = file("Config.properties"); 
		foreach ($lines as $line) {
			list($k, $v) = explode('=', $line);
			if (rtrim(ltrim($k)) == rtrim(ltrim("app42.paas.db.username"))) {
				$user = rtrim(ltrim($v));
			}if (rtrim(ltrim($k)) == rtrim(ltrim("app42.paas.db.port"))) {
				$port = rtrim(ltrim($v));
			}if (rtrim(ltrim($k)) == rtrim(ltrim("app42.paas.db.password"))) {
				$password = rtrim(ltrim($v));
			}if (rtrim(ltrim($k)) == rtrim(ltrim("app42.paas.db.ip"))) {
				$ip = rtrim(ltrim($v));
			}if (rtrim(ltrim($k)) == rtrim(ltrim("app42.paas.db.name"))) {
				$dbName = rtrim(ltrim($v));
			}
		}
		try{
			// create connection
			$this->client = new Mongo("mongodb://$ip:$port");
			// access database
			$this->db = $this->client->$dbName;
			// authenticate
			$this->db->authenticate($user, $password);
			// access collection
			$this->collection = $this->db->user;
		} catch (MongoConnectionException $e) {
			die('Error connecting to MongoDB server');
		} catch (MongoException $e) {
			die('Error: ' . $e->getMessage());
		}
    }

	
	function saveDoc($name, $email, $description) {
		
		// insert a new document
		$item = array(
				'name' => $name,
				'email' => $email,
				'description' => $description
		);
		$this->collection->insert($item);
		$this->client->close();
    }
	
	function getAllDocs() {
		
		// retrieve all documents
		$result = $this->collection->find();
		return $result;
		
    }

}

?>