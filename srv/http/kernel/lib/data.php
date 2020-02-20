<?php

	class ModuleModel
	{
		protected string $Name;
		protected string $TabDefault;
		protected bool $StatusActive;
		protected Tab $ListTab;

		public function getName()
		{
			return $this->Name;
		}

		public function getTabDefault()
		{
			return $this->TabDefault;
		}

		public function isStatusActive()
		{
			return $this->StatusActive;
		}

		public function getListTab()
		{
			return $this->ListTab;
		}

	}

	class Module extends ModuleModel
	{
		private $Data;
		private $IdModule;
		
		function __construct($Id)
		{
			$this->IdModule = $Id;
			$this->Data = $this->Module_getData();

			$this->Name = $this->Module_getName();
			$this->TabDefault = $this->Module_getTabDefault();
			$this->StatusActive = $this->Module_getStatusActive();
		}

		private function Module_getName()
		{
			return $this->Data['Name'];
		}

		private function Module_getTabDefault()
		{
			return $this->Data['Tab'];
		}

		private function Module_getStatusActive()
		{
			if ( $this->Data['Status'] == 'Active')
				return TRUE;
			else
				return FALSE;
		}

		public function getListTab()
		{
			return DataSystem::getListTabs($this->IdModule);
		}

		private function Module_getData()
		{
			return DataSystem::getDataModule($this->IdModule);
		}

	}

	class Modules
	{
		public static function getListModules()
		{
			$IdModules = DataSystem::getListModules();

			foreach ($IdModules as $key => $IdModule) 
				$List[$IdModule] = new Module($IdModule);

			return $List;
		}


	}

	class TabModel
	{
		protected string $Name;
		protected string $Template;
		protected string $Dinamic;

		public function getName()
		{
			return $this->Name;
		}

		public function getCode()
		{
			return $this->Template;
		}

		public function isDinamic()
		{
			return $this->Dinamic;
		}
	}

	class Tab extends TabModel
	{
		private $Module;
		private $Tab;
		private $Data;

		function __construct($IdModule, $IdTab)
		{
			$this->Module = $IdModule;
			$this->Tab = $IdTab;
			$this->Data = $this->Tab_getData();

			$this->Name = $this->Tab_getName();
			$this->Dinamic = $this->Tab_isDinamic();
		}

		private function Tab_getName()
		{
			return $this->Data['Name'];
		}

		public function getTemplate()
		{
			$this->Template = DataSystem::getTemplateTab($this->Module, $this->Tab);
			return $this->Template;
		}

		private function Tab_isDinamic()
		{
			if ( $this->Data['Dinamic'] == 'yes')
				return $this->Data['Dinamic'];
			else
				return "Not_found";
		}

		private function Tab_getData()
		{
			return DataSystem::getDataTab($this->Module,$this->Tab);
		}

	}

	class DataSystem
	{
		public static function getDataModule($IdModule)
		{
			$Path = self::getPath($IdModule) . "/base.info";
			$ListKey = ['Name', 'Tab', 'Status'];

			$Result = DataFromFile::ParseInfoFromFile($Path, $ListKey);

			return $Result;
		}

		public static function getDataTab($IdModule, $IdTab)
		{
			$Path = self::getPath($IdModule) . "/tabs/$IdTab.tpl";
			$ListKey = ['Name', 'Dinamic'];

			$Result = DataFromFile::ParseInfoFromFile($Path, $ListKey);

			return $Result;
		}

		public static function getTemplateTab($IdModule, $IdTab)
		{
			$Path = self::getPath($IdModule) . "/tabs/$IdTab.tpl";

			return DataFromFile::getTemplate($Path);
		}

		public static function getListModules()
		{
			$Path = "./custom/modules";
			$Result = DataFromFile::getListCatalog($Path);

			return $Result;
		}

		public static function getListTabs($IdModule)
		{
			$Path = self::getPath($IdModule) . "/tabs/*.tpl*";

			$Files = DataFromFile::getListFile($Path);

			foreach ($Files as $IdTab) 
				$List[$IdTab] = new Tab($IdModule, $IdTab);
			
			return $List;
		}

		private function getPath($IdModule)
		{
			if ($IdModule == 'main' )
				return "./kernel/main";
			else
				return "./custom/modules/$IdModule";
		}
		
	}

	class DataFromFile
	{
		public static function ParseInfoFromFile($Path, $Keys = NULL)
		{
			$FileText = self::getFileText($Path);
			$Result = self::ParseInfo($FileText, $Keys);

			return $Result;
		}

		public static function getTemplate($Path)
		{
			$FileText = self::getFileText($Path);
			$Template = self::getCodeHTML($FileText);

			return $Template;
		}

		public static function getFileText($Path)
		{
			if ( file_exists($Path) )
				$FileText = file_get_contents($Path);
			else
				throw new Exception("File not Found", 1);

			return $FileText;
		}

		public static function ParseInfo($FileText, $Keys = NULL)
		{
			$Reg = '/([A-z]+)\s*=\s*(.+)/';
			preg_match_all($Reg, $FileText, $Buffer);

			foreach ($Buffer[0] as $index => $val) 
			{
				$key = $Buffer[1][$index];
				$value = $Buffer[2][$index];

				if ( $Keys == NULL or in_array($key, $Keys) )
					$result[$key] = $value; 
			}

			foreach ($Keys as $key) 
				if ( !array_key_exists($key, $result) )
					$result[$key] = "Not_found";

			return $result;
		}

		public static function getCodeHTML($FileText)
		{
			$Pos = strpos($FileText, "<");
			$Result = substr($FileText, $Pos);

			return $Result;
		}


		public static function getListCatalog($Path)
		{
			$catalogs = scandir($Path);
			$catalogs = array_diff($catalogs, array('.', '..'));

			foreach ($catalogs as  $key => $catalog) 
			{
				if ( !is_dir("$Path/$catalog") )
					unset($catalogs[$key]);
			}

			return array_values($catalogs);
		}

		public static function getListFile($Path)
		{
			$Buffer = glob($Path);

			foreach ($Buffer as $Value) 
			{
				$File = explode("/", $Value);
				$File = array_pop($File);
				$File = strstr($File, ".", TRUE);

				$Result[] = $File;
			}

			return $Result;
		}
	}


?>