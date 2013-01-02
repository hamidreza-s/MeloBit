<?php
	// get rid of limitations
	ini_set('memory_limit', '-1');
	ini_set('max_execution_time', '-1');
	ini_set('max_input_time', '-1');
	
	// set importaint variables;
	$db = new PDO('mysql:host=localhost;dbname=test;charset=UTF-8', '__dbusername__', '__dbpassword__');
	$directoryPattern = "C:/Users/h.soleimani/Desktop/Postal Code/test/*";
	$filesPatterns = "C:/Users/h.soleimani/Desktop/Postal Code/test/*/*.csv";

	// get directory names to create database names
	$directories = glob($directoryPattern);
	foreach ($directories as $directory)
	{
		$directoryArray[] = basename($directory);
	}

	/*	
	$cityNameListFile = 'C:/Users/h.soleimani/Desktop/Postal Code/cityList.csv';
	$fileHandle = fopen($cityNameListFile, 'r');
	$cityCsv = fread($fileHandle, filesize($cityNameListFile));
	fclose($fileHandle);
	$cityArray = preg_split('/\n|\r\n?/', $cityCsv);
	array_pop($cityArray); // remove last index
	*/
	
	// create tables
	$sql = null;
	foreach ($directoryArray as $cityName)
	{
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

	// glob csv files
	$cityArray = glob($filesPatterns);
	
	// set counter
	$i = 0;
	
	// populate tables
	foreach ($cityArray as $numberListFile)
	{
		$fileHandle = fopen($numberListFile, 'r');
		$numberCsv = fread($fileHandle, filesize($numberListFile));
		fclose($fileHandle);
		$numberArray = preg_split('/\n|\r\n?/', $numberCsv);
		
		
		$finalNumberArray = null;
		foreach ($numberArray as $array)
		{
			$each = explode(',', $array);
			// Index 0: Phone No. and Index 1: Postal Code
			$finalNumberArray[$each[0]] = $each[1];
		}
		
		// save memory
		$numberArray = null;
		
		// get city name
		$cityName = $directoryArray[$i];
		$i++;
		
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
