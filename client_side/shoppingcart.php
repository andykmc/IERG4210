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
			<div class="top_bar">
				<ul class="top_links">
					<li><a href="#">FREE SHIPPING ABOVE HK$150</a></li>
					<li><a href="#">15 DAY RETURN</a></li>
					<li><a href="#">+852-110|FAQ</a></li>
				</ul>
			</div>
	
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
			<div class="cart"><a href="#"><span>0</span> ITEM / <span>$0.00</span></a>
				<div class="cart_down">
					<span class="small_arrow"></span>
					<form action="#" method="post">
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
				<li class="active"><a href="shoppingcart.php">>Shopping-Cart</a></li>
			</ul>
			<span class="underconstruct">The Page is still under construction!</span>
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