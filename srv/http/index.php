<?php 

	include './kernel/lib/lib.php';
	include './kernel/lib/new_lib.php';
	include './kernel/lib/api.php';

	if ( file_exists("./kernel/aut") )
	{
		/* Обработка параметров */
		/************************************************************/
		$conf = $_REQUEST['conf'];
		$mode = $_REQUEST['mode'];

		$info = DataFromFile::ParseInfoFromFile("./kernel/base.info", ['Module', 'Tab'] );

		if ( $mode == NULL )
			$mode = $info['Tab'];

		if ( $conf == NULL )
			$conf = $info['Module'];
		/************************************************************/
		
		$CurrentModule = new Module($conf);
		$Modules = Modules::getListModules();

		foreach ( $Modules as $IdModule => $Module )
		{
			if ( $Module->isStatusActive() )
			{
				$buff['Tab'][] = $Module->getTabDefault();
				$buff['Name'][] = $Module->getName();
				$buff['module'][] = $IdModule;
			}
		}

		$Tabs = $CurrentModule->getListTab();

		foreach ( $Tabs as $IdTab => $Tab )
		{
			$buff['conf'][] = $conf;
			$buff['tab'][] = $IdTab;
			$buff['tab_name'][] = $Tab->getName();
			$buff['but'][] = $Tab->isDinamic();
		}

		$html = handler_base("base", $buff);

		$html = sh_handler("kernel", $html);
		$tmp = tab_code($conf, $mode);
		$html = str_replace( "@work@", $tmp,  $html);

		$html = sh_handler($conf, $html);
		$html = form_generation($html);

		echo $html;
	}
	else
	{
		$html = kernel_tmp("aut");
		echo $html;
	}
?>