var DragIt = {
	myObj: null,
	
	init: function(objs) {
		if(!objs.length) {
			return;
		}
		
		window.onload = function() {		
			for(var i = 0; i < objs.length; i++) {
				DragIt.load(document.getElementById(objs[i]));
			}
		}
	},
	
	load: function(obj) {
		if(!obj) {
			return;
		}
		
		DragIt.myEl = obj;
		DragIt.myBody = document.getElementsByTagName('body')[0];
		DragIt.myHtml = document.getElementsByTagName('html')[0];
		DragIt.drag = false;
		
		// make sure we can't drag childs...
		var myChildNodes = DragIt.myEl.getElementsByTagName('*');
		
		// this is used to find the parent element that we actually want to drag
		// we can use e.currentTarget in mozilla, but window.event.targetElement
		// doesn't seem to be working in IE... so... this is my own way
		if(myChildNodes.length) {
			for(var i = 0; i < myChildNodes.length; i++) {
				var node = myChildNodes[i];
				
				if(!node.className.match(/\bnoDrag\b/i)) {
					node.className += ' noDrag';
				}
			}
		}
		
		// and umm... get rid of noDrag if we have it...
		DragIt.myEl.className = DragIt.myEl.className.replace(/\bnoDrag\b/i, '');
		
		// make it so we can drag...
		DragIt.myEl.style.position = 'relative';
		
		// set them to 0... so we have some values to start with
		DragIt.myEl.style.top = 0;
		DragIt.myEl.style.left = 0;
		
		wtcBB.addEvent(DragIt.myEl, 'mousedown', DragIt.dragStart);
		wtcBB.addEvent(DragIt.myHtml, 'mousemove', DragIt.dragMove);
		wtcBB.addEvent(DragIt.myEl, 'mouseup', DragIt.dragEnd);
	},
	
	dragStart: function(e) {		
		if(!(mouse = wtcBB.getE(e))) {
			return;
		}
		
		DragIt.myObj = wtcBB.getTarget(e);
		DragIt.myObj = DragIt.getParentTarget(DragIt.myObj);
		
		// stop normal stuff...
		wtcBB.stopNormal(e);
		
		// change cursor...
		DragIt.myBody.style.cursor = 'move';
		DragIt.drag = true;
		DragIt.lastX = mouse.clientX;
		DragIt.lastY = mouse.clientY;
		
		return false;
	},
	
	dragMove: function(e) {		
		if(!DragIt.drag || !(mouse = wtcBB.getE(e))) {
			return;
		}
		
		// stop normal stuff...
		wtcBB.stopNormal(e);
		
		DragIt.myObj.style.left = (parseInt(DragIt.myObj.style.left) + (mouse.clientX - DragIt.lastX)) + 'px';
		DragIt.myObj.style.top = (parseInt(DragIt.myObj.style.top) + (mouse.clientY - DragIt.lastY)) + 'px';
		
		DragIt.lastX = mouse.clientX;
		DragIt.lastY = mouse.clientY;
	},
	
	dragEnd: function(e) {
		// make sure we don't allow normal stuff to happen...
		wtcBB.stopNormal(e);
		
		// change cursor back to normal...
		DragIt.myBody.style.cursor = 'default';
		DragIt.drag = false;
	},
	
	getParentTarget: function(el) {
		while(el.nodeName.toLowerCase() != 'html' && el.className.match(/\bnoDrag\b/i)) {
			el = el.parentNode;
		}
		
		if(el.nodeName.toLowerCase() == 'html') {
			return false;
		}
		
		return el;
	}
}

DragIt.init(Array('sweet'));