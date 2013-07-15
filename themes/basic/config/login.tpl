<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>PahlitoMaker v0.1.2.1</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link href="{$theme}/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    	<link href="{$theme}/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    	<script src="http://code.jquery.com/jquery.js"></script>
    	<script src="{$theme}/bootstrap/js/bootstrap.min.js"></script>
    	<style>
      		body {
        		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
    	  	}
    	</style>
	</head>
	<body>
		<div class="hero-unit span4 offset4">
		<form method="post" action="">
			<table class="table table-bordered">
				<caption>Bienvenido</caption>
				<tr>
					<th>
						<label for="email">Email</label>
					</th>
					<td>
						<input id="email" name="email" type="text" value="{$_post.email}">
					</td>
				</tr>
				<tr>
					<th>
						<label for="pass">Password</label>
					</th>
					<td>
						<input id="pass" name="pass" type="password" value="">
					</td>
				</tr>
				{if isset($error)}
				<tr>
					<th colspan="2"><div class="alert alert-error">{$error}</div></th>
				</tr>
				{/if}
				<tr>
					<th colspan="2"><input type="submit" class="btn" value="Ingresar"></th>
				</tr>
			</table>
		</form>
		</div>
	</body>
</html>