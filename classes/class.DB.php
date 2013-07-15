<?php
class DB{ 
   	private $db_handler;
	private $db_server;
	private $db_user;
	private $db_pass;
	private $db_name;
	public $prefix;
	public $insert_id;
	public $error_nro;
	public $error;
   	public function __construct($db_server=NULL, $db_user=NULL, $db_pass=NULL, $db_name=NULL, $db_motor=NULL, $db_prefix=NULL){
   		$db_config=Config::getDatabaseConfig();
   		if(is_null($db_server)) $db_server=$db_config['server'];
   		if(is_null($db_user)) $db_user=$db_config['user'];
   		if(is_null($db_pass)) $db_pass=$db_config['password'];
   		if(is_null($db_name)) $db_name=$db_config['name'];
   		if(is_null($db_motor)) $db_motor=$db_config['motor'];
   		if(is_null($db_prefix)) $db_prefix=$db_config['prefix'];
		if(empty($db_server)||empty($db_user)||empty($db_name)||empty($db_motor)){
			$this->error_nro=404;
			$this->error="No se encontró información de la base de datos";
			//die($this->error);
		}else{ 
			$this->db_server=$db_server;
			$this->db_user=$db_user;
			$this->db_pass=$db_pass;
			$this->db_name=$db_name;
			$this->prefix=$db_prefix;
	   		switch($db_motor){
				case 'mysql':
					require_once 'database/MySQLHandler.php';
					$this->db_handler=new MySQLHandler();
	   		}
		}
   	}
   	public function get_results($query){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->get_results($query);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function get_row($query){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->get_row($query);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function get_value($query, $field=NULL){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->get_value($query, $field);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function insert($table, $data){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->insert($table, $data);
		$this->insert_id=$this->db_handler->insert_id;
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function update($table, $data, $where){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->update($table, $data, $where);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function execute($query){
		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp=$this->db_handler->execute($query);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
	public function delete($table, $where){
   		$this->db_handler->connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
		$resp = $this->db_handler->delete($table, $where);
		$this->error_nro=$this->db_handler->error_nro;
		$this->error=$this->db_handler->error;
		$this->db_handler->close();
		return $resp;
	}
}
?>