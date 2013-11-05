<?php
session_start();
include_once('lib/db.inc.php');

function auth() {
	if (!empty($_SESSION['auth']))
		return $_SESSION['auth']['em'];
	
	if (!empty($_COOKIE['auth'])) {
		if ($t = json_decode($_COOKIE['auth'], true)) {
			if (time() > $t['exp']) return false;
			
			global $db;
			$db = ierg4210_DB();
			$q = $db->prepare('SELECT salt, password FROM users WHERE email = (:email)');
			if (($q->execute(array(':email'=>$t['em']))) && ($r = $q->fetch()) && ($t['k'] == hash_hmac('sha1', $t['exp'] . $r['password'], $r['salt']))) {
				$_SESSION['auth'] = $_COOKIE['auth'];
				return $t['em'];
			}
			header('Location: login.html');
			exit ();
		}
	}
	else {
		header('Location: login.html');
		exit ();
	}
}
auth();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>IERG4210 Shop - Admin Panel</title>
	<link href="incl/admin.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<header>
<h1>IERG4210 Shop - Admin Panel</h1>
<div><input type="button" id="log_out" value="Log Out" />
</header>

<article id="main">

<section id="categoryPanel">
	<fieldset>
		<legend>New Category</legend>
		<form id="cat_insert" method="POST" action="cgi-bin/admin-process.php?action=cat_insert" onsubmit="return false;">
			<label for="cat_insert_name">Name</label>
			<div><input id="cat_insert_name" type="text" name="name" required="true" pattern="^[\w\- ]+$" /></div>

			<input type="submit" value="Submit" />
		</form>
	</fieldset>
	
	<!-- Generate the existing categories here -->
	<ul id="categoryList"></ul>
</section>

<section id="categoryEditPanel" class="hide">
	<fieldset>
		<legend>Editing Category</legend>
		<form id="cat_edit" method="POST" action="cgi-bin/admin-process.php?action=cat_edit" onsubmit="return false;">
			<label for="cat_edit_name">Name</label>
			<div><input id="cat_edit_name" type="text" name="name" required="true" pattern="^[\w\- ]+$" /></div>
			<input type="hidden" id="cat_edit_catid" name="catid" />
			<input type="submit" value="Submit" /> <input type="button" id="cat_edit_cancel" value="Cancel" />
		</form>
	</fieldset>
</section>

<section id="productPanel">
	<fieldset>
		<legend>New Product</legend>
		<form id="prod_insert" method="POST" action="cgi-bin/admin-process.php?action=prod_insert" enctype="multipart/form-data">
			<label for="prod_insert_catid">Category *</label>
			<div><select id="prod_insert_catid" name="catid" pattern="^[\w\- ]+$" required="true"></select></div>

			<label for="prod_insert_name">Name *</label>
			<div><input id="prod_insert_name" type="text" name="name" required="true" pattern="^[\w\- ]+$" /></div>

			<label for="prod_insert_price">Price *</label>
			<div><input id="prod_insert_price" type="number" name="price" required="true" pattern="^[\d\.]+$" /></div>

			<label for="prod_insert_description">Description</label>
			<div><textarea id="prod_insert_description" name="description" pattern="^[\w\-, ]*$"></textarea></div>

			Image *
			<div><input type="file" name="file" required="true" accept="image/jpeg" /></div>

			<input type="submit" value="Submit" />
		</form>
	</fieldset>
	
	<!-- Generate the corresponding products here -->
	<ul id="productList"></ul>
	
</section>
	
	<section id="productEditPanel" class="hide">
		<fieldset>
			<legend>Editing Product</legend>
			<form id="prod_edit" method="POST" action="cgi-bin/admin-process.php?action=prod_edit" enctype="multipart/form-data">
				
				<label for="prod_edit_name">Name *</label>
				<div><input id="prod_edit_name" type="text" name="name" required="true" pattern="^[\w\- ]+$" /></div>

				<label for="prod_edit_price">Price *</label>
				<div><input id="prod_edit_price" type="number" name="price" required="true" pattern="^\d+(\.\d{1,2})?$" /></div>

				<label for="prod_edit_description">Description</label>
				<div><textarea id="prod_edit_description" name="description" pattern="^[\w\-, ]*$"></textarea></div>

				Image
				<div><input type="file" name="file" accept="image/jpeg" />
				<img id="prod_edit_img" />
				</div>
				<input type="hidden" id="prod_edit_pid" name="pid" />
				<input type="submit" value="Submit" /> <input type="button" id="prod_edit_cancel" value="Cancel" />
			</form>
		</fieldset>
		<!-- 
			Design your form for editing a product's catid, name, price, description and image	
			- the original values/image should be prefilled in the relevant elements (i.e. <input>, <select>, <textarea>, <img>)
			- prompt for input errors if any, then submit the form to admin-process.php (AJAX is not required)
		-->
		
	</section>

<div class="clear"></div>
</article>
<script type="text/javascript" src="incl/myLib.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>
