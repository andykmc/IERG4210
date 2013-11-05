(function(){
	
	el('sign_up_form').onsubmit = function() {
			return myLib.submit(this, function(json){
				if(json == true){
					alert('Signed up successfully!');
					self.location.href = 'login.html';
				}
				else
					alert("Error: " + json);
			});
	}
	
	el('login_panel_cancel').onclick = function() {
		self.location.href = 'login.html';
	}
	
})();