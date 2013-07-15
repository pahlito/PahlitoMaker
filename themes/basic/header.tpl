<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>{$title}</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
	<link rel="shortcut icon" type="image/png" href="{Config::getThemeURL()}/assets/favicon-16.png" />
	{$css}
	{$js}
</head>
<body>
	<div id="page_wrapper">
		<div id="header">
			<div id="logo"></div>
			<div class="user_menu"></div>
		</div>
		{if isset($menu)}
		<div id="menu_wrapper">
			<ul id="main_menu">
				{foreach from=$menu item=table}
				<li>
					<a class="menu_item" href="{$table.url}">{$table.description}</a>
				</li>
				{/foreach}
			</ul>
			<div class="clear"></div>
		</div>
		{/if}
		<div id="content_wrapper">