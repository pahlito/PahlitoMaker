<?php 
/**
 * Base Config
 * @author Pahlito Campos
 * 
 */
  
 Config::setBaseURL('http://localhost/pahlito.cl/openpark/administrador');
  
 Config::setTheme('basic');
 
 Config::setSecret('testsecret');
 
 RequestHandler::addFormat('html', TRUE);
 RequestHandler::addFormat('json', FALSE); 
 RequestHandler::addStyle('basic', Config::getThemeURL().'css/basic.css'); 
 //TODO: PasswordInputElement
 ?>