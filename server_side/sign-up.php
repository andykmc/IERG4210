<?php
error_reporting(-1);
// Same as error_reporting (E_ALL);
ini_set('error_reporting',E_ALL);

include_once('lib/db.inc.php');

function generate_salt() {
	$str = '';
	$length = 12;
	$l = 0;
	while ($l < $length)
	{
		$l = strlen($str);
		$str .= hash('sha1', uniqid('',true));
	}
	$str = base64_encode($str);
	$str =strlen($str) > $length ? substr($str, 0, $length) : $str;
	return trim(strtr($str, '/+=', '   '));
}

function ierg4210_sign_up() {
	
	$sanitized_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL))
		throw new Exception("invalid-email");
	
	if (!preg_match('/^[\w\-, ]+$/', $_POST['password'])||!preg_match('/^[\w\-, ]+$/', $_POST['verify']))
		throw new Exception("invalid-password");
	
	if ($_POST['password'] !== $_POST['verify'])
		throw new Exception("password do not match");
	
	$password = $_POST['password'];
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	
	$salt = generate_salt();
	$storePW = hash_hmac('sha1', $password, $salt);
	$q = $db->prepare("INSERT INTO users (email, salt, password) VALUES (:email, :salt, :password)");
	if($q->execute(array(':email'=>$sanitized_email, ':salt'=>$salt, ':password'=>$storePW)))
		return true;
	else
		throw new PDOException("error-user-sign-up");
}		

	
header('Content-Type: application/json');

// input validation
if (empty($_REQUEST['action']) || !preg_match('/^\w+$/', $_REQUEST['action'])) {
	echo json_encode(array('failed'=>'undefined'));
	exit();
}
	
try {
	if (($returnVal = call_user_func('ierg4210_' . $_REQUEST['action'])) === false) {
		if ($db && $db->errorCode())
			error_log(print_r($db->errorInfo(), true));
		echo json_encode(array('failed'=>$db->errorCode()));
	}
	echo 'while(1);' . json_encode(array('success' => $returnVal));
} catch(PDOException $e) {
	error_log($e->getMessage());
	echo json_encode(array('failed'=>'error-db'));
} catch(Exception $e) {
	echo 'while(1);' . json_encode(array('failed'=> $e->getMessage()));
}
?>

	
	
	
	