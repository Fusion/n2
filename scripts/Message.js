var Message = {
	message: '',
	smilies: '',
	openTags: Array(),
	attachSelect: false,
	attachButton: false,
	attachSelection: false,

	init: function() {
		Message.message = document.getElementById('message');
		Message.smilies = document.getElementById('smiley');

		Message.message.init = true;

		// loop through smilies and add onclick event
		if((typeof Message.smilies) != 'undefined' && Message.smilies != null) {
			var allSmilies = Message.smilies.getElementsByTagName('img');

			if(allSmilies.length) {
				for(var i = 0; i < allSmilies.length; i++) {
					var obj = allSmilies[i];

					obj.style.cursor = 'pointer';

					wtcBB.addEvent(obj, 'click', Message.handleSmiley);
				}
			}
		}

		// var bbcode created by "Message.js.php"
		if((typeof bbcode) != 'undefined' && bbcode.length) {
			for(var i = 0; i < bbcode.length; i++) {
				var info = bbcode[i];
				var obj = document.getElementById('bbcode_' + info[0]);

				if(!obj) {
					continue;
				}

				obj.info = info;
				obj.status = 'off';
				obj.hoverStatus = 'off';

				if(obj.nodeName.toLowerCase() == 'select') {
					wtcBB.addEvent(obj, 'change', Message.handleBBCode);
				}

				else {
					wtcBB.addEvent(obj, 'click', Message.handleBBCode);
					wtcBB.addEvent(obj, 'mouseover', Message.bbCodeHover);
					wtcBB.addEvent(obj, 'mouseout', Message.bbCodeHover);
				}
			}
		}

		// log keys... so we can trigger special bb code
		wtcBB.addEvent(Message.message, 'keydown', Message.keylogger);

		// do attachments...
		Message.attachSelect = document.getElementById('attachments');
		Message.attachButton = document.getElementById('attachments_button');

		if(Message.attachSelect) wtcBB.addEvent(Message.attachSelect, 'change', Message.openAttachWin);
		if(Message.attachButton) wtcBB.addEvent(Message.attachButton, 'click', Message.openAttachWin);

		// add more smilies event
		if(document.getElementById('moreSmilies')) {
			wtcBB.addEvent(document.getElementById('moreSmilies'), 'click', function(e) {
				wtcBB.stopNormal(e);
				window.open('index.php?file=misc&do=smilies', 'newwin', 'height=300,width=300,resizable=yes,scrollbars=yes');
			});
		}
	},

	initAgain: function() {
		if(Message.message.init) {
			return;
		}

		wtcBB.addEvent(Message.message, 'keydown', Message.keylogger);
	},

	use: function(newid) {
		if(!newid) {
			Message.message = document.getElementById('message');
		}

		else {
			Message.message = newid;
			Message.initAgain();
			Message.message.init = true;
		}
	},

	keylogger: function(e) {
		if(e.type == 'keydown' && e.ctrlKey) {
			letter = String.fromCharCode(e.keyCode).toUpperCase();

			// some special cases:
			switch(letter) {
				case 'L':
					letter = 'LEFT';
				break;

				case 'R':
					letter = 'RIGHT';
				break;
			}

			// loop through bbcode array, and try to find a matching tag
			if(bbcode.length) {
				for(var i = 0; i <= bbcode.length; i++) {
					if(typeof bbcode[i] == 'undefined') {
						continue;
					}

					if(bbcode[i][1].toUpperCase() == letter) {
						Message.doBBCode(document.getElementById('bbcode_' + bbcode[i][0]));
						wtcBB.stopNormal(e);

						break;
					}
				}
			}
		}
	},

	addText: function(text, text2, force) {
		if((typeof Message.message) == 'undefined') {
			Message.message = documnet.getElementById('message');
		}

		Message.message.focus();

		if(document.selection) {
			selection = document.selection.createRange();
			len = selection.text.length;

			if((typeof force) != 'undefined' || (typeof text2 != 'undefined' && selection.text != '')) {
				selection.text = text + selection.text + text2;
				selection.moveStart('character', -len -text2.length);
				selection.moveEnd('character', -text2.length);
				selection.select();

				Message.message.focus();

				return true;
			}

			else {
				selection.text = text;
			}
		}

		else if((typeof Message.message.selectionStart) != 'undefined' && (typeof Message.message.selectionEnd) != 'undefined') {
			var start = Message.message.selectionStart;
			var end = Message.message.selectionEnd;

			// rebuild value...
			if((typeof force == 'undefined') && (start == end || (start != end && (typeof text2) == 'undefined'))) {
				Message.message.value = (Message.message.value).substring(0, start) + text + (Message.message.value).substring(end, Message.message.value.length);
				Message.message.selectionEnd = end + text.length;
			}

			else {
				Message.message.value = (Message.message.value).substring(0, start) + text + (Message.message.value).substring(start, end) + text2 + (Message.message.value).substring(end, Message.message.value.length);

				Message.message.selectionStart = start + text.length;
				Message.message.selectionEnd = end + text.length;

				Message.message.focus();

				return true;
			}
		}

		// tryed my best.. just add it onto the end...
		else {
			Message.message.value += text;
		}

		Message.message.focus();

		return false;
	},

	handleSmiley: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// now add the replacement text...
		Message.addText(el.className + ' ');
	},

	handleBBCode: function(e) {
		if(!(el = wtcBB.getTarget(e)) || (el.nodeName.toLowerCase() != 'select' && !(el = wtcBB.ascendDOM(el, 'div')))) {
			return;
		}

		Message.doBBCode(el);
	},

	openAttachWin: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// stop the norm...
		wtcBB.stopNormal(e);

		// get the selection
		Message.selection = Message.attachSelect.options[Message.attachSelect.selectedIndex].value;

		// first option, open new window
		if(!Message.attachSelect.selectedIndex) {
			window.open(window.attachURL.replace(/&amp;/g, '&'), 'attachWin', 'height=400,width=500,resizable=yes,scrollbars=yes');
		}

		else {
			Message.insertAttachment(Message.selection);
		}
	},

	insertAttachment: function(value) {
		// split the value, we need the attachment id, the file name, and the mime type
		var pieces = value.split('!@#%');
		var id = pieces[0];
		var name = pieces[1];
		var mime = pieces[2];
		var thumb = pieces[3];
		var attachLink = 'http://www.wtcbb2.com/index.php?file=attach&a=' + id;

		// image?
		if(mime.indexOf('image') != -1) {
			if(thumb == 'thumb') {
				Message.addText('[url=' + attachLink + '][img]' + (attachLink + '&thumb=1') + '[/img][/url]');
			}

			else {
				Message.addText('[img]' + attachLink + '[/img]');
			}
		}

		else {
			Message.addText('[url=' + attachLink + ']' + name + '[/url]');
		}
	},

	doBBCode: function(el) {
		var id = el.info[0];
		var tag = el.info[1];
		var option = el.info[2];

		if(option == false && tag.toLowerCase() != 'url' && tag.toLowerCase() != 'ul' && tag.toLowerCase() != 'ol' && tag.toLowerCase() != 'email') {
			if(el.status == 'off') {
				if(Message.addText('[' + tag + ']', '[/' + tag + ']')) {
					return;
				}
			}

			else {
				Message.addText('[/' + tag + ']');
			}
		}

		else {
			tagger = tag.toLowerCase();

			switch(tag.toLowerCase()) {
				case 'url':
					var feedback = prompt('Please Enter a URL:', 'http://');

					if(!feedback || feedback == '' || feedback == 'http://') {
						return;
					}

					Message.addText('[url=' + feedback + ']', '[/url]', true);

					return;
				break;

				case 'email':
					var feedback = prompt('Please Enter an E-mail Address:', '');

					if(!feedback || feedback == '') {
						return;
					}

					Message.addText('[email=' + feedback + ']', '[/url]', true);

					return;
				break;

				case 'color':
				case 'size':
				case 'font':
					Message.addText('[' + tagger + '=' + el.options[el.options.selectedIndex].value + ']', '[/' + tagger + ']', true);

					return;
				break;

				// lists...
				case 'ul':
				case 'ol':
					listItems = Array();

					while(true) {
						getItem = prompt('Please enter a list item. Leave blank or press the cancel button to stop entering items.', '');

						if(!getItem || (typeof getItem) == 'undefined' || getItem == '') {
							break;
						}

						listItems[listItems.length] = getItem;
					}

					if(!listItems.length) {
						return;
					}

					textToAdd = '[' + tagger + ']' + "\n";

					for(var i = 0; i < listItems.length; i++) {
						textToAdd += '[!]' + listItems[i] + '[/!]' + "\n";
					}

					textToAdd += '[/' + tagger + ']';

					Message.addText(textToAdd);

					return;
				break;

				// must be custom...
				// prompt for an option
				default:
					getOption = prompt('Enter Option:', '');

					if(!getOption || (typeof getOption) == 'undefined' || getOption == '') {
						return;
					}

					Message.addText('[' + tagger + '=' + getOption + ']', '[/' + tagger + ']', true);
				break;
			}
		}

		if(!option) {
			if(el.status == 'off') {
				el.style.background = '#98b5e2';
				el.style.border = '1px solid #316ac5';
				el.style.padding = '2px';
				el.status = 'on';
				el.tagIndex = Message.openTags.length;
				Message.openTags[Message.openTags.length] = el;
			}

			else {
				if(el.hoverStatus == 'on') {
					el.style.background = '#c1d2ee';
				}

				else {
					el.style.border = 'none';
					el.style.padding = '3px';
					el.style.background = 'transparent';
				}

				el.status = 'off';
				Message.openTags[el.tagIndex] = false;
				el.tagIndex = -1;
			}
		}
	},

	bbCodeHover: function(e) {
		if(!(el = wtcBB.getTarget(e)) || !(el = wtcBB.ascendDOM(el, 'div'))) {
			return;
		}

		if(el.hoverStatus == 'off') {
			if(el.status == 'on') {
				el.style.background = '#98b5e2';
			}

			else {
				el.style.background = '#c1d2ee';
			}

			el.style.border = '1px solid #316ac5';
			el.style.padding = '2px';
			el.hoverStatus = 'on';
		}

		else {
			if(el.status == 'off') {
				el.style.border = 'none';
				el.style.padding = '3px';
				el.style.background = 'transparent';
			}

			el.hoverStatus = 'off';
		}
	},

	closeAll: function() {
		if(Message.openTags.length) {
			for(var i = (Message.openTags.length - 1); i >= 0; i--) {
				if(Message.openTags[i] != false) {
					Message.doBBCode(Message.openTags[i]);
				}
			}
		}
	}
}

wtcBB.addEvent(window, 'load', Message.init);