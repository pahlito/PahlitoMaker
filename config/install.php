<?php
$error="";
if(isset($_POST['start'])){
	require_once 'main.php';
	//TODO: Validar datos del administrador antes de comenzar.
	$config=array();
	$config['title']=$_POST['title'];
	switch($_POST['motor']){
		case 'mysql':
			$connect=mysql_connect($_POST['server'], $_POST['user'], $_POST['password']);
			if($connect){
				$database=mysql_select_db($_POST['name']);
			}
			break;
	}
	if($connect&&$database){
		$config['database']=array(
			'motor'=>$_POST['motor'],
			'server'=>$_POST['server'],
			'user'=>$_POST['user'],
			'password'=>$_POST['password'],
			'name'=>$_POST['name'],
			'prefix'=>$_POST['prefix']
		); 
		$fields=array();
		$tables=array();
		$query="SHOW TABLES";
		$result=mysql_query($query); //TODO: Dar soporte a otras bases de datos.
		while ($table=mysql_fetch_array($result, MYSQL_NUM)) {
			$tables[$table[0]]=array(
				'description' => formatedName($table[0]),
				'display'=>TRUE,
				'primary_key'=> '',
				'elements'=>array(),
				'views'=>array(),
				'extras'=>array()
			);
		}
		foreach($tables as $name=>$table){
			//TODO: saltar tablas PahlitoMaker
			$query="DESCRIBE $name";
			$result=mysql_query($query);
			while($element=mysql_fetch_array($result, MYSQL_ASSOC)){
				$field=$element['Field'];
				$field_type=($pos=strpos($element['Type'], "("))?substr($element['Type'], 0, $pos): $element['Type'];
				$required= $element['Null']=="NO";
				$primary_key= $element['Key']=="PRI";
				$auto_increment= $element['Extra']=="auto_increment";	
				switch ($field_type) { //TODO: Agregar soporte a tipo DATE, TIME, YEAR y a los ENUM y LIST
					case 'datetime':
					case 'timestamp':
						$type='dateinput';
						break;
					case 'tinyint':
					case 'smallint':
					case 'mediumint':	
					case 'bigint':	
					case 'int':
					case 'decimal':
					case 'double':
					case 'real':
						$type="numericinput";
						break;
					default:
						$type="textinput";
						break;
				}			
				$tables[$name]['elements'][$field]=array(
					'display' => TRUE,
					'description' => formatedName($field),
					'type' => $type,
					'options' => array('required'=> $required) 
				);
				if(in_array($field, array_keys($fields))){
					foreach($fields[$field] as $ftable=>$pk){
						if($pk){
							$tables[$name]['elements'][$field]['type']='dynamicselect';
							$tables[$name]['elements'][$field]['options']['relation']=array(
								'table'=> $ftable,
								'value_field'=>$field,
								'display_field'=>$field
							);
						}elseif($primary_key){
							$tables[$ftable]['elements'][$field]['type']='dynamicselect';
							$tables[$ftable]['elements'][$field]['options']['relation']=array(
								'table'=> $name,
								'value_field'=>$field,
								'display_field'=>$field
							);
						}
					}
				}
				if($auto_increment){
					$tables[$name]['elements'][$field]['type']='autonumeric';
					$tables[$name]['elements'][$field]['options']=array('required'=>FALSE);
				}
				$fields[$field][$name]=$primary_key;
				if(empty($tables[$name]['primary_key'])&&$primary_key) $tables[$name]['primary_key']=$field;
			}
		}
		$config['tables']=$tables;
		mysql_close($connect);
		$setup_config->setConfig($config);
		$sql_key=array('[prefix]', '[user_email]', '[user_pass]');
		$sql_val=array($_POST['prefix'], $_POST['user_email'], md5($_POST['user_pass']));
		$sql=file_get_contents(CONFIG_DIR.'install.sql');
		$sql=str_replace($sql_key, $sql_val, $sql);
		$queries=explode(';', $sql);
		$db=new DB();
		foreach($queries as $query){
			$db->execute($query);
		}			
		$access="";
		$actions=$setup_config->getActions();
		foreach($tables as $table_name=>$table_data){
			foreach($actions as $action_name=>$action_data){
				$access.=($access? ", ": "")."(1, '$table_name', '$action_name')";
			} 
		}
		if($access){
			$query="INSERT INTO ".$db->prefix."access (group_id, table_name, action_name) VALUES $access";
			$db->execute($query);
		}
		header('Location: ./');
	}else{
		$error="<strong>MySQL Error: ".mysql_errno()."</strong><br/> ".mysql_error();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>PahlitoMaker v0.2</title>
	</head>
	<body>
		<form action="" method="post">
			<table>
				<caption class="error"><?php echo $error;?></caption>
				<tr>
					<th colspan="2"><h3>Proyecto</h3></th>
				</tr>
				<tr>
					<th>Nombre del Proyecto:</th>
					<td><input type="text" name="title" value="<?php echo isset($_POST['title'])? $_POST['title']: 'Proyecto 1'; ?>" /></td>
				</tr>
				<tr>
					<th>Email Administrador:</th>
					<td><input type="text" name="user_email" value="<?php echo isset($_POST['user_email'])? $_POST['user_email']: ''; ?>" /></td>
				</tr>
				<tr>
					<th>Contraseña Administrador:</th>
					<td><input type="password" name="user_pass" value="" /></td>
				</tr>
				<tr>
					<th>Repetir Contraseña Administrador:</th>
					<td><input type="password" name="re_pass" value="" /></td>
				</tr>
				<tr>
					<th colspan="2"><h3>Base de datos</h3></th>
				</tr>
				<tr>
					<th>Motor:</th>
					<td>
						<select name="motor" >
							<option value="mysql">MySQL</option>
						</select>		
					</td>
				</tr>
				<tr>
					<th>Servidor:</th>
					<td><input type="text" name="server" value="<?php echo isset($_POST['server'])? $_POST['server']: 'localhost'; ?>" /></td>
				</tr>
				<tr>
					<th>Usuario:</th>
					<td><input type="text" name="user" value="<?php echo isset($_POST['user'])? $_POST['user']: ''; ?>" /></td>
				</tr>
				<tr>
					<th>Contraseña:</th>
					<td><input type="text" name="password" value="<?php echo isset($_POST['password'])? $_POST['password']: ''; ?>" /></td>
				</tr>
				<tr>
					<th>Base de datos:</th>
					<td><input type="text" name="name" value="<?php echo isset($_POST['name'])? $_POST['name']: ''; ?>" /></td>
				</tr>
				<tr>
					<th>Prefijo:</th>
					<td><input type="text" name="prefix" value="<?php echo isset($_POST['prefix'])? $_POST['prefix']: 'phm_'; ?>" /></td>
				</tr>			
				<tr>
					<th colspan="2"><input type="submit" name="start" value="¡Empecemos!" /></th>
				</tr>
			</table>
		</form>
	</body>
</html>