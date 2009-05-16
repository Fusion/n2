var AJAX = {
	req: false,
	completeStatus: false,
	myXML: '',
	funcRef: false,
	post: false,
	fileLoc: '',
	queryStr: '',
	xml: false,
	URL: 'index.php?file=ajax',

	load: function(myGet, myPost, exe, isXml) {
		AJAX.funcRef = exe;
		AJAX.post = myPost;
		AJAX.get = myGet;
		AJAX.xml = isXml;

		if(window.XMLHttpRequest) {
			try {
				AJAX.req = new XMLHttpRequest();
			}

			catch(e) {
				AJAX.req = false;
			}
		}

		else if(window.ActiveXObject) {
			try {
				AJAX.req = new ActiveXObject('Msxml2.XMLHTTP');
			}

			catch(e) {
				try {
					AJAX.req = new ActiveXObject('Microsoft.XMLHTTP');
				}

				catch(e) {
					AJAX.req = false;
				}
			}
		}

		if(AJAX.req) {
			AJAX.req.onreadystatechange = AJAX.handleData;

			if(wtcBB.trim(AJAX.post) != '') {
				if(wtcBB.trim(AJAX.get) != '') {
					AJAX.get = '&' + AJAX.get;
				}

				AJAX.req.open('POST', AJAX.URL + AJAX.get + '&' + AJAX.post, true);
				AJAX.req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				AJAX.req.send(AJAX.post);
			}

			else {
				AJAX.req.open('GET', AJAX.URL + AJAX.get, true);
				AJAX.req.send(null);
			}
		}
	},

	handleData: function() {
		if(AJAX.req.readyState != 4) {
			return;
		}

		if(AJAX.xml) {
			AJAX.funcRef(AJAX.req.responseXML);
		}

		else {
			AJAX.funcRef(AJAX.req.responseText);
		}
	}
}