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
					<th colspan="2"><input type="submit" name="start" value="�Empecemos!" /></th>
				</tr>
			</table>
		</form>
	</body>
</html>