<?php

	include 'lib.php';
	include 'new_lib.php';
	include 'api.php';
	chdir('../..');

	$mode_render = $_REQUEST['mode_render'];

	$conf = $_REQUEST['conf'];

	if ( $mode_render == "work" )
	{
		$mode = $_REQUEST['mode'];

		$tmp = tab_code($conf, $mode);

		$tmp = sh_handler($conf, $tmp);
		$tmp = form_generation($tmp);

		echo $tmp;
	}

	if ( $mode_render == "tabs" )
	{
		$CurrentModule = new Module($conf);
		$Tabs = $CurrentModule->getListTab();

		foreach ( $Tabs as $IdTab => $Tab )
		{
			$buff['conf'][] = $conf;
			$buff['tab'][] = $IdTab;
			$buff['tab_name'][] = $Tab->getName();
			$buff['but'][] = $Tab->isDinamic();
		}

		$tmp  = handler_base("tabs", $buff);

		echo $tmp;
	}
?>