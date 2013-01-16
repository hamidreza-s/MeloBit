<?php
	// get rid of limitations
	ini_set('memory_limit', '-1');
	ini_set('max_execution_time', '-1');
	ini_set('max_input_time', '-1');
	
	// set importaint variables;
	$db = new PDO('mysql:host=localhost;dbname=__dbname__;charset=UTF-8', '__dbusername__', '__dbpassword__');
	$filesPatterns = "path/to/your/csv/files/root/{*,*/*, */*/*}/*.csv";
	
	// glob csv files
	$cityArray = glob($filesPatterns, GLOB_BRACE);
	
	// create tables
	$sql = null;
	foreach ($cityArray as $cityName)
	{
		// get city name
		$cityName = basename($cityName , '.csv');
	
		// execute
		$sql = "
			CREATE TABLE IF NOT EXISTS `post_$cityName` (
			`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`phone_no` varchar(10) NOT NULL, 
			`postal_code` varchar(10) NOT NULL, 
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
		
		$stmt = $db->prepare($sql);
		if($stmt->execute())
		{
			$stmt->closeCursor();
		}
	}

	// save memory
	$sql = null;
	
	// populate tables
	foreach ($cityArray as $numberListFile)
	{
		$fileHandle = fopen($numberListFile, 'r');
		$numberCsv = fread($fileHandle, filesize($numberListFile));
		fclose($fileHandle);
		$numberArray = preg_split('/\n|\r\n?/', $numberCsv);
		
		// save memory
		$finalNumberArray = null;
		
		// build phone_no => postal_code array
		foreach ($numberArray as $array)
		{
			$each = explode(',', $array);
			// Index 0: Phone No. and Index 1: Postal Code
			$finalNumberArray[$each[0]] = $each[1];
		}
		
		// save memory
		$numberArray = null;
		
		// get city name
		$cityName = basename($numberListFile , '.csv');
		
		// fire sql
		foreach ($finalNumberArray as $phoneNumber => $postalCode)
		{
			$sql = "INSERT INTO `post_$cityName` (`phone_no`, `postal_code`) VALUES (?, ?)";
			$stmt = $db->prepare($sql);
			if($stmt->execute(array($phoneNumber, $postalCode)))
			{
				$stmt->closeCursor();
			}
		}
		
		// report status
		echo "<strong>$cityName</strong> was saved!<br/>";

		// save memory
		$finalNumberArray = null;
	}

?>
