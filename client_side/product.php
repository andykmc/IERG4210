<!DOCTYPE html>
<html>
<head>
<title>Food ON-line</title>
<meta charset="UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
	
<body>
<div class="page">
	<div class="header_container">
		<header>
			<div class="top_bar"><!--Top Links-->
				<ul class="top_links">
					<li><a href="#">FREE SHIPPING ABOVE HK$150</a></li>
					<li><a href="#">15 DAY RETURN</a></li>
					<li><a href="#">+852-110|FAQ</a></li>
				</ul>
			</div>
			<!--Main Logo/Name of the Web-->
			<h1 class="logo"><a href="index.php">Food On-line</a></h1>
		</header>
	</div>
	
	<div class="navigation_container">
		<nav>
			<ul class="navbar"><!--Navigation Bar-->
			<?php
					include_once('../cgi-bin/lib/db.inc.php');
					
					global $db;
					$db = ierg4210_DB();
					$q = $db->prepare("SELECT * FROM categories;");
					$cat_array;
					if ($q->execute())
						$cat_array = $q->fetchAll();
					
					foreach ($cat_array as $cat){
						echo '<li>';
						echo '<a href="product.php?catid='.$cat["catid"].'">'.$cat["name"].'</a>';
						echo '</li>';
					}
						
			?>
			</ul>
			<!--ShoppingCart-->
			<div class="cart"><a href="shoppingcart.php"><span>0</span> ITEM / <span>$0.00</span></a>
				<div class="cart_down">
					<span class="small_arrow"></span>
					<form action="shoppingcart.php" method="post">
					<div class="chooseditem">
						<div class="items">
							<span>Item3</span>
							<div class="quantity">Quantity :
							<input type="number" name="quantity" min="1" />
							</div>
						</div>
						<div class="items more">
							<span>Item1</span>
							<div class="quantity">Quantity :
							<input type="number" name="quantity" min="1" />
							</div>
						</div>
					</div>
					<div class="cart_bottom">
						<input type="submit" value="Checkout" class="checkout">
					</div>
					</form>
				</div>
			</div>
		</nav>
	</div>
	
	<div class="content_container">
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
					
					/* Underconstruction */
					foreach ($product_array as $product){
						echo '<li>';
						echo	'<a class="product_img" href="item-details.php?pid=' . $product["pid"] .'">';
						echo 		'<img src="' . $product["imagedir"] . '" alt="' . $product["name"] .'" />';
						echo	'</a>';
						echo 	'<div class="product_info">';
						echo 		'<h2><a href="item-details.php?pid='. $product["pid"] . '">' . $product["name"] . '</a></h2>';
						//echo 		'<p>Description</p>';
						echo 	'</div>';
						echo 	'<div class="price_info">';
						echo		'<button class="price_add"><span class="pr_price">$'. $product["price"] .'</span></button>';
						echo	'</div>';
						echo '</li>';
						
						/* echo 'pid:' . $product["pid"];
						echo 'catid:' . $product["catid"];
						echo 'name:' . $product["name"];
						echo 'price:' . $product["price"];
						echo 'description:' . $product["description"];
						echo '<br>'; */
					}
				?>
				<!-- <li><a class="product_img" href="item-details.html"><img src="images/meat-1.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item1</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button class="price_add"><span class="pr_price">$56.33</span></button>
					</div>
				</li>-->
			</ul>
		</div>
		<div class="ad"><!--Advertisement Area-->
			<aside><img src="images/ad.jpg" alt="advertisement" /></aside>
		</div>
		</section>
	</div>
		
		
		<div class="footer_container">
		<!--Footer Info-->
		<footer>
			<div class="footer_links">
				<ul>
					<li><span>Shop By Product</span></li>
					<li><span>Shop By Price</span></li>
					<li class="seperator"><span>Support</span>
						<ul>
							<li><a href="#">Become a Dealer</a></li>
							<li><a href="#">Find a Dealer</a></li>
							<li><a href="#">Get a Catalog</a></li>
							<li><a href="#">Returns</a></li>
						</ul>
					</li>
					<li><span>News and Events</span>
						<ul>
							<li><a href="#">Latest News</a></li>
							<li><a href="#">Current Events</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="bottom_info">
			Copyright &copy; 2013 Food On_line. All Rights Reserved.<img src="images/payment_info.jpg" alt="payment_info" />
			</div>
		</footer>
	</div>
</div>	
</body>
</html>
