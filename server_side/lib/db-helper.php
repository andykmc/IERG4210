<?php
/* Under construction, CANNOT be used at the moment */
chdir(dirname(__FILE__));
include_once('db.inc.php');
function get_catid_by_pid($pid){
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("SELECT catid FROM products WHERE pid = (:pid);");
	
	$result;
	if ($q->execute(array(':pid'=>$pid)))
		$result = $q->fetchAll();
	return $catid = $result;
}

function get_catname_by_catid($catid){
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("SELECT name FROM categories WHERE catid = (:catid);");
	if ($q->execute(array(':catid'=>$catid)))
		return ($q->fetchAll())[0]["name"];
}
?>