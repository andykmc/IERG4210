<header>                      
		<div class="top_bar"><!--Top Links-->
			<ul class="top_links">
				<li>FREE SHIPPING ABOVE HK$150</li>
				<li>15 DAY RETURN</li>
				<li>+852-110|FAQ</li>
			</ul>
		</div>
		<!--Main Logo/Name of the Web-->
		<h1 class="logo"><a href="index.php">Food On-line</a></h1>
	
		<nav><!--Navigation Bar-->
			<ul class="navbar">
			<?php
					include_once('../cgi-bin/lib/db.inc.php');
					
					global $db;
					$db = ierg4210_DB();
					$q = $db->prepare("SELECT * FROM categories;");
					$cat_array;
					if ($q->execute())
						$cat_array = $q->fetchAll();
					
					$db =null;
					foreach ($cat_array as $cat){
						echo '<li>';
						echo '<a href="product.php?catid='.$cat["catid"].'">'.$cat["name"].'</a>';
						echo '</li>';
					}
						
			?>
			</ul>
			<!--ShoppingCart Start-->
			<div class="cart-toggle"><span>$</span><span id="cartTotal">0</span>
				<div class="cart_down">
					<span class="small_arrow"></span>					
						<ul id="cart">
							No items!
						</ul>
						<div class="cart_bottom">			
							<button class="checkout" class="checkout">checkout</button>							
							<button class="reset" onclick="ui.cart.reset()">reset</button>						
						</div>					
				</div>
			</div>
			<!--ShoppingCart End-->
		</nav>
</header>
