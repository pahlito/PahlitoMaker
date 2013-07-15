<!DOCTYPE html>
<html>
  <head>		
  		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    	<title>PahlitoMaker v0.9</title>
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
    	<div class="navbar navbar-inverse navbar-fixed-top">
      		<div class="navbar-inner">
        		<div class="container">     	
         			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
           				<span class="icon-bar"></span>
           				<span class="icon-bar"></span>
           				<span class="icon-bar"></span>
           				<span class="icon-bar"></span>
         			</button>          				
         			<a class="brand" href="#">PahlitoMaker v0.9</a>   	
         			<div class="nav-collapse collapse">
           				<ul class="nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tablas<b class="caret"></b></a>						
    							<ul class="dropdown-menu">
									<li><a href="./tables.php">Tablas</a></li>
									<li><a href="./views.php">Vistas extra</a></li>
									<li><a href="./junction.php">Campos extra.</a></li>
          						</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Grupos<b class="caret"></b></a>
								<ul class="dropdown-menu">									
									<li><a href="./actions.php">Acceso por grupos</a></li>
									<li><a href="./groups.php">Grupos</a></li>
									<li><a href="./users.php">Usuarios</a></li>
          						</ul>
							</li>
							<li><a class="pagina" href="../" target="_blank">Volver al administrador</a></li>							
							<li><a class="superior logout" href="?logout">Salir</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>		
		<div id="wrapper" class="container">
			{if !is_null($mensaje)}
			<div class="alert alert-success">
  				<a class="close" data-dismiss="alert">×</a>
  				<div id="mensaje">{$mensaje}</div>
			</div>
			{/if}
		{if !is_null($error)}
			<div class="alert">
  				<a class="close" data-dismiss="alert">×</a>
  				<div id="error">{$error}</div>
  			</div>
  		{/if} 