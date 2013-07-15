<?php
if(!(defined('PHPMAKER')&&Session::isAdmin())){
	header('Location: ./');
}