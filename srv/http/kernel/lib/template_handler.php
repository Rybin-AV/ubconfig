<?php
	
	class TemplateHandler
	{
		public static function Processing($Template, $ListValue)
		{
			$ListVariables = self::FindVariables($Template);
			$Template = self::ReplaceVariables($Template, $ListVariables, $ListValue);

			return $Template;
		}

		private function FindVariables($Template)
		{
			$reg = '/.+(\$[A-z]+).+/';

			preg_match_all($reg, $Template, $out);

			foreach ($out[0] as $key => $value) 
					$result[][0] = $value;


			foreach ($result as $key => $res) 
			{
				$buff = $res[0];
				preg_match_all($reg, $buff, $out);

				do 
				{
					$var = $out[1][0];

					$result[$key][1][] = $var;
					$buff = str_replace($var,"", $buff);
					preg_match_all($reg, $buff, $out);
				} 
				while ( !empty($out[0]) );

			}

			return $result;
		}

		private function ReplaceVariables($Template, $ListVariables, $ListValue)
		{
			foreach ($ListVariables as $key => $Variables) 
			{
				$obj = $Variables[0];
				$test = $Variables[1][0];
				$test = substr($test, 1);
				$str = "";

				foreach ($ListValue[$test] as $key => $value) 
				{
					$st = $obj;

					foreach ($Variables[1] as $ind => $Variable) 
					{
						$var = substr($Variable, 1);
						$st = str_replace($Variable, $ListValue[$var][$key], $st);
					}

					$str .= $st;
				}

				$Template = str_replace($obj, $str, $Template);
			}

			return $Template;
		}
	}

?>