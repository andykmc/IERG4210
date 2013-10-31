<!DOCTYPE html>
<html>
<head>
<title>Food ON-line</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
	
<body>  

<?php include_once('header.php'); ?>

<article>
			<ul class="sitemap"><!--Current Location Indicator-->
				<li class="active"><a href="index.php">Home</a></li>
			</ul>
			<!--Slide Show-->
			<section class="slider" id="slider">
				<ul id="slides">
					<li><a href="product.php?catid=1"><img src="images/4.jpg" alt="banner1" /></a></li>
					<li><a href="product.php?catid=1"><img src="images/2.jpg" alt="banner2" /></a></li>
					<li><a href="product.php?catid=1"><img src="images/3.jpg" alt="banner3" /></a></li>
					<li><a href="product.php?catid=1"><img src="images/1.jpg" alt="banner4" /></a></li>
					<li><a href="product.php?catid=1"><img src="images/5.jpg" alt="banner5" /></a></li>
				</ul>
			</section>
			<!--Content Slide-->
			<section class="list">
				<div class="best_sell_products">
					<h2>Best Sell</h2>
					<ul>
						<li><a href="product.php?catid=1"><img src="images/s-02.jpg" alt="Best Sell Product1" /></a></li>
						<li><a href="product.php?catid=1"><img src="images/s-03.jpg" alt="Best Sell Product2" /></a></li>
						<li><a href="product.php?catid=1"><img src="images/s-04.jpg" alt="Best Sell Product3" /></a></li>
					</ul>
				</div>
				<div class="business_time">
					<h2>Business Time</h2>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut.</p>
				</div>
				<div class="special">
					<h2>Special Favour</h2>
					<ul>
						<li><a href="product.php?catid=1"><img src="images/s-05.jpg" alt="Special Favour1" /></a></li>
						<li><a href="product.php?catid=1"><img src="images/s-03.jpg" alt="Special Favour2" /></a></li>
						<li><a href="product.php?catid=1"><img src="images/s-04.jpg" alt="Special Favour3" /></a></li>
					</ul>
				</div>
			</section>
</article>
	<?php readfile('footer.html'); ?>
	
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="js/slideshow.js" type="text/javascript"></script>
<script type="text/javascript" src="incl/myLib.js"></script>
<script type="text/javascript" src="incl/ui.js"></script>
</body>
</html>	