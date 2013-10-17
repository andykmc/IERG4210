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
			<ul class="navbar">
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
			<div class="cart"><a href="shoppingcart.html"><span>0</span> ITEM / <span>$0.00</span></a>
				<div class="cart_down">
					<span class="small_arrow"></span>
					<form action="shoppingcart.html" method="post">
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
		<ul class="sitemap">
			<li><a href="index.php">Home</a></li>
			<?php
				include_once('../cgi-bin/lib/db-helper.php');
				if (!is_numeric($_GET['pid']))
					throw new Exception("invalid-pid");
				$pid = $_GET['pid'];
				
				$catid = get_catid_by_pid($pid);
				$catname = get_catname_by_catid($catid);
				echo '<li>' . '<a href="product.php?catid=' . $catid . '">>' . $catname . '</a></li>';
			?>
			<!--<li><a href="product.php?catid=">>Meat</a></li>!-->
			<li class="active"><a href="#">>Item-details</a></li>
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
					
				$product = $product_array[0];
				echo '<div class="item_photo">';
				echo	'<img src="'. $product["imagedir"] .'" alt="'. $product["name"] .'" />';
				echo '</div>';
				echo '<div class="item_descrip">';
				//echo '<span>Excellent Meat</span>';
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
				echo		'<button class="add_cart">Add to Cart</button>';
				echo	 '</div>';
				echo '</div>';
			?>
			<!--<div class="item_photo"><img src="images/meat-3.jpg" alt="Product Image" />
			</div>
			<div class="item_descrip"><span>Excellent Meat</span>
				<h2>WUHUA meat</h1>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut.</p>
				<div class="item_price">$56.33</div>
				<div class="size_info">
					<div class="bag_sel">
						<label>Bag :</label>
						<select>
							<option>SELECT</option>
							<option>Small</option>
							<option>Medium</option>
							<option>Large</option>
						</select>
					</div>
					<div class="weight_sel">
						<label>Color :</label>
						<select>
							<option>SELECT</option>
							<option>Light</option>
							<option>Heavy</option>
						</select>
					</div>
				</div>
				<div class="add_to_buttons">
					<button class="add_cart">Add to Cart</button>
				</div>
			</div>!-->
		</div>
		</section>
	</div>
	
	<div class="footer_container">
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
			