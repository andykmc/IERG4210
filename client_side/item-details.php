<!DOCTYPE html>
<html>
<head>
<title>Food ON-line</title>
<meta charset="UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
	
<body>
	
	<?php include_once('header.php'); ?>
	
	<div class="content_container">
		<section>
		<ul class="sitemap">
			<li><a href="index.php">Home</a></li>
			<?php
				include_once('../cgi-bin/lib/db.inc.php');
				
				if (!is_numeric($_GET['pid']))
					throw new Exception("invalid-pid");
				$pid = $_GET['pid'];
				
				global $db;
				$result;
				$db = ierg4210_DB();
				$q = $db->prepare("SELECT catid,name FROM products WHERE pid = (:pid);");
				if ($q->execute(array(':pid'=>$pid)))
					$result = $q->fetchAll();
					
				$catid = $result[0]["catid"];
				$item_name = $result[0]["name"];
				
				$q = $db->prepare("SELECT * FROM categories WHERE catid = (:catid);");
				if ($q->execute(array(':catid'=>$catid)))
					$result = $q->fetchAll();
				$catname = $result[0]["name"];
				
				$db = null;
				echo '<li>';
				echo '<a href="product.php?catid=' . $catid . '">>' . $catname . '</a>';
				echo '<li class="active">';
				echo '<a href="item-details.php?pid='.$pid.'">>'.$item_name.'</a>';
				echo '<li>';
			?>
		</ul>
		<div id="item_detail">
			<?php
				include_once('../cgi-bin/lib/db.inc.php');
				
				if (!is_numeric($_GET['pid']))
					throw new Exception("invalid-pid");
				$pid = $_GET['pid'];
				
				global $db;
				$db = ierg4210_DB();
				$q = $db->prepare("SELECT * FROM products WHERE pid=(:pid);");
				$product_array;
				if ($q->execute(array(':pid'=>$pid)))
					$product_array = $q->fetchAll();
				
				$db = null;
				$product = $product_array[0];
				echo '<div class="item_photo">';
				echo	'<img src="'. $product["imagedir"] .'" alt="'. $product["name"] .'" />';
				echo '</div>';
				echo '<div class="item_descrip">';
				echo 	'<h2>' . $product["name"] . '</h2>';
				echo 	'<p>' . $product["description"] . '</p>';
				echo	 '<div class="item_price">' . $product["price"] . '</div>';
				echo 	'<div class="size_info">';
				echo		'<div class="bag_sel">';
				echo			'<label>Bag :</label>';
				echo			'<select>';
				echo				'<option>SELECT</option>';
				echo				'<option>Small</option>';
				echo				'<option>Medium</option>';
				echo				'<option>Large</option>';
				echo			'</select>';
				echo		'</div>';
				echo		'<div class="weight_sel">';
				echo			'<label>Weight :</label>';
				echo			'<select>';
				echo				'<option>SELECT</option>';
				echo				'<option>Light</option>';
				echo				'<option>Heavy</option>';
				echo			'</select>';
				echo		'</div>';
				echo 	'</div>';
				echo	 '<div class="add_to_buttons">';
				echo		'<button class="add_cart" onclick="ui.cart.add('. $pid .')">Add to Cart</button>';
				echo	 '</div>';
				echo '</div>';
			?>
		</div>
		</section>
	</div>
	
	<?php readfile('footer.html'); ?>
	
<script type="text/javascript" src="incl/myLib.js"></script>
<script type="text/javascript" src="incl/ui.js"></script>
</body>
</html>	
			