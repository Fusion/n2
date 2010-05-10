<?php
/*
Plugin Name: nicEdit
Plugin URI: http://n2.nextbbs.com
Description: This is a WYSIWYG, Javascript-based editor for your text areas. It saves to BBCode.
Author: Chris F Ravenscroft
Version: 1.0
Author URI: http://nexus.zteo.com
Long Name: WYSIWYG
N2Type: E
*/

function getModule_nicEdit()
{
	return new NicEdit();
}

class NicEdit implements EditorModule
{
	function __construct()
	{
	}

	function encode($text)
	{
		return 
			str_replace(
				array('<br>', '&nbsp;'),
				array("\n", ' '),
				$text);
	}
	
	function decode($text)
	{
		return 
			str_replace(
				array("\n"),
				array('<br>'),
				$text);		
	}

	function render($content, $areaId, $class = null)
	{
		$jspath = n2src('modules/nicEdit/nicEdit.js');
		$icpath = n2src('modules/nicEdit/nicEditorIcons.gif');
		
		$html = "<div align=\"left\"><textarea name=\"{$areaId}\" id=\"{$areaId}\"";
		if(!empty($class))
			$html .= " class=\"{$class}\"";
		$html .= '>' . $content . "</textarea></div>\n";

		$header = <<<EOB
<style type="text/css">
.nicEdit-main {
	background-color: #fff !important;
}
</style>		
<script language="javascript" type="text/javascript" src="{$jspath}"></script>

EOB;
		$js = <<<EOB
<script type="text/javascript">
var nicN2Code = bkClass.extend({
	construct : function(nicEditor) {
		this.ne = nicEditor;
		nicEditor.addEvent('get',this.n2Get.closure(this));
		nicEditor.addEvent('set',this.n2Set.closure(this));
		
		var loadedPlugins = this.ne.loadedPlugins;
		for(itm in loadedPlugins) {
			if(loadedPlugins[itm].toXHTML) {
				this.xhtml = loadedPlugins[itm];
			}
		}
	},
	
	// getContent() retrieves editor's content and invokes 'get'
	n2Get : function(ni) {
		var xhtml = this.xhtml.toXHTML(ni.getElm());	// From BBCode plugin
		ni.content = this.toBBCode(xhtml);				// From BBCode plugin
		ni.content = ni.content.replace(/<br \/>/g, "\\n");
	},
	
	// setContent() sets editor's new content and invokes 'set'
	n2Set : function(ni) {
		// Note: retain the order below! This allows multi-line regex...
		ni.content = ni.content.replace(/\\n/g, "<br \/>");	
		ni.content = this.fromBBCode(ni.content);		// From BBCode plugin
	},
	
	// Begin: From BBCode plugin, but modified
	toBBCode : function(xhtml) {
		function rp(r,m) {
			xhtml = xhtml.replace(r,m);
		}
		
		function rps(r,m) {
			xhtml = xhtml.replace(r,m).
				replace(/\\[size=(.*?)px\\]/gi,"[size=$1]").
				replace(/\\[size=x-large\\]/gi,"[size=24]").
				replace(/\\[size=large\\]/gi,"[size=18]").
				replace(/\\[size=medium\\]/gi,"[size=14]").
				replace(/\\[size=small\\]/gi,"[size=12]").
				replace(/\\[size=x-small\\]/gi,"[size=10]").
				replace(/\\[size=xx-small\\]/gi,"[size=8]");
		}
		
		rp(/\\n/gi,"");
		rp(/<strong>(.*?)<\\/strong>/gi,"[b]$1[/b]");
		rp(/<em>(.*?)<\\/em>/gi,"[i]$1[/i]");
		rp(/<p>(.*?)<\\/p>/gi,"[p]$1[/p]");
		rp(/<pre>(.*?)<\\/pre>/gi,"[pre]$1[/pre]");
		rp(/<span.*?style="text-decoration:underline;">(.*?)<\\/span>/gi,"[u]$1[/u]");
		rp(/<span.*?style="text-decoration:line-through;">(.*?)<\\/span>/gi,"[strike]$1[/strike]");
		rp(/<span.*?style="color:(.*?);">(.*?)<\\/span>/gi, "[color=$1]$2[/color]");
		rp(/<span.*?style="background-color:(.*?);">(.*?)<\\/span>/gi, "[background=$1]$2[/background]");
		rps(/<span.*?style="font-size:(.*?);">(.*?)<\\/span>/gi,"[size=$1]$2[/size]");
		rp(/<span.*?style="font-family:(.*?);">(.*?)<\\/span>/gi,"[font=$1]$2[/font]");
		rp(/<ul.*?>(.*?)<\\/ul>/gi,"[ul]$1[/ul]");
		rp(/<li.*?>(.*?)<\\/li>/gi,"[*]$1[/*]");
		rp(/<ol.*?>(.*?)<\\/ol>/gi,"[ol]$1[/ol]");
		rp(/<img.*?src="(.*?)".*?>/gi,"[img]$1[/img]");
		rp(/<h(.?)>(.*?)<\\/h.?>/gi,"[header=$1]$2[/header]");
		rp(/<hr.*?>/gi,"[hr] [/hr]");
		rp(/<a.*?href="(.*?)".*?>(.*?)<\\/a>/gi,"[url=$1]$2[/url]");
		rp(/<div style="text-align:(.*?);">(.*?)<\\/div>/gi, "[align=$1]$2[/align]");
		rp(/<div style="margin-left:(.*?)px;">(.*?)<\\/div>/gi, "[indent=$1]$2[/indent]");
		rp(/<div><br.*?><\\/div>/g, "\\n");
		rp(/<div>(.*?)<\\/div>/gi,"\\n$1");
		rp(/<sub>(.*?)<\\/sub>/gi,"[sub]$1[/sub]");
		rp(/<sup>(.*?)<\\/sup>/gi,"[sup]$1[/sup]");
		rp(/<br.*?>/gi,"\\n");
		rp(/<.*?>.*?<\\/.*?>/gi,"");
		
		return xhtml;
	},
	
	fromBBCode : function(bbCode) {
		function rp(r,m) {
			bbCode = bbCode.replace(r,m);
		}		
		
		rp(/\\[b\\](.*?)\\[\\/b\\]/gi,"<strong>$1</strong>");
		rp(/\\[i\\](.*?)\\[\\/i\\]/gi,"<em>$1</em>");
		rp(/\\[p\\](.*?)\\[\\/p\\]/gi,"<p>$1</p>");
		rp(/\\[pre\\](.*?)\\[\\/pre\\]/gi,"<pre>$1</pre>");
		rp(/\\[u\\](.*?)\\[\\/u\\]/gi,"<span style=\"text-decoration:underline;\">$1</span>");
		rp(/\\[strike\\](.*?)\\[\\/strike\\]/gi,"<span style=\"text-decoration:line-through;\">$1</span>");
		rp(/\\[color=(.*?)\\](.*?)\\[\\/color\\]/gi, "<span style=\"color:$1;\">$2</span>");
		rp(/\\[background=(.*?)\\](.*?)\\[\\/background\\]/gi, "<span style=\"background-color:$1;\">$2</span>");
		rp(/\\[size=(.*?)\\](.*?)\\[\\/size\\]/gi,"<span style=\"font-size:$1px;\">$2</span>");
		rp(/\\[font=(.*?)\\](.*?)\\[\\/font]/gi,"<span style=\"font-family:$1;\">$2</span>");
		rp(/\\[ul\\](.*?)\\[\\/ul\\]/gi,"<ul>$1</ul>");
		rp(/\\[ol\\](.*?)\\[\\/ol\\]/gi,"<ol>$1</ol>");
		rp(/\\[\\*\\](.*?)\\[\\/\\*\\]/gi,"<li>$1</li>");
		rp(/\\[img\\](.*?)\\[\\/img\\]/gi,"<img src=\"$1\" />");
		rp(/\\[header=(.?)\\](.*?)\\[\\/header\\]/gi,"<h$1>$2</h$1>");
		rp(/\\[hr\\] \\[\\/hr\\]/gi, "<hr style=\"width:100%;height:2px;\">");
		rp(/\\[url=(.*?)\\](.*?)\\[\\/url\\]/gi,"<a href=\"$1\">$2</a>");
		rp(/\\[align=(.*?)\\](.*?)\\[\\/align\\]/gi, "<div style=\"text-align:$1;\">$2</div>");
		rp(/\\[indent=(.*?)\\](.*?)\\[\\/indent\\]/gi, "<div style=\"margin-left:$1px;\">$2</div>");
		rp(/\\[sub\\](.*?)\\[\\/sub\\]/gi,"<sub>$1</sub>");
		rp(/\\[sup\\](.*?)\\[\\/sup\\]/gi,"<sup>$1</sup>");
		rp(/\\n/gi,"<br />");
		//rp(/\\[.*?\\](.*?)\\[\\/.*?\\]/gi,"$1");
		
		return bbCode;
	}
	// End: From BBCode plugin, but modified
});
nicEditors.registerPlugin(nicN2Code);

var _editor = new Object();
_editor.command = function(type, arg)
{
	var instance = this.editor.selectedInstance;
	if(!instance) instance = this.editor.lastSelectedInstance;
	if(!instance) return;
	instance.nicCommand(type, arg);
}
_editor.addHTML = function(content)
{
	this.command('insertHTML', content);
};

_editor.addImage = function(uri)
{
	this.command('insertImage', uri);
};

_editor._insertHTML = function(html)
{				
    /*
     * Here is how I would theoritically fix the lack of insertHTML in IE:
     * I would get/create a range then invoke pasteHTML
     *
     *	if(document.all) {
	 *		post.focus(); // Focus so that current active selection is within that particular textarea
     *		post.caretPos = document.selection.createRange();
     *		document.pasteHTML(html); // or something...
     *	}
     *
     * But at this point I am going to take the easy road...
	 */
	 
	if(document.all)
	{
		var e = nicEditors.findEditor('$areaId');
		e.setContent(e.getContent() + html);
	}
	else
	{
		nicEditors.findEditor('$areaId').nicCommand('insertHTML', html);
	}
}

// Plug-in schtuff

_editor.editorInsertSmileyCallback = function(el)
{
	nicEditors.findEditor('$areaId').nicCommand('insertImage', el.src);
}

_editor.editorInsertAttachmentCallback = function(id, name, mime, thumb)
{
	var attachLink = HOME + '?file=attach&a=' + id;

	// image?
	if(mime.indexOf('image') != -1) {
		if(thumb == 'thumb') {
			var html = '<a href="' + attachLink + '"><img src="' + attachLink + '&thumb=1" /></a>' ;
			_editor._insertHTML(html);
		}

		else {
			nicEditors.findEditor('$areaId').nicCommand('insertImage', attachLink);
		}
	}

	else {
		var html = '<a href="' + attachLink + '">' + name + '</a>' ;
		_editor._insertHTML(html);
	}
}

// Action! Hide bbcode block, get textarea, hide it and display rich text editor

var bbcodeBlock = document.getElementById('bbcode');
if(bbcodeBlock)
	bbcodeBlock.style.display = 'none';

var text = document.getElementById('$areaId').value;
_editor.editor = new nicEditor({
	iconsPath:'{$icpath}',
	fullPanel:true,
	xhtml:true,
	bbCode:true
}).panelInstance('$areaId');

// This is sad but for some reason nicEdit isn't calling setContent()...?
nicEditors.findEditor('$areaId').setContent(text);
</script>

EOB;
		return $html . $header . $js;
	}
}
?>
