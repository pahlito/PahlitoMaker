<?php 
include 'main.php';
if(!Session::isAdmin()){
	header('Location: ./');
} 
$config=$setup_config->getConfig();
?>
<html>
<head>
	<link rel="stylesheet" href="temp/prettify.css" />
	<script src="temp/prettify.js"></script>
</head>
<body>
<?php foreach($config as $key=>$val): ?>
<h1><?php echo ucfirst($key); ?></h1>
<pre class="prettyprint" style="background-color: #FFF;padding: 10px"><code><?php var_dump($val); ?></code></pre>
<?php endforeach; ?>
<script>prettyPrint();</script>
</body>
</html>
