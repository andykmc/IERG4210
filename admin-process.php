<?php
error_reporting(-1);
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

include_once('lib/db.inc.php');

function ierg4210_cat_fetchall() {
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("SELECT * FROM categories LIMIT 100;");
	if ($q->execute())
		return $q->fetchAll();
}

function ierg4210_cat_insert() {
	// input validation or sanitization
	if (!preg_match('/^[\w\-, ]+$/', $_POST['name']))
		throw new Exception("invalid-name");
	$name = $_POST['name'];
	
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("INSERT INTO categories (name) VALUES (:name)");//catid not needed, since auto_increment
	return $q->execute(array(':name'=>$name));
}

function ierg4210_cat_edit() {
	// TODO: complete the rest of this function; it's now always says "successful" without doing anything
	if (!preg_match('/^[\w\-, ]+$/', $_POST['name']))
		throw new Exception("invalid-name");
	$name = $_POST['name'];
	if (!is_numeric($_POST['catid']))
		throw new Exception("invalid-catid");
	$catid = $_POST['catid'];
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("UPDATE categories SET name=(:name) WHERE catid=(:catid)");
	$q->execute(array(':name'=>$name, ':catid'=>$catid));
	return true;
}

function ierg4210_cat_delete() {
	// input validation or sanitization
	//$_POST['catid'] = (int) $_POST['catid'];
	if (!is_numeric($_POST['catid']))
		throw new Exception("invalid-catid");
	$catid = $_POST['catid'];
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	
	$q = $db->prepare("SELECT * FROM products WHERE catid = (:catid)");
	if ($q->execute(array(':catid'=>$catid)))
		if (count($q->fetchAll()) == 0){
			$q = $db->prepare("DELETE FROM categories WHERE catid = (:catid)");
			if ($q->execute(array(':catid'=>$catid))){
				return true;
			}else 
				return false;
		}
	else
		return 'Cannot delete category being linked by product(s)';
	
	//return $q->execute(array(':catid'=>$catid));
}

// Since this form will take file upload, we use the tranditional (simpler) rather than AJAX form submission.
// Therefore, after handling the request (DB insert and file copy), this function then redirects back to admin.html
function ierg4210_prod_insert() {
	// input validation or sanitization
	if (!is_numeric($_POST['catid']))
		throw new Exception("invalid-catid");
	$catid = $_POST["catid"];
	if (!preg_match('/^[\w\-, ]+$/', $_POST['name']))
		throw new Exception("invalid-product-name");
	$name = $_POST["name"];
	if (!preg_match('/^\d+(\.\d{1,2})?$/', $_POST['price']))
		throw new Exception("invalid-price");
	$price = $_POST["price"];
	if (!preg_match('/^[\w\-, ]*$/', $_POST['description']))
		throw new Exception("invalid-description");
	$description = $_POST["description"];
	
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	// TODO: complete the rest of the INSERT command
	$q = $db->prepare("INSERT INTO products (catid, name, price, description) VALUES (:catid, :name, :price, :description)");//pid not needed, since auto_increment
	if(! $q->execute(array(':catid'=>$catid, ':name'=>$name, ':price'=>$price, ':description'=>$description))){
		throw new PDOException("error-product-insert");
	}
	
	// The lastInsertId() function returns the pid (primary key) resulted by the last INSERT command
	$lastId = $db->lastInsertId();

	// Copy the uploaded file to a folder which can be publicly accessible at incl/img/[pid].jpg
	if ($_FILES["file"]["error"] == 0
		&& ($_FILES["file"]["type"] == "image/jpeg" || 
			$_FILES["file"]["type"] == "image/gif" ||
			$_FILES["file"]["type"] == "image/png")
		//&& $_FILES["file"]["size"] < 5000000) {
		&& $_FILES["file"]["size"] <= 1310720) {//1310720 bytes = 10MB
		// Note: Take care of the permission of destination folder (hints: current user is apache)
		$extension = str_replace('image/', '.', $_FILES["file"]["type"]);
		if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/incl/img/" . $lastId . $extension)) {
		//if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/incl/img/" . $_FILES["file"]["name"])) {
			// redirect back to original page; you may comment it during debug
			header('Location: ../admin.html');
			exit();
		}
	}

	// Only an invalid file will result in the execution below
	
	// TODO: remove the SQL record that was just inserted
	$q = $db->prepare("DELETE FROM products WHERE pid=(:pid)");
	if(! $q->execute(array(':pid'=>$lastId))){
		throw new PDOException("error-remove-invalid-insert");
	}
	
	// To replace the content-type header which was json and output an error message
	header('Content-Type: text/html; charset=utf-8');
	echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
	exit();
}

// TODO: add other functions here to make the whole application complete
function ierg4210_prod_fetchAllBy_catid() {
	$catid = $_REQUEST["catid"];
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	$q = $db->prepare("SELECT * FROM products WHERE catid=(:cid)");
	if ($q->execute(array(':cid' => $catid)))
		return $q->fetchAll();
}

function ierg4210_prod_delete() {
	if (!is_numeric($_POST['pid']))
		throw new Exception("invalid-pid");
	$pid = $_POST['pid'];
	// DB manipulation
	global $db;
	$db = ierg4210_DB();
	
	$q = $db->prepare("DELETE FROM products WHERE pid=(:pid)");
	if($q->execute(array(':pid'=>$pid))){
		if (! unlink('/var/www/html/incl/img/'.$pid.'.jpg'))
		if (! unlink('/var/www/html/incl/img/'.$pid.'.png'))
			unlink('/var/www/html/incl/img/'.$pid.'.gif');
		return true;
	}else
		return 'Delete Failed';
}
	
function ierg4210_prod_fetch(){
	if(!is_numeric($_REQUEST['pid']))
		throw new Exception("invalid-pid");
	$pid = $_REQUEST['pid'];
	//DB manipulation
	global $db;
	$db = ierg4210_DB();
	
	$q = $db->prepare("SELECT * FROM products WHERE pid=(:pid)");
	if($q->execute(array(':pid' => $pid)))
		return $q->fetchAll();
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
