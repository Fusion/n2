var wtcBB = {
	// we have some things to do before page loading...
	initPrevPageLoad: function() {
		// The problem with detecting javascript this way
		// is that if cookies are disabled, and javascript
		// is enabled, we have an infinite loop... meh

		/*******
		// we want to check cookies IMMEDIATELY
		var cookieSet = true;

		// is the cookie set?
		if(!wtcBB.getCookie('jsEnabled')) {
			cookieSet = false;
			wtcBB.checkCookies();
		}

		// was it set before?
		// if not, reload so we get appropriate results
		if(!cookieSet) {
			window.location = window.location;
		}
		*******/
	},

	init: function() {
		// this initiates drop down boxes
		// if you want something to appear/disappear, put this in the class of that element:
		// 'exCol_EVENT_ID-OF-ELEMENT
		// 'EVENT' should be an event (don't include 'on'- ie: don't use 'onclick' use 'click')
		// 'ID-OF-ELEMENT' should be the id of the element that will appear and diappear
		// If an 'img' element has an id of 'ID-OF-ELEMENT_img' then 'collapse' will be replaced
		// 		with 'expand' and vice versa in the image name
		exCol.init();
	},

	addEvent: function(elm, evType, fn) {
		if(elm.addEventListener) {
			elm.addEventListener(evType, fn, false);
		}

		else if(elm.attachEvent) {
			var r = elm.attachEvent('on' + evType, fn);
			return r;
		}

		else {
			elm['on' + evType] = fn;
		}
	},

	offsetTop: function(obj) {
		retval = 0; useobj = obj;

		while(useobj.nodeName.toLowerCase() != 'html') {
			if(useobj.nodeName.toLowerCase() != 'tr') {
				retval += useobj.offsetTop;
			}

			useobj = useobj.parentNode;
		}

		return retval;
	},

	offsetLeft: function(obj) {
		retval = 0; useobj = obj;

		while(useobj.nodeName.toLowerCase() != 'html') {
			retval += useobj.offsetLeft;
			useobj = useobj.parentNode;
		}

		return retval;
	},

	ascendDOM: function(e, target) {
		while(e.nodeName.toLowerCase() != target && e.nodeName.toLowerCase() != 'html') {
			e = e.parentNode;
		}

		return (e.nodeName.toLowerCase() == 'html') ? false : e;
	},

	nextSiblings: function(e, target) {
		while(e.nodeName.toLowerCase() != target && e.nodeName) {
			e = e.nextSibling;
		}

		return (e.nodeName) ? e : false;
	},

	previousSiblings: function(e, target) {
		while(e.nodeName.toLowerCase() != target && e.nodeName) {
			e = e.previousSibling;
		}

		return (e.nodeName) ? e : false;
	},

	// use to get a single value...
	getCookie: function(cookieName) {
		var check = document.cookie.indexOf(cookiePrefix + cookieName + '=');

		// nothin...
		if(check == -1) {
			return '';
		}

		var checkLength = (cookiePrefix + cookieName + '=').length + check;
		var stop = document.cookie.indexOf(';', checkLength);

		// just to the end then...
		if(stop == -1) {
			stop = document.cookie.length;
		}

		return document.cookie.substring(checkLength, stop);
	},

	// this will return an array of CSV in cookie
	getArrayCookie: function(cookieName) {
		var cookieVal;
		var retVal = Array();

		if(!(cookieVal = wtcBB.getCookie(cookieName))) {
			return false;
		}

		// allow spaces inbetween commas
		var splitting = cookieVal.split(/\s*,\s*/);

		for(var i = 0; i < splitting.length; i++) {
			retVal[retVal.length] = splitting[i];
		}

		return retVal;
	},

	setCookie: function(cookieName, cookieValue) {
		tempDate = new Date();
		expireDate = new Date(tempDate.getTime() + (60 * 60 * 24 * 365 * 1000));

		//alert(document.cookie);

		document.cookie = cookiePrefix + cookieName + '=' + cookieValue + ';expires=' + expireDate + ';path=' + wtcBBPath + ';domain=' + wtcBBDomain;
	},

	delCookie: function(cookieName) {
		regex = new RegExp(cookiePrefix + cookieName + '=.*?;');
		document.cookie = document.cookie.replace(regex, '');
	},

	checkCookies: function() {
		wtcBB.setCookie('jsEnabled', true);
	},

	getTarget: function(e) {
		return (window.event ? window.event.srcElement : e ? e.target : false);
	},

	getE: function(e) {
		return (window.event ? window.event : e ? e : false);
	},

	getCharCode: function(e) {
		var retval;

		if(e && e.which) {
			retval = e.which;
		}

		else if(e && e.keyCode) {
			retval = e.keyCode;
		}

		else if(window.event && window.event.keyCode) {
			retval = window.event.keyCode;
		}

		else {
			retval = false;
		}

		return retval;
	},

	stopNormal: function(e) {
		if(window.event) {
			window.event.cancelBubble = true;
			window.event.returnValue = false;
		}

		else {
			e.stopPropagation();
			e.preventDefault();
		}
	},

	selectLoc: function(formSelect) {
		window.location = formSelect.options[formSelect.selectedIndex].value;
	},

	tickAllYes: function(formObj) {
		for(x = 0; x < formObj.elements.length; x++) {
			radio = formObj.elements[x];

			if(radio.type != 'radio') {
				continue;
			}

			if(radio.value == 1) {
				radio.checked = true;
			}

			else {
				radio.checked = false;
			}
		}
	},

	tickAllNo: function(formObj) {
		for(x = 0; x < formObj.elements.length; x++) {
			radio = formObj.elements[x];

			if(radio.type != 'radio') {
				continue;
			}

			if(radio.value == 1) {
				radio.checked = false;
			}

			else if(radio.value == 0) {
				radio.checked = true;
			}
		}
	},

	tickBoxes: function(formObj, tick) {
		tickvalue = false;

		if(tick.checked == true) {
			tickvalue = true;
		}

		for(x = 1; x < formObj.elements.length; x++) {
			tickbox = formObj.elements[x];

			if(tickbox.type != 'checkbox') {
				continue;
			}

			tickbox.checked = tickvalue;
		}
	},

	colorViewer: function(name, input) {
		var divit = document.getElementById(name);

		try {
			divit.style.background = input.value;
		} catch(csserror) {
			divit.style.background = "transparent";
		}
	},

	trim: function(trimmer) {
		return trimmer.replace(/^\s+/g, '').replace(/\s+$/g, '');
	},

	backToHtml: function(text) {
		text = text.replace(/&lt;/g, '<');
		text = text.replace(/&gt;/g, '>');
		text = text.replace(/&amp;/g, '&');

		return text;
	},

	matchClass: function(obj, cName) {
		myreg = new RegExp('\\b\\s*' + cName + '\\b');

		if(obj.className.match(myreg)) {
			return true;
		}

		return false;
	},

	addClass: function(obj, cName) {
		return obj.className + ' ' + cName;
	},

	removeClass: function(obj, cName) {
		myreg = new RegExp('\\b\\s*' + cName + '\\b');
		return obj.className.replace(myreg, '');
	}
}

wtcBB.initPrevPageLoad();
wtcBB.addEvent(window, 'load', wtcBB.init);