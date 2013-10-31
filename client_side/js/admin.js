(function(){

	function updateUI() {
		myLib.get({action:'cat_fetchall'}, function(json){
			// loop over the server response json
			//   the expected format (as shown in Firebug): 
			for (var options = [], listItems = [],
					i = 0, cat; cat = json[i]; i++) {
				options.push('<option value="' , parseInt(cat.catid) , '">' , cat.name.escapeHTML() , '</option>');
				listItems.push('<li id="cat' , parseInt(cat.catid) , '"><span class="name">' , cat.name.escapeHTML() , '</span> <span class="delete">[Delete]</span> <span class="edit">[Edit]</span></li>');
			}
			el('prod_insert_catid').innerHTML = '<option></option>' + options.join('');
			el('categoryList').innerHTML = listItems.join('');
		});
		el('productList').innerHTML = '';
	}
	updateUI();
	
	function updateprodUI(catid){
		var id=arguments[0];
		myLib.get({action:'prod_fetchAllBy_catid',catid:id}, function(json){
			for (var listItems = [], i = 0, prod; prod = json[i]; i++){
				listItems.push('<li id="prod', parseInt(prod.pid), '"><span class="name">' , prod.name.escapeHTML() , '</span> <span id="cat' , parseInt(prod.catid) , '" class="delete">[Delete]</span> <span class="edit">[Edit]</span></li>');
			}
			el('productList').innerHTML = listItems.join('');
		});
	}
		
		
	el('categoryList').onclick = function(e) {
		if (e.target.tagName != 'SPAN')
			return false;
		
		var target = e.target,
			parent = target.parentNode,
			id = target.parentNode.id.replace(/^cat/, ''),
			name = target.parentNode.querySelector('.name').innerHTML;
		
		// handle the delete click
		if ('delete' === target.className) {
			confirm('Delete category: '+name+' \nConfirm?') && myLib.post({action: 'cat_delete', catid: id}, function(json){
				if(json==true){
					alert('"' + name + '" is deleted successfully!');
					updateUI();
				}
				else
					alert("Error: " + json);
			    });
		
		// handle the edit click
		} else if ('edit' === target.className) {
			// toggle the edit/view display
			el('categoryEditPanel').show();
			el('categoryPanel').hide();
			
			// fill in the editing form with existing values
			el('cat_edit_name').value = name;
			el('cat_edit_catid').value = id;
		
		//handle the click on the category name
		} else {
			el('productPanel').show();
			el('productEditPanel').hide();
			el('prod_insert_catid').value = id;
			// populate the product list or navigate to admin.php?catid=<id>
			updateprodUI(id);
			//el('productList').innerHTML = '<li> Product 1 of "' + name + '" [Edit] [Delete]</li><li> Product 2 of "' + name + '" [Edit] [Delete]</li>';
		}
	}
	
	el('productList').onclick = function(e){
		if(e.target.tagName!= 'SPAN')
			return false;
		
		var target = e.target,
			parent = target.parentNode,
			catid = target.id.replace(/^cat/,''),
			id = target.parentNode.id.replace(/^prod/,''),
			name = target.parentNode.querySelector('.name').innerHTML;
		
		//handle the delete click
		if('delete' === target.className){
			confirm('Delete product: '+name+' \nConfirm?')&& myLib.post({action: 'prod_delete', pid: id},function(json){
				if(json==true){
				alert('"' + name + '" is deleted successfully!');
				updateprodUI(catid);
				}
				else
				alert("Error: "+json);
			});
		}
		
		//handle the edit click
		else if('edit'===e.target.className) {
			el('productPanel').hide();
			el('productEditPanel').show();	
			myLib.get({action:'prod_fetch', pid: id}, function(json){
				var prod = json[0];
				el("prod_edit_name").value = prod.name;
				el("prod_edit_price").value = prod.price;
				el("prod_edit_description").value = prod.description;
				el("prod_edit_pid").value=prod.pid;
				el("prod_edit_img").src=prod.imagedir;
				el("prod_edit_img").alt=prod.name;
			}
			);
			
		}
	}	

	el('cat_insert').onsubmit = function() {
		return myLib.submit(this, updateUI);
	}
	el('cat_edit').onsubmit = function() {
		return myLib.submit(this, function() {
			// toggle the edit/view display
			el('categoryEditPanel').hide();
			el('categoryPanel').show();
			updateUI();
		});
	}
	el('cat_edit_cancel').onclick = function() {
		// toggle the edit/view display
		el('categoryEditPanel').hide();
		el('categoryPanel').show();
	}

	el('prod_edit_cancel').onclick = function() {
		el('productEditPanel').hide();
		el('productPanel').show();
	}
	
	
})();