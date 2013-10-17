<?php
function ierg4210_DB() {
	// connect to the database
	// TODO: change the following path if needed
	// Warning: NEVER put your db in a publicly accessible location
	//$db = new PDO('sqlite:/var/www/db/shop.db');
	$db = new PDO("mysql:host=localhost;dbname=ierg4210;","root","4210gp6");
	
	// enable foreign key support
	$db->query('PRAGMA foreign_keys = ON;');

	// FETCH_ASSOC: 
	// Specifies that the fetch method shall return each row as an
	// array indexed by column name as returned in the corresponding
	// result set. If the result set contains multiple columns with
	// the same name, PDO::FETCH_ASSOC returns only a single value
	// per column name. 
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	//makes sure the statement and the values aren't parsed by PHP before sending it to the MySQL server (giving a possible attacker no chance to inject malicious SQL)
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	return $db;
}

$image_wholedir_prefix = '/var/www/html/incl/img/';
$image_webdir_prefix = 'incl/img/';
?>
