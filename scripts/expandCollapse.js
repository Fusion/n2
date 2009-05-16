var exCol = {
	init: function() {
		exCol.build();

		// now handle our cookie preferences...
		if((typeof adminNav) != 'undefined') {
			var cookiePrefs = wtcBB.getArrayCookie('exColPrefsAdminNav');
		}

		else {
			var cookiePrefs = wtcBB.getArrayCookie('exColPrefs');
		}

		// now iterate and open/close...
		for(var i = 0; i < cookiePrefs.length; i++) {
			var node = document.getElementById(cookiePrefs[i]);

			// make sure it's on this page
			if((typeof node) == 'undefined' || !node) {
				continue;
			}

			// open or close?
			node.status = (typeof adminNav != 'undefined') ? 'close' : 'open';

			exCol.handleMenu(node);
		}
	},

	build: function(doWhat) {
		if((typeof doWhat) == 'undefined') {
			if(typeof adminNav != 'undefined') {
				var doWhat = 'open';
			}

			else {
				var doWhat = 'close';
			}
		}

		// get all elements, and vary action based on className
		var allNodes = document.getElementsByTagName('*');
		var tdCookPrefs = wtcBB.getArrayCookie('exColPrefsTds');

		for(var i = 0; i < allNodes.length; i++) {
			var node = allNodes[i];

			// if no exCol get out...
			if(!node.className.match(/\bexCol_\S/)) {
				continue;
			}

			// get our parts of the class name
			var matches = node.className.match(/(\s|^)(exCol_(.+?)_(.+?))(\s|$)/);

			// add actOn reference to node...
			if(node.nodeName.toLowerCase() == 'td' || (node.nodeName.toLowerCase() == 'img' && (node.parentNode.parentNode.nodeName.toLowerCase() == 'td' || node.parentNode.nodeName.toLowerCase() == 'td'))) {
				node.doEl = Array();

				if(node.nodeName.toLowerCase() != 'img') {
					doWhat = 'close';
				}

				if(tdCookPrefs.length > 0/* && node.nodeName.toLowerCase() != 'img'*/) {
					for(var z = 0; z < tdCookPrefs.length; z++) {
						var matcher = tdCookPrefs[z].match(/(\s|^)(exCol_(.+?)_(.+?))(\s|$)/);

						if(matcher[2] == matches[2]) {
							doWhat = 'open';

							if((imgObj = document.getElementById(matches[4] + '_img'))) {
								imgObj.src = imgObj.src.replace(/collapse/i, 'expand');
							}
						}
					}
				}

				var allChildRows = document.getElementsByTagName('tr');

				if(allChildRows.length > 0) {
					for(var k = 0; k < allChildRows.length; k++) {
						var tr = allChildRows[k];

						var regex = new RegExp("(\\\s|^)(exColTr_" + matches[4] + ")(\\\s|$)");

						if(tr.className.match(regex)) {
							tr.status = doWhat;
							node.doEl[node.doEl.length] = tr;
							exCol.handleMenu(tr);
						}
					}
				}
			}

			else {
				if(typeof adminNav == 'undefined') {
					doWhat = 'close';
				}

				// get the obj we're going to toggle
				var actOn = document.getElementById(matches[4]);

				node.doEl = actOn;

				// now make sure it gets closed...
				node.doEl.status = doWhat;

				// open/close it...
				exCol.handleMenu(actOn);
			}

			// add event listeners...
			wtcBB.addEvent(node, matches[3], exCol.getHandleMenu);
		}
	},

	getHandleMenu: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		if(typeof el.doEl.length != 'undefined') {
			for(var i = 0; i < el.doEl.length; i++) {
				exCol.handleMenu(el.doEl[i]);
			}

			var matches = el.className.match(/(\s|^)(exCol_(.+?)_(.+?))(\s|$)/);

			if((imgObj = document.getElementById(matches[4] + '_img'))) {
				if(imgObj.src.match(/collapse/i)) {
					imgObj.src = imgObj.src.replace(/collapse/i, 'expand');
				}

				else {
					imgObj.src = imgObj.src.replace(/expand/i, 'collapse');
				}
			}
		}

		else {
			exCol.handleMenu(el.doEl);
		}

		if(typeof adminNav == 'undefined') {
			exCol.savePrefs();
		}
	},

	handleMenu: function(el) {
		// close it or open it? o_0
		if(el.status == 'open') {
			el.style.display = 'none';

			// change an image?
			if((imgObj = document.getElementById(el.id + '_img'))) {
				imgObj.src = imgObj.src.replace(/collapse/i, 'expand');
			}

			// now set it to closed...
			el.status = 'close';
		}

		// open it
		else {
			// table row... and not IE? o_0
			if(el.nodeName.toLowerCase() == 'tr' && (!document.all || window.opera)) {
				el.style.display = 'table-row';
			}

			else {
				el.style.display = 'block';
			}

			// change an image?
			if((imgObj = document.getElementById(el.id + '_img'))) {
				imgObj.src = imgObj.src.replace(/expand/i, 'collapse');
			}

			// now set it back to open
			el.status = 'open';
		}
	},

	savePrefs: function() {
		// go through and find all closed elements...
		var allNodes = document.getElementsByTagName('*');
		var cookString = wtcBB.getCookie('exColPrefs');
		var before = '';

		for(var i = 0; i < allNodes.length; i++) {
			var node = allNodes[i];

			// if no doEl... get out...
			if(!node.doEl || (typeof node.doEl.id == 'undefined')) {
				continue;
			}

			if(((typeof adminNav) == 'undefined' && node.doEl.status == 'open' && cookString.indexOf(node.doEl.id) != -1)) {
				// remove from list...
				regex = new RegExp(node.doEl.id + ',?');
				cookString = cookString.replace(regex, '');

				continue;
			}

			if(((typeof adminNav) != 'undefined' && node.doEl.status == 'close') || ((typeof adminNav) == 'undefined' && node.doEl.status == 'open') || cookString.indexOf(node.doEl.id) != -1) {
				continue;
			}

			if(cookString.length) {
				before = ',';
			}

			else {
				before = '';
			}

			// add to cookie string...
			cookString += before + node.doEl.id;
		}

		cookString = cookString.replace(/,{2,}/g, ',');
		cookString = cookString.replace(/,+\s*$/g, '');
		cookString = cookString.replace(/^\s*,+\s*/g, '');

		// add to cookie... (even if it's blank o_0)
		wtcBB.setCookie(((typeof adminNav) != 'undefined') ? 'exColPrefsAdminNav' : 'exColPrefs', cookString);

		// now do the forum prefs...
		if(typeof adminNav == 'undefined') {
			before = '';
			cookString = wtcBB.getCookie('exColPrefsTds');

			var allTds = document.getElementsByTagName('img');

			for(var i = 0; i < allTds.length; i++) {
				var node = allTds[i];

				if(!node.doEl || typeof node.doEl.length == 'undefined' || node.doEl.length == 0 || (node.doEl[0].status == 'open' && cookString.indexOf(node.className) == -1) || (node.doEl[0].status == 'close' && cookString.indexOf(node.className) != -1)) {
					continue;
				}

				if(node.doEl[0].status == 'open' && cookString.indexOf(node.className) != -1) {
					// remove from list...
					regex = new RegExp(node.className + ',?');
					cookString = cookString.replace(regex, '');

					continue;
				}

				if(cookString.length) {
					before = ',';
				}

				else {
					before = '';
				}

				cookString += before + node.className;
			}

			cookString = cookString.replace(/,{2,}/g, ',');
			cookString = cookString.replace(/,+\s*$/g, '');
			cookString = cookString.replace(/^\s*,+\s*/g, '');

			wtcBB.setCookie('exColPrefsTds', cookString);
		}
	}
}