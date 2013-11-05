<!DOCTYPE html>
<html>
<head>
<title>Food ON-line</title>
<meta charset="UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
	
<body>
	
	<?php include_once('header.php'); ?>
	
	<article>
		<section>
		<!--Current Location Indicator-->
		<ul class="sitemap">
			<?php
				include_once('../cgi-bin/lib/db.inc.php');
					
					if (!is_numeric($_GET['catid']))
						throw new Exception("invalid-catid");
					$catid = $_GET['catid'];
					
					global $db;
					$db = ierg4210_DB();
					$q = $db->prepare("SELECT * FROM categories where catid=(:catid);");
					$cat_array;
					if ($q->execute(array(':catid'=>$catid)))
						$cat_array = $q->fetchAll();
					
					$db = null;	
					
					$cat = $cat_array[0];
					echo '<li>';
					echo '<a href="index.php">Home</a>';
					echo '</li>';
					echo '<li class="active"><a href="product.php?catid='.$cat["catid"].'">>'.$cat["name"].'</a></li>';
			?>
		</ul>
		<div class="products_list"><!--procuct-list area-->
			<ul>
				<?php
					include_once('../cgi-bin/lib/db.inc.php');
					
					if (!is_numeric($_GET['catid']))
						throw new Exception("invalid-catid");
					$catid = $_GET['catid'];
					
					global $db;
					$db = ierg4210_DB();
					$q = $db->prepare("SELECT * FROM products WHERE catid=(:catid);");
					$product_array;
					if ($q->execute(array(':catid'=>$catid)))
						$product_array = $q->fetchAll();
					$db = null;
					/* Underconstruction */
					foreach ($product_array as $product){
						echo '<li>';
						echo	'<a class="product_img" href="item-details.php?pid=' . $product["pid"] .'">';
						echo 		'<img src="' . $product["imagedir"] . '" alt="' . $product["name"] .'" />';
						echo	'</a>';
						echo 	'<div class="product_info">';
						echo 		'<span><a href="item-details.php?pid='. $product["pid"] . '">' . $product["name"] . '</a></span>';
						echo 	'<div class="price_info">';
						echo		'<span>$'. $product["price"] .'</span>';
						echo	'</div>';
						echo 	'</div>';
						echo	'<div class="add_to_buttons">';
						echo	'<button class="add_cart" onclick="ui.cart.add('. $product["pid"] .')">Add to Cart</button>';
						echo  	'</div>';
						echo '</li>';
						
					}
				?>
			</ul>
		</div>
		<div class="ad"><!--Advertisement Area-->
			<aside><img src="images/ad.jpg" alt="advertisement" /></aside>
		</div>
		</section>
	</article>
		
	<?php readfile('footer.html'); ?>	
		
<script type="text/javascript" src="incl/myLib.js"></script>
<script type="text/javascript" src="incl/ui.js"></script>
</body>
</html>
