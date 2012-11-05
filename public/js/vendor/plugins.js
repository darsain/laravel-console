// Avoid `console` errors in browsers that lack a console.
(function() {
	var method;
	var noop = function noop() {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});

	while (length--) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());

/* jwerty - Awesome handling of keyboard events */
(function(m,u){function j(a,b){return null===a?"null"===b:void 0===a?"undefined"===b:a.is&&a instanceof k?"element"===b:7<Object.prototype.toString.call(a).toLowerCase().indexOf(b)}function p(a){var b,d,f,e,i,c,g,l;if(a instanceof p)return a;j(a,"array")||(a=String(a).replace(/\s/g,"").toLowerCase().match(/(?:\+,|[^,])+/g));b=0;for(d=a.length;b<d;++b){j(a[b],"array")||(a[b]=String(a[b]).match(/(?:\+\/|[^\/])+/g));c=[];for(f=a[b].length;f--;){g=a[b][f];i={jwertyCombo:String(g),shiftKey:!1,ctrlKey:!1,
altKey:!1,metaKey:!1};j(g,"array")||(g=String(g).toLowerCase().match(/(?:(?:[^\+])+|\+\+|^\+$)/g));for(e=g.length;e--;)"++"===g[e]&&(g[e]="+"),g[e]in h.mods?i[v[h.mods[g[e]]]]=!0:g[e]in h.keys?i.keyCode=h.keys[g[e]]:l=g[e].match(/^\[([^-]+\-?[^-]*)-([^-]+\-?[^-]*)\]$/);if(j(i.keyCode,"undefined"))if(l&&l[1]in h.keys&&l[2]in h.keys){l[2]=h.keys[l[2]];l[1]=h.keys[l[1]];for(e=l[1];e<l[2];++e)c.push({altKey:i.altKey,shiftKey:i.shiftKey,metaKey:i.metaKey,ctrlKey:i.ctrlKey,keyCode:e,jwertyCombo:String(g)});
i.keyCode=e}else i.keyCode=0;c.push(i)}this[b]=c}this.length=b;return this}var q=m.document,k=m.jQuery||m.Zepto||m.ender||q,r,s;k===q?(r=function(a,b){return a?k.querySelector(a,b||k):k},s=function(a,b){a.addEventListener("keydown",b,!1)},$f=function(a,b){var d=document.createEvent("Event"),f;d.initEvent("keydown",!0,!0);for(f in b)d[f]=b[f];return(a||k).dispatchEvent(d)}):(r=function(a,b){return k(a||q,b)},s=function(a,b){k(a).bind("keydown.jwerty",b)},$f=function(a,b){k(a||q).trigger(k.Event("keydown",
b))});var v={16:"shiftKey",17:"ctrlKey",18:"altKey",91:"metaKey"},h={mods:{"\u21e7":16,shift:16,"\u2303":17,ctrl:17,"\u2325":18,alt:18,option:18,"\u2318":91,meta:91,cmd:91,"super":91,win:91},keys:{"\u232b":8,backspace:8,"\u21e5":9,"\u21c6":9,tab:9,"\u21a9":13,"return":13,enter:13,"\u2305":13,pause:19,"pause-break":19,"\u21ea":20,caps:20,"caps-lock":20,"\u238b":27,escape:27,esc:27,space:32,"\u2196":33,pgup:33,"page-up":33,"\u2198":34,pgdown:34,"page-down":34,"\u21df":35,end:35,"\u21de":36,home:36,
ins:45,insert:45,del:46,"delete":46,"\u2190":37,left:37,"arrow-left":37,"\u2191":38,up:38,"arrow-up":38,"\u2192":39,right:39,"arrow-right":39,"\u2193":40,down:40,"arrow-down":40,"*":106,star:106,asterisk:106,multiply:106,"+":107,plus:107,"-":109,subtract:109,";":186,semicolon:186,"=":187,equals:187,",":188,comma:188,".":190,period:190,"full-stop":190,"/":191,slash:191,"forward-slash":191,"`":192,tick:192,"back-quote":192,"[":219,"open-bracket":219,"\\":220,"back-slash":220,"]":221,"close-bracket":221,
"'":222,quote:222,apostraphe:222}},c=95;for(n=0;106>++c;)h.keys["num-"+n]=c,++n;c=47;for(n=0;58>++c;)h.keys[n]=c,++n;c=111;for(n=1;136>++c;)h.keys["f"+n]=c,++n;for(var c=64;91>++c;)h.keys[String.fromCharCode(c).toLowerCase()]=c;var t=u.jwerty={event:function(a,b,d){if(j(b,"boolean"))var f=b,b=function(){return f};var a=new p(a),e=0,i=a.length-1,c,g;return function(f){(g=t.is(a,f,e))?e<i?++e:(c=b.call(d||this,f,g),!1===c&&f.preventDefault(),e=0):e=t.is(a,f)?1:0}},is:function(a,b,d){for(var a=new p(a),
a=a[d||0],b=b.originalEvent||b,d=a.length,f=!1;d--;){var f=a[d].jwertyCombo,e;for(e in a[d])"jwertyCombo"!==e&&b[e]!=a[d][e]&&(f=!1);if(!1!==f)break}return f},key:function(a,b,d,f,e){var c=j(d,"element")||j(d,"string")?d:f,h=c===d?m:d,d=c===d?f:e;s(j(c,"element")?c:r(c,d),t.event(a,b,h))},fire:function(a,b,d,c){a=new p(a);c=j(d,"number")?d:c;$f(j(b,"element")?b:r(b,d),a[c||0][0])},KEYS:h}})(this,"undefined"!==typeof module&&module.exports?module.exports:this);

/* imagesLoaded */
(function(c,n){var l="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";c.fn.imagesLoaded=function(f){function m(){var b=c(i),a=c(h);d&&(h.length?d.reject(e,b,a):d.resolve(e));c.isFunction(f)&&f.call(g,e,b,a)}function j(b,a){b.src===l||-1!==c.inArray(b,k)||(k.push(b),a?h.push(b):i.push(b),c.data(b,"imagesLoaded",{isBroken:a,src:b.src}),o&&d.notifyWith(c(b),[a,e,c(i),c(h)]),e.length===k.length&&(setTimeout(m),e.unbind(".imagesLoaded")))}var g=this,d=c.isFunction(c.Deferred)?c.Deferred():
0,o=c.isFunction(d.notify),e=g.find("img").add(g.filter("img")),k=[],i=[],h=[];c.isPlainObject(f)&&c.each(f,function(b,a){if("callback"===b)f=a;else if(d)d[b](a)});e.length?e.bind("load.imagesLoaded error.imagesLoaded",function(b){j(b.target,"error"===b.type)}).each(function(b,a){var d=a.src,e=c.data(a,"imagesLoaded");if(e&&e.src===d)j(a,e.isBroken);else if(a.complete&&a.naturalWidth!==n)j(a,0===a.naturalWidth||0===a.naturalHeight);else if(a.readyState||a.complete)a.src=l,a.src=d}):m();return d?d.promise(g):
g}})(jQuery);