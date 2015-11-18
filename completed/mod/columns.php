<?php
if (!empty($_GET['table'])) {
	
	$table = $_GET['table'];
	
	try {
	
		$objDb = new PDO("mysql:dbname=books;host=localhost", "root", "password");
		$objDb->exec("SET CHARACTER SET utf8");
		
		$sql = "SHOW COLUMNS FROM `{$table}`";
		$statement = $objDb->query($sql);
		$list = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		if (!empty($list)) {
		
			$out = array();
			
			foreach($list as $row) {
				$chk  = '<li>';
				$chk .= '<input type="checkbox" name="column_'.$row['Field'];
				$chk .= '" id="column_'.$row['Field'].'" value="'.$row['Field'];
				$chk .= '" />';
				$chk .= '<label for="column_'.$row['Field'].'">';
				$chk .= $row['Field'].'</label>';
				$chk .= '</li>';
				$out[] = $chk;
			}
			
			$list  = '<ul>';
			$list .= implode('', $out);
			$list .= '</ul>';
			
			echo json_encode(array('error' => false, 'list' => $list));
		
		} else {
			echo json_encode(array('error' => true, 'message' => 'Table is empty'));
		}
	
	} catch(PDOException $e) {
		echo json_encode(array('error' => true, 'message' => $e->getMessage()));
	}
	
	
} else {
	echo json_encode(array('error' => true));
}