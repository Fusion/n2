var Attachments = {
	win: false,

	init: function() {
		Attachments.win = window.opener;
		Attachments.integrity();
		Attachments.insertNew();
	},

	integrity: function() {
		if((typeof Attachments.win.Message) == 'undefined') {
			return;
		}
	},

	_attachInput: function() {
		var attachInput = Attachments.win.document.getElementById('attachGroupInput');
		if(!attachInput)
		{
			var attachGroup = Attachments.win.document.getElementById('attachments');
			var el = Attachments.win.document.createElement('<div>');
			el.setAttribute('id', 'attachGroupInput');
			attachGroup.parentNode.insertBefore(el, attachGroup);
			attachInput = Attachments.win.document.getElementById('attachGroupInput');
		}
		return attachInput;
	},
	
	insertNew: function() {
		// loop through all "a" elements
		// compare their class names with those in select menu in main window
		// if it isn't there, add it!
		var allA = document.getElementsByTagName('a');
		var currentUploads = new Array();

		if(allA.length) {
			for(var i = 0; i < allA.length; i++) {
				var myClass = allA[i].className;

				// uh oh!
				if(myClass.substr(0, 11) == 'attachment_') {
					myClass = myClass.substr(11);
					currentUploads[currentUploads.length] = myClass;

					var found = false;
					var k = 0;

					for(k = 0; k < Attachments.win.Message.attachSelect.options.length; k++) {
						var menuItem = Attachments.win.Message.attachSelect.options[k].value;

						if(menuItem == myClass) {
							found = true;
						}
					}

					if(!found) {
						var pieces = myClass.split('!@#%');
						var newObj = Attachments.win.document.createElement('option');
						newObj.value = myClass;
						newObj.innerHTML = pieces[1];
						Attachments.win.Message.attachSelect.appendChild(newObj);

/*						
						var attachInput = Attachments._attachInput();
						newObj = Attachments.win.document.createElement('input');
						newObj.setAttribute('type', 'hidden');
						newObj.setAttribute('name', 'attachgroup[]');
						newObj.setAttribute('value', myClass);
						attachInput.appendChild(newObj);
 */						
					}
				}
			}
		}

		// now we have to do the reverse!
		// skip over first element which is "Manage Attachments"
		for(var n = 1; n < Attachments.win.Message.attachSelect.options.length; n++) {
			var menuItem = Attachments.win.Message.attachSelect.options[n];
			var found = false;

			for(var m = 0; m < currentUploads.length; m++) {
				var myClass = currentUploads[m];

				if(myClass == menuItem.value) {
					found = true;
				}
			}

			// uh oh!
			if(!found) {
				Attachments.win.Message.attachSelect.removeChild(menuItem);
				
/*				
				// Also remove from hidden input field
				var attachInput = Attachments._attachInput();
				var children = attachInput.childNodes;
				var l = children.length;
				var i = 0;
				for(i=0; i<l; i++)
				{
					if(children[i].value == menuItem.value)
					{
						found = true;
						break;
					}
				}
				if(found)
					attachInput.removeChild(children[i]);
 */					
			}
		}
	}
}

wtcBB.addEvent(window, 'load', Attachments.init);