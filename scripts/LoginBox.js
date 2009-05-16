var LoginBox = {	
	init: function() {
		// get our form element...
		var formElm = document.getElementById('login');
		
		// now get our inputs...
		var inputs = formElm.getElementsByTagName('input');
		
		for(var i = 0; i < inputs.length; i++) {
			var obj = inputs[i];
			
			// only if text or pass...
			if(obj.type == 'text' || obj.type == 'password') {
				wtcBB.addEvent(obj, 'click', LoginBox.handleClick);
				wtcBB.addEvent(obj, 'focus', LoginBox.handleClick);
				wtcBB.addEvent(obj, 'blur', LoginBox.handleBlur);
			}
		}
	},
	
	handleClick: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}
		
		if(el.type == 'text' && el.value == 'User Name') {
			el.value = '';
		}
		
		if(el.type == 'password' && el.value == 'password') {
			el.value = '';
		}
	},
	
	handleBlur: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}
		
		if(el.type == 'text' && el.value == '') {
			el.value = 'User Name';
		}
		
		if(el.type == 'password' && el.value == '') {
			el.value = 'password';
		}
	}
}

wtcBB.addEvent(window, 'load', LoginBox.init);