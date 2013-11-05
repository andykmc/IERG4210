(function(){
	
	el('login_form').onsubmit = function() {
		return myLib.submit(this, function(json){
			if(json == true){
					self.location.href = 'admin.php';
				}
				else
					alert("Error: " + json);
			});
	}
	
	el('login_panel_signup').onclick = function() {
		self.location.href = 'register.html';
	}

})();