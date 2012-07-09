/*
 *
 * jQuery JSON
 *
 */
(function($){$.toJSON=function(o)
{if(typeof(JSON)=='object'&&JSON.stringify)
return JSON.stringify(o);var type=typeof(o);if(o===null)
return"null";if(type=="undefined")
return undefined;if(type=="number"||type=="boolean")
return o+"";if(type=="string")
return $.quoteString(o);if(type=='object')
{if(typeof o.toJSON=="function")
return $.toJSON(o.toJSON());if(o.constructor===Date)
{var month=o.getUTCMonth()+1;if(month<10)month='0'+month;var day=o.getUTCDate();if(day<10)day='0'+day;var year=o.getUTCFullYear();var hours=o.getUTCHours();if(hours<10)hours='0'+hours;var minutes=o.getUTCMinutes();if(minutes<10)minutes='0'+minutes;var seconds=o.getUTCSeconds();if(seconds<10)seconds='0'+seconds;var milli=o.getUTCMilliseconds();if(milli<100)milli='0'+milli;if(milli<10)milli='0'+milli;return'"'+year+'-'+month+'-'+day+'T'+
hours+':'+minutes+':'+seconds+'.'+milli+'Z"';}
if(o.constructor===Array)
{var ret=[];for(var i=0;i<o.length;i++)
ret.push($.toJSON(o[i])||"null");return"["+ret.join(",")+"]";}
var pairs=[];for(var k in o){var name;var type=typeof k;if(type=="number")
name='"'+k+'"';else if(type=="string")
name=$.quoteString(k);else
continue;if(typeof o[k]=="function")
continue;var val=$.toJSON(o[k]);pairs.push(name+":"+val);}
return"{"+pairs.join(", ")+"}";}};$.evalJSON=function(src)
{if(typeof(JSON)=='object'&&JSON.parse)
return JSON.parse(src);return eval("("+src+")");};$.secureEvalJSON=function(src)
{if(typeof(JSON)=='object'&&JSON.parse)
return JSON.parse(src);var filtered=src;filtered=filtered.replace(/\\["\\\/bfnrtu]/g,'@');filtered=filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,']');filtered=filtered.replace(/(?:^|:|,)(?:\s*\[)+/g,'');if(/^[\],:{}\s]*$/.test(filtered))
return eval("("+src+")");else
throw new SyntaxError("Error parsing JSON, source is not valid.");};$.quoteString=function(string)
{if(string.match(_escapeable))
{return'"'+string.replace(_escapeable,function(a)
{var c=_meta[a];if(typeof c==='string')return c;c=a.charCodeAt();return'\\u00'+Math.floor(c/16).toString(16)+(c%16).toString(16);})+'"';}
return'"'+string+'"';};var _escapeable=/["\\\x00-\x1f\x7f-\x9f]/g;var _meta={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'};})(jQuery);

/*
 *
 * jQuery pngFix
 *
 */
(function($){jQuery.fn.pngFix=function(settings){settings=jQuery.extend({blankgif:"blank.gif"},settings);var ie55=navigator.appName=="Microsoft Internet Explorer"&&parseInt(navigator.appVersion)==4&&navigator.appVersion.indexOf("MSIE 5.5")!=-1;var ie6=navigator.appName=="Microsoft Internet Explorer"&&parseInt(navigator.appVersion)==4&&navigator.appVersion.indexOf("MSIE 6.0")!=-1;if(jQuery.browser.msie&&(ie55||ie6)){jQuery(this).find("img[src$=.png]").each(function(){jQuery(this).attr("width",jQuery(this).width());
jQuery(this).attr("height",jQuery(this).height());var prevStyle="";var strNewHTML="";var imgId=jQuery(this).attr("id")?'id="'+jQuery(this).attr("id")+'" ':"";var imgClass=jQuery(this).attr("class")?'class="'+jQuery(this).attr("class")+'" ':"";var imgTitle=jQuery(this).attr("title")?'title="'+jQuery(this).attr("title")+'" ':"";var imgAlt=jQuery(this).attr("alt")?'alt="'+jQuery(this).attr("alt")+'" ':"";var imgAlign=jQuery(this).attr("align")?"float:"+jQuery(this).attr("align")+";":"";var imgHand=jQuery(this).parent().attr("href")?
"cursor:hand;":"";if(this.style.border){prevStyle+="border:"+this.style.border+";";this.style.border=""}if(this.style.padding){prevStyle+="padding:"+this.style.padding+";";this.style.padding=""}if(this.style.margin){prevStyle+="margin:"+this.style.margin+";";this.style.margin=""}var imgStyle=this.style.cssText;strNewHTML+="<span "+imgId+imgClass+imgTitle+imgAlt;strNewHTML+='style="position:relative;white-space:pre-line;display:inline-block;background:transparent;'+imgAlign+imgHand;strNewHTML+="width:"+
jQuery(this).width()+"px;"+"height:"+jQuery(this).height()+"px;";strNewHTML+="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"+"(src='"+jQuery(this).attr("src")+"', sizingMethod='scale');";strNewHTML+=imgStyle+'"></span>';if(prevStyle!="")strNewHTML='<span style="position:relative;display:inline-block;'+prevStyle+imgHand+"width:"+jQuery(this).width()+"px;"+"height:"+jQuery(this).height()+"px;"+'">'+strNewHTML+"</span>";jQuery(this).hide();jQuery(this).after(strNewHTML)});jQuery(this).find("*").each(function(){var bgIMG=
jQuery(this).css("background-image");if(bgIMG.indexOf(".png")!=-1){var iebg=bgIMG.split('url("')[1].split('")')[0];jQuery(this).css("background-image","none");jQuery(this).get(0).runtimeStyle.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+iebg+"',sizingMethod='scale')"}});jQuery(this).find("input[src$=.png]").each(function(){var bgIMG=jQuery(this).attr("src");jQuery(this).get(0).runtimeStyle.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader"+"(src='"+bgIMG+"', sizingMethod='scale');";
jQuery(this).attr("src",settings.blankgif)})}return jQuery}})(jQuery);

/*
 *
 * jQuery plugins
 *
 */
jQuery.fn.extend({
	
	//////////////////////////////////////////////////
	//////Text Hints in input
	//////////////////////////////////////////////////
	hint: function(action) {
		if(!$(this).length) { return false; }
		else {
			
			function init(el) {
				el.each(function() {
					var input = $(this);
					input.focus(function() {
						if($(this).val() == $(this).attr("title")) {
							hide($(this));
						}
					}).blur(function() {
						if(jQuery.trim($(this).val()) == "") {
							show($(this));
						}
					});
					
					input.parents("form").submit(function() {
						if(input.val() == input.attr("title")) { hide(input); }
					});
					if(!$.trim($(this).val()).length) {
						show($(this));
					}
				});
			}
			
			function hide(el) {
				$(el).each(function() {
					$(this).removeClass("hasHint");
					if($(this).val() == $(this).attr("title")) { $(this).val(""); }
				});
			}
			
			function show(el) {
				$(el).each(function() {
					$(this).val($(this).attr("title")).addClass("hasHint");
				});
			}
			
			if(!action) {
				init($(this));
			} else if(action == "hide") {
				hide($(this));
			} else if(action == "show") {
				show($(this));
			} else {
				init($(this));
			}
		}
		return this;
	},
	
	collapsable : function() {
		
		if(!$(this).length) { return; }
		var $el = $(this);
		
		$el.hint();
		
		$el.focus(function() {
			if($(this).val() == $(this).attr("title") || !$.trim($(this).val()).length) {
				$(this).animate({height:'200px'},500);
			}
		});
		
		$el.blur(function() {
			if(!$.trim($(this).val()).length || $(this).val() == $(this).attr("title")) {
				$(this).animate({height:'30px'},300);
			}
		});
		
		$el.each(function() {
			if(!$.trim($(this).val()).length || $(this).val() == $(this).attr("title")) {
				$(this).height(30);
			}
		});
		
		$el.parents("form").one('submit',function() {
			$el.each(function() {
				if(!$.trim($(this).val()).length || $(this).val() == $(this).attr("title")) {
					$(this).val("");
				}
			});
		});
		
		return $(this);
	}
	
});

/*
 *
 * Array Object extends
 *
 */
if(typeof(Array.prototype.indexOf) == undefined) {
	Array.prototype.indexOf = function(it) {
		for(var i = 0; i < this.length; i++) {
			if(this[i] == it) {
				return i;
			}
		}
		return -1;
	};
}
if(typeof(Array.prototype.inArray) == undefined) {
	Array.prototype.inArray = function(it) {
		return this.indexOf(it) == -1 ? false:true;
	};
}


/*
 *
 * String Object extends
 *
 */
String.prototype.noaccent = function() {
  return this.replace(/[àâä]/gi,"a").replace(/[éèêë]/gi,"e").replace(/[îï]/gi,"i").replace(/[ôö]/gi,"o").replace(/[ùûü]/gi,"u");
};

String.prototype.ext = function(ext) {
  if(this.indexOf("?") >= 0) return this.replace(/\.([a-zA-z]{1,4})\?/gi, ((ext.substr(0,1) == ".") ? ext:"."+ext) + "?");
  else if(this.indexOf("&") >= 0) return this.replace(/\.([a-zA-z]{1,4})\&/gi, ((ext.substr(0,1) == ".") ? ext:"."+ext) + "&");
  else return this.replace(/\.([a-zA-z]{1,4})$/gi, (ext.substr(0,1) == ".") ? ext:"."+ext); 
};