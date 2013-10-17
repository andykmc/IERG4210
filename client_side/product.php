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
			<h1 class="logo"><a href="index.html">Food On-line</a></h1>
		</header>
	</div>
	
	<div class="navigation_container">
		<nav>
			<ul class="navbar"><!--Navigation Bar-->
				<li><a href="meat.html">FRESH ARRIVAL</a></li>
				<li><a href="meat.html">MEAT</a></li>
				<li><a href="meat.html">VEGETABLE</a></li>
				<li><a href="meat.html">FRUIT</a></li>
			</ul>
			<!--ShoppingCart-->
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
		<!--Current Location Indicator-->
		<ul class="sitemap">
			<li><a href="index.html">Home</a></li>
			<li class="active"><a href="meat.html">>Meat</a></li>
		</ul>
		<div class="products_list"><!--procuct-list area-->
			<ul>
				<?php
					include_once('../cgi-bin/lib/db.inc.php');
					
					if (!is_numeric($_POST['catid']))
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
						echo '<li class="divide"><a class="product_img" href="item-details.html"><img src="' . $product["imagedir"] . ' alt="product image" /></a>';
						echo 	'<div class="product_info">';
						echo 		'<h2><a href="item-details.html?catid='. $product["catid"] . '">Item1</a></h2>';
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
				</li>
				<li class="divide"><a class="product_img" href="item-details.html"><img src="images/meat-2.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item2</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button class="price_add"><span class="pr_price">$56.33</span></button>
					</div>
				</li>
				<li><a class="product_img" href="item-details.html"><img src="images/meat-3.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item3</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button class="price_add"><span class="pr_price">$56.33</span></button>
					</div>
				</li>
				<li><a class="product_img" href="item-details.html"><img src="images/meat-3.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item4</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button class="price_add"><span class="pr_price">$56.33</span></button>
					</div>
				</li>
				<li class="divide"><a class="product_img" href="item-details.html"><img src="images/meat-5.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item5</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button class="price_add"><span class="pr_price">$56.33</span></button>
					</div>
				</li>
				<li><a class="product_img" href="item-details.html"><img src="images/meat-6.jpg" alt="product image" /></a>
					<div class="product_info">
						<h2><a href="item-details.html">Item6</a></h2>
						<p>Description</p>
					</div>
					<div class="price_info">
						<button><span class="pr_price">$56.33</span></button>
					</div>
				</li>!-->
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
