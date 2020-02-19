<?php 

	include './kernel/lib/new_lib.php';
	include './kernel/lib/lib.php';

	if ( file_exists("./kernel/aut") )
	{
		$Main = new Module('main');
		$Page = new Tab('main', 'base');

		$P_IdModule = $_REQUEST['module'];
		$P_IdTab = $_REQUEST['tab'];

		if ($P_IdModule == NULL)
			$P_IdModule = $Main->getTabDefault();

		$CurrentModule = new Module($P_IdModule);

		if ($P_IdTab == NULL)
			$P_IdTab = $CurrentModule->getTabDefault();

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
				$buff['conf'][] = $P_IdModule;
				$buff['tab'][] = $IdTab;
				$buff['tab_name'][] = $Tab->getName();
				$buff['but'][] = $Tab->isDinamic();
			}


		$tpl = $Page->getTemplate();
		$tpl = handler_base($tpl, $buff);
		$tpl = sh_handler("kernel", $tpl);
		$tmp = new Tab($P_IdModule, $P_IdTab);

		print_r($tpl);
	}
	else
	{
		$tpl = new Tab('main', 'aut');
		echo $tpl->getTemplate();
	}
?>