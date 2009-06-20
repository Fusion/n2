var Reputations = {
	repid: 0,
	deleted: Array(),
	ajaxLoad: false,
	exiting: false,

	init: function() {
		// get our form element...
		var divit = document.getElementById('reputationsDisplay');
		Reputations.repid = divit.getAttribute('name');

		// now get our imgs...
		var imgs = divit.getElementsByTagName('img');

		for(var i = 0; i < imgs.length; i++) {
			var obj = imgs[i];

			// only if quote/del/reply/edit button
			if(wtcBB.matchClass(obj, 'deleteButton')) {
				Reputations.deleted[Reputations.deleted.length] = Array(obj.id.replace(/delete_/i, ''), false);
				obj.index = (Reputations.deleted.length - 1);

				wtcBB.addEvent(obj, 'click', Reputations.handleDelete);
			}

			else if(wtcBB.matchClass(obj, 'delButton')) {
				wtcBB.addEvent(obj, 'click', Reputations.handleDeletion);
			}
		}
	},

	handleDelete: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}

		// get the info
		var info = Reputations.deleted[el.index];

		if(info[1]) {
			Reputations.deleted[el.index][1] = false;
			el.src = window.delPlusSrc;
		}

		else {
			Reputations.deleted[el.index][1] = true;
			el.src = window.delMinusSrc;
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
		Reputations.deleted[delButton.index][1] = true;

		// start forming the URL
		var url = './index.php?file=profile&do=deletereputation';

		// do the forming
		for(var i = 0; i < Reputations.deleted.length; i++) {
			var info = Reputations.deleted[i];

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
}

wtcBB.addEvent(window, 'load', Reputations.init);