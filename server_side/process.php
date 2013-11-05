<?php
error_reporting(-1);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

include_once('lib/db.inc.php');

function ierg4210_fetchProducts(){
	$list = $_POST['list'];
	$list_array = json_decode($list, true);  //the request JSON format:	{"5":4,"6":4,"8":1}
	$pid_array = array_keys($list_array);
	
	$results_array = array();
	
	//DB manipulation
	global $db;
	$db = ierg4210_DB();
	
	foreach ($pid_array as $pid){
		if (!is_numeric($pid))
			throw new Exception("invalid-pid");
	
		$q = $db->prepare("SELECT pid, catid, name, price FROM products WHERE pid=(:pid)");
		if($q->execute(array(':pid' => $pid))){
			if (empty($results_array))
				$results_array = $q->fetchAll();
			else
				array_push($results_array, $q->fetch());
		}
	}
	$db = null;
	return $results_array;
}




header('Content-Type: application/json');

// input validation
if (empty($_REQUEST['action']) || !preg_match('/^\w+$/', $_REQUEST['action'])) {
	echo json_encode(array('failed'=>'undefined'));
	exit();
}

// The following calls the appropriate function based to the request parameter $_REQUEST['action'],
//   (e.g. When $_REQUEST['action'] is 'cat_insert', the function ierg4210_cat_insert() is called)
// the return values of the functions are then encoded in JSON format and used as output
try {
	if (($returnVal = call_user_func('ierg4210_' . $_REQUEST['action'])) === false) {
		if ($db && $db->errorCode()) 
			error_log(print_r($db->errorInfo(), true));
		//echo json_encode(array('failed'=>'1'));
		echo json_encode(array('failed'=>$db->errorCode()));
	}
	echo 'while(1);' . json_encode(array('success' => $returnVal));
} catch(PDOException $e) {
	error_log($e->getMessage());
	echo json_encode(array('failed'=>'error-db'));
} catch(Exception $e) {
	echo 'while(1);' . json_encode(array('failed' => $e->getMessage()));
}
?>
