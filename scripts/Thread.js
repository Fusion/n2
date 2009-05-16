var Thread = {
	threadid: 0,
	quoted: Array(),
	deleted: Array(),
	editTimeout: false,
	ajaxLoad: false,
	isEditing: false,
	exiting: false,

	init: function() {
		// get our form element...
		var divit = document.getElementById('threadDisplay');
		Thread.threadid = divit.getAttribute('name');

		// now get our imgs...
		var imgs = divit.getElementsByTagName('img');

		for(var i = 0; i < imgs.length; i++) {
			var obj = imgs[i];

			// only if quote/del/reply/edit button
			if(wtcBB.matchClass(obj, 'quoteButton')) {
				Thread.quoted[Thread.quoted.length] = Array(obj.id.replace(/quote_/i, ''), false);
				obj.index = (Thread.quoted.length - 1);

				wtcBB.addEvent(obj, 'click', function(e) {
					if(!(el = wtcBB.getTarget(e))) return;
					AJAX.load('do=save&what=postquote', 'postid=' + el.title, function(response) {
						Thread.handleQuote(e, response);
					}, false);
				});
			}

			else if(wtcBB.matchClass(obj, 'editButton')) {
				obj.a = wtcBB.ascendDOM(obj, 'a');
				wtcBB.addEvent(obj.a, 'click', wtcBB.stopNormal);

				wtcBB.addEvent(obj, 'click', Thread.handleQuickEdit);
			}

			else if(wtcBB.matchClass(obj, 'qrButton')) {
				myUser = document.getElementById('username_' + obj.id.replace(/qr_/i, ''));

				obj.added = true;

				if((typeof myUser) != 'undefined' && myUser != null) {
					obj.user = myUser;
					obj.added = false;
				}

				wtcBB.addEvent(obj, 'click', function(e) {
					if(!(el = wtcBB.getTarget(e))) return;
					AJAX.load('do=save&what=postquote', 'postid=' + el.id.replace(/qr_/i, ''), function(response) {
						Thread.handleQr(e, response);
					}, false);
				});
			}

			else if(wtcBB.matchClass(obj, 'replyButton')) {
				wtcBB.addEvent(obj, 'click', Thread.handleReply);
			}

			else if(wtcBB.matchClass(obj, 'deleteButton')) {
				Thread.deleted[Thread.deleted.length] = Array(obj.id.replace(/delete_/i, ''), false);
				obj.index = (Thread.deleted.length - 1);

				wtcBB.addEvent(obj, 'click', Thread.handleDelete);
			}

			else if(wtcBB.matchClass(obj, 'delButton')) {
				wtcBB.addEvent(obj, 'click', Thread.handleDeletion);
			}
		}
	},

	handleQuickEdit: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// already editing?
		if(Thread.isEditing == el.title) {
			Thread.exiting = true;
			window.location = el.a.href;

			return;
		}

		else if(Thread.isEditing != false) {
			return;
		}

		Thread.isEditing = el.title;
		Thread.doQuickEdit(el);
	},

	doQuickEdit: function(el) {
		if(Thread.ajaxLoad) {
			return;
		}

		var els = {
			'qearea': document.getElementById('qearea_' + el.title),
			'qedivit': document.getElementById('quickedit_' + el.title),
			'msgdivit': document.getElementById('regtext_' + el.title),
			'msg': document.getElementById('postmessage_' + el.title)
		}

		Message.use(els['qearea']);

		// do we need to fetch the textarea text?
		if(wtcBB.trim(els['qearea'].value) == '') {
			AJAX.load('do=save&what=postedittext', 'postid=' + el.title, function(response) { Thread.quickEditInsert(response, el, els, true); }, false);

			// assign some things so we can save our message...
			wtcBB.addEvent(els['qearea'], 'focus', function() {
														if(Thread.editTimeout) {
															window.clearTimeout(Thread.editTimeout);
															Thread.editTimeout = false;
														}
													});

			wtcBB.addEvent(els['qearea'], 'blur', function() {
														Thread.editTimeout = window.setTimeout(function() {
															Thread.quickEditSave(el, els);
														}, 200);
													});
		}

		else {
			els['msgdivit'].style.display = 'none';
			els['qedivit'].style.display = 'block';
			els['qearea'].focus();
		}
	},

	quickEditInsert: function(response, el, els, dis) {
		els['qearea'].value = response;

		if(dis) {
			els['msgdivit'].style.display = 'none';
			els['qedivit'].style.display = 'block';
			els['qearea'].focus();
		}
	},

	quickEditSave: function(el, els) {
		if(Thread.exiting) {
			return;
		}

		Message.closeAll();
		Thread.ajaxLoad = true;

		AJAX.load('do=save&what=postedit', 'postid=' + el.title + '&message=' + els['qearea'].value.replace('&', '^*^**^*^', 'g'), function(replaceText) { Thread.quickEditFinish(replaceText, el, els); }, false);
	},

	quickEditFinish: function(replaceText, el, els) {
		if(wtcBB.trim(replaceText) != 'Failed') els['msg'].innerHTML = replaceText;
		els['qedivit'].style.display = 'none';
		els['msgdivit'].style.display = 'block';

		Message.use(false);
		Thread.ajaxLoad = false;
		Thread.isEditing = false;
		Thread.editTimeout = false;

		if(wtcBB.trim(replaceText) == 'Failed') {
			AJAX.load('do=save&what=postedittext', 'postid=' + el.title, function(response) { Thread.quickEditInsert(response, el, els, false); }, false);
		}
	},

	handleQr: function(e, response) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// add to quick reply... if we haven't already
		if(!el.added) {
			var quick = document.getElementById('message');

			if((typeof quick) != 'undefined' && quick != null) {
				quick.value += '[quote=' + el.user.innerHTML + ']' + wtcBB.trim(wtcBB.backToHtml(response)) + '[/quote]' + "\n";
			}

			el.added = true;
		}

		Message.message.focus();
	},

	handleDelete: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// get the info
		var info = Thread.deleted[el.index];

		if(info[1]) {
			Thread.deleted[el.index][1] = false;
			el.src = window.delPlusSrc;
		}

		else {
			Thread.deleted[el.index][1] = true;
			el.src = window.delMinusSrc;
		}
	},

	handleQuote: function(e, response) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		var info = Thread.quoted[el.index];

		// add into quick reply?
		var quick = document.getElementById('message');
		//var myMessage = document.getElementById('message_' + info[0]);
		var myUsername = document.getElementById('username_' + info[0]);

		if(info[1]) {
			Thread.quoted[el.index][1] = false;
			el.src = window.quotePlusSrc;

			if((typeof quick) != 'undefined' && (typeof myUsername) != 'undefined') {
				quick.value = quick.value.replace('[quote=' + myUsername.innerHTML + ']' + wtcBB.trim(wtcBB.backToHtml(response)).replace("\r\n", "\n", "g") + '[/quote]' + "\n\n", '');
			}
		}

		else {
			Thread.quoted[el.index][1] = true;
			el.src = window.quoteMinusSrc;

			if((typeof quick) != 'undefined' && (typeof myUsername) != 'undefined') {
				quick.value += '[quote=' + myUsername.innerHTML + ']' + wtcBB.trim(wtcBB.backToHtml(response)) + '[/quote]' + "\n\n";
			}
		}
	},

	handleDeletion: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// cancel normal
		wtcBB.stopNormal(e);

		// add in to the deleted array
		var delButton = document.getElementById('delete_' + el.title);
		Thread.deleted[delButton.index][1] = true;

		// start forming the URL
		var url = './index.php?file=post&do=delete';

		// do the forming
		for(var i = 0; i < Thread.deleted.length; i++) {
			var info = Thread.deleted[i];

			// append postid IF we want it
			if(info[1]) {
				url += '&p[]=' + info[0];
			}
		}

		// don't forget about sessions
		if((typeof SESSURL) != 'undefined') {
			url += SESSURL.replace(/&amp;/, '&');
		}

		// go!
		window.location = url;
	},

	handleReply: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// add in the quoted array
		var quoteButton = document.getElementById('quote_' + el.title);
		Thread.quoted[quoteButton.index][1] = true;

		var url = window.replyURL + Thread.threadid;

		// we need to form the post reply URL based on quoted array
		for(var i = 0; i < Thread.quoted.length; i++) {
			var info = Thread.quoted[i];

			// append postid IF we want it
			if(info[1]) {
				url += '&p[]=' + info[0];
			}
		}

		if((typeof SESSURL) != 'undefined') {
			url += SESSURL.replace(/&amp;/, '&');
		}

		// go!
		window.location = url;
	}
}

wtcBB.addEvent(window, 'load', Thread.init);