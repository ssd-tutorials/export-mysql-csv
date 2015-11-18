<?php

require_once('classes/Helper.php');

$list = null;

try {

	$objDb = new PDO("mysql:dbname=books;host=localhost", "root", "password");
	$objDb->exec("SET CHARACTER SET utf8");
	
	$sql = "SHOW TABLES";
	$statement = $objDb->query($sql);
	$list = $statement->fetchAll(PDO::FETCH_ASSOC);
	
} catch(PDOException $e) {
	
	echo 'Problem with the database';
	
}

if (isset($_POST['table'])) {

	$table = !empty($_POST['table']) ? $_POST['table'] : null;
	$field = array();
	
	foreach($_POST as $key => $value) {
		$key = explode("_", $key);
		if (is_array($key) && count($key) > 1 && $key[0] == 'column') {
			$field[] = $value;
		}
	}
	
	echo Helper::getCsv($table, $field, 'export.csv');
	exit;
	
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Download MySQL as CSV</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link href="/css/core.css" rel="stylesheet" media="all" type="text/css">
</head>
<body>

<div id="wrapper">

	<form action="" method="post">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th>
					<label for="table">Select table: *</label>
				</th>
				<td>
					<select name="table" id="table" class="field">
						<option value="">Select one</option>
						<?php if (!empty($list)) { ?>
							
							<?php foreach($list as $row) { ?>
							
								<option value="<?php echo $row['Tables_in_books']; ?>">
									<?php echo $row['Tables_in_books']; ?>
								</option>
							
							<?php } ?>
							
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" id="columns"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td>
					<input type="submit" id="button" value="Download as CSV" />
				</td>
			</tr>
		</table>
	</form>

</div>

<script type="text/javascript" src="/js/jquery-1.6.3.min.js"></script>
<script type="text/javascript" src="/js/core.js"></script>
</body>
</html>




