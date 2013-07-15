<?php
	require_once 'class.DBHandler.php';
    class MySQLHandler extends DBHandler {
    	private $db_link;
    	public function connect($db_server, $db_user, $db_pass, $db_name){
    		$this->insert_id=FALSE;
    		$this->error_nro=0;
			$this->error='';
    		$this->db_link=mysql_connect($db_server, $db_user, $db_pass);
			mysql_select_db($db_name, $this->db_link);
    	}		    
    	public function get_results($query){
    		$results=array();
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
			}else{
				while($row=mysql_fetch_array($result, MYSQL_ASSOC))
					$results[]=$row;
			}
			return $results;
		}
		public function get_row($query){
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
			}else{
				if($row=mysql_fetch_array($result, MYSQL_ASSOC))
					return $row;
			}
			return array();
		}
		public function get_value($query, $field=NULL){
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
			}else{
				if(is_string($field)&&$row=mysql_fetch_array($result, MYSQL_ASSOC))
					return $row[$field];
				elseif($row=mysql_fetch_array($result, MYSQL_NUM))
					return $row[0];
			}
			return FALSE;
		}
		public function insert($table, $data){
			$fields=join(", ", array_keys($data));
			$value_array=array();
			foreach($data as $value){
				$value_array[]="'".addslashes($value)."'";
			}
			$values=join(", ", $value_array);
			$query="INSERT INTO $table ($fields) VALUES ($values)";
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
				return FALSE;
			}elseif(mysql_affected_rows()){
				$this->insert_id=mysql_insert_id($this->db_link);
				return TRUE;
			}
		}
		public function update($table, $data, $where){
			$values="";
			foreach($data as $field=>$value){
				$values.=($values? ", ": ""). "$field='".addslashes($value)."'";
			}
			$condition="";
			foreach($where as $field=>$value){
				$condition=($condition? " AND ": ""). "$field='".addslashes($value)."'";
			}
			$query="UPDATE $table SET $values WHERE $condition";
			$result=mysql_query($query, $this->db_link);if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
				return FALSE;
			}else{
				return mysql_affected_rows($this->db_link);
			}	
		}
		public function delete($table, $where){
			$condition="";
			foreach($where as $field=>$value){
				$condition.=($condition? " AND ": ""). "$field='".addslashes($value)."'";
			}
			$query="DELETE FROM $table WHERE $condition";
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
				return FALSE;
			}else{
				return mysql_affected_rows($this->db_link);
			}	
		}
		public function execute($query){
			$result=mysql_query($query, $this->db_link);
			if($error_nro=mysql_errno($this->db_link)){
				$this->error_nro=$error_nro;
				$this->error=mysql_error($this->db_link);
				return FALSE;
			}else{
				return mysql_affected_rows();
			}
		}
		public function close(){
			mysql_close($this->db_link);
		}
    }
?>