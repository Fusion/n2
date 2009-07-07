var Tabs = {
	prevOpen: '',
	
	init: function() {
		// get all UL tabs... and set appropriate events for A elements
		var allUls = document.getElementsByTagName('ul');
		
		for(var i = 0; i < allUls.length; i++) {			
			if(!allUls[i].className.match(/\btabs\b/)) {
				continue;
			}
			
			var childLis = allUls[i].getElementsByTagName('li');
		
			var foundMain = false;
				
			for(var k = 0; k < childLis.length; k++) {
				var aObj = childLis[k].getElementsByTagName('a')[0];
				
				wtcBB.addEvent(aObj, 'click', Tabs.handleTabs);
				if(aObj.id == 'main') {
					foundMain = true;
					Tabs.showTab(aObj);
				}
				
				else {
					if(!foundMain && aObj.id == 'extra') {
						Tabs.showTab(aObj);
					}
					else {
						Tabs.hideTab(aObj);
					}
				}
			}
		}
	},
	
	handleTabs: function(e) {
		if(!(el = wtcBB.getTarget(e))) {
			return;
		}
		
		if(Tabs.prevOpen != '') {
			Tabs.hideTab(Tabs.prevOpen);
		}
		
		Tabs.showTab(el);
	},
	
	showTab: function(el) {
		var tabObj = document.getElementById(el.id + '_table');
		el.parentNode.className = 'selected';
		
		tabObj.parentNode.style.display = 'block';
		Tabs.prevOpen = el;
	},
	
	hideTab: function(el) {
		var tabObj = document.getElementById(el.id + '_table');
		el.parentNode.className = '';
		
		tabObj.parentNode.style.display = 'none';
	}
}

wtcBB.addEvent(window, 'load', Tabs.init);