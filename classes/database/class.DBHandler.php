<?php
	abstract class DBHandler{
		public $insert_id;
		public $error_nro;
		public $error;
		public abstract function connect($db_server, $db_user, $db_pass, $db_name);		
		public abstract function get_results($query);
		public abstract function get_row($query);
		public abstract function get_value($query, $field=NULL);
		public abstract function insert($table, $data);
		public abstract function update($table, $data, $where);
		public abstract function delete($table, $where);
		public abstract function execute($query);
		public abstract function close();
	}
?>