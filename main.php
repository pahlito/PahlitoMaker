<?php
define('PHPMAKER', 1);
define('BASE_DIR', dirname(__FILE__));
define('CONFIG_DIR', BASE_DIR.'/config/');
define('CONTROL_DIR', BASE_DIR.'/control/');
define('INCLUDE_DIR', BASE_DIR.'/classes/');
define('ACTION_DIR', INCLUDE_DIR.'/actions/');
define('BUILDER_DIR', INCLUDE_DIR.'builders/');
define('ELEMENT_DIR', INCLUDE_DIR.'elements/');
define('SMARTY_DIR', INCLUDE_DIR.'/smarty/');
define('TEMPLATE_DIR', BASE_DIR.'/themes/');

require SMARTY_DIR.'Smarty.class.php';

require INCLUDE_DIR.'class.Config.php';
require INCLUDE_DIR.'class.Session.php';
require INCLUDE_DIR.'class.DB.php';
require INCLUDE_DIR.'class.Tools.php';

require CONTROL_DIR.'class.RequestHandler.php';
require ACTION_DIR.'class.Action.php';
require BUILDER_DIR.'class.Builder.php';
require ELEMENT_DIR.'class.Element.php';

include CONFIG_DIR.'config.php';

Action::registerActions();
Builder::registerBuilders();
Element::registerElements();

session_start();
Config::init();