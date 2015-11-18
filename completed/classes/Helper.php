<?php
class Helper {




	public static function isEmpty($value = null) {
		return empty($value) && !is_numeric($value) ? true : false;
	}







	public static function getCsv($table = null, $fields = null, $file_name = 'file.csv', $separator = "\t") {
		
		if (!empty($table)) {
		
			if (!empty($fields)) {
			
				$fields = is_array($fields) ? $fields : array($fields);
			
				$sql  = "SELECT `";
				$sql .= implode("`, `", $fields);
				$sql .= "` FROM `{$table}`";
				
			} else {
				$sql = "SELECT * FROM `{$table}`";
			}
			
			$objDb = new PDO("mysql:dbname=books;host=localhost", "root", "password");
			$objDb->exec("SET CHARACTER SET utf8");
			
			
			$statement = $objDb->query($sql);
			$list = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			
			
			$header = array();
			
			for($i = 0; $i < count($fields); $i++) {				
				$header[] = $fields[$i];				
			}
			
			$header = implode($separator, $header);
			
			
			
			$data = null;
			
			foreach($list as $row) {
				$line = null;
				foreach($row as $value) {
					if (self::isEmpty($value)) {
						$value = $separator;
					} else {
						$value = str_replace('"', '""', $value);
						$value = '"'.$value.'"'.$separator;
					}
					$line .= $value;
				}
				$data .= trim($line)."\n";
			}
			
			$data = str_replace("\r", "", $data);
			
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename={$file_name}");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			return "{$header}\n{$data}";
		
		}
		
	}






}