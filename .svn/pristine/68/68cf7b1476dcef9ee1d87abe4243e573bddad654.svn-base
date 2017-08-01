/*! jQuery v1.8.3 jquery.com | jquery.org/license */
(function(e,t){function _(e){var t=M[e]={};return v.each(e.split(y),function(e,n){t[n]=!0}),t}function H(e,n,r){if(r===t&&e.nodeType===1){var i="data-"+n.replace(P,"-$1").toLowerCase();r=e.getAttribute(i);if(typeof r=="string"){try{r=r==="true"?!0:r==="false"?!1:r==="null"?null:+r+""===r?+r:D.test(r)?v.parseJSON(r):r}catch(s){}v.data(e,n,r)}else r=t}return r}function B(e){var t;for(t in e){if(t==="data"&&v.isEmptyObject(e[t]))continue;if(t!=="toJSON")return!1}return!0}function et(){return!1}function tt(){return!0}function ut(e){return!e||!e.parentNode||e.parentNode.nodeType===11}function at(e,t){do e=e[t];while(e&&e.nodeType!==1);return e}function ft(e,t,n){t=t||0;if(v.isFunction(t))return v.grep(e,function(e,r){var i=!!t.call(e,r,e);return i===n});if(t.nodeType)return v.grep(e,function(e,r){return e===t===n});if(typeof t=="string"){var r=v.grep(e,function(e){return e.nodeType===1});if(it.test(t))return v.filter(t,r,!n);t=v.filter(t,r)}return v.grep(e,function(e,r){return v.inArray(e,t)>=0===n})}function lt(e){var t=ct.split("|"),n=e.createDocumentFragment();if(n.createElement)while(t.length)n.createElement(t.pop());return n}function Lt(e,t){return e.getElementsByTagName(t)[0]||e.appendChild(e.ownerDocument.createElement(t))}function At(e,t){if(t.nodeType!==1||!v.hasData(e))return;var n,r,i,s=v._data(e),o=v._data(t,s),u=s.events;if(u){delete o.handle,o.events={};for(n in u)for(r=0,i=u[n].length;r<i;r++)v.event.add(t,n,u[n][r])}o.data&&(o.data=v.extend({},o.data))}function Ot(e,t){var n;if(t.nodeType!==1)return;t.clearAttributes&&t.clearAttributes(),t.mergeAttributes&&t.mergeAttributes(e),n=t.nodeName.toLowerCase(),n==="object"?(t.parentNode&&(t.outerHTML=e.outerHTML),v.support.html5Clone&&e.innerHTML&&!v.trim(t.innerHTML)&&(t.innerHTML=e.innerHTML)):n==="input"&&Et.test(e.type)?(t.defaultChecked=t.checked=e.checked,t.value!==e.value&&(t.value=e.value)):n==="option"?t.selected=e.defaultSelected:n==="input"||n==="textarea"?t.defaultValue=e.defaultValue:n==="script"&&t.text!==e.text&&(t.text=e.text),t.removeAttribute(v.expando)}function Mt(e){return typeof e.getElementsByTagName!="undefined"?e.getElementsByTagName("*"):typeof e.querySelectorAll!="undefined"?e.querySelectorAll("*"):[]}function _t(e){Et.test(e.type)&&(e.defaultChecked=e.checked)}function Qt(e,t){if(t in e)return t;var n=t.charAt(0).toUpperCase()+t.slice(1),r=t,i=Jt.length;while(i--){t=Jt[i]+n;if(t in e)return t}return r}function Gt(e,t){return e=t||e,v.css(e,"display")==="none"||!v.contains(e.ownerDocument,e)}function Yt(e,t){var n,r,i=[],s=0,o=e.length;for(;s<o;s++){n=e[s];if(!n.style)continue;i[s]=v._data(n,"olddisplay"),t?(!i[s]&&n.style.display==="none"&&(n.style.display=""),n.style.display===""&&Gt(n)&&(i[s]=v._data(n,"olddisplay",nn(n.nodeName)))):(r=Dt(n,"display"),!i[s]&&r!=="none"&&v._data(n,"olddisplay",r))}for(s=0;s<o;s++){n=e[s];if(!n.style)continue;if(!t||n.style.display==="none"||n.style.display==="")n.style.display=t?i[s]||"":"none"}return e}function Zt(e,t,n){var r=Rt.exec(t);return r?Math.max(0,r[1]-(n||0))+(r[2]||"px"):t}function en(e,t,n,r){var i=n===(r?"border":"content")?4:t==="width"?1:0,s=0;for(;i<4;i+=2)n==="margin"&&(s+=v.css(e,n+$t[i],!0)),r?(n==="content"&&(s-=parseFloat(Dt(e,"padding"+$t[i]))||0),n!=="margin"&&(s-=parseFloat(Dt(e,"border"+$t[i]+"Width"))||0)):(s+=parseFloat(Dt(e,"padding"+$t[i]))||0,n!=="padding"&&(s+=parseFloat(Dt(e,"border"+$t[i]+"Width"))||0));return s}function tn(e,t,n){var r=t==="width"?e.offsetWidth:e.offsetHeight,i=!0,s=v.support.boxSizing&&v.css(e,"boxSizing")==="border-box";if(r<=0||r==null){r=Dt(e,t);if(r<0||r==null)r=e.style[t];if(Ut.test(r))return r;i=s&&(v.support.boxSizingReliable||r===e.style[t]),r=parseFloat(r)||0}return r+en(e,t,n||(s?"border":"content"),i)+"px"}function nn(e){if(Wt[e])return Wt[e];var t=v("<"+e+">").appendTo(i.body),n=t.css("display");t.remove();if(n==="none"||n===""){Pt=i.body.appendChild(Pt||v.extend(i.createElement("iframe"),{frameBorder:0,width:0,height:0}));if(!Ht||!Pt.createElement)Ht=(Pt.contentWindow||Pt.contentDocument).document,Ht.write("<!doctype html><html><body>"),Ht.close();t=Ht.body.appendChild(Ht.createElement(e)),n=Dt(t,"display"),i.body.removeChild(Pt)}return Wt[e]=n,n}function fn(e,t,n,r){var i;if(v.isArray(t))v.each(t,function(t,i){n||sn.test(e)?r(e,i):fn(e+"["+(typeof i=="object"?t:"")+"]",i,n,r)});else if(!n&&v.type(t)==="object")for(i in t)fn(e+"["+i+"]",t[i],n,r);else r(e,t)}function Cn(e){return function(t,n){typeof t!="string"&&(n=t,t="*");var r,i,s,o=t.toLowerCase().split(y),u=0,a=o.length;if(v.isFunction(n))for(;u<a;u++)r=o[u],s=/^\+/.test(r),s&&(r=r.substr(1)||"*"),i=e[r]=e[r]||[],i[s?"unshift":"push"](n)}}function kn(e,n,r,i,s,o){s=s||n.dataTypes[0],o=o||{},o[s]=!0;var u,a=e[s],f=0,l=a?a.length:0,c=e===Sn;for(;f<l&&(c||!u);f++)u=a[f](n,r,i),typeof u=="string"&&(!c||o[u]?u=t:(n.dataTypes.unshift(u),u=kn(e,n,r,i,u,o)));return(c||!u)&&!o["*"]&&(u=kn(e,n,r,i,"*",o)),u}function Ln(e,n){var r,i,s=v.ajaxSettings.flatOptions||{};for(r in n)n[r]!==t&&((s[r]?e:i||(i={}))[r]=n[r]);i&&v.extend(!0,e,i)}function An(e,n,r){var i,s,o,u,a=e.contents,f=e.dataTypes,l=e.responseFields;for(s in l)s in r&&(n[l[s]]=r[s]);while(f[0]==="*")f.shift(),i===t&&(i=e.mimeType||n.getResponseHeader("content-type"));if(i)for(s in a)if(a[s]&&a[s].test(i)){f.unshift(s);break}if(f[0]in r)o=f[0];else{for(s in r){if(!f[0]||e.converters[s+" "+f[0]]){o=s;break}u||(u=s)}o=o||u}if(o)return o!==f[0]&&f.unshift(o),r[o]}function On(e,t){var n,r,i,s,o=e.dataTypes.slice(),u=o[0],a={},f=0;e.dataFilter&&(t=e.dataFilter(t,e.dataType));if(o[1])for(n in e.converters)a[n.toLowerCase()]=e.converters[n];for(;i=o[++f];)if(i!=="*"){if(u!=="*"&&u!==i){n=a[u+" "+i]||a["* "+i];if(!n)for(r in a){s=r.split(" ");if(s[1]===i){n=a[u+" "+s[0]]||a["* "+s[0]];if(n){n===!0?n=a[r]:a[r]!==!0&&(i=s[0],o.splice(f--,0,i));break}}}if(n!==!0)if(n&&e["throws"])t=n(t);else try{t=n(t)}catch(l){return{state:"parsererror",error:n?l:"No conversion from "+u+" to "+i}}}u=i}return{state:"success",data:t}}function Fn(){try{return new e.XMLHttpRequest}catch(t){}}function In(){try{return new e.ActiveXObject("Microsoft.XMLHTTP")}catch(t){}}function $n(){return setTimeout(function(){qn=t},0),qn=v.now()}function Jn(e,t){v.each(t,function(t,n){var r=(Vn[t]||[]).concat(Vn["*"]),i=0,s=r.length;for(;i<s;i++)if(r[i].call(e,t,n))return})}function Kn(e,t,n){var r,i=0,s=0,o=Xn.length,u=v.Deferred().always(function(){delete a.elem}),a=function(){var t=qn||$n(),n=Math.max(0,f.startTime+f.duration-t),r=n/f.duration||0,i=1-r,s=0,o=f.tweens.length;for(;s<o;s++)f.tweens[s].run(i);return u.notifyWith(e,[f,i,n]),i<1&&o?n:(u.resolveWith(e,[f]),!1)},f=u.promise({elem:e,props:v.extend({},t),opts:v.extend(!0,{specialEasing:{}},n),originalProperties:t,originalOptions:n,startTime:qn||$n(),duration:n.duration,tweens:[],createTween:function(t,n,r){var i=v.Tween(e,f.opts,t,n,f.opts.specialEasing[t]||f.opts.easing);return f.tweens.push(i),i},stop:function(t){var n=0,r=t?f.tweens.length:0;for(;n<r;n++)f.tweens[n].run(1);return t?u.resolveWith(e,[f,t]):u.rejectWith(e,[f,t]),this}}),l=f.props;Qn(l,f.opts.specialEasing);for(;i<o;i++){r=Xn[i].call(f,e,l,f.opts);if(r)return r}return Jn(f,l),v.isFunction(f.opts.start)&&f.opts.start.call(e,f),v.fx.timer(v.extend(a,{anim:f,queue:f.opts.queue,elem:e})),f.progress(f.opts.progress).done(f.opts.done,f.opts.complete).fail(f.opts.fail).always(f.opts.always)}function Qn(e,t){var n,r,i,s,o;for(n in e){r=v.camelCase(n),i=t[r],s=e[n],v.isArray(s)&&(i=s[1],s=e[n]=s[0]),n!==r&&(e[r]=s,delete e[n]),o=v.cssHooks[r];if(o&&"expand"in o){s=o.expand(s),delete e[r];for(n in s)n in e||(e[n]=s[n],t[n]=i)}else t[r]=i}}function Gn(e,t,n){var r,i,s,o,u,a,f,l,c,h=this,p=e.style,d={},m=[],g=e.nodeType&&Gt(e);n.queue||(l=v._queueHooks(e,"fx"),l.unqueued==null&&(l.unqueued=0,c=l.empty.fire,l.empty.fire=function(){l.unqueued||c()}),l.unqueued++,h.always(function(){h.always(function(){l.unqueued--,v.queue(e,"fx").length||l.empty.fire()})})),e.nodeType===1&&("height"in t||"width"in t)&&(n.overflow=[p.overflow,p.overflowX,p.overflowY],v.css(e,"display")==="inline"&&v.css(e,"float")==="none"&&(!v.support.inlineBlockNeedsLayout||nn(e.nodeName)==="inline"?p.display="inline-block":p.zoom=1)),n.overflow&&(p.overflow="hidden",v.support.shrinkWrapBlocks||h.done(function(){p.overflow=n.overflow[0],p.overflowX=n.overflow[1],p.overflowY=n.overflow[2]}));for(r in t){s=t[r];if(Un.exec(s)){delete t[r],a=a||s==="toggle";if(s===(g?"hide":"show"))continue;m.push(r)}}o=m.length;if(o){u=v._data(e,"fxshow")||v._data(e,"fxshow",{}),"hidden"in u&&(g=u.hidden),a&&(u.hidden=!g),g?v(e).show():h.done(function(){v(e).hide()}),h.done(function(){var t;v.removeData(e,"fxshow",!0);for(t in d)v.style(e,t,d[t])});for(r=0;r<o;r++)i=m[r],f=h.createTween(i,g?u[i]:0),d[i]=u[i]||v.style(e,i),i in u||(u[i]=f.start,g&&(f.end=f.start,f.start=i==="width"||i==="height"?1:0))}}function Yn(e,t,n,r,i){return new Yn.prototype.init(e,t,n,r,i)}function Zn(e,t){var n,r={height:e},i=0;t=t?1:0;for(;i<4;i+=2-t)n=$t[i],r["margin"+n]=r["padding"+n]=e;return t&&(r.opacity=r.width=e),r}function tr(e){return v.isWindow(e)?e:e.nodeType===9?e.defaultView||e.parentWindow:!1}var n,r,i=e.document,s=e.location,o=e.navigator,u=e.jQuery,a=e.$,f=Array.prototype.push,l=Array.prototype.slice,c=Array.prototype.indexOf,h=Object.prototype.toString,p=Object.prototype.hasOwnProperty,d=String.prototype.trim,v=function(e,t){return new v.fn.init(e,t,n)},m=/[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,g=/\S/,y=/\s+/,b=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,w=/^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,E=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,S=/^[\],:{}\s]*$/,x=/(?:^|:|,)(?:\s*\[)+/g,T=/\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,N=/"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,C=/^-ms-/,k=/-([\da-z])/gi,L=function(e,t){return(t+"").toUpperCase()},A=function(){i.addEventListener?(i.removeEventListener("DOMContentLoaded",A,!1),v.ready()):i.readyState==="complete"&&(i.detachEvent("onreadystatechange",A),v.ready())},O={};v.fn=v.prototype={constructor:v,init:function(e,n,r){var s,o,u,a;if(!e)return this;if(e.nodeType)return this.context=this[0]=e,this.length=1,this;if(typeof e=="string"){e.charAt(0)==="<"&&e.charAt(e.length-1)===">"&&e.length>=3?s=[null,e,null]:s=w.exec(e);if(s&&(s[1]||!n)){if(s[1])return n=n instanceof v?n[0]:n,a=n&&n.nodeType?n.ownerDocument||n:i,e=v.parseHTML(s[1],a,!0),E.test(s[1])&&v.isPlainObject(n)&&this.attr.call(e,n,!0),v.merge(this,e);o=i.getElementById(s[2]);if(o&&o.parentNode){if(o.id!==s[2])return r.find(e);this.length=1,this[0]=o}return this.context=i,this.selector=e,this}return!n||n.jquery?(n||r).find(e):this.constructor(n).find(e)}return v.isFunction(e)?r.ready(e):(e.selector!==t&&(this.selector=e.selector,this.context=e.context),v.makeArray(e,this))},selector:"",jquery:"1.8.3",length:0,size:function(){return this.length},toArray:function(){return l.call(this)},get:function(e){return e==null?this.toArray():e<0?this[this.length+e]:this[e]},pushStack:function(e,t,n){var r=v.merge(this.constructor(),e);return r.prevObject=this,r.context=this.context,t==="find"?r.selector=this.selector+(this.selector?" ":"")+n:t&&(r.selector=this.selector+"."+t+"("+n+")"),r},each:function(e,t){return v.each(this,e,t)},ready:function(e){return v.ready.promise().done(e),this},eq:function(e){return e=+e,e===-1?this.slice(e):this.slice(e,e+1)},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},slice:function(){return this.pushStack(l.apply(this,arguments),"slice",l.call(arguments).join(","))},map:function(e){return this.pushStack(v.map(this,function(t,n){return e.call(t,n,t)}))},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:[].sort,splice:[].splice},v.fn.init.prototype=v.fn,v.extend=v.fn.extend=function(){var e,n,r,i,s,o,u=arguments[0]||{},a=1,f=arguments.length,l=!1;typeof u=="boolean"&&(l=u,u=arguments[1]||{},a=2),typeof u!="object"&&!v.isFunction(u)&&(u={}),f===a&&(u=this,--a);for(;a<f;a++)if((e=arguments[a])!=null)for(n in e){r=u[n],i=e[n];if(u===i)continue;l&&i&&(v.isPlainObject(i)||(s=v.isArray(i)))?(s?(s=!1,o=r&&v.isArray(r)?r:[]):o=r&&v.isPlainObject(r)?r:{},u[n]=v.extend(l,o,i)):i!==t&&(u[n]=i)}return u},v.extend({noConflict:function(t){return e.$===v&&(e.$=a),t&&e.jQuery===v&&(e.jQuery=u),v},isReady:!1,readyWait:1,holdReady:function(e){e?v.readyWait++:v.ready(!0)},ready:function(e){if(e===!0?--v.readyWait:v.isReady)return;if(!i.body)return setTimeout(v.ready,1);v.isReady=!0;if(e!==!0&&--v.readyWait>0)return;r.resolveWith(i,[v]),v.fn.trigger&&v(i).trigger("ready").off("ready")},isFunction:function(e){return v.type(e)==="function"},isArray:Array.isArray||function(e){return v.type(e)==="array"},isWindow:function(e){return e!=null&&e==e.window},isNumeric:function(e){return!isNaN(parseFloat(e))&&isFinite(e)},type:function(e){return e==null?String(e):O[h.call(e)]||"object"},isPlainObject:function(e){if(!e||v.type(e)!=="object"||e.nodeType||v.isWindow(e))return!1;try{if(e.constructor&&!p.call(e,"constructor")&&!p.call(e.constructor.prototype,"isPrototypeOf"))return!1}catch(n){return!1}var r;for(r in e);return r===t||p.call(e,r)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},error:function(e){throw new Error(e)},parseHTML:function(e,t,n){var r;return!e||typeof e!="string"?null:(typeof t=="boolean"&&(n=t,t=0),t=t||i,(r=E.exec(e))?[t.createElement(r[1])]:(r=v.buildFragment([e],t,n?null:[]),v.merge([],(r.cacheable?v.clone(r.fragment):r.fragment).childNodes)))},parseJSON:function(t){if(!t||typeof t!="string")return null;t=v.trim(t);if(e.JSON&&e.JSON.parse)return e.JSON.parse(t);if(S.test(t.replace(T,"@").replace(N,"]").replace(x,"")))return(new Function("return "+t))();v.error("Invalid JSON: "+t)},parseXML:function(n){var r,i;if(!n||typeof n!="string")return null;try{e.DOMParser?(i=new DOMParser,r=i.parseFromString(n,"text/xml")):(r=new ActiveXObject("Microsoft.XMLDOM"),r.async="false",r.loadXML(n))}catch(s){r=t}return(!r||!r.documentElement||r.getElementsByTagName("parsererror").length)&&v.error("Invalid XML: "+n),r},noop:function(){},globalEval:function(t){t&&g.test(t)&&(e.execScript||function(t){e.eval.call(e,t)})(t)},camelCase:function(e){return e.replace(C,"ms-").replace(k,L)},nodeName:function(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()},each:function(e,n,r){var i,s=0,o=e.length,u=o===t||v.isFunction(e);if(r){if(u){for(i in e)if(n.apply(e[i],r)===!1)break}else for(;s<o;)if(n.apply(e[s++],r)===!1)break}else if(u){for(i in e)if(n.call(e[i],i,e[i])===!1)break}else for(;s<o;)if(n.call(e[s],s,e[s++])===!1)break;return e},trim:d&&!d.call("\ufeff\u00a0")?function(e){return e==null?"":d.call(e)}:function(e){return e==null?"":(e+"").replace(b,"")},makeArray:function(e,t){var n,r=t||[];return e!=null&&(n=v.type(e),e.length==null||n==="string"||n==="function"||n==="regexp"||v.isWindow(e)?f.call(r,e):v.merge(r,e)),r},inArray:function(e,t,n){var r;if(t){if(c)return c.call(t,e,n);r=t.length,n=n?n<0?Math.max(0,r+n):n:0;for(;n<r;n++)if(n in t&&t[n]===e)return n}return-1},merge:function(e,n){var r=n.length,i=e.length,s=0;if(typeof r=="number")for(;s<r;s++)e[i++]=n[s];else while(n[s]!==t)e[i++]=n[s++];return e.length=i,e},grep:function(e,t,n){var r,i=[],s=0,o=e.length;n=!!n;for(;s<o;s++)r=!!t(e[s],s),n!==r&&i.push(e[s]);return i},map:function(e,n,r){var i,s,o=[],u=0,a=e.length,f=e instanceof v||a!==t&&typeof a=="number"&&(a>0&&e[0]&&e[a-1]||a===0||v.isArray(e));if(f)for(;u<a;u++)i=n(e[u],u,r),i!=null&&(o[o.length]=i);else for(s in e)i=n(e[s],s,r),i!=null&&(o[o.length]=i);return o.concat.apply([],o)},guid:1,proxy:function(e,n){var r,i,s;return typeof n=="string"&&(r=e[n],n=e,e=r),v.isFunction(e)?(i=l.call(arguments,2),s=function(){return e.apply(n,i.concat(l.call(arguments)))},s.guid=e.guid=e.guid||v.guid++,s):t},access:function(e,n,r,i,s,o,u){var a,f=r==null,l=0,c=e.length;if(r&&typeof r=="object"){for(l in r)v.access(e,n,l,r[l],1,o,i);s=1}else if(i!==t){a=u===t&&v.isFunction(i),f&&(a?(a=n,n=function(e,t,n){return a.call(v(e),n)}):(n.call(e,i),n=null));if(n)for(;l<c;l++)n(e[l],r,a?i.call(e[l],l,n(e[l],r)):i,u);s=1}return s?e:f?n.call(e):c?n(e[0],r):o},now:function(){return(new Date).getTime()}}),v.ready.promise=function(t){if(!r){r=v.Deferred();if(i.readyState==="complete")setTimeout(v.ready,1);else if(i.addEventListener)i.addEventListener("DOMContentLoaded",A,!1),e.addEventListener("load",v.ready,!1);else{i.attachEvent("onreadystatechange",A),e.attachEvent("onload",v.ready);var n=!1;try{n=e.frameElement==null&&i.documentElement}catch(s){}n&&n.doScroll&&function o(){if(!v.isReady){try{n.doScroll("left")}catch(e){return setTimeout(o,50)}v.ready()}}()}}return r.promise(t)},v.each("Boolean Number String Function Array Date RegExp Object".split(" "),function(e,t){O["[object "+t+"]"]=t.toLowerCase()}),n=v(i);var M={};v.Callbacks=function(e){e=typeof e=="string"?M[e]||_(e):v.extend({},e);var n,r,i,s,o,u,a=[],f=!e.once&&[],l=function(t){n=e.memory&&t,r=!0,u=s||0,s=0,o=a.length,i=!0;for(;a&&u<o;u++)if(a[u].apply(t[0],t[1])===!1&&e.stopOnFalse){n=!1;break}i=!1,a&&(f?f.length&&l(f.shift()):n?a=[]:c.disable())},c={add:function(){if(a){var t=a.length;(function r(t){v.each(t,function(t,n){var i=v.type(n);i==="function"?(!e.unique||!c.has(n))&&a.push(n):n&&n.length&&i!=="string"&&r(n)})})(arguments),i?o=a.length:n&&(s=t,l(n))}return this},remove:function(){return a&&v.each(arguments,function(e,t){var n;while((n=v.inArray(t,a,n))>-1)a.splice(n,1),i&&(n<=o&&o--,n<=u&&u--)}),this},has:function(e){return v.inArray(e,a)>-1},empty:function(){return a=[],this},disable:function(){return a=f=n=t,this},disabled:function(){return!a},lock:function(){return f=t,n||c.disable(),this},locked:function(){return!f},fireWith:function(e,t){return t=t||[],t=[e,t.slice?t.slice():t],a&&(!r||f)&&(i?f.push(t):l(t)),this},fire:function(){return c.fireWith(this,arguments),this},fired:function(){return!!r}};return c},v.extend({Deferred:function(e){var t=[["resolve","done",v.Callbacks("once memory"),"resolved"],["reject","fail",v.Callbacks("once memory"),"rejected"],["notify","progress",v.Callbacks("memory")]],n="pending",r={state:function(){return n},always:function(){return i.done(arguments).fail(arguments),this},then:function(){var e=arguments;return v.Deferred(function(n){v.each(t,function(t,r){var s=r[0],o=e[t];i[r[1]](v.isFunction(o)?function(){var e=o.apply(this,arguments);e&&v.isFunction(e.promise)?e.promise().done(n.resolve).fail(n.reject).progress(n.notify):n[s+"With"](this===i?n:this,[e])}:n[s])}),e=null}).promise()},promise:function(e){return e!=null?v.extend(e,r):r}},i={};return r.pipe=r.then,v.each(t,function(e,s){var o=s[2],u=s[3];r[s[1]]=o.add,u&&o.add(function(){n=u},t[e^1][2].disable,t[2][2].lock),i[s[0]]=o.fire,i[s[0]+"With"]=o.fireWith}),r.promise(i),e&&e.call(i,i),i},when:function(e){var t=0,n=l.call(arguments),r=n.length,i=r!==1||e&&v.isFunction(e.promise)?r:0,s=i===1?e:v.Deferred(),o=function(e,t,n){return function(r){t[e]=this,n[e]=arguments.length>1?l.call(arguments):r,n===u?s.notifyWith(t,n):--i||s.resolveWith(t,n)}},u,a,f;if(r>1){u=new Array(r),a=new Array(r),f=new Array(r);for(;t<r;t++)n[t]&&v.isFunction(n[t].promise)?n[t].promise().done(o(t,f,n)).fail(s.reject).progress(o(t,a,u)):--i}return i||s.resolveWith(f,n),s.promise()}}),v.support=function(){var t,n,r,s,o,u,a,f,l,c,h,p=i.createElement("div");p.setAttribute("className","t"),p.innerHTML="  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>",n=p.getElementsByTagName("*"),r=p.getElementsByTagName("a")[0];if(!n||!r||!n.length)return{};s=i.createElement("select"),o=s.appendChild(i.createElement("option")),u=p.getElementsByTagName("input")[0],r.style.cssText="top:1px;float:left;opacity:.5",t={leadingWhitespace:p.firstChild.nodeType===3,tbody:!p.getElementsByTagName("tbody").length,htmlSerialize:!!p.getElementsByTagName("link").length,style:/top/.test(r.getAttribute("style")),hrefNormalized:r.getAttribute("href")==="/a",opacity:/^0.5/.test(r.style.opacity),cssFloat:!!r.style.cssFloat,checkOn:u.value==="on",optSelected:o.selected,getSetAttribute:p.className!=="t",enctype:!!i.createElement("form").enctype,html5Clone:i.createElement("nav").cloneNode(!0).outerHTML!=="<:nav></:nav>",boxModel:i.compatMode==="CSS1Compat",submitBubbles:!0,changeBubbles:!0,focusinBubbles:!1,deleteExpando:!0,noCloneEvent:!0,inlineBlockNeedsLayout:!1,shrinkWrapBlocks:!1,reliableMarginRight:!0,boxSizingReliable:!0,pixelPosition:!1},u.checked=!0,t.noCloneChecked=u.cloneNode(!0).checked,s.disabled=!0,t.optDisabled=!o.disabled;try{delete p.test}catch(d){t.deleteExpando=!1}!p.addEventListener&&p.attachEvent&&p.fireEvent&&(p.attachEvent("onclick",h=function(){t.noCloneEvent=!1}),p.cloneNode(!0).fireEvent("onclick"),p.detachEvent("onclick",h)),u=i.createElement("input"),u.value="t",u.setAttribute("type","radio"),t.radioValue=u.value==="t",u.setAttribute("checked","checked"),u.setAttribute("name","t"),p.appendChild(u),a=i.createDocumentFragment(),a.appendChild(p.lastChild),t.checkClone=a.cloneNode(!0).cloneNode(!0).lastChild.checked,t.appendChecked=u.checked,a.removeChild(u),a.appendChild(p);if(p.attachEvent)for(l in{submit:!0,change:!0,focusin:!0})f="on"+l,c=f in p,c||(p.setAttribute(f,"return;"),c=typeof p[f]=="function"),t[l+"Bubbles"]=c;return v(function(){var n,r,s,o,u="padding:0;margin:0;border:0;display:block;overflow:hidden;",a=i.getElementsByTagName("body")[0];if(!a)return;n=i.createElement("div"),n.style.cssText="visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px",a.insertBefore(n,a.firstChild),r=i.createElement("div"),n.appendChild(r),r.innerHTML="<table><tr><td></td><td>t</td></tr></table>",s=r.getElementsByTagName("td"),s[0].style.cssText="padding:0;margin:0;border:0;display:none",c=s[0].offsetHeight===0,s[0].style.display="",s[1].style.display="none",t.reliableHiddenOffsets=c&&s[0].offsetHeight===0,r.innerHTML="",r.style.cssText="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;",t.boxSizing=r.offsetWidth===4,t.doesNotIncludeMarginInBodyOffset=a.offsetTop!==1,e.getComputedStyle&&(t.pixelPosition=(e.getComputedStyle(r,null)||{}).top!=="1%",t.boxSizingReliable=(e.getComputedStyle(r,null)||{width:"4px"}).width==="4px",o=i.createElement("div"),o.style.cssText=r.style.cssText=u,o.style.marginRight=o.style.width="0",r.style.width="1px",r.appendChild(o),t.reliableMarginRight=!parseFloat((e.getComputedStyle(o,null)||{}).marginRight)),typeof r.style.zoom!="undefined"&&(r.innerHTML="",r.style.cssText=u+"width:1px;padding:1px;display:inline;zoom:1",t.inlineBlockNeedsLayout=r.offsetWidth===3,r.style.display="block",r.style.overflow="visible",r.innerHTML="<div></div>",r.firstChild.style.width="5px",t.shrinkWrapBlocks=r.offsetWidth!==3,n.style.zoom=1),a.removeChild(n),n=r=s=o=null}),a.removeChild(p),n=r=s=o=u=a=p=null,t}();var D=/(?:\{[\s\S]*\}|\[[\s\S]*\])$/,P=/([A-Z])/g;v.extend({cache:{},deletedIds:[],uuid:0,expando:"jQuery"+(v.fn.jquery+Math.random()).replace(/\D/g,""),noData:{embed:!0,object:"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",applet:!0},hasData:function(e){return e=e.nodeType?v.cache[e[v.expando]]:e[v.expando],!!e&&!B(e)},data:function(e,n,r,i){if(!v.acceptData(e))return;var s,o,u=v.expando,a=typeof n=="string",f=e.nodeType,l=f?v.cache:e,c=f?e[u]:e[u]&&u;if((!c||!l[c]||!i&&!l[c].data)&&a&&r===t)return;c||(f?e[u]=c=v.deletedIds.pop()||v.guid++:c=u),l[c]||(l[c]={},f||(l[c].toJSON=v.noop));if(typeof n=="object"||typeof n=="function")i?l[c]=v.extend(l[c],n):l[c].data=v.extend(l[c].data,n);return s=l[c],i||(s.data||(s.data={}),s=s.data),r!==t&&(s[v.camelCase(n)]=r),a?(o=s[n],o==null&&(o=s[v.camelCase(n)])):o=s,o},removeData:function(e,t,n){if(!v.acceptData(e))return;var r,i,s,o=e.nodeType,u=o?v.cache:e,a=o?e[v.expando]:v.expando;if(!u[a])return;if(t){r=n?u[a]:u[a].data;if(r){v.isArray(t)||(t in r?t=[t]:(t=v.camelCase(t),t in r?t=[t]:t=t.split(" ")));for(i=0,s=t.length;i<s;i++)delete r[t[i]];if(!(n?B:v.isEmptyObject)(r))return}}if(!n){delete u[a].data;if(!B(u[a]))return}o?v.cleanData([e],!0):v.support.deleteExpando||u!=u.window?delete u[a]:u[a]=null},_data:function(e,t,n){return v.data(e,t,n,!0)},acceptData:function(e){var t=e.nodeName&&v.noData[e.nodeName.toLowerCase()];return!t||t!==!0&&e.getAttribute("classid")===t}}),v.fn.extend({data:function(e,n){var r,i,s,o,u,a=this[0],f=0,l=null;if(e===t){if(this.length){l=v.data(a);if(a.nodeType===1&&!v._data(a,"parsedAttrs")){s=a.attributes;for(u=s.length;f<u;f++)o=s[f].name,o.indexOf("data-")||(o=v.camelCase(o.substring(5)),H(a,o,l[o]));v._data(a,"parsedAttrs",!0)}}return l}return typeof e=="object"?this.each(function(){v.data(this,e)}):(r=e.split(".",2),r[1]=r[1]?"."+r[1]:"",i=r[1]+"!",v.access(this,function(n){if(n===t)return l=this.triggerHandler("getData"+i,[r[0]]),l===t&&a&&(l=v.data(a,e),l=H(a,e,l)),l===t&&r[1]?this.data(r[0]):l;r[1]=n,this.each(function(){var t=v(this);t.triggerHandler("setData"+i,r),v.data(this,e,n),t.triggerHandler("changeData"+i,r)})},null,n,arguments.length>1,null,!1))},removeData:function(e){return this.each(function(){v.removeData(this,e)})}}),v.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=v._data(e,t),n&&(!r||v.isArray(n)?r=v._data(e,t,v.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=v.queue(e,t),r=n.length,i=n.shift(),s=v._queueHooks(e,t),o=function(){v.dequeue(e,t)};i==="inprogress"&&(i=n.shift(),r--),i&&(t==="fx"&&n.unshift("inprogress"),delete s.stop,i.call(e,o,s)),!r&&s&&s.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return v._data(e,n)||v._data(e,n,{empty:v.Callbacks("once memory").add(function(){v.removeData(e,t+"queue",!0),v.removeData(e,n,!0)})})}}),v.fn.extend({queue:function(e,n){var r=2;return typeof e!="string"&&(n=e,e="fx",r--),arguments.length<r?v.queue(this[0],e):n===t?this:this.each(function(){var t=v.queue(this,e,n);v._queueHooks(this,e),e==="fx"&&t[0]!=="inprogress"&&v.dequeue(this,e)})},dequeue:function(e){return this.each(function(){v.dequeue(this,e)})},delay:function(e,t){return e=v.fx?v.fx.speeds[e]||e:e,t=t||"fx",this.queue(t,function(t,n){var r=setTimeout(t,e);n.stop=function(){clearTimeout(r)}})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,n){var r,i=1,s=v.Deferred(),o=this,u=this.length,a=function(){--i||s.resolveWith(o,[o])};typeof e!="string"&&(n=e,e=t),e=e||"fx";while(u--)r=v._data(o[u],e+"queueHooks"),r&&r.empty&&(i++,r.empty.add(a));return a(),s.promise(n)}});var j,F,I,q=/[\t\r\n]/g,R=/\r/g,U=/^(?:button|input)$/i,z=/^(?:button|input|object|select|textarea)$/i,W=/^a(?:rea|)$/i,X=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,V=v.support.getSetAttribute;v.fn.extend({attr:function(e,t){return v.access(this,v.attr,e,t,arguments.length>1)},removeAttr:function(e){return this.each(function(){v.removeAttr(this,e)})},prop:function(e,t){return v.access(this,v.prop,e,t,arguments.length>1)},removeProp:function(e){return e=v.propFix[e]||e,this.each(function(){try{this[e]=t,delete this[e]}catch(n){}})},addClass:function(e){var t,n,r,i,s,o,u;if(v.isFunction(e))return this.each(function(t){v(this).addClass(e.call(this,t,this.className))});if(e&&typeof e=="string"){t=e.split(y);for(n=0,r=this.length;n<r;n++){i=this[n];if(i.nodeType===1)if(!i.className&&t.length===1)i.className=e;else{s=" "+i.className+" ";for(o=0,u=t.length;o<u;o++)s.indexOf(" "+t[o]+" ")<0&&(s+=t[o]+" ");i.className=v.trim(s)}}}return this},removeClass:function(e){var n,r,i,s,o,u,a;if(v.isFunction(e))return this.each(function(t){v(this).removeClass(e.call(this,t,this.className))});if(e&&typeof e=="string"||e===t){n=(e||"").split(y);for(u=0,a=this.length;u<a;u++){i=this[u];if(i.nodeType===1&&i.className){r=(" "+i.className+" ").replace(q," ");for(s=0,o=n.length;s<o;s++)while(r.indexOf(" "+n[s]+" ")>=0)r=r.replace(" "+n[s]+" "," ");i.className=e?v.trim(r):""}}}return this},toggleClass:function(e,t){var n=typeof e,r=typeof t=="boolean";return v.isFunction(e)?this.each(function(n){v(this).toggleClass(e.call(this,n,this.className,t),t)}):this.each(function(){if(n==="string"){var i,s=0,o=v(this),u=t,a=e.split(y);while(i=a[s++])u=r?u:!o.hasClass(i),o[u?"addClass":"removeClass"](i)}else if(n==="undefined"||n==="boolean")this.className&&v._data(this,"__className__",this.className),this.className=this.className||e===!1?"":v._data(this,"__className__")||""})},hasClass:function(e){var t=" "+e+" ",n=0,r=this.length;for(;n<r;n++)if(this[n].nodeType===1&&(" "+this[n].className+" ").replace(q," ").indexOf(t)>=0)return!0;return!1},val:function(e){var n,r,i,s=this[0];if(!arguments.length){if(s)return n=v.valHooks[s.type]||v.valHooks[s.nodeName.toLowerCase()],n&&"get"in n&&(r=n.get(s,"value"))!==t?r:(r=s.value,typeof r=="string"?r.replace(R,""):r==null?"":r);return}return i=v.isFunction(e),this.each(function(r){var s,o=v(this);if(this.nodeType!==1)return;i?s=e.call(this,r,o.val()):s=e,s==null?s="":typeof s=="number"?s+="":v.isArray(s)&&(s=v.map(s,function(e){return e==null?"":e+""})),n=v.valHooks[this.type]||v.valHooks[this.nodeName.toLowerCase()];if(!n||!("set"in n)||n.set(this,s,"value")===t)this.value=s})}}),v.extend({valHooks:{option:{get:function(e){var t=e.attributes.value;return!t||t.specified?e.value:e.text}},select:{get:function(e){var t,n,r=e.options,i=e.selectedIndex,s=e.type==="select-one"||i<0,o=s?null:[],u=s?i+1:r.length,a=i<0?u:s?i:0;for(;a<u;a++){n=r[a];if((n.selected||a===i)&&(v.support.optDisabled?!n.disabled:n.getAttribute("disabled")===null)&&(!n.parentNode.disabled||!v.nodeName(n.parentNode,"optgroup"))){t=v(n).val();if(s)return t;o.push(t)}}return o},set:function(e,t){var n=v.makeArray(t);return v(e).find("option").each(function(){this.selected=v.inArray(v(this).val(),n)>=0}),n.length||(e.selectedIndex=-1),n}}},attrFn:{},attr:function(e,n,r,i){var s,o,u,a=e.nodeType;if(!e||a===3||a===8||a===2)return;if(i&&v.isFunction(v.fn[n]))return v(e)[n](r);if(typeof e.getAttribute=="undefined")return v.prop(e,n,r);u=a!==1||!v.isXMLDoc(e),u&&(n=n.toLowerCase(),o=v.attrHooks[n]||(X.test(n)?F:j));if(r!==t){if(r===null){v.removeAttr(e,n);return}return o&&"set"in o&&u&&(s=o.set(e,r,n))!==t?s:(e.setAttribute(n,r+""),r)}return o&&"get"in o&&u&&(s=o.get(e,n))!==null?s:(s=e.getAttribute(n),s===null?t:s)},removeAttr:function(e,t){var n,r,i,s,o=0;if(t&&e.nodeType===1){r=t.split(y);for(;o<r.length;o++)i=r[o],i&&(n=v.propFix[i]||i,s=X.test(i),s||v.attr(e,i,""),e.removeAttribute(V?i:n),s&&n in e&&(e[n]=!1))}},attrHooks:{type:{set:function(e,t){if(U.test(e.nodeName)&&e.parentNode)v.error("type property can't be changed");else if(!v.support.radioValue&&t==="radio"&&v.nodeName(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}},value:{get:function(e,t){return j&&v.nodeName(e,"button")?j.get(e,t):t in e?e.value:null},set:function(e,t,n){if(j&&v.nodeName(e,"button"))return j.set(e,t,n);e.value=t}}},propFix:{tabindex:"tabIndex",readonly:"readOnly","for":"htmlFor","class":"className",maxlength:"maxLength",cellspacing:"cellSpacing",cellpadding:"cellPadding",rowspan:"rowSpan",colspan:"colSpan",usemap:"useMap",frameborder:"frameBorder",contenteditable:"contentEditable"},prop:function(e,n,r){var i,s,o,u=e.nodeType;if(!e||u===3||u===8||u===2)return;return o=u!==1||!v.isXMLDoc(e),o&&(n=v.propFix[n]||n,s=v.propHooks[n]),r!==t?s&&"set"in s&&(i=s.set(e,r,n))!==t?i:e[n]=r:s&&"get"in s&&(i=s.get(e,n))!==null?i:e[n]},propHooks:{tabIndex:{get:function(e){var n=e.getAttributeNode("tabindex");return n&&n.specified?parseInt(n.value,10):z.test(e.nodeName)||W.test(e.nodeName)&&e.href?0:t}}}}),F={get:function(e,n){var r,i=v.prop(e,n);return i===!0||typeof i!="boolean"&&(r=e.getAttributeNode(n))&&r.nodeValue!==!1?n.toLowerCase():t},set:function(e,t,n){var r;return t===!1?v.removeAttr(e,n):(r=v.propFix[n]||n,r in e&&(e[r]=!0),e.setAttribute(n,n.toLowerCase())),n}},V||(I={name:!0,id:!0,coords:!0},j=v.valHooks.button={get:function(e,n){var r;return r=e.getAttributeNode(n),r&&(I[n]?r.value!=="":r.specified)?r.value:t},set:function(e,t,n){var r=e.getAttributeNode(n);return r||(r=i.createAttribute(n),e.setAttributeNode(r)),r.value=t+""}},v.each(["width","height"],function(e,t){v.attrHooks[t]=v.extend(v.attrHooks[t],{set:function(e,n){if(n==="")return e.setAttribute(t,"auto"),n}})}),v.attrHooks.contenteditable={get:j.get,set:function(e,t,n){t===""&&(t="false"),j.set(e,t,n)}}),v.support.hrefNormalized||v.each(["href","src","width","height"],function(e,n){v.attrHooks[n]=v.extend(v.attrHooks[n],{get:function(e){var r=e.getAttribute(n,2);return r===null?t:r}})}),v.support.style||(v.attrHooks.style={get:function(e){return e.style.cssText.toLowerCase()||t},set:function(e,t){return e.style.cssText=t+""}}),v.support.optSelected||(v.propHooks.selected=v.extend(v.propHooks.selected,{get:function(e){var t=e.parentNode;return t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex),null}})),v.support.enctype||(v.propFix.enctype="encoding"),v.support.checkOn||v.each(["radio","checkbox"],function(){v.valHooks[this]={get:function(e){return e.getAttribute("value")===null?"on":e.value}}}),v.each(["radio","checkbox"],function(){v.valHooks[this]=v.extend(v.valHooks[this],{set:function(e,t){if(v.isArray(t))return e.checked=v.inArray(v(e).val(),t)>=0}})});var $=/^(?:textarea|input|select)$/i,J=/^([^\.]*|)(?:\.(.+)|)$/,K=/(?:^|\s)hover(\.\S+|)\b/,Q=/^key/,G=/^(?:mouse|contextmenu)|click/,Y=/^(?:focusinfocus|focusoutblur)$/,Z=function(e){return v.event.special.hover?e:e.replace(K,"mouseenter$1 mouseleave$1")};v.event={add:function(e,n,r,i,s){var o,u,a,f,l,c,h,p,d,m,g;if(e.nodeType===3||e.nodeType===8||!n||!r||!(o=v._data(e)))return;r.handler&&(d=r,r=d.handler,s=d.selector),r.guid||(r.guid=v.guid++),a=o.events,a||(o.events=a={}),u=o.handle,u||(o.handle=u=function(e){return typeof v=="undefined"||!!e&&v.event.triggered===e.type?t:v.event.dispatch.apply(u.elem,arguments)},u.elem=e),n=v.trim(Z(n)).split(" ");for(f=0;f<n.length;f++){l=J.exec(n[f])||[],c=l[1],h=(l[2]||"").split(".").sort(),g=v.event.special[c]||{},c=(s?g.delegateType:g.bindType)||c,g=v.event.special[c]||{},p=v.extend({type:c,origType:l[1],data:i,handler:r,guid:r.guid,selector:s,needsContext:s&&v.expr.match.needsContext.test(s),namespace:h.join(".")},d),m=a[c];if(!m){m=a[c]=[],m.delegateCount=0;if(!g.setup||g.setup.call(e,i,h,u)===!1)e.addEventListener?e.addEventListener(c,u,!1):e.attachEvent&&e.attachEvent("on"+c,u)}g.add&&(g.add.call(e,p),p.handler.guid||(p.handler.guid=r.guid)),s?m.splice(m.delegateCount++,0,p):m.push(p),v.event.global[c]=!0}e=null},global:{},remove:function(e,t,n,r,i){var s,o,u,a,f,l,c,h,p,d,m,g=v.hasData(e)&&v._data(e);if(!g||!(h=g.events))return;t=v.trim(Z(t||"")).split(" ");for(s=0;s<t.length;s++){o=J.exec(t[s])||[],u=a=o[1],f=o[2];if(!u){for(u in h)v.event.remove(e,u+t[s],n,r,!0);continue}p=v.event.special[u]||{},u=(r?p.delegateType:p.bindType)||u,d=h[u]||[],l=d.length,f=f?new RegExp("(^|\\.)"+f.split(".").sort().join("\\.(?:.*\\.|)")+"(\\.|$)"):null;for(c=0;c<d.length;c++)m=d[c],(i||a===m.origType)&&(!n||n.guid===m.guid)&&(!f||f.test(m.namespace))&&(!r||r===m.selector||r==="**"&&m.selector)&&(d.splice(c--,1),m.selector&&d.delegateCount--,p.remove&&p.remove.call(e,m));d.length===0&&l!==d.length&&((!p.teardown||p.teardown.call(e,f,g.handle)===!1)&&v.removeEvent(e,u,g.handle),delete h[u])}v.isEmptyObject(h)&&(delete g.handle,v.removeData(e,"events",!0))},customEvent:{getData:!0,setData:!0,changeData:!0},trigger:function(n,r,s,o){if(!s||s.nodeType!==3&&s.nodeType!==8){var u,a,f,l,c,h,p,d,m,g,y=n.type||n,b=[];if(Y.test(y+v.event.triggered))return;y.indexOf("!")>=0&&(y=y.slice(0,-1),a=!0),y.indexOf(".")>=0&&(b=y.split("."),y=b.shift(),b.sort());if((!s||v.event.customEvent[y])&&!v.event.global[y])return;n=typeof n=="object"?n[v.expando]?n:new v.Event(y,n):new v.Event(y),n.type=y,n.isTrigger=!0,n.exclusive=a,n.namespace=b.join("."),n.namespace_re=n.namespace?new RegExp("(^|\\.)"+b.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,h=y.indexOf(":")<0?"on"+y:"";if(!s){u=v.cache;for(f in u)u[f].events&&u[f].events[y]&&v.event.trigger(n,r,u[f].handle.elem,!0);return}n.result=t,n.target||(n.target=s),r=r!=null?v.makeArray(r):[],r.unshift(n),p=v.event.special[y]||{};if(p.trigger&&p.trigger.apply(s,r)===!1)return;m=[[s,p.bindType||y]];if(!o&&!p.noBubble&&!v.isWindow(s)){g=p.delegateType||y,l=Y.test(g+y)?s:s.parentNode;for(c=s;l;l=l.parentNode)m.push([l,g]),c=l;c===(s.ownerDocument||i)&&m.push([c.defaultView||c.parentWindow||e,g])}for(f=0;f<m.length&&!n.isPropagationStopped();f++)l=m[f][0],n.type=m[f][1],d=(v._data(l,"events")||{})[n.type]&&v._data(l,"handle"),d&&d.apply(l,r),d=h&&l[h],d&&v.acceptData(l)&&d.apply&&d.apply(l,r)===!1&&n.preventDefault();return n.type=y,!o&&!n.isDefaultPrevented()&&(!p._default||p._default.apply(s.ownerDocument,r)===!1)&&(y!=="click"||!v.nodeName(s,"a"))&&v.acceptData(s)&&h&&s[y]&&(y!=="focus"&&y!=="blur"||n.target.offsetWidth!==0)&&!v.isWindow(s)&&(c=s[h],c&&(s[h]=null),v.event.triggered=y,s[y](),v.event.triggered=t,c&&(s[h]=c)),n.result}return},dispatch:function(n){n=v.event.fix(n||e.event);var r,i,s,o,u,a,f,c,h,p,d=(v._data(this,"events")||{})[n.type]||[],m=d.delegateCount,g=l.call(arguments),y=!n.exclusive&&!n.namespace,b=v.event.special[n.type]||{},w=[];g[0]=n,n.delegateTarget=this;if(b.preDispatch&&b.preDispatch.call(this,n)===!1)return;if(m&&(!n.button||n.type!=="click"))for(s=n.target;s!=this;s=s.parentNode||this)if(s.disabled!==!0||n.type!=="click"){u={},f=[];for(r=0;r<m;r++)c=d[r],h=c.selector,u[h]===t&&(u[h]=c.needsContext?v(h,this).index(s)>=0:v.find(h,this,null,[s]).length),u[h]&&f.push(c);f.length&&w.push({elem:s,matches:f})}d.length>m&&w.push({elem:this,matches:d.slice(m)});for(r=0;r<w.length&&!n.isPropagationStopped();r++){a=w[r],n.currentTarget=a.elem;for(i=0;i<a.matches.length&&!n.isImmediatePropagationStopped();i++){c=a.matches[i];if(y||!n.namespace&&!c.namespace||n.namespace_re&&n.namespace_re.test(c.namespace))n.data=c.data,n.handleObj=c,o=((v.event.special[c.origType]||{}).handle||c.handler).apply(a.elem,g),o!==t&&(n.result=o,o===!1&&(n.preventDefault(),n.stopPropagation()))}}return b.postDispatch&&b.postDispatch.call(this,n),n.result},props:"attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(e,t){return e.which==null&&(e.which=t.charCode!=null?t.charCode:t.keyCode),e}},mouseHooks:{props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(e,n){var r,s,o,u=n.button,a=n.fromElement;return e.pageX==null&&n.clientX!=null&&(r=e.target.ownerDocument||i,s=r.documentElement,o=r.body,e.pageX=n.clientX+(s&&s.scrollLeft||o&&o.scrollLeft||0)-(s&&s.clientLeft||o&&o.clientLeft||0),e.pageY=n.clientY+(s&&s.scrollTop||o&&o.scrollTop||0)-(s&&s.clientTop||o&&o.clientTop||0)),!e.relatedTarget&&a&&(e.relatedTarget=a===e.target?n.toElement:a),!e.which&&u!==t&&(e.which=u&1?1:u&2?3:u&4?2:0),e}},fix:function(e){if(e[v.expando])return e;var t,n,r=e,s=v.event.fixHooks[e.type]||{},o=s.props?this.props.concat(s.props):this.props;e=v.Event(r);for(t=o.length;t;)n=o[--t],e[n]=r[n];return e.target||(e.target=r.srcElement||i),e.target.nodeType===3&&(e.target=e.target.parentNode),e.metaKey=!!e.metaKey,s.filter?s.filter(e,r):e},special:{load:{noBubble:!0},focus:{delegateType:"focusin"},blur:{delegateType:"focusout"},beforeunload:{setup:function(e,t,n){v.isWindow(this)&&(this.onbeforeunload=n)},teardown:function(e,t){this.onbeforeunload===t&&(this.onbeforeunload=null)}}},simulate:function(e,t,n,r){var i=v.extend(new v.Event,n,{type:e,isSimulated:!0,originalEvent:{}});r?v.event.trigger(i,null,t):v.event.dispatch.call(t,i),i.isDefaultPrevented()&&n.preventDefault()}},v.event.handle=v.event.dispatch,v.removeEvent=i.removeEventListener?function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n,!1)}:function(e,t,n){var r="on"+t;e.detachEvent&&(typeof e[r]=="undefined"&&(e[r]=null),e.detachEvent(r,n))},v.Event=function(e,t){if(!(this instanceof v.Event))return new v.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||e.returnValue===!1||e.getPreventDefault&&e.getPreventDefault()?tt:et):this.type=e,t&&v.extend(this,t),this.timeStamp=e&&e.timeStamp||v.now(),this[v.expando]=!0},v.Event.prototype={preventDefault:function(){this.isDefaultPrevented=tt;var e=this.originalEvent;if(!e)return;e.preventDefault?e.preventDefault():e.returnValue=!1},stopPropagation:function(){this.isPropagationStopped=tt;var e=this.originalEvent;if(!e)return;e.stopPropagation&&e.stopPropagation(),e.cancelBubble=!0},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=tt,this.stopPropagation()},isDefaultPrevented:et,isPropagationStopped:et,isImmediatePropagationStopped:et},v.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(e,t){v.event.special[e]={delegateType:t,bindType:t,handle:function(e){var n,r=this,i=e.relatedTarget,s=e.handleObj,o=s.selector;if(!i||i!==r&&!v.contains(r,i))e.type=s.origType,n=s.handler.apply(this,arguments),e.type=t;return n}}}),v.support.submitBubbles||(v.event.special.submit={setup:function(){if(v.nodeName(this,"form"))return!1;v.event.add(this,"click._submit keypress._submit",function(e){var n=e.target,r=v.nodeName(n,"input")||v.nodeName(n,"button")?n.form:t;r&&!v._data(r,"_submit_attached")&&(v.event.add(r,"submit._submit",function(e){e._submit_bubble=!0}),v._data(r,"_submit_attached",!0))})},postDispatch:function(e){e._submit_bubble&&(delete e._submit_bubble,this.parentNode&&!e.isTrigger&&v.event.simulate("submit",this.parentNode,e,!0))},teardown:function(){if(v.nodeName(this,"form"))return!1;v.event.remove(this,"._submit")}}),v.support.changeBubbles||(v.event.special.change={setup:function(){if($.test(this.nodeName)){if(this.type==="checkbox"||this.type==="radio")v.event.add(this,"propertychange._change",function(e){e.originalEvent.propertyName==="checked"&&(this._just_changed=!0)}),v.event.add(this,"click._change",function(e){this._just_changed&&!e.isTrigger&&(this._just_changed=!1),v.event.simulate("change",this,e,!0)});return!1}v.event.add(this,"beforeactivate._change",function(e){var t=e.target;$.test(t.nodeName)&&!v._data(t,"_change_attached")&&(v.event.add(t,"change._change",function(e){this.parentNode&&!e.isSimulated&&!e.isTrigger&&v.event.simulate("change",this.parentNode,e,!0)}),v._data(t,"_change_attached",!0))})},handle:function(e){var t=e.target;if(this!==t||e.isSimulated||e.isTrigger||t.type!=="radio"&&t.type!=="checkbox")return e.handleObj.handler.apply(this,arguments)},teardown:function(){return v.event.remove(this,"._change"),!$.test(this.nodeName)}}),v.support.focusinBubbles||v.each({focus:"focusin",blur:"focusout"},function(e,t){var n=0,r=function(e){v.event.simulate(t,e.target,v.event.fix(e),!0)};v.event.special[t]={setup:function(){n++===0&&i.addEventListener(e,r,!0)},teardown:function(){--n===0&&i.removeEventListener(e,r,!0)}}}),v.fn.extend({on:function(e,n,r,i,s){var o,u;if(typeof e=="object"){typeof n!="string"&&(r=r||n,n=t);for(u in e)this.on(u,n,r,e[u],s);return this}r==null&&i==null?(i=n,r=n=t):i==null&&(typeof n=="string"?(i=r,r=t):(i=r,r=n,n=t));if(i===!1)i=et;else if(!i)return this;return s===1&&(o=i,i=function(e){return v().off(e),o.apply(this,arguments)},i.guid=o.guid||(o.guid=v.guid++)),this.each(function(){v.event.add(this,e,i,r,n)})},one:function(e,t,n,r){return this.on(e,t,n,r,1)},off:function(e,n,r){var i,s;if(e&&e.preventDefault&&e.handleObj)return i=e.handleObj,v(e.delegateTarget).off(i.namespace?i.origType+"."+i.namespace:i.origType,i.selector,i.handler),this;if(typeof e=="object"){for(s in e)this.off(s,n,e[s]);return this}if(n===!1||typeof n=="function")r=n,n=t;return r===!1&&(r=et),this.each(function(){v.event.remove(this,e,r,n)})},bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},live:function(e,t,n){return v(this.context).on(e,this.selector,t,n),this},die:function(e,t){return v(this.context).off(e,this.selector||"**",t),this},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return arguments.length===1?this.off(e,"**"):this.off(t,e||"**",n)},trigger:function(e,t){return this.each(function(){v.event.trigger(e,t,this)})},triggerHandler:function(e,t){if(this[0])return v.event.trigger(e,t,this[0],!0)},toggle:function(e){var t=arguments,n=e.guid||v.guid++,r=0,i=function(n){var i=(v._data(this,"lastToggle"+e.guid)||0)%r;return v._data(this,"lastToggle"+e.guid,i+1),n.preventDefault(),t[i].apply(this,arguments)||!1};i.guid=n;while(r<t.length)t[r++].guid=n;return this.click(i)},hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),v.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(e,t){v.fn[t]=function(e,n){return n==null&&(n=e,e=null),arguments.length>0?this.on(t,null,e,n):this.trigger(t)},Q.test(t)&&(v.event.fixHooks[t]=v.event.keyHooks),G.test(t)&&(v.event.fixHooks[t]=v.event.mouseHooks)}),function(e,t){function nt(e,t,n,r){n=n||[],t=t||g;var i,s,a,f,l=t.nodeType;if(!e||typeof e!="string")return n;if(l!==1&&l!==9)return[];a=o(t);if(!a&&!r)if(i=R.exec(e))if(f=i[1]){if(l===9){s=t.getElementById(f);if(!s||!s.parentNode)return n;if(s.id===f)return n.push(s),n}else if(t.ownerDocument&&(s=t.ownerDocument.getElementById(f))&&u(t,s)&&s.id===f)return n.push(s),n}else{if(i[2])return S.apply(n,x.call(t.getElementsByTagName(e),0)),n;if((f=i[3])&&Z&&t.getElementsByClassName)return S.apply(n,x.call(t.getElementsByClassName(f),0)),n}return vt(e.replace(j,"$1"),t,n,r,a)}function rt(e){return function(t){var n=t.nodeName.toLowerCase();return n==="input"&&t.type===e}}function it(e){return function(t){var n=t.nodeName.toLowerCase();return(n==="input"||n==="button")&&t.type===e}}function st(e){return N(function(t){return t=+t,N(function(n,r){var i,s=e([],n.length,t),o=s.length;while(o--)n[i=s[o]]&&(n[i]=!(r[i]=n[i]))})})}function ot(e,t,n){if(e===t)return n;var r=e.nextSibling;while(r){if(r===t)return-1;r=r.nextSibling}return 1}function ut(e,t){var n,r,s,o,u,a,f,l=L[d][e+" "];if(l)return t?0:l.slice(0);u=e,a=[],f=i.preFilter;while(u){if(!n||(r=F.exec(u)))r&&(u=u.slice(r[0].length)||u),a.push(s=[]);n=!1;if(r=I.exec(u))s.push(n=new m(r.shift())),u=u.slice(n.length),n.type=r[0].replace(j," ");for(o in i.filter)(r=J[o].exec(u))&&(!f[o]||(r=f[o](r)))&&(s.push(n=new m(r.shift())),u=u.slice(n.length),n.type=o,n.matches=r);if(!n)break}return t?u.length:u?nt.error(e):L(e,a).slice(0)}function at(e,t,r){var i=t.dir,s=r&&t.dir==="parentNode",o=w++;return t.first?function(t,n,r){while(t=t[i])if(s||t.nodeType===1)return e(t,n,r)}:function(t,r,u){if(!u){var a,f=b+" "+o+" ",l=f+n;while(t=t[i])if(s||t.nodeType===1){if((a=t[d])===l)return t.sizset;if(typeof a=="string"&&a.indexOf(f)===0){if(t.sizset)return t}else{t[d]=l;if(e(t,r,u))return t.sizset=!0,t;t.sizset=!1}}}else while(t=t[i])if(s||t.nodeType===1)if(e(t,r,u))return t}}function ft(e){return e.length>1?function(t,n,r){var i=e.length;while(i--)if(!e[i](t,n,r))return!1;return!0}:e[0]}function lt(e,t,n,r,i){var s,o=[],u=0,a=e.length,f=t!=null;for(;u<a;u++)if(s=e[u])if(!n||n(s,r,i))o.push(s),f&&t.push(u);return o}function ct(e,t,n,r,i,s){return r&&!r[d]&&(r=ct(r)),i&&!i[d]&&(i=ct(i,s)),N(function(s,o,u,a){var f,l,c,h=[],p=[],d=o.length,v=s||dt(t||"*",u.nodeType?[u]:u,[]),m=e&&(s||!t)?lt(v,h,e,u,a):v,g=n?i||(s?e:d||r)?[]:o:m;n&&n(m,g,u,a);if(r){f=lt(g,p),r(f,[],u,a),l=f.length;while(l--)if(c=f[l])g[p[l]]=!(m[p[l]]=c)}if(s){if(i||e){if(i){f=[],l=g.length;while(l--)(c=g[l])&&f.push(m[l]=c);i(null,g=[],f,a)}l=g.length;while(l--)(c=g[l])&&(f=i?T.call(s,c):h[l])>-1&&(s[f]=!(o[f]=c))}}else g=lt(g===o?g.splice(d,g.length):g),i?i(null,o,g,a):S.apply(o,g)})}function ht(e){var t,n,r,s=e.length,o=i.relative[e[0].type],u=o||i.relative[" "],a=o?1:0,f=at(function(e){return e===t},u,!0),l=at(function(e){return T.call(t,e)>-1},u,!0),h=[function(e,n,r){return!o&&(r||n!==c)||((t=n).nodeType?f(e,n,r):l(e,n,r))}];for(;a<s;a++)if(n=i.relative[e[a].type])h=[at(ft(h),n)];else{n=i.filter[e[a].type].apply(null,e[a].matches);if(n[d]){r=++a;for(;r<s;r++)if(i.relative[e[r].type])break;return ct(a>1&&ft(h),a>1&&e.slice(0,a-1).join("").replace(j,"$1"),n,a<r&&ht(e.slice(a,r)),r<s&&ht(e=e.slice(r)),r<s&&e.join(""))}h.push(n)}return ft(h)}function pt(e,t){var r=t.length>0,s=e.length>0,o=function(u,a,f,l,h){var p,d,v,m=[],y=0,w="0",x=u&&[],T=h!=null,N=c,C=u||s&&i.find.TAG("*",h&&a.parentNode||a),k=b+=N==null?1:Math.E;T&&(c=a!==g&&a,n=o.el);for(;(p=C[w])!=null;w++){if(s&&p){for(d=0;v=e[d];d++)if(v(p,a,f)){l.push(p);break}T&&(b=k,n=++o.el)}r&&((p=!v&&p)&&y--,u&&x.push(p))}y+=w;if(r&&w!==y){for(d=0;v=t[d];d++)v(x,m,a,f);if(u){if(y>0)while(w--)!x[w]&&!m[w]&&(m[w]=E.call(l));m=lt(m)}S.apply(l,m),T&&!u&&m.length>0&&y+t.length>1&&nt.uniqueSort(l)}return T&&(b=k,c=N),x};return o.el=0,r?N(o):o}function dt(e,t,n){var r=0,i=t.length;for(;r<i;r++)nt(e,t[r],n);return n}function vt(e,t,n,r,s){var o,u,f,l,c,h=ut(e),p=h.length;if(!r&&h.length===1){u=h[0]=h[0].slice(0);if(u.length>2&&(f=u[0]).type==="ID"&&t.nodeType===9&&!s&&i.relative[u[1].type]){t=i.find.ID(f.matches[0].replace($,""),t,s)[0];if(!t)return n;e=e.slice(u.shift().length)}for(o=J.POS.test(e)?-1:u.length-1;o>=0;o--){f=u[o];if(i.relative[l=f.type])break;if(c=i.find[l])if(r=c(f.matches[0].replace($,""),z.test(u[0].type)&&t.parentNode||t,s)){u.splice(o,1),e=r.length&&u.join("");if(!e)return S.apply(n,x.call(r,0)),n;break}}}return a(e,h)(r,t,s,n,z.test(e)),n}function mt(){}var n,r,i,s,o,u,a,f,l,c,h=!0,p="undefined",d=("sizcache"+Math.random()).replace(".",""),m=String,g=e.document,y=g.documentElement,b=0,w=0,E=[].pop,S=[].push,x=[].slice,T=[].indexOf||function(e){var t=0,n=this.length;for(;t<n;t++)if(this[t]===e)return t;return-1},N=function(e,t){return e[d]=t==null||t,e},C=function(){var e={},t=[];return N(function(n,r){return t.push(n)>i.cacheLength&&delete e[t.shift()],e[n+" "]=r},e)},k=C(),L=C(),A=C(),O="[\\x20\\t\\r\\n\\f]",M="(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",_=M.replace("w","w#"),D="([*^$|!~]?=)",P="\\["+O+"*("+M+")"+O+"*(?:"+D+O+"*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|("+_+")|)|)"+O+"*\\]",H=":("+M+")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:"+P+")|[^:]|\\\\.)*|.*))\\)|)",B=":(even|odd|eq|gt|lt|nth|first|last)(?:\\("+O+"*((?:-\\d)?\\d*)"+O+"*\\)|)(?=[^-]|$)",j=new RegExp("^"+O+"+|((?:^|[^\\\\])(?:\\\\.)*)"+O+"+$","g"),F=new RegExp("^"+O+"*,"+O+"*"),I=new RegExp("^"+O+"*([\\x20\\t\\r\\n\\f>+~])"+O+"*"),q=new RegExp(H),R=/^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,U=/^:not/,z=/[\x20\t\r\n\f]*[+~]/,W=/:not\($/,X=/h\d/i,V=/input|select|textarea|button/i,$=/\\(?!\\)/g,J={ID:new RegExp("^#("+M+")"),CLASS:new RegExp("^\\.("+M+")"),NAME:new RegExp("^\\[name=['\"]?("+M+")['\"]?\\]"),TAG:new RegExp("^("+M.replace("w","w*")+")"),ATTR:new RegExp("^"+P),PSEUDO:new RegExp("^"+H),POS:new RegExp(B,"i"),CHILD:new RegExp("^:(only|nth|first|last)-child(?:\\("+O+"*(even|odd|(([+-]|)(\\d*)n|)"+O+"*(?:([+-]|)"+O+"*(\\d+)|))"+O+"*\\)|)","i"),needsContext:new RegExp("^"+O+"*[>+~]|"+B,"i")},K=function(e){var t=g.createElement("div");try{return e(t)}catch(n){return!1}finally{t=null}},Q=K(function(e){return e.appendChild(g.createComment("")),!e.getElementsByTagName("*").length}),G=K(function(e){return e.innerHTML="<a href='#'></a>",e.firstChild&&typeof e.firstChild.getAttribute!==p&&e.firstChild.getAttribute("href")==="#"}),Y=K(function(e){e.innerHTML="<select></select>";var t=typeof e.lastChild.getAttribute("multiple");return t!=="boolean"&&t!=="string"}),Z=K(function(e){return e.innerHTML="<div class='hidden e'></div><div class='hidden'></div>",!e.getElementsByClassName||!e.getElementsByClassName("e").length?!1:(e.lastChild.className="e",e.getElementsByClassName("e").length===2)}),et=K(function(e){e.id=d+0,e.innerHTML="<a name='"+d+"'></a><div name='"+d+"'></div>",y.insertBefore(e,y.firstChild);var t=g.getElementsByName&&g.getElementsByName(d).length===2+g.getElementsByName(d+0).length;return r=!g.getElementById(d),y.removeChild(e),t});try{x.call(y.childNodes,0)[0].nodeType}catch(tt){x=function(e){var t,n=[];for(;t=this[e];e++)n.push(t);return n}}nt.matches=function(e,t){return nt(e,null,null,t)},nt.matchesSelector=function(e,t){return nt(t,null,null,[e]).length>0},s=nt.getText=function(e){var t,n="",r=0,i=e.nodeType;if(i){if(i===1||i===9||i===11){if(typeof e.textContent=="string")return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=s(e)}else if(i===3||i===4)return e.nodeValue}else for(;t=e[r];r++)n+=s(t);return n},o=nt.isXML=function(e){var t=e&&(e.ownerDocument||e).documentElement;return t?t.nodeName!=="HTML":!1},u=nt.contains=y.contains?function(e,t){var n=e.nodeType===9?e.documentElement:e,r=t&&t.parentNode;return e===r||!!(r&&r.nodeType===1&&n.contains&&n.contains(r))}:y.compareDocumentPosition?function(e,t){return t&&!!(e.compareDocumentPosition(t)&16)}:function(e,t){while(t=t.parentNode)if(t===e)return!0;return!1},nt.attr=function(e,t){var n,r=o(e);return r||(t=t.toLowerCase()),(n=i.attrHandle[t])?n(e):r||Y?e.getAttribute(t):(n=e.getAttributeNode(t),n?typeof e[t]=="boolean"?e[t]?t:null:n.specified?n.value:null:null)},i=nt.selectors={cacheLength:50,createPseudo:N,match:J,attrHandle:G?{}:{href:function(e){return e.getAttribute("href",2)},type:function(e){return e.getAttribute("type")}},find:{ID:r?function(e,t,n){if(typeof t.getElementById!==p&&!n){var r=t.getElementById(e);return r&&r.parentNode?[r]:[]}}:function(e,n,r){if(typeof n.getElementById!==p&&!r){var i=n.getElementById(e);return i?i.id===e||typeof i.getAttributeNode!==p&&i.getAttributeNode("id").value===e?[i]:t:[]}},TAG:Q?function(e,t){if(typeof t.getElementsByTagName!==p)return t.getElementsByTagName(e)}:function(e,t){var n=t.getElementsByTagName(e);if(e==="*"){var r,i=[],s=0;for(;r=n[s];s++)r.nodeType===1&&i.push(r);return i}return n},NAME:et&&function(e,t){if(typeof t.getElementsByName!==p)return t.getElementsByName(name)},CLASS:Z&&function(e,t,n){if(typeof t.getElementsByClassName!==p&&!n)return t.getElementsByClassName(e)}},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace($,""),e[3]=(e[4]||e[5]||"").replace($,""),e[2]==="~="&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),e[1]==="nth"?(e[2]||nt.error(e[0]),e[3]=+(e[3]?e[4]+(e[5]||1):2*(e[2]==="even"||e[2]==="odd")),e[4]=+(e[6]+e[7]||e[2]==="odd")):e[2]&&nt.error(e[0]),e},PSEUDO:function(e){var t,n;if(J.CHILD.test(e[0]))return null;if(e[3])e[2]=e[3];else if(t=e[4])q.test(t)&&(n=ut(t,!0))&&(n=t.indexOf(")",t.length-n)-t.length)&&(t=t.slice(0,n),e[0]=e[0].slice(0,n)),e[2]=t;return e.slice(0,3)}},filter:{ID:r?function(e){return e=e.replace($,""),function(t){return t.getAttribute("id")===e}}:function(e){return e=e.replace($,""),function(t){var n=typeof t.getAttributeNode!==p&&t.getAttributeNode("id");return n&&n.value===e}},TAG:function(e){return e==="*"?function(){return!0}:(e=e.replace($,"").toLowerCase(),function(t){return t.nodeName&&t.nodeName.toLowerCase()===e})},CLASS:function(e){var t=k[d][e+" "];return t||(t=new RegExp("(^|"+O+")"+e+"("+O+"|$)"))&&k(e,function(e){return t.test(e.className||typeof e.getAttribute!==p&&e.getAttribute("class")||"")})},ATTR:function(e,t,n){return function(r,i){var s=nt.attr(r,e);return s==null?t==="!=":t?(s+="",t==="="?s===n:t==="!="?s!==n:t==="^="?n&&s.indexOf(n)===0:t==="*="?n&&s.indexOf(n)>-1:t==="$="?n&&s.substr(s.length-n.length)===n:t==="~="?(" "+s+" ").indexOf(n)>-1:t==="|="?s===n||s.substr(0,n.length+1)===n+"-":!1):!0}},CHILD:function(e,t,n,r){return e==="nth"?function(e){var t,i,s=e.parentNode;if(n===1&&r===0)return!0;if(s){i=0;for(t=s.firstChild;t;t=t.nextSibling)if(t.nodeType===1){i++;if(e===t)break}}return i-=r,i===n||i%n===0&&i/n>=0}:function(t){var n=t;switch(e){case"only":case"first":while(n=n.previousSibling)if(n.nodeType===1)return!1;if(e==="first")return!0;n=t;case"last":while(n=n.nextSibling)if(n.nodeType===1)return!1;return!0}}},PSEUDO:function(e,t){var n,r=i.pseudos[e]||i.setFilters[e.toLowerCase()]||nt.error("unsupported pseudo: "+e);return r[d]?r(t):r.length>1?(n=[e,e,"",t],i.setFilters.hasOwnProperty(e.toLowerCase())?N(function(e,n){var i,s=r(e,t),o=s.length;while(o--)i=T.call(e,s[o]),e[i]=!(n[i]=s[o])}):function(e){return r(e,0,n)}):r}},pseudos:{not:N(function(e){var t=[],n=[],r=a(e.replace(j,"$1"));return r[d]?N(function(e,t,n,i){var s,o=r(e,null,i,[]),u=e.length;while(u--)if(s=o[u])e[u]=!(t[u]=s)}):function(e,i,s){return t[0]=e,r(t,null,s,n),!n.pop()}}),has:N(function(e){return function(t){return nt(e,t).length>0}}),contains:N(function(e){return function(t){return(t.textContent||t.innerText||s(t)).indexOf(e)>-1}}),enabled:function(e){return e.disabled===!1},disabled:function(e){return e.disabled===!0},checked:function(e){var t=e.nodeName.toLowerCase();return t==="input"&&!!e.checked||t==="option"&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,e.selected===!0},parent:function(e){return!i.pseudos.empty(e)},empty:function(e){var t;e=e.firstChild;while(e){if(e.nodeName>"@"||(t=e.nodeType)===3||t===4)return!1;e=e.nextSibling}return!0},header:function(e){return X.test(e.nodeName)},text:function(e){var t,n;return e.nodeName.toLowerCase()==="input"&&(t=e.type)==="text"&&((n=e.getAttribute("type"))==null||n.toLowerCase()===t)},radio:rt("radio"),checkbox:rt("checkbox"),file:rt("file"),password:rt("password"),image:rt("image"),submit:it("submit"),reset:it("reset"),button:function(e){var t=e.nodeName.toLowerCase();return t==="input"&&e.type==="button"||t==="button"},input:function(e){return V.test(e.nodeName)},focus:function(e){var t=e.ownerDocument;return e===t.activeElement&&(!t.hasFocus||t.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},active:function(e){return e===e.ownerDocument.activeElement},first:st(function(){return[0]}),last:st(function(e,t){return[t-1]}),eq:st(function(e,t,n){return[n<0?n+t:n]}),even:st(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:st(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:st(function(e,t,n){for(var r=n<0?n+t:n;--r>=0;)e.push(r);return e}),gt:st(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}},f=y.compareDocumentPosition?function(e,t){return e===t?(l=!0,0):(!e.compareDocumentPosition||!t.compareDocumentPosition?e.compareDocumentPosition:e.compareDocumentPosition(t)&4)?-1:1}:function(e,t){if(e===t)return l=!0,0;if(e.sourceIndex&&t.sourceIndex)return e.sourceIndex-t.sourceIndex;var n,r,i=[],s=[],o=e.parentNode,u=t.parentNode,a=o;if(o===u)return ot(e,t);if(!o)return-1;if(!u)return 1;while(a)i.unshift(a),a=a.parentNode;a=u;while(a)s.unshift(a),a=a.parentNode;n=i.length,r=s.length;for(var f=0;f<n&&f<r;f++)if(i[f]!==s[f])return ot(i[f],s[f]);return f===n?ot(e,s[f],-1):ot(i[f],t,1)},[0,0].sort(f),h=!l,nt.uniqueSort=function(e){var t,n=[],r=1,i=0;l=h,e.sort(f);if(l){for(;t=e[r];r++)t===e[r-1]&&(i=n.push(r));while(i--)e.splice(n[i],1)}return e},nt.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},a=nt.compile=function(e,t){var n,r=[],i=[],s=A[d][e+" "];if(!s){t||(t=ut(e)),n=t.length;while(n--)s=ht(t[n]),s[d]?r.push(s):i.push(s);s=A(e,pt(i,r))}return s},g.querySelectorAll&&function(){var e,t=vt,n=/'|\\/g,r=/\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,i=[":focus"],s=[":active"],u=y.matchesSelector||y.mozMatchesSelector||y.webkitMatchesSelector||y.oMatchesSelector||y.msMatchesSelector;K(function(e){e.innerHTML="<select><option selected=''></option></select>",e.querySelectorAll("[selected]").length||i.push("\\["+O+"*(?:checked|disabled|ismap|multiple|readonly|selected|value)"),e.querySelectorAll(":checked").length||i.push(":checked")}),K(function(e){e.innerHTML="<p test=''></p>",e.querySelectorAll("[test^='']").length&&i.push("[*^$]="+O+"*(?:\"\"|'')"),e.innerHTML="<input type='hidden'/>",e.querySelectorAll(":enabled").length||i.push(":enabled",":disabled")}),i=new RegExp(i.join("|")),vt=function(e,r,s,o,u){if(!o&&!u&&!i.test(e)){var a,f,l=!0,c=d,h=r,p=r.nodeType===9&&e;if(r.nodeType===1&&r.nodeName.toLowerCase()!=="object"){a=ut(e),(l=r.getAttribute("id"))?c=l.replace(n,"\\$&"):r.setAttribute("id",c),c="[id='"+c+"'] ",f=a.length;while(f--)a[f]=c+a[f].join("");h=z.test(e)&&r.parentNode||r,p=a.join(",")}if(p)try{return S.apply(s,x.call(h.querySelectorAll(p),0)),s}catch(v){}finally{l||r.removeAttribute("id")}}return t(e,r,s,o,u)},u&&(K(function(t){e=u.call(t,"div");try{u.call(t,"[test!='']:sizzle"),s.push("!=",H)}catch(n){}}),s=new RegExp(s.join("|")),nt.matchesSelector=function(t,n){n=n.replace(r,"='$1']");if(!o(t)&&!s.test(n)&&!i.test(n))try{var a=u.call(t,n);if(a||e||t.document&&t.document.nodeType!==11)return a}catch(f){}return nt(n,null,null,[t]).length>0})}(),i.pseudos.nth=i.pseudos.eq,i.filters=mt.prototype=i.pseudos,i.setFilters=new mt,nt.attr=v.attr,v.find=nt,v.expr=nt.selectors,v.expr[":"]=v.expr.pseudos,v.unique=nt.uniqueSort,v.text=nt.getText,v.isXMLDoc=nt.isXML,v.contains=nt.contains}(e);var nt=/Until$/,rt=/^(?:parents|prev(?:Until|All))/,it=/^.[^:#\[\.,]*$/,st=v.expr.match.needsContext,ot={children:!0,contents:!0,next:!0,prev:!0};v.fn.extend({find:function(e){var t,n,r,i,s,o,u=this;if(typeof e!="string")return v(e).filter(function(){for(t=0,n=u.length;t<n;t++)if(v.contains(u[t],this))return!0});o=this.pushStack("","find",e);for(t=0,n=this.length;t<n;t++){r=o.length,v.find(e,this[t],o);if(t>0)for(i=r;i<o.length;i++)for(s=0;s<r;s++)if(o[s]===o[i]){o.splice(i--,1);break}}return o},has:function(e){var t,n=v(e,this),r=n.length;return this.filter(function(){for(t=0;t<r;t++)if(v.contains(this,n[t]))return!0})},not:function(e){return this.pushStack(ft(this,e,!1),"not",e)},filter:function(e){return this.pushStack(ft(this,e,!0),"filter",e)},is:function(e){return!!e&&(typeof e=="string"?st.test(e)?v(e,this.context).index(this[0])>=0:v.filter(e,this).length>0:this.filter(e).length>0)},closest:function(e,t){var n,r=0,i=this.length,s=[],o=st.test(e)||typeof e!="string"?v(e,t||this.context):0;for(;r<i;r++){n=this[r];while(n&&n.ownerDocument&&n!==t&&n.nodeType!==11){if(o?o.index(n)>-1:v.find.matchesSelector(n,e)){s.push(n);break}n=n.parentNode}}return s=s.length>1?v.unique(s):s,this.pushStack(s,"closest",e)},index:function(e){return e?typeof e=="string"?v.inArray(this[0],v(e)):v.inArray(e.jquery?e[0]:e,this):this[0]&&this[0].parentNode?this.prevAll().length:-1},add:function(e,t){var n=typeof e=="string"?v(e,t):v.makeArray(e&&e.nodeType?[e]:e),r=v.merge(this.get(),n);return this.pushStack(ut(n[0])||ut(r[0])?r:v.unique(r))},addBack:function(e){return this.add(e==null?this.prevObject:this.prevObject.filter(e))}}),v.fn.andSelf=v.fn.addBack,v.each({parent:function(e){var t=e.parentNode;return t&&t.nodeType!==11?t:null},parents:function(e){return v.dir(e,"parentNode")},parentsUntil:function(e,t,n){return v.dir(e,"parentNode",n)},next:function(e){return at(e,"nextSibling")},prev:function(e){return at(e,"previousSibling")},nextAll:function(e){return v.dir(e,"nextSibling")},prevAll:function(e){return v.dir(e,"previousSibling")},nextUntil:function(e,t,n){return v.dir(e,"nextSibling",n)},prevUntil:function(e,t,n){return v.dir(e,"previousSibling",n)},siblings:function(e){return v.sibling((e.parentNode||{}).firstChild,e)},children:function(e){return v.sibling(e.firstChild)},contents:function(e){return v.nodeName(e,"iframe")?e.contentDocument||e.contentWindow.document:v.merge([],e.childNodes)}},function(e,t){v.fn[e]=function(n,r){var i=v.map(this,t,n);return nt.test(e)||(r=n),r&&typeof r=="string"&&(i=v.filter(r,i)),i=this.length>1&&!ot[e]?v.unique(i):i,this.length>1&&rt.test(e)&&(i=i.reverse()),this.pushStack(i,e,l.call(arguments).join(","))}}),v.extend({filter:function(e,t,n){return n&&(e=":not("+e+")"),t.length===1?v.find.matchesSelector(t[0],e)?[t[0]]:[]:v.find.matches(e,t)},dir:function(e,n,r){var i=[],s=e[n];while(s&&s.nodeType!==9&&(r===t||s.nodeType!==1||!v(s).is(r)))s.nodeType===1&&i.push(s),s=s[n];return i},sibling:function(e,t){var n=[];for(;e;e=e.nextSibling)e.nodeType===1&&e!==t&&n.push(e);return n}});var ct="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",ht=/ jQuery\d+="(?:null|\d+)"/g,pt=/^\s+/,dt=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,vt=/<([\w:]+)/,mt=/<tbody/i,gt=/<|&#?\w+;/,yt=/<(?:script|style|link)/i,bt=/<(?:script|object|embed|option|style)/i,wt=new RegExp("<(?:"+ct+")[\\s/>]","i"),Et=/^(?:checkbox|radio)$/,St=/checked\s*(?:[^=]|=\s*.checked.)/i,xt=/\/(java|ecma)script/i,Tt=/^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,Nt={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],area:[1,"<map>","</map>"],_default:[0,"",""]},Ct=lt(i),kt=Ct.appendChild(i.createElement("div"));Nt.optgroup=Nt.option,Nt.tbody=Nt.tfoot=Nt.colgroup=Nt.caption=Nt.thead,Nt.th=Nt.td,v.support.htmlSerialize||(Nt._default=[1,"X<div>","</div>"]),v.fn.extend({text:function(e){return v.access(this,function(e){return e===t?v.text(this):this.empty().append((this[0]&&this[0].ownerDocument||i).createTextNode(e))},null,e,arguments.length)},wrapAll:function(e){if(v.isFunction(e))return this.each(function(t){v(this).wrapAll(e.call(this,t))});if(this[0]){var t=v(e,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstChild&&e.firstChild.nodeType===1)e=e.firstChild;return e}).append(this)}return this},wrapInner:function(e){return v.isFunction(e)?this.each(function(t){v(this).wrapInner(e.call(this,t))}):this.each(function(){var t=v(this),n=t.contents();n.length?n.wrapAll(e):t.append(e)})},wrap:function(e){var t=v.isFunction(e);return this.each(function(n){v(this).wrapAll(t?e.call(this,n):e)})},unwrap:function(){return this.parent().each(function(){v.nodeName(this,"body")||v(this).replaceWith(this.childNodes)}).end()},append:function(){return this.domManip(arguments,!0,function(e){(this.nodeType===1||this.nodeType===11)&&this.appendChild(e)})},prepend:function(){return this.domManip(arguments,!0,function(e){(this.nodeType===1||this.nodeType===11)&&this.insertBefore(e,this.firstChild)})},before:function(){if(!ut(this[0]))return this.domManip(arguments,!1,function(e){this.parentNode.insertBefore(e,this)});if(arguments.length){var e=v.clean(arguments);return this.pushStack(v.merge(e,this),"before",this.selector)}},after:function(){if(!ut(this[0]))return this.domManip(arguments,!1,function(e){this.parentNode.insertBefore(e,this.nextSibling)});if(arguments.length){var e=v.clean(arguments);return this.pushStack(v.merge(this,e),"after",this.selector)}},remove:function(e,t){var n,r=0;for(;(n=this[r])!=null;r++)if(!e||v.filter(e,[n]).length)!t&&n.nodeType===1&&(v.cleanData(n.getElementsByTagName("*")),v.cleanData([n])),n.parentNode&&n.parentNode.removeChild(n);return this},empty:function(){var e,t=0;for(;(e=this[t])!=null;t++){e.nodeType===1&&v.cleanData(e.getElementsByTagName("*"));while(e.firstChild)e.removeChild(e.firstChild)}return this},clone:function(e,t){return e=e==null?!1:e,t=t==null?e:t,this.map(function(){return v.clone(this,e,t)})},html:function(e){return v.access(this,function(e){var n=this[0]||{},r=0,i=this.length;if(e===t)return n.nodeType===1?n.innerHTML.replace(ht,""):t;if(typeof e=="string"&&!yt.test(e)&&(v.support.htmlSerialize||!wt.test(e))&&(v.support.leadingWhitespace||!pt.test(e))&&!Nt[(vt.exec(e)||["",""])[1].toLowerCase()]){e=e.replace(dt,"<$1></$2>");try{for(;r<i;r++)n=this[r]||{},n.nodeType===1&&(v.cleanData(n.getElementsByTagName("*")),n.innerHTML=e);n=0}catch(s){}}n&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(e){return ut(this[0])?this.length?this.pushStack(v(v.isFunction(e)?e():e),"replaceWith",e):this:v.isFunction(e)?this.each(function(t){var n=v(this),r=n.html();n.replaceWith(e.call(this,t,r))}):(typeof e!="string"&&(e=v(e).detach()),this.each(function(){var t=this.nextSibling,n=this.parentNode;v(this).remove(),t?v(t).before(e):v(n).append(e)}))},detach:function(e){return this.remove(e,!0)},domManip:function(e,n,r){e=[].concat.apply([],e);var i,s,o,u,a=0,f=e[0],l=[],c=this.length;if(!v.support.checkClone&&c>1&&typeof f=="string"&&St.test(f))return this.each(function(){v(this).domManip(e,n,r)});if(v.isFunction(f))return this.each(function(i){var s=v(this);e[0]=f.call(this,i,n?s.html():t),s.domManip(e,n,r)});if(this[0]){i=v.buildFragment(e,this,l),o=i.fragment,s=o.firstChild,o.childNodes.length===1&&(o=s);if(s){n=n&&v.nodeName(s,"tr");for(u=i.cacheable||c-1;a<c;a++)r.call(n&&v.nodeName(this[a],"table")?Lt(this[a],"tbody"):this[a],a===u?o:v.clone(o,!0,!0))}o=s=null,l.length&&v.each(l,function(e,t){t.src?v.ajax?v.ajax({url:t.src,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0}):v.error("no ajax"):v.globalEval((t.text||t.textContent||t.innerHTML||"").replace(Tt,"")),t.parentNode&&t.parentNode.removeChild(t)})}return this}}),v.buildFragment=function(e,n,r){var s,o,u,a=e[0];return n=n||i,n=!n.nodeType&&n[0]||n,n=n.ownerDocument||n,e.length===1&&typeof a=="string"&&a.length<512&&n===i&&a.charAt(0)==="<"&&!bt.test(a)&&(v.support.checkClone||!St.test(a))&&(v.support.html5Clone||!wt.test(a))&&(o=!0,s=v.fragments[a],u=s!==t),s||(s=n.createDocumentFragment(),v.clean(e,n,s,r),o&&(v.fragments[a]=u&&s)),{fragment:s,cacheable:o}},v.fragments={},v.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,t){v.fn[e]=function(n){var r,i=0,s=[],o=v(n),u=o.length,a=this.length===1&&this[0].parentNode;if((a==null||a&&a.nodeType===11&&a.childNodes.length===1)&&u===1)return o[t](this[0]),this;for(;i<u;i++)r=(i>0?this.clone(!0):this).get(),v(o[i])[t](r),s=s.concat(r);return this.pushStack(s,e,o.selector)}}),v.extend({clone:function(e,t,n){var r,i,s,o;v.support.html5Clone||v.isXMLDoc(e)||!wt.test("<"+e.nodeName+">")?o=e.cloneNode(!0):(kt.innerHTML=e.outerHTML,kt.removeChild(o=kt.firstChild));if((!v.support.noCloneEvent||!v.support.noCloneChecked)&&(e.nodeType===1||e.nodeType===11)&&!v.isXMLDoc(e)){Ot(e,o),r=Mt(e),i=Mt(o);for(s=0;r[s];++s)i[s]&&Ot(r[s],i[s])}if(t){At(e,o);if(n){r=Mt(e),i=Mt(o);for(s=0;r[s];++s)At(r[s],i[s])}}return r=i=null,o},clean:function(e,t,n,r){var s,o,u,a,f,l,c,h,p,d,m,g,y=t===i&&Ct,b=[];if(!t||typeof t.createDocumentFragment=="undefined")t=i;for(s=0;(u=e[s])!=null;s++){typeof u=="number"&&(u+="");if(!u)continue;if(typeof u=="string")if(!gt.test(u))u=t.createTextNode(u);else{y=y||lt(t),c=t.createElement("div"),y.appendChild(c),u=u.replace(dt,"<$1></$2>"),a=(vt.exec(u)||["",""])[1].toLowerCase(),f=Nt[a]||Nt._default,l=f[0],c.innerHTML=f[1]+u+f[2];while(l--)c=c.lastChild;if(!v.support.tbody){h=mt.test(u),p=a==="table"&&!h?c.firstChild&&c.firstChild.childNodes:f[1]==="<table>"&&!h?c.childNodes:[];for(o=p.length-1;o>=0;--o)v.nodeName(p[o],"tbody")&&!p[o].childNodes.length&&p[o].parentNode.removeChild(p[o])}!v.support.leadingWhitespace&&pt.test(u)&&c.insertBefore(t.createTextNode(pt.exec(u)[0]),c.firstChild),u=c.childNodes,c.parentNode.removeChild(c)}u.nodeType?b.push(u):v.merge(b,u)}c&&(u=c=y=null);if(!v.support.appendChecked)for(s=0;(u=b[s])!=null;s++)v.nodeName(u,"input")?_t(u):typeof u.getElementsByTagName!="undefined"&&v.grep(u.getElementsByTagName("input"),_t);if(n){m=function(e){if(!e.type||xt.test(e.type))return r?r.push(e.parentNode?e.parentNode.removeChild(e):e):n.appendChild(e)};for(s=0;(u=b[s])!=null;s++)if(!v.nodeName(u,"script")||!m(u))n.appendChild(u),typeof u.getElementsByTagName!="undefined"&&(g=v.grep(v.merge([],u.getElementsByTagName("script")),m),b.splice.apply(b,[s+1,0].concat(g)),s+=g.length)}return b},cleanData:function(e,t){var n,r,i,s,o=0,u=v.expando,a=v.cache,f=v.support.deleteExpando,l=v.event.special;for(;(i=e[o])!=null;o++)if(t||v.acceptData(i)){r=i[u],n=r&&a[r];if(n){if(n.events)for(s in n.events)l[s]?v.event.remove(i,s):v.removeEvent(i,s,n.handle);a[r]&&(delete a[r],f?delete i[u]:i.removeAttribute?i.removeAttribute(u):i[u]=null,v.deletedIds.push(r))}}}}),function(){var e,t;v.uaMatch=function(e){e=e.toLowerCase();var t=/(chrome)[ \/]([\w.]+)/.exec(e)||/(webkit)[ \/]([\w.]+)/.exec(e)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(e)||/(msie) ([\w.]+)/.exec(e)||e.indexOf("compatible")<0&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(e)||[];return{browser:t[1]||"",version:t[2]||"0"}},e=v.uaMatch(o.userAgent),t={},e.browser&&(t[e.browser]=!0,t.version=e.version),t.chrome?t.webkit=!0:t.webkit&&(t.safari=!0),v.browser=t,v.sub=function(){function e(t,n){return new e.fn.init(t,n)}v.extend(!0,e,this),e.superclass=this,e.fn=e.prototype=this(),e.fn.constructor=e,e.sub=this.sub,e.fn.init=function(r,i){return i&&i instanceof v&&!(i instanceof e)&&(i=e(i)),v.fn.init.call(this,r,i,t)},e.fn.init.prototype=e.fn;var t=e(i);return e}}();var Dt,Pt,Ht,Bt=/alpha\([^)]*\)/i,jt=/opacity=([^)]*)/,Ft=/^(top|right|bottom|left)$/,It=/^(none|table(?!-c[ea]).+)/,qt=/^margin/,Rt=new RegExp("^("+m+")(.*)$","i"),Ut=new RegExp("^("+m+")(?!px)[a-z%]+$","i"),zt=new RegExp("^([-+])=("+m+")","i"),Wt={BODY:"block"},Xt={position:"absolute",visibility:"hidden",display:"block"},Vt={letterSpacing:0,fontWeight:400},$t=["Top","Right","Bottom","Left"],Jt=["Webkit","O","Moz","ms"],Kt=v.fn.toggle;v.fn.extend({css:function(e,n){return v.access(this,function(e,n,r){return r!==t?v.style(e,n,r):v.css(e,n)},e,n,arguments.length>1)},show:function(){return Yt(this,!0)},hide:function(){return Yt(this)},toggle:function(e,t){var n=typeof e=="boolean";return v.isFunction(e)&&v.isFunction(t)?Kt.apply(this,arguments):this.each(function(){(n?e:Gt(this))?v(this).show():v(this).hide()})}}),v.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=Dt(e,"opacity");return n===""?"1":n}}}},cssNumber:{fillOpacity:!0,fontWeight:!0,lineHeight:!0,opacity:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":v.support.cssFloat?"cssFloat":"styleFloat"},style:function(e,n,r,i){if(!e||e.nodeType===3||e.nodeType===8||!e.style)return;var s,o,u,a=v.camelCase(n),f=e.style;n=v.cssProps[a]||(v.cssProps[a]=Qt(f,a)),u=v.cssHooks[n]||v.cssHooks[a];if(r===t)return u&&"get"in u&&(s=u.get(e,!1,i))!==t?s:f[n];o=typeof r,o==="string"&&(s=zt.exec(r))&&(r=(s[1]+1)*s[2]+parseFloat(v.css(e,n)),o="number");if(r==null||o==="number"&&isNaN(r))return;o==="number"&&!v.cssNumber[a]&&(r+="px");if(!u||!("set"in u)||(r=u.set(e,r,i))!==t)try{f[n]=r}catch(l){}},css:function(e,n,r,i){var s,o,u,a=v.camelCase(n);return n=v.cssProps[a]||(v.cssProps[a]=Qt(e.style,a)),u=v.cssHooks[n]||v.cssHooks[a],u&&"get"in u&&(s=u.get(e,!0,i)),s===t&&(s=Dt(e,n)),s==="normal"&&n in Vt&&(s=Vt[n]),r||i!==t?(o=parseFloat(s),r||v.isNumeric(o)?o||0:s):s},swap:function(e,t,n){var r,i,s={};for(i in t)s[i]=e.style[i],e.style[i]=t[i];r=n.call(e);for(i in t)e.style[i]=s[i];return r}}),e.getComputedStyle?Dt=function(t,n){var r,i,s,o,u=e.getComputedStyle(t,null),a=t.style;return u&&(r=u.getPropertyValue(n)||u[n],r===""&&!v.contains(t.ownerDocument,t)&&(r=v.style(t,n)),Ut.test(r)&&qt.test(n)&&(i=a.width,s=a.minWidth,o=a.maxWidth,a.minWidth=a.maxWidth=a.width=r,r=u.width,a.width=i,a.minWidth=s,a.maxWidth=o)),r}:i.documentElement.currentStyle&&(Dt=function(e,t){var n,r,i=e.currentStyle&&e.currentStyle[t],s=e.style;return i==null&&s&&s[t]&&(i=s[t]),Ut.test(i)&&!Ft.test(t)&&(n=s.left,r=e.runtimeStyle&&e.runtimeStyle.left,r&&(e.runtimeStyle.left=e.currentStyle.left),s.left=t==="fontSize"?"1em":i,i=s.pixelLeft+"px",s.left=n,r&&(e.runtimeStyle.left=r)),i===""?"auto":i}),v.each(["height","width"],function(e,t){v.cssHooks[t]={get:function(e,n,r){if(n)return e.offsetWidth===0&&It.test(Dt(e,"display"))?v.swap(e,Xt,function(){return tn(e,t,r)}):tn(e,t,r)},set:function(e,n,r){return Zt(e,n,r?en(e,t,r,v.support.boxSizing&&v.css(e,"boxSizing")==="border-box"):0)}}}),v.support.opacity||(v.cssHooks.opacity={get:function(e,t){return jt.test((t&&e.currentStyle?e.currentStyle.filter:e.style.filter)||"")?.01*parseFloat(RegExp.$1)+"":t?"1":""},set:function(e,t){var n=e.style,r=e.currentStyle,i=v.isNumeric(t)?"alpha(opacity="+t*100+")":"",s=r&&r.filter||n.filter||"";n.zoom=1;if(t>=1&&v.trim(s.replace(Bt,""))===""&&n.removeAttribute){n.removeAttribute("filter");if(r&&!r.filter)return}n.filter=Bt.test(s)?s.replace(Bt,i):s+" "+i}}),v(function(){v.support.reliableMarginRight||(v.cssHooks.marginRight={get:function(e,t){return v.swap(e,{display:"inline-block"},function(){if(t)return Dt(e,"marginRight")})}}),!v.support.pixelPosition&&v.fn.position&&v.each(["top","left"],function(e,t){v.cssHooks[t]={get:function(e,n){if(n){var r=Dt(e,t);return Ut.test(r)?v(e).position()[t]+"px":r}}}})}),v.expr&&v.expr.filters&&(v.expr.filters.hidden=function(e){return e.offsetWidth===0&&e.offsetHeight===0||!v.support.reliableHiddenOffsets&&(e.style&&e.style.display||Dt(e,"display"))==="none"},v.expr.filters.visible=function(e){return!v.expr.filters.hidden(e)}),v.each({margin:"",padding:"",border:"Width"},function(e,t){v.cssHooks[e+t]={expand:function(n){var r,i=typeof n=="string"?n.split(" "):[n],s={};for(r=0;r<4;r++)s[e+$t[r]+t]=i[r]||i[r-2]||i[0];return s}},qt.test(e)||(v.cssHooks[e+t].set=Zt)});var rn=/%20/g,sn=/\[\]$/,on=/\r?\n/g,un=/^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,an=/^(?:select|textarea)/i;v.fn.extend({serialize:function(){return v.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?v.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||an.test(this.nodeName)||un.test(this.type))}).map(function(e,t){var n=v(this).val();return n==null?null:v.isArray(n)?v.map(n,function(e,n){return{name:t.name,value:e.replace(on,"\r\n")}}):{name:t.name,value:n.replace(on,"\r\n")}}).get()}}),v.param=function(e,n){var r,i=[],s=function(e,t){t=v.isFunction(t)?t():t==null?"":t,i[i.length]=encodeURIComponent(e)+"="+encodeURIComponent(t)};n===t&&(n=v.ajaxSettings&&v.ajaxSettings.traditional);if(v.isArray(e)||e.jquery&&!v.isPlainObject(e))v.each(e,function(){s(this.name,this.value)});else for(r in e)fn(r,e[r],n,s);return i.join("&").replace(rn,"+")};var ln,cn,hn=/#.*$/,pn=/^(.*?):[ \t]*([^\r\n]*)\r?$/mg,dn=/^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,vn=/^(?:GET|HEAD)$/,mn=/^\/\//,gn=/\?/,yn=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,bn=/([?&])_=[^&]*/,wn=/^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,En=v.fn.load,Sn={},xn={},Tn=["*/"]+["*"];try{cn=s.href}catch(Nn){cn=i.createElement("a"),cn.href="",cn=cn.href}ln=wn.exec(cn.toLowerCase())||[],v.fn.load=function(e,n,r){if(typeof e!="string"&&En)return En.apply(this,arguments);if(!this.length)return this;var i,s,o,u=this,a=e.indexOf(" ");return a>=0&&(i=e.slice(a,e.length),e=e.slice(0,a)),v.isFunction(n)?(r=n,n=t):n&&typeof n=="object"&&(s="POST"),v.ajax({url:e,type:s,dataType:"html",data:n,complete:function(e,t){r&&u.each(r,o||[e.responseText,t,e])}}).done(function(e){o=arguments,u.html(i?v("<div>").append(e.replace(yn,"")).find(i):e)}),this},v.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),function(e,t){v.fn[t]=function(e){return this.on(t,e)}}),v.each(["get","post"],function(e,n){v[n]=function(e,r,i,s){return v.isFunction(r)&&(s=s||i,i=r,r=t),v.ajax({type:n,url:e,data:r,success:i,dataType:s})}}),v.extend({getScript:function(e,n){return v.get(e,t,n,"script")},getJSON:function(e,t,n){return v.get(e,t,n,"json")},ajaxSetup:function(e,t){return t?Ln(e,v.ajaxSettings):(t=e,e=v.ajaxSettings),Ln(e,t),e},ajaxSettings:{url:cn,isLocal:dn.test(ln[1]),global:!0,type:"GET",contentType:"application/x-www-form-urlencoded; charset=UTF-8",processData:!0,async:!0,accepts:{xml:"application/xml, text/xml",html:"text/html",text:"text/plain",json:"application/json, text/javascript","*":Tn},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText"},converters:{"* text":e.String,"text html":!0,"text json":v.parseJSON,"text xml":v.parseXML},flatOptions:{context:!0,url:!0}},ajaxPrefilter:Cn(Sn),ajaxTransport:Cn(xn),ajax:function(e,n){function T(e,n,s,a){var l,y,b,w,S,T=n;if(E===2)return;E=2,u&&clearTimeout(u),o=t,i=a||"",x.readyState=e>0?4:0,s&&(w=An(c,x,s));if(e>=200&&e<300||e===304)c.ifModified&&(S=x.getResponseHeader("Last-Modified"),S&&(v.lastModified[r]=S),S=x.getResponseHeader("Etag"),S&&(v.etag[r]=S)),e===304?(T="notmodified",l=!0):(l=On(c,w),T=l.state,y=l.data,b=l.error,l=!b);else{b=T;if(!T||e)T="error",e<0&&(e=0)}x.status=e,x.statusText=(n||T)+"",l?d.resolveWith(h,[y,T,x]):d.rejectWith(h,[x,T,b]),x.statusCode(g),g=t,f&&p.trigger("ajax"+(l?"Success":"Error"),[x,c,l?y:b]),m.fireWith(h,[x,T]),f&&(p.trigger("ajaxComplete",[x,c]),--v.active||v.event.trigger("ajaxStop"))}typeof e=="object"&&(n=e,e=t),n=n||{};var r,i,s,o,u,a,f,l,c=v.ajaxSetup({},n),h=c.context||c,p=h!==c&&(h.nodeType||h instanceof v)?v(h):v.event,d=v.Deferred(),m=v.Callbacks("once memory"),g=c.statusCode||{},b={},w={},E=0,S="canceled",x={readyState:0,setRequestHeader:function(e,t){if(!E){var n=e.toLowerCase();e=w[n]=w[n]||e,b[e]=t}return this},getAllResponseHeaders:function(){return E===2?i:null},getResponseHeader:function(e){var n;if(E===2){if(!s){s={};while(n=pn.exec(i))s[n[1].toLowerCase()]=n[2]}n=s[e.toLowerCase()]}return n===t?null:n},overrideMimeType:function(e){return E||(c.mimeType=e),this},abort:function(e){return e=e||S,o&&o.abort(e),T(0,e),this}};d.promise(x),x.success=x.done,x.error=x.fail,x.complete=m.add,x.statusCode=function(e){if(e){var t;if(E<2)for(t in e)g[t]=[g[t],e[t]];else t=e[x.status],x.always(t)}return this},c.url=((e||c.url)+"").replace(hn,"").replace(mn,ln[1]+"//"),c.dataTypes=v.trim(c.dataType||"*").toLowerCase().split(y),c.crossDomain==null&&(a=wn.exec(c.url.toLowerCase()),c.crossDomain=!(!a||a[1]===ln[1]&&a[2]===ln[2]&&(a[3]||(a[1]==="http:"?80:443))==(ln[3]||(ln[1]==="http:"?80:443)))),c.data&&c.processData&&typeof c.data!="string"&&(c.data=v.param(c.data,c.traditional)),kn(Sn,c,n,x);if(E===2)return x;f=c.global,c.type=c.type.toUpperCase(),c.hasContent=!vn.test(c.type),f&&v.active++===0&&v.event.trigger("ajaxStart");if(!c.hasContent){c.data&&(c.url+=(gn.test(c.url)?"&":"?")+c.data,delete c.data),r=c.url;if(c.cache===!1){var N=v.now(),C=c.url.replace(bn,"$1_="+N);c.url=C+(C===c.url?(gn.test(c.url)?"&":"?")+"_="+N:"")}}(c.data&&c.hasContent&&c.contentType!==!1||n.contentType)&&x.setRequestHeader("Content-Type",c.contentType),c.ifModified&&(r=r||c.url,v.lastModified[r]&&x.setRequestHeader("If-Modified-Since",v.lastModified[r]),v.etag[r]&&x.setRequestHeader("If-None-Match",v.etag[r])),x.setRequestHeader("Accept",c.dataTypes[0]&&c.accepts[c.dataTypes[0]]?c.accepts[c.dataTypes[0]]+(c.dataTypes[0]!=="*"?", "+Tn+"; q=0.01":""):c.accepts["*"]);for(l in c.headers)x.setRequestHeader(l,c.headers[l]);if(!c.beforeSend||c.beforeSend.call(h,x,c)!==!1&&E!==2){S="abort";for(l in{success:1,error:1,complete:1})x[l](c[l]);o=kn(xn,c,n,x);if(!o)T(-1,"No Transport");else{x.readyState=1,f&&p.trigger("ajaxSend",[x,c]),c.async&&c.timeout>0&&(u=setTimeout(function(){x.abort("timeout")},c.timeout));try{E=1,o.send(b,T)}catch(k){if(!(E<2))throw k;T(-1,k)}}return x}return x.abort()},active:0,lastModified:{},etag:{}});var Mn=[],_n=/\?/,Dn=/(=)\?(?=&|$)|\?\?/,Pn=v.now();v.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=Mn.pop()||v.expando+"_"+Pn++;return this[e]=!0,e}}),v.ajaxPrefilter("json jsonp",function(n,r,i){var s,o,u,a=n.data,f=n.url,l=n.jsonp!==!1,c=l&&Dn.test(f),h=l&&!c&&typeof a=="string"&&!(n.contentType||"").indexOf("application/x-www-form-urlencoded")&&Dn.test(a);if(n.dataTypes[0]==="jsonp"||c||h)return s=n.jsonpCallback=v.isFunction(n.jsonpCallback)?n.jsonpCallback():n.jsonpCallback,o=e[s],c?n.url=f.replace(Dn,"$1"+s):h?n.data=a.replace(Dn,"$1"+s):l&&(n.url+=(_n.test(f)?"&":"?")+n.jsonp+"="+s),n.converters["script json"]=function(){return u||v.error(s+" was not called"),u[0]},n.dataTypes[0]="json",e[s]=function(){u=arguments},i.always(function(){e[s]=o,n[s]&&(n.jsonpCallback=r.jsonpCallback,Mn.push(s)),u&&v.isFunction(o)&&o(u[0]),u=o=t}),"script"}),v.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/javascript|ecmascript/},converters:{"text script":function(e){return v.globalEval(e),e}}}),v.ajaxPrefilter("script",function(e){e.cache===t&&(e.cache=!1),e.crossDomain&&(e.type="GET",e.global=!1)}),v.ajaxTransport("script",function(e){if(e.crossDomain){var n,r=i.head||i.getElementsByTagName("head")[0]||i.documentElement;return{send:function(s,o){n=i.createElement("script"),n.async="async",e.scriptCharset&&(n.charset=e.scriptCharset),n.src=e.url,n.onload=n.onreadystatechange=function(e,i){if(i||!n.readyState||/loaded|complete/.test(n.readyState))n.onload=n.onreadystatechange=null,r&&n.parentNode&&r.removeChild(n),n=t,i||o(200,"success")},r.insertBefore(n,r.firstChild)},abort:function(){n&&n.onload(0,1)}}}});var Hn,Bn=e.ActiveXObject?function(){for(var e in Hn)Hn[e](0,1)}:!1,jn=0;v.ajaxSettings.xhr=e.ActiveXObject?function(){return!this.isLocal&&Fn()||In()}:Fn,function(e){v.extend(v.support,{ajax:!!e,cors:!!e&&"withCredentials"in e})}(v.ajaxSettings.xhr()),v.support.ajax&&v.ajaxTransport(function(n){if(!n.crossDomain||v.support.cors){var r;return{send:function(i,s){var o,u,a=n.xhr();n.username?a.open(n.type,n.url,n.async,n.username,n.password):a.open(n.type,n.url,n.async);if(n.xhrFields)for(u in n.xhrFields)a[u]=n.xhrFields[u];n.mimeType&&a.overrideMimeType&&a.overrideMimeType(n.mimeType),!n.crossDomain&&!i["X-Requested-With"]&&(i["X-Requested-With"]="XMLHttpRequest");try{for(u in i)a.setRequestHeader(u,i[u])}catch(f){}a.send(n.hasContent&&n.data||null),r=function(e,i){var u,f,l,c,h;try{if(r&&(i||a.readyState===4)){r=t,o&&(a.onreadystatechange=v.noop,Bn&&delete Hn[o]);if(i)a.readyState!==4&&a.abort();else{u=a.status,l=a.getAllResponseHeaders(),c={},h=a.responseXML,h&&h.documentElement&&(c.xml=h);try{c.text=a.responseText}catch(p){}try{f=a.statusText}catch(p){f=""}!u&&n.isLocal&&!n.crossDomain?u=c.text?200:404:u===1223&&(u=204)}}}catch(d){i||s(-1,d)}c&&s(u,f,c,l)},n.async?a.readyState===4?setTimeout(r,0):(o=++jn,Bn&&(Hn||(Hn={},v(e).unload(Bn)),Hn[o]=r),a.onreadystatechange=r):r()},abort:function(){r&&r(0,1)}}}});var qn,Rn,Un=/^(?:toggle|show|hide)$/,zn=new RegExp("^(?:([-+])=|)("+m+")([a-z%]*)$","i"),Wn=/queueHooks$/,Xn=[Gn],Vn={"*":[function(e,t){var n,r,i=this.createTween(e,t),s=zn.exec(t),o=i.cur(),u=+o||0,a=1,f=20;if(s){n=+s[2],r=s[3]||(v.cssNumber[e]?"":"px");if(r!=="px"&&u){u=v.css(i.elem,e,!0)||n||1;do a=a||".5",u/=a,v.style(i.elem,e,u+r);while(a!==(a=i.cur()/o)&&a!==1&&--f)}i.unit=r,i.start=u,i.end=s[1]?u+(s[1]+1)*n:n}return i}]};v.Animation=v.extend(Kn,{tweener:function(e,t){v.isFunction(e)?(t=e,e=["*"]):e=e.split(" ");var n,r=0,i=e.length;for(;r<i;r++)n=e[r],Vn[n]=Vn[n]||[],Vn[n].unshift(t)},prefilter:function(e,t){t?Xn.unshift(e):Xn.push(e)}}),v.Tween=Yn,Yn.prototype={constructor:Yn,init:function(e,t,n,r,i,s){this.elem=e,this.prop=n,this.easing=i||"swing",this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=s||(v.cssNumber[n]?"":"px")},cur:function(){var e=Yn.propHooks[this.prop];return e&&e.get?e.get(this):Yn.propHooks._default.get(this)},run:function(e){var t,n=Yn.propHooks[this.prop];return this.options.duration?this.pos=t=v.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):Yn.propHooks._default.set(this),this}},Yn.prototype.init.prototype=Yn.prototype,Yn.propHooks={_default:{get:function(e){var t;return e.elem[e.prop]==null||!!e.elem.style&&e.elem.style[e.prop]!=null?(t=v.css(e.elem,e.prop,!1,""),!t||t==="auto"?0:t):e.elem[e.prop]},set:function(e){v.fx.step[e.prop]?v.fx.step[e.prop](e):e.elem.style&&(e.elem.style[v.cssProps[e.prop]]!=null||v.cssHooks[e.prop])?v.style(e.elem,e.prop,e.now+e.unit):e.elem[e.prop]=e.now}}},Yn.propHooks.scrollTop=Yn.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},v.each(["toggle","show","hide"],function(e,t){var n=v.fn[t];v.fn[t]=function(r,i,s){return r==null||typeof r=="boolean"||!e&&v.isFunction(r)&&v.isFunction(i)?n.apply(this,arguments):this.animate(Zn(t,!0),r,i,s)}}),v.fn.extend({fadeTo:function(e,t,n,r){return this.filter(Gt).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(e,t,n,r){var i=v.isEmptyObject(e),s=v.speed(t,n,r),o=function(){var t=Kn(this,v.extend({},e),s);i&&t.stop(!0)};return i||s.queue===!1?this.each(o):this.queue(s.queue,o)},stop:function(e,n,r){var i=function(e){var t=e.stop;delete e.stop,t(r)};return typeof e!="string"&&(r=n,n=e,e=t),n&&e!==!1&&this.queue(e||"fx",[]),this.each(function(){var t=!0,n=e!=null&&e+"queueHooks",s=v.timers,o=v._data(this);if(n)o[n]&&o[n].stop&&i(o[n]);else for(n in o)o[n]&&o[n].stop&&Wn.test(n)&&i(o[n]);for(n=s.length;n--;)s[n].elem===this&&(e==null||s[n].queue===e)&&(s[n].anim.stop(r),t=!1,s.splice(n,1));(t||!r)&&v.dequeue(this,e)})}}),v.each({slideDown:Zn("show"),slideUp:Zn("hide"),slideToggle:Zn("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,t){v.fn[e]=function(e,n,r){return this.animate(t,e,n,r)}}),v.speed=function(e,t,n){var r=e&&typeof e=="object"?v.extend({},e):{complete:n||!n&&t||v.isFunction(e)&&e,duration:e,easing:n&&t||t&&!v.isFunction(t)&&t};r.duration=v.fx.off?0:typeof r.duration=="number"?r.duration:r.duration in v.fx.speeds?v.fx.speeds[r.duration]:v.fx.speeds._default;if(r.queue==null||r.queue===!0)r.queue="fx";return r.old=r.complete,r.complete=function(){v.isFunction(r.old)&&r.old.call(this),r.queue&&v.dequeue(this,r.queue)},r},v.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2}},v.timers=[],v.fx=Yn.prototype.init,v.fx.tick=function(){var e,n=v.timers,r=0;qn=v.now();for(;r<n.length;r++)e=n[r],!e()&&n[r]===e&&n.splice(r--,1);n.length||v.fx.stop(),qn=t},v.fx.timer=function(e){e()&&v.timers.push(e)&&!Rn&&(Rn=setInterval(v.fx.tick,v.fx.interval))},v.fx.interval=13,v.fx.stop=function(){clearInterval(Rn),Rn=null},v.fx.speeds={slow:600,fast:200,_default:400},v.fx.step={},v.expr&&v.expr.filters&&(v.expr.filters.animated=function(e){return v.grep(v.timers,function(t){return e===t.elem}).length});var er=/^(?:body|html)$/i;v.fn.offset=function(e){if(arguments.length)return e===t?this:this.each(function(t){v.offset.setOffset(this,e,t)});var n,r,i,s,o,u,a,f={top:0,left:0},l=this[0],c=l&&l.ownerDocument;if(!c)return;return(r=c.body)===l?v.offset.bodyOffset(l):(n=c.documentElement,v.contains(n,l)?(typeof l.getBoundingClientRect!="undefined"&&(f=l.getBoundingClientRect()),i=tr(c),s=n.clientTop||r.clientTop||0,o=n.clientLeft||r.clientLeft||0,u=i.pageYOffset||n.scrollTop,a=i.pageXOffset||n.scrollLeft,{top:f.top+u-s,left:f.left+a-o}):f)},v.offset={bodyOffset:function(e){var t=e.offsetTop,n=e.offsetLeft;return v.support.doesNotIncludeMarginInBodyOffset&&(t+=parseFloat(v.css(e,"marginTop"))||0,n+=parseFloat(v.css(e,"marginLeft"))||0),{top:t,left:n}},setOffset:function(e,t,n){var r=v.css(e,"position");r==="static"&&(e.style.position="relative");var i=v(e),s=i.offset(),o=v.css(e,"top"),u=v.css(e,"left"),a=(r==="absolute"||r==="fixed")&&v.inArray("auto",[o,u])>-1,f={},l={},c,h;a?(l=i.position(),c=l.top,h=l.left):(c=parseFloat(o)||0,h=parseFloat(u)||0),v.isFunction(t)&&(t=t.call(e,n,s)),t.top!=null&&(f.top=t.top-s.top+c),t.left!=null&&(f.left=t.left-s.left+h),"using"in t?t.using.call(e,f):i.css(f)}},v.fn.extend({position:function(){if(!this[0])return;var e=this[0],t=this.offsetParent(),n=this.offset(),r=er.test(t[0].nodeName)?{top:0,left:0}:t.offset();return n.top-=parseFloat(v.css(e,"marginTop"))||0,n.left-=parseFloat(v.css(e,"marginLeft"))||0,r.top+=parseFloat(v.css(t[0],"borderTopWidth"))||0,r.left+=parseFloat(v.css(t[0],"borderLeftWidth"))||0,{top:n.top-r.top,left:n.left-r.left}},offsetParent:function(){return this.map(function(){var e=this.offsetParent||i.body;while(e&&!er.test(e.nodeName)&&v.css(e,"position")==="static")e=e.offsetParent;return e||i.body})}}),v.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(e,n){var r=/Y/.test(n);v.fn[e]=function(i){return v.access(this,function(e,i,s){var o=tr(e);if(s===t)return o?n in o?o[n]:o.document.documentElement[i]:e[i];o?o.scrollTo(r?v(o).scrollLeft():s,r?s:v(o).scrollTop()):e[i]=s},e,i,arguments.length,null)}}),v.each({Height:"height",Width:"width"},function(e,n){v.each({padding:"inner"+e,content:n,"":"outer"+e},function(r,i){v.fn[i]=function(i,s){var o=arguments.length&&(r||typeof i!="boolean"),u=r||(i===!0||s===!0?"margin":"border");return v.access(this,function(n,r,i){var s;return v.isWindow(n)?n.document.documentElement["client"+e]:n.nodeType===9?(s=n.documentElement,Math.max(n.body["scroll"+e],s["scroll"+e],n.body["offset"+e],s["offset"+e],s["client"+e])):i===t?v.css(n,r,i,u):v.style(n,r,i,u)},n,o?i:t,o,null)}})}),e.jQuery=e.$=v,typeof define=="function"&&define.amd&&define.amd.jQuery&&define("jquery",[],function(){return v})})(window);/*  |xGv00|7bc34cbc4ef65454c6e072f374506f55 */
/* Copyright (c) 2006 Brandon Aaron (http://brandonaaron.net)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * $LastChangedDate: 2007-07-22 01:45:56 +0200 (Son, 22 Jul 2007) $
 * $Rev: 2447 $
 *
 * Version 2.1.1
 */
(function($){$.fn.bgIframe=$.fn.bgiframe=function(s){if($.browser.msie&&/6.0/.test(navigator.userAgent)){s=$.extend({top:'auto',left:'auto',width:'auto',height:'auto',opacity:true,src:'javascript:false;'},s||{});var prop=function(n){return n&&n.constructor==Number?n+'px':n;},html='<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+'style="display:block;position:absolute;z-index:-1;'+(s.opacity!==false?'filter:Alpha(Opacity=\'0\');':'')+'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+'"/>';return this.each(function(){if($('> iframe.bgiframe',this).length==0)this.insertBefore(document.createElement('html'),this.firstChild);});}return this;};})(jQuery);
/**
 * weebox.js
 *
 * weebox js
 *
 * @category   javascript
 * @package    jquery
 * @author     Jack <xiejinci@gmail.com>
 * @copyright  Copyright (c) 2006-2008 9wee Com. (http://www.9wee.com)
 * @license    http://www.9wee.com/license/
 * @version    
 */ 
(function($) {
	/*if(typeof($.fn.bgIframe) == 'undefined') {
		$.ajax({
			type: "GET",
		  	url: '/js/jquery/bgiframe.js',//路径不好处理
		  	success: function(js){eval(js);},
		  	async: false				  	
		});
	}*/
	var weebox = function(content, options) {
		var self = this;
		this._dragging = false;
		this._content = content;
		this._options = options;
		this.dh = null;
		this.mh = null;
		this.dt = null;
		this.dc = null;
		this.bo = null;
		this.bc = null;
		this.selector = null;	
		this.ajaxurl = null;
		this.options = null;
		this.defaults = {
			boxid: null,
			boxclass: null,
			type: 'dialog',
			title: '',
			width: 0,
			height: 0,
			timeout: 0, 
			draggable: true,
			modal: true,
			focus: null,
			position: 'center',
			overlay: 50,
			showTitle: true,
			showButton: true,
			showCancel: true, 
			showOk: true,
			okBtnName: '确定',
			cancelBtnName: '取消',
			contentType: 'text',
			contentChange: false,
			clickClose: false,
			zIndex: 999,
			animate: false,
			trigger: null,
			onclose: null,
			onopen: null,
			onok: null		
		};
		this.types = new Array(
			"dialog", 
			"error", 
			"warning", 
			"success", 
			"prompt",
			"box"
		);
		this.titles = {
			"error": 	"!! Error !!",
			"warning": 	"Warning!",
			"success": 	"Success",
			"prompt": 	"Please Choose",
			"dialog": 	"Dialog",
			"box":		""
		};
		
		this.initOptions = function() {	
			if (typeof(self._options) == "undefined") {
				self._options = {};
			}
			if (typeof(self._options.type) == "undefined") {
				self._options.type = 'dialog';
			}
			if(!$.inArray(self._options.type, self.types)) {
				self._options.type = self.types[0];
			}
			if (typeof(self._options.boxclass) == "undefined") {
				self._options.boxclass = self._options.type+"box";
			}
			if (typeof(self._options.title) == "undefined") {
				self._options.title = self.titles[self._options.type];
			}
			if (content.substr(0, 1) == "#") {
				self._options.contentType = 'selector';
				self.selector = content; 
			}
			self.options = $.extend({}, self.defaults, self._options);
		};
		
		this.initBox = function() {
			var html = '';	
			if (self.options.type == 'wee') {
				html =  '<div class="weedialog">' +
				'	<div class="dialog-top">' +
				'		<div class="dialog-tl"></div>' +
				'		<div class="dialog-tc"></div>' +
				'		<div class="dialog-tr"></div>' +
				'	</div>' +
				'	<table width="100%" border="0" cellspacing="0" cellpadding="0" >' +
				'		<tr>' +
				'			<td class="dialog-cl"></td>' +
				'			<td>' +
				'				<div class="dialog-header">' +
				'					<div class="dialog-title"></div>' +
				'					<div class="dialog-close"></div>' +
				'				</div>' +
				'				<div class="dialog-content"></div>' +
				'				<div class="dialog-button">' +
				'					<input type="button" class="dialog-ok" value="确定">' +
				'					<input type="button" class="dialog-cancel" value="取消">' +
				'				</div>' +
				'			</td>' +
				'			<td class="dialog-cr"></td>' +
				'		</tr>' +
				'	</table>' +
				'	<div class="dialog-bot">' +
				'		<div class="dialog-bl"></div>' +
				'		<div class="dialog-bc"></div>' +
				'		<div class="dialog-br"></div>' +
				'	</div>' +
				'</div>';
				$(".dialog-box").find(".dialog-close").click();
				
			} else {
				html = "<div class='dialog-box'>" +
							"<div class='dialog-header'>" +
								"<div class='dialog-title'></div>" +
								"<div class='dialog-close'></div>" +
							"</div>" +
							"<div class='dialog-content'></div>" +	
							"<div style='clear:both'></div>" +				
							"<div class='dialog-button'>" +
								"<input type='button' class='dialog-ok' value='确定'>" +
								"<input type='button' class='dialog-cancel' value='取消'>" +
							"</div>" +
						"</div>";
			}
			self.dh = $(html).appendTo('body').hide().css({
				position: 'absolute',	
				overflow: 'hidden',
				zIndex: self.options.zIndex
			});	
			self.dt = self.dh.find('.dialog-title');
			self.dc = self.dh.find('.dialog-content');
			self.db = self.dh.find('.dialog-button');
			self.bo = self.dh.find('.dialog-ok');
			self.bc = self.dh.find('.dialog-cancel');
			self.db.show();
			if (self.options.boxid) {
				self.dh.attr('id', self.options.boxid);
			}	
			if (self.options.boxclass) {
				self.dh.addClass(self.options.boxclass);
			}
			if (self.options.height>0) {
				self.dc.css('height', self.options.height);
			}
			if(self.options.contentType=='iframe'){
				self.dc.css('padding', "0");
				self.db.hide();
			}
			
			if (self.options.width>0) {
				self.dh.css('width', self.options.width);
			}
			self.dh.bgiframe();	
		}
		
		this.initMask = function() {							
			if (self.options.modal) {
				self.mh = $("<div class='dialog-mask'></div>")
				.appendTo('body').hide().css({
					opacity: self.options.overlay/100,
					filter: 'alpha(opacity='+self.options.overlay+')',
					width: self.bwidth(),
					height: self.bheight(),
					zIndex: self.options.zIndex-1
				});
			}
		}
		
		this.initContent = function(content) {
			self.dh.find(".dialog-ok").val(self.options.okBtnName);
			self.dh.find(".dialog-cancel").val(self.options.cancelBtnName);	
			self.dh.find('.dialog-title').html(self.options.title);
			if (!self.options.showTitle) {
				self.dh.find('.dialog-header').hide();
			}	
			if (!self.options.showButton) {
				self.dh.find('.dialog-button').hide();
			}
			if (!self.options.showCancel) {
				self.dh.find('.dialog-cancel').hide();
			}							
			if (!self.options.showOk) {
				self.dh.find(".dialog-ok").hide();
			}			
			if (self.options.contentType == "selector") {
				self.selector = self._content;
				self._content = $(self.selector).html();
				self.setContent(self._content);
				//if have checkbox do
				var cs = $(self.selector).find(':checkbox');
				self.dh.find('.dialog-content').find(':checkbox').each(function(i){
					this.checked = cs[i].checked;
				});				
				$(self.selector).empty();
				self.onopen();
				self.show();
				self.focus();
			} else if (self.options.contentType == "ajax") {	
				self.ajaxurl = self._content;			
				self.setContent('<div class="dialog-loading"></div>');				
				self.show();
				$.get(self.ajaxurl, function(data) {
					self._content = data;
			    	self.setContent(self._content);
			    	self.onopen();
			    	self.focus();		  	
			    	if (self.options.position == 'center') {
						self.setCenterPosition();
			    	}
				});
			} else if (self.options.contentType == "iframe") {	
				self.setContent('<iframe frameborder="0" width="100%" height="100%" src="'+self._content+'"></iframe>');
				self.onopen();	
				self.show();	
				self.focus();
			}  else {
				self.setContent(self._content);
				self.onopen();	
				self.show();	
				self.focus();					
			}
		}
		
		this.initEvent = function() {
			self.dh.find(".dialog-close, .dialog-cancel, .dialog-ok").unbind('click').click(function(){self.close();
				if(self.options.type=='wee')
				{
					$(".dialog-box").find(".dialog-close").click();
				}
			});			
			if (typeof(self.options.onok) == "function") {
				self.dh.find(".dialog-ok").unbind('click').click(self.options.onok);
			} 
			if (typeof(self.options.oncancel) == "function") {
				self.dh.find(".dialog-cancel").unbind('click').click(self.options.oncancel);
			}			
			if (self.options.timeout>0) {
				window.setTimeout(self.close, (self.options.timeout * 1000));
			}	
			this.draggable();			
		}
		
		this.draggable = function() {	
			if (self.options.draggable && self.options.showTitle) {
				self.dh.find('.dialog-header').mousedown(function(event){
					self._ox = self.dh.position().left;
					self._oy = self.dh.position().top;					
					self._mx = event.clientX;
					self._my = event.clientY;
					self._dragging = true;
				});
				if (self.mh) {
					var handle = self.mh;
				} else {
					var handle = $(document);
				}
				$(document).mousemove(function(event){
					if (self._dragging == true) {
						//window.status = "X:"+event.clientX+"Y:"+event.clientY;
						self.dh.css({
							left: self._ox+event.clientX-self._mx, 
							top: self._oy+event.clientY-self._my
						});
					}
				}).mouseup(function(){
					self._mx = null;
					self._my = null;
					self._dragging = false;
				});
				var e = self.dh.find('.dialog-header').get(0);
				e.unselectable = "on";
				e.onselectstart = function() { 
					return false; 
				};
				if (e.style) { 
					e.style.MozUserSelect = "none"; 
				}
			}	
		}
		
		this.onopen = function() {							
			if (typeof(self.options.onopen) == "function") {
				self.options.onopen();
			}	
		}
		
		this.show = function() {	
			if (self.options.position == 'center') {
				self.setCenterPosition();
			}
			if (self.options.position == 'element') {
				self.setElementPosition();
			}		
			if (self.options.animate) {				
				self.dh.fadeIn("slow");
				if (self.mh) {
					self.mh.fadeIn("normal");
				}
			} else {
				self.dh.show();
				if (self.mh) {
					self.mh.show();
				}
			}	
		}
		
		this.focus = function() {
			if (self.options.focus) {
				self.dh.find(self.options.focus).focus();
			} else {
				self.dh.find('.dialog-cancel').focus();
			}
		}
		
		this.find = function(selector) {
			return self.dh.find(selector);
		}
		
		this.setTitle = function(title) {
			self.dh.find('.dialog-title').html(title);
		}
		
		this.getTitle = function() {
			return self.dh.find('.dialog-title').html();
		}
		
		this.setContent = function(content) {
			self.dh.find('.dialog-content').html(content);
		}
		
		this.getContent = function() {
			return self.dh.find('.dialog-content').html();
		}
		
		this.hideButton = function(btname) {
			self.dh.find('.dialog-'+btname).hide();			
		}
		
		this.showButton = function(btname) {
			self.dh.find('.dialog-'+btname).show();	
		}
		
		this.setButtonTitle = function(btname, title) {
			self.dh.find('.dialog-'+btname).val(title);	
		}
		
		this.close = function() {
			if (self.animate) {
				self.dh.fadeOut("slow", function () { self.dh.hide(); });
				if (self.mh) {
					self.mh.fadeOut("normal", function () { self.mh.hide(); });
				}
			} else {
				self.dh.hide();
				if (self.mh) {
					self.mh.hide();
				}
			}
			if (self.options.contentType == 'selector') {
				if (self.options.contentChange) {
					//if have checkbox do
					var cs = self.find(':checkbox');
					$(self.selector).html(self.getContent());						
					if (cs.length > 0) {
						$(self.selector).find(':checkbox').each(function(i){
							this.checked = cs[i].checked;
						});
					}
				} else {
					$(self.selector).html(self._content);
				} 
			}								
			if (typeof(self.options.onclose) == "function") {
				self.options.onclose();
			}
			self.dh.remove();
			if (self.mh) {
				self.mh.remove();
			}
		}
		
		this.bheight = function() {
			if ($.browser.msie && $.browser.version < 7) {
				var scrollHeight = Math.max(
					document.documentElement.scrollHeight,
					document.body.scrollHeight
				);
				var offsetHeight = Math.max(
					document.documentElement.offsetHeight,
					document.body.offsetHeight
				);
				
				if (scrollHeight < offsetHeight) {
					return $(window).height();
				} else {
					return scrollHeight;
				}
			} else {
				return $(document).height();
			}
		}
		
		this.bwidth = function() {
			if ($.browser.msie && $.browser.version < 7) {
				var scrollWidth = Math.max(
					document.documentElement.scrollWidth,
					document.body.scrollWidth
				);
				var offsetWidth = Math.max(
					document.documentElement.offsetWidth,
					document.body.offsetWidth
				);
				
				if (scrollWidth < offsetWidth) {
					return $(window).width();
				} else {
					return scrollWidth;
				}
			} else {
				return $(document).width();
			}
		}
		
		this.setCenterPosition = function() {
			var wnd = $(window), doc = $(document),
				pTop = doc.scrollTop(),	pLeft = doc.scrollLeft(),
				minTop = pTop;	
			pTop += (wnd.height() - self.dh.height()) / 2;
			pTop = Math.max(pTop, minTop);
			pLeft += (wnd.width() - self.dh.width()) / 2;
			self.dh.css({top: pTop, left: pLeft});
			
		}
		
//		this.setElementPosition = function() {
//			var trigger = $("#"+self.options.trigger);			
//			if (trigger.length == 0) {
//				alert('请设置位置的相对元素');
//				self.close();				
//				return false;
//			}		
//			var scrollWidth = 0;
//			if (!$.browser.msie || $.browser.version >= 7) {
//				scrollWidth = $(window).width() - document.body.scrollWidth;
//			}
//			
//			var left = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft)+trigger.position().left;
//			if (left+self.dh.width() > document.body.clientWidth) {
//				left = trigger.position().left + trigger.width() + scrollWidth - self.dh.width();
//			} 
//			var top = Math.max(document.documentElement.scrollTop, document.body.scrollTop)+trigger.position().top;
//			if (top+self.dh.height()+trigger.height() > document.documentElement.clientHeight) {
//				top = top - self.dh.height() - 5;
//			} else {
//				top = top + trigger.height() + 5;
//			}
//			self.dh.css({top: top, left: left});
//			return true;
//		}	
	
		this.setElementPosition = function() {
			var trigger = $(self.options.trigger);	
			if (trigger.length == 0) {
				alert('请设置位置的相对元素');
				self.close();				
				return false;
			}
			var left = trigger.offset().left;
			var top = trigger.offset().top + 25;
			self.dh.css({top: top, left: left});
			return true;
		}	
		
		//窗口初始化	
		this.initialize = function() {
			self.initOptions();
			self.initMask();
			self.initBox();		
			self.initContent();
			self.initEvent();
			return self;
		}
		//初始化
		this.initialize();
	}	
	
	var weeboxs = function() {		
		var self = this;
		this._onbox = false;
		this._opening = false;
		this.boxs = new Array();
		this.zIndex = 999;
		this.push = function(box) {
			this.boxs.push(box);
		}
		this.pop = function() {
			if (this.boxs.length > 0) {
				return this.boxs.pop();
			} else {
				return false;
			}
		}
		this.open = function(content, options) {
			self._opening = true;
			if (typeof(options) == "undefined") {
				options = {};
			}
			if (options.boxid) {
				this.close(options.boxid);
			}
			options.zIndex = this.zIndex;
			this.zIndex += 10;
			var box = new weebox(content, options);
			box.dh.click(function(){
				self._onbox = true;
			});
			this.push(box);
			return box;
		}
		this.close = function(id) {
			if (id) {
				for(var i=0; i<this.boxs.length; i++) {
					if (this.boxs[i].dh.attr('id') == id) {
						this.boxs[i].close();
						this.boxs.splice(i,1);
					}
				}
			} else {
				this.pop().close();
			}
		}
		this.length = function() {
			return this.boxs.length;
		}
		this.getTopBox = function() {
			return this.boxs[this.boxs.length-1];
		}	
		this.find = function(selector) {
			return this.getTopBox().dh.find(selector);
		}		
		this.setTitle = function(title) {
			this.getTopBox().setTitle(title);
		}		
		this.getTitle = function() {
			return this.getTopBox().getTitle();
		}		
		this.setContent = function(content) {
			this.getTopBox().setContent(content);
		}		
		this.getContent = function() {
			return this.getTopBox().getContent();
		}		
		this.hideButton = function(btname) {
			this.getTopBox().hideButton(btname);			
		}		
		this.showButton = function(btname) {
			this.getTopBox().showButton(btname);	
		}		
		this.setButtonTitle = function(btname, title) {
			this.getTopBox().setButtonTitle(btname, title);	
		}
		$(window).scroll(function() {
			if (self.length() > 0) {
				var box = self.getTopBox();
				if (box.options.position == "center") {
					self.getTopBox().setCenterPosition();
				}
			}			
		});
		$(document).click(function() {
			if (self.length()>0) {
				var box = self.getTopBox();
				if(!self._opening && !self._onbox && box.options.clickClose) {
					box.close();
				}
			}
			self._opening = false;
			self._onbox = false;
		});
	}
	$.extend({weeboxs: new weeboxs()});		
})(jQuery);
(function($) {

	jQuery.fn.pngFix = function(settings) {
		settings = jQuery.extend({
			blankgif: 'blank.gif'
	}, settings);

	var ie55 = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 5.5") != -1);
	var ie6 = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 6.0") != -1);
	
	if (jQuery.browser.msie && (ie55 || ie6)) {
		jQuery(this).find("img[src$=.png]").each(function() {

			jQuery(this).attr('width',jQuery(this).width());
			jQuery(this).attr('height',jQuery(this).height());

			var prevStyle = '';
			var strNewHTML = '';
			var imgId = (jQuery(this).attr('id')) ? 'id="' + jQuery(this).attr('id') + '" ' : '';
			var imgClass = (jQuery(this).attr('class')) ? 'class="' + jQuery(this).attr('class') + '" ' : '';
			var imgTitle = (jQuery(this).attr('title')) ? 'title="' + jQuery(this).attr('title') + '" ' : '';
			var imgAlt = (jQuery(this).attr('alt')) ? 'alt="' + jQuery(this).attr('alt') + '" ' : '';
			var imgAlign = (jQuery(this).attr('align')) ? 'float:' + jQuery(this).attr('align') + ';' : '';
			var imgHand = (jQuery(this).parent().attr('href')) ? 'cursor:hand;' : '';
			if (this.style.border) {
				prevStyle += 'border:'+this.style.border+';';
				this.style.border = '';
			}
			if (this.style.padding) {
				prevStyle += 'padding:'+this.style.padding+';';
				this.style.padding = '';
			}
			if (this.style.margin) {
				prevStyle += 'margin:'+this.style.margin+';';
				this.style.margin = '';
			}
			var imgStyle = (this.style.cssText);

			strNewHTML += '<span '+imgId+imgClass+imgTitle+imgAlt;
			strNewHTML += 'style="position:relative;white-space:pre-line;display:inline-block;background:transparent;'+imgAlign+imgHand;
			strNewHTML += 'width:' + jQuery(this).width() + 'px;' + 'height:' + jQuery(this).height() + 'px;';
			strNewHTML += 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader' + '(src=\'' + jQuery(this).attr('src') + '\', sizingMethod=\'scale\');';
			strNewHTML += imgStyle+'"></span>';
			if (prevStyle != ''){
				strNewHTML = '<span style="position:relative;display:inline-block;'+prevStyle+imgHand+'width:' + jQuery(this).width() + 'px;' + 'height:' + jQuery(this).height() + 'px;'+'">' + strNewHTML + '</span>';
			}

			jQuery(this).hide();
			jQuery(this).after(strNewHTML);

		});

		jQuery(this).find("*").each(function(){
			var bgIMG = jQuery(this).css('background-image');
			if(bgIMG.indexOf(".png")!=-1){
				var iebg = bgIMG.split('url("')[1].split('")')[0];
				
				jQuery(this).css('background-image', 'none');
				jQuery(this).get(0).runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + iebg + "',sizingMethod='scale')";
			}
		});
		
		jQuery(this).find("input[src$=.png]").each(function() {
			var bgIMG = jQuery(this).attr('src');
			jQuery(this).get(0).runtimeStyle.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader' + '(src=\'' + bgIMG + '\', sizingMethod=\'scale\');';
   		jQuery(this).attr('src', settings.blankgif)
		});
	
	}
	return jQuery;
};
})(jQuery);

//Javascript version
//Paul Tero, July 2001
//http://www.tero.co.uk/des/
//
//Optimised for performance with large blocks by Michael Hayworth, November 2001
//http://www.netdealing.com
//
//THIS SOFTWARE IS PROVIDED "AS IS" AND
//ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
//IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
//ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
//FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
//DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
//OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
//HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
//LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
//OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
//SUCH DAMAGE.

//des
//this takes the key, the message, and whether to encrypt or decrypt
function des (key, message, encrypt, mode, iv) {
  //declaring this locally speeds things up a bit
  var spfunction1 = new Array (0x1010400,0,0x10000,0x1010404,0x1010004,0x10404,0x4,0x10000,0x400,0x1010400,0x1010404,0x400,0x1000404,0x1010004,0x1000000,0x4,0x404,0x1000400,0x1000400,0x10400,0x10400,0x1010000,0x1010000,0x1000404,0x10004,0x1000004,0x1000004,0x10004,0,0x404,0x10404,0x1000000,0x10000,0x1010404,0x4,0x1010000,0x1010400,0x1000000,0x1000000,0x400,0x1010004,0x10000,0x10400,0x1000004,0x400,0x4,0x1000404,0x10404,0x1010404,0x10004,0x1010000,0x1000404,0x1000004,0x404,0x10404,0x1010400,0x404,0x1000400,0x1000400,0,0x10004,0x10400,0,0x1010004);
  var spfunction2 = new Array (-0x7fef7fe0,-0x7fff8000,0x8000,0x108020,0x100000,0x20,-0x7fefffe0,-0x7fff7fe0,-0x7fffffe0,-0x7fef7fe0,-0x7fef8000,-0x80000000,-0x7fff8000,0x100000,0x20,-0x7fefffe0,0x108000,0x100020,-0x7fff7fe0,0,-0x80000000,0x8000,0x108020,-0x7ff00000,0x100020,-0x7fffffe0,0,0x108000,0x8020,-0x7fef8000,-0x7ff00000,0x8020,0,0x108020,-0x7fefffe0,0x100000,-0x7fff7fe0,-0x7ff00000,-0x7fef8000,0x8000,-0x7ff00000,-0x7fff8000,0x20,-0x7fef7fe0,0x108020,0x20,0x8000,-0x80000000,0x8020,-0x7fef8000,0x100000,-0x7fffffe0,0x100020,-0x7fff7fe0,-0x7fffffe0,0x100020,0x108000,0,-0x7fff8000,0x8020,-0x80000000,-0x7fefffe0,-0x7fef7fe0,0x108000);
  var spfunction3 = new Array (0x208,0x8020200,0,0x8020008,0x8000200,0,0x20208,0x8000200,0x20008,0x8000008,0x8000008,0x20000,0x8020208,0x20008,0x8020000,0x208,0x8000000,0x8,0x8020200,0x200,0x20200,0x8020000,0x8020008,0x20208,0x8000208,0x20200,0x20000,0x8000208,0x8,0x8020208,0x200,0x8000000,0x8020200,0x8000000,0x20008,0x208,0x20000,0x8020200,0x8000200,0,0x200,0x20008,0x8020208,0x8000200,0x8000008,0x200,0,0x8020008,0x8000208,0x20000,0x8000000,0x8020208,0x8,0x20208,0x20200,0x8000008,0x8020000,0x8000208,0x208,0x8020000,0x20208,0x8,0x8020008,0x20200);
  var spfunction4 = new Array (0x802001,0x2081,0x2081,0x80,0x802080,0x800081,0x800001,0x2001,0,0x802000,0x802000,0x802081,0x81,0,0x800080,0x800001,0x1,0x2000,0x800000,0x802001,0x80,0x800000,0x2001,0x2080,0x800081,0x1,0x2080,0x800080,0x2000,0x802080,0x802081,0x81,0x800080,0x800001,0x802000,0x802081,0x81,0,0,0x802000,0x2080,0x800080,0x800081,0x1,0x802001,0x2081,0x2081,0x80,0x802081,0x81,0x1,0x2000,0x800001,0x2001,0x802080,0x800081,0x2001,0x2080,0x800000,0x802001,0x80,0x800000,0x2000,0x802080);
  var spfunction5 = new Array (0x100,0x2080100,0x2080000,0x42000100,0x80000,0x100,0x40000000,0x2080000,0x40080100,0x80000,0x2000100,0x40080100,0x42000100,0x42080000,0x80100,0x40000000,0x2000000,0x40080000,0x40080000,0,0x40000100,0x42080100,0x42080100,0x2000100,0x42080000,0x40000100,0,0x42000000,0x2080100,0x2000000,0x42000000,0x80100,0x80000,0x42000100,0x100,0x2000000,0x40000000,0x2080000,0x42000100,0x40080100,0x2000100,0x40000000,0x42080000,0x2080100,0x40080100,0x100,0x2000000,0x42080000,0x42080100,0x80100,0x42000000,0x42080100,0x2080000,0,0x40080000,0x42000000,0x80100,0x2000100,0x40000100,0x80000,0,0x40080000,0x2080100,0x40000100);
  var spfunction6 = new Array (0x20000010,0x20400000,0x4000,0x20404010,0x20400000,0x10,0x20404010,0x400000,0x20004000,0x404010,0x400000,0x20000010,0x400010,0x20004000,0x20000000,0x4010,0,0x400010,0x20004010,0x4000,0x404000,0x20004010,0x10,0x20400010,0x20400010,0,0x404010,0x20404000,0x4010,0x404000,0x20404000,0x20000000,0x20004000,0x10,0x20400010,0x404000,0x20404010,0x400000,0x4010,0x20000010,0x400000,0x20004000,0x20000000,0x4010,0x20000010,0x20404010,0x404000,0x20400000,0x404010,0x20404000,0,0x20400010,0x10,0x4000,0x20400000,0x404010,0x4000,0x400010,0x20004010,0,0x20404000,0x20000000,0x400010,0x20004010);
  var spfunction7 = new Array (0x200000,0x4200002,0x4000802,0,0x800,0x4000802,0x200802,0x4200800,0x4200802,0x200000,0,0x4000002,0x2,0x4000000,0x4200002,0x802,0x4000800,0x200802,0x200002,0x4000800,0x4000002,0x4200000,0x4200800,0x200002,0x4200000,0x800,0x802,0x4200802,0x200800,0x2,0x4000000,0x200800,0x4000000,0x200800,0x200000,0x4000802,0x4000802,0x4200002,0x4200002,0x2,0x200002,0x4000000,0x4000800,0x200000,0x4200800,0x802,0x200802,0x4200800,0x802,0x4000002,0x4200802,0x4200000,0x200800,0,0x2,0x4200802,0,0x200802,0x4200000,0x800,0x4000002,0x4000800,0x800,0x200002);
  var spfunction8 = new Array (0x10001040,0x1000,0x40000,0x10041040,0x10000000,0x10001040,0x40,0x10000000,0x40040,0x10040000,0x10041040,0x41000,0x10041000,0x41040,0x1000,0x40,0x10040000,0x10000040,0x10001000,0x1040,0x41000,0x40040,0x10040040,0x10041000,0x1040,0,0,0x10040040,0x10000040,0x10001000,0x41040,0x40000,0x41040,0x40000,0x10041000,0x1000,0x40,0x10040040,0x1000,0x41040,0x10001000,0x40,0x10000040,0x10040000,0x10040040,0x10000000,0x40000,0x10001040,0,0x10041040,0x40040,0x10000040,0x10040000,0x10001000,0x10001040,0,0x10041040,0x41000,0x41000,0x1040,0x1040,0x40040,0x10000000,0x10041000);

  //create the 16 or 48 subkeys we will need
  var keys = des_createKeys (key);
  var m=0, i, j, temp, temp2, right1, right2, left, right, looping;
  var cbcleft, cbcleft2, cbcright, cbcright2
  var endloop, loopinc;
  var len = message.length;
  var chunk = 0;
  //set up the loops for single and triple des
  var iterations = keys.length == 32 ? 3 : 9; //single or triple des
  if (iterations == 3) {looping = encrypt ? new Array (0, 32, 2) : new Array (30, -2, -2);}
  else {looping = encrypt ? new Array (0, 32, 2, 62, 30, -2, 64, 96, 2) : new Array (94, 62, -2, 32, 64, 2, 30, -2, -2);}

  message += "\0\0\0\0\0\0\0\0"; //pad the message out with null bytes
  //store the result here
  result = "";
  tempresult = "";

  if (mode == 1) { //CBC mode
    cbcleft = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++);
    cbcright = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++);
    m=0;
  }

  //loop through each 64 bit chunk of the message
  while (m < len) {
    left = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++);
    right = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++);

    //for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {if (encrypt) {left ^= cbcleft; right ^= cbcright;} else {cbcleft2 = cbcleft; cbcright2 = cbcright; cbcleft = left; cbcright = right;}}

    //first each 64 but chunk of the message must be permuted according to IP
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);
    temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16);
    temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);

    left = ((left << 1) | (left >>> 31)); 
    right = ((right << 1) | (right >>> 31)); 

    //do this either 1 or 3 times for each chunk of the message
    for (j=0; j<iterations; j+=3) {
      endloop = looping[j+1];
      loopinc = looping[j+2];
      //now go through and perform the encryption or decryption  
      for (i=looping[j]; i!=endloop; i+=loopinc) { //for efficiency
        right1 = right ^ keys[i]; 
        right2 = ((right >>> 4) | (right << 28)) ^ keys[i+1];
        //the result is attained by passing these bytes through the S selection functions
        temp = left;
        left = right;
        right = temp ^ (spfunction2[(right1 >>> 24) & 0x3f] | spfunction4[(right1 >>> 16) & 0x3f]
              | spfunction6[(right1 >>>  8) & 0x3f] | spfunction8[right1 & 0x3f]
              | spfunction1[(right2 >>> 24) & 0x3f] | spfunction3[(right2 >>> 16) & 0x3f]
              | spfunction5[(right2 >>>  8) & 0x3f] | spfunction7[right2 & 0x3f]);
      }
      temp = left; left = right; right = temp; //unreverse left and right
    } //for either 1 or 3 iterations

    //move then each one bit to the right
    left = ((left >>> 1) | (left << 31)); 
    right = ((right >>> 1) | (right << 31)); 

    //now perform IP-1, which is IP in the opposite direction
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2);
    temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16);
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);

    //for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {if (encrypt) {cbcleft = left; cbcright = right;} else {left ^= cbcleft2; right ^= cbcright2;}}
    tempresult += String.fromCharCode ((left>>>24), ((left>>>16) & 0xff), ((left>>>8) & 0xff), (left & 0xff), (right>>>24), ((right>>>16) & 0xff), ((right>>>8) & 0xff), (right & 0xff));

    chunk += 8;
    if (chunk == 512) {result += tempresult; tempresult = ""; chunk = 0;}
  } //for every 8 characters, or 64 bits in the message

  //return the result as an array
  return result + tempresult;
} //end of des



//des_createKeys
//this takes as input a 64 bit key (even though only 56 bits are used)
//as an array of 2 integers, and returns 16 48 bit keys
function des_createKeys (key) {
  //declaring this locally speeds things up a bit
  pc2bytes0  = new Array (0,0x4,0x20000000,0x20000004,0x10000,0x10004,0x20010000,0x20010004,0x200,0x204,0x20000200,0x20000204,0x10200,0x10204,0x20010200,0x20010204);
  pc2bytes1  = new Array (0,0x1,0x100000,0x100001,0x4000000,0x4000001,0x4100000,0x4100001,0x100,0x101,0x100100,0x100101,0x4000100,0x4000101,0x4100100,0x4100101);
  pc2bytes2  = new Array (0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808,0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808);
  pc2bytes3  = new Array (0,0x200000,0x8000000,0x8200000,0x2000,0x202000,0x8002000,0x8202000,0x20000,0x220000,0x8020000,0x8220000,0x22000,0x222000,0x8022000,0x8222000);
  pc2bytes4  = new Array (0,0x40000,0x10,0x40010,0,0x40000,0x10,0x40010,0x1000,0x41000,0x1010,0x41010,0x1000,0x41000,0x1010,0x41010);
  pc2bytes5  = new Array (0,0x400,0x20,0x420,0,0x400,0x20,0x420,0x2000000,0x2000400,0x2000020,0x2000420,0x2000000,0x2000400,0x2000020,0x2000420);
  pc2bytes6  = new Array (0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002,0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002);
  pc2bytes7  = new Array (0,0x10000,0x800,0x10800,0x20000000,0x20010000,0x20000800,0x20010800,0x20000,0x30000,0x20800,0x30800,0x20020000,0x20030000,0x20020800,0x20030800);
  pc2bytes8  = new Array (0,0x40000,0,0x40000,0x2,0x40002,0x2,0x40002,0x2000000,0x2040000,0x2000000,0x2040000,0x2000002,0x2040002,0x2000002,0x2040002);
  pc2bytes9  = new Array (0,0x10000000,0x8,0x10000008,0,0x10000000,0x8,0x10000008,0x400,0x10000400,0x408,0x10000408,0x400,0x10000400,0x408,0x10000408);
  pc2bytes10 = new Array (0,0x20,0,0x20,0x100000,0x100020,0x100000,0x100020,0x2000,0x2020,0x2000,0x2020,0x102000,0x102020,0x102000,0x102020);
  pc2bytes11 = new Array (0,0x1000000,0x200,0x1000200,0x200000,0x1200000,0x200200,0x1200200,0x4000000,0x5000000,0x4000200,0x5000200,0x4200000,0x5200000,0x4200200,0x5200200);
  pc2bytes12 = new Array (0,0x1000,0x8000000,0x8001000,0x80000,0x81000,0x8080000,0x8081000,0x10,0x1010,0x8000010,0x8001010,0x80010,0x81010,0x8080010,0x8081010);
  pc2bytes13 = new Array (0,0x4,0x100,0x104,0,0x4,0x100,0x104,0x1,0x5,0x101,0x105,0x1,0x5,0x101,0x105);

  //how many iterations (1 for des, 3 for triple des)
  var iterations = key.length >= 24 ? 3 : 1;
  //stores the return keys
  var keys = new Array (32 * iterations);
  //now define the left shifts which need to be done
  var shifts = new Array (0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0);
  //other variables
  var lefttemp, righttemp, m=0, n=0, temp;

  for (var j=0; j<iterations; j++) { //either 1 or 3 iterations
    left = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++);
    right = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++);

    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);
    temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16);
    temp = ((left >>> 2) ^ right) & 0x33333333; right ^= temp; left ^= (temp << 2);
    temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);

    //the right side needs to be shifted and to get the last four bits of the left side
    temp = (left << 8) | ((right >>> 20) & 0x000000f0);
    //left needs to be put upside down
    left = (right << 24) | ((right << 8) & 0xff0000) | ((right >>> 8) & 0xff00) | ((right >>> 24) & 0xf0);
    right = temp;

    //now go through and perform these shifts on the left and right keys
    for (i=0; i < shifts.length; i++) {
      //shift the keys either one or two bits to the left
      if (shifts[i]) {left = (left << 2) | (left >>> 26); right = (right << 2) | (right >>> 26);}
      else {left = (left << 1) | (left >>> 27); right = (right << 1) | (right >>> 27);}
      left &= -0xf; right &= -0xf;

      //now apply PC-2, in such a way that E is easier when encrypting or decrypting
      //this conversion will look like PC-2 except only the last 6 bits of each byte are used
      //rather than 48 consecutive bits and the order of lines will be according to 
      //how the S selection functions will be applied: S2, S4, S6, S8, S1, S3, S5, S7
      lefttemp = pc2bytes0[left >>> 28] | pc2bytes1[(left >>> 24) & 0xf]
              | pc2bytes2[(left >>> 20) & 0xf] | pc2bytes3[(left >>> 16) & 0xf]
              | pc2bytes4[(left >>> 12) & 0xf] | pc2bytes5[(left >>> 8) & 0xf]
              | pc2bytes6[(left >>> 4) & 0xf];
      righttemp = pc2bytes7[right >>> 28] | pc2bytes8[(right >>> 24) & 0xf]
                | pc2bytes9[(right >>> 20) & 0xf] | pc2bytes10[(right >>> 16) & 0xf]
                | pc2bytes11[(right >>> 12) & 0xf] | pc2bytes12[(right >>> 8) & 0xf]
                | pc2bytes13[(right >>> 4) & 0xf];
      temp = ((righttemp >>> 16) ^ lefttemp) & 0x0000ffff; 
      keys[n++] = lefttemp ^ temp; keys[n++] = righttemp ^ (temp << 16);
    }
  } //for each iterations
  //return the keys we've created
  return keys;
} //end of des_createKeys


////////////////////////////// TEST //////////////////////////////
function stringToHex (s) {
  var r = "";
  var hexes = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
  for (var i=0; i<s.length; i++) {r += hexes [s.charCodeAt(i) >> 4] + hexes [s.charCodeAt(i) & 0xf];}
  return r;
}


function FW_Password (pwd){
	return stringToHex(des(__LOGIN_KEY,pwd,1,0));
}


$(document).ready(function(){
	if($.browser.msie) {			
		var SH=$(window).height();
		$('.contactusdiyou').css('height',SH+50);	
	}
	
});

$(function(){

	$(".hoverbtn").bind('click',function(){
		$(".hoverbtn").toggleClass("v"); 
		if ($(".hoverbtn").hasClass("v")) {
			$(".hoverimg").attr("src",TMPL+"/images/hoverbtnbg1.gif");
			if($.browser.msie) {
			
				// 此浏览器为 IE
				
			} else {
				$('.diyoumask').fadeIn();
			}
			$('.contactusdiyou').animate({right:'0'},300);		
		}
		else{
			$(".hoverimg").attr("src",TMPL+"/images/hoverbtnbg.gif");
			$('.contactusdiyou').animate({right:'-230px'},300,function(){});
			if($.browser.msie) {
				// 此浏览器为 IE
			} else {
				$('.diyoumask').fadeOut();
			}
		}
	});

});


/*鼠标上移显示*/



function aqln_hover(){
	$(".contactusdiyou").mouseover(function(){
		$(".contactusdiyou").oneTime(50,function(){  
			$('.diyoumask').show();
			$('.contactusdiyou').animate({right:'0'},1000);			
		 });
	});
}
function aqln_leave(){
	$(".contactusdiyou").mouseleave(function(){
		$(".contactusdiyou").stopTime(); 
		$('.contactusdiyou').animate({right:'-230px'},1000,function(){$('.diyoumask').hide();});
	});
}

/*
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for more info.
 */

/*
 * Configurable variables. You may need to tweak these to be compatible with
 * the server-side, but the defaults work in most cases.
 */
var hexcase = 0;  /* hex output format. 0 - lowercase; 1 - uppercase        */
var b64pad  = ""; /* base-64 pad character. "=" for strict RFC compliance   */
var chrsz   = 8;  /* bits per input character. 8 - ASCII; 16 - Unicode      */

/*
 * These are the functions you'll usually want to call
 * They take string arguments and return either hex or base-64 encoded strings
 */
function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
function str_md5(s){ return binl2str(core_md5(str2binl(s), s.length * chrsz));}
function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
function str_hmac_md5(key, data) { return binl2str(core_hmac_md5(key, data)); }

/*
 * Perform a simple self-test to see if the VM is working
 */
function md5_vm_test()
{
  return hex_md5("abc") == "900150983cd24fb0d6963f7d28e17f72";
}

/*
 * Calculate the MD5 of an array of little-endian words, and a bit length
 */
function core_md5(x, len)
{
  /* append padding */
  x[len >> 5] |= 0x80 << ((len) % 32);
  x[(((len + 64) >>> 9) << 4) + 14] = len;

  var a =  1732584193;
  var b = -271733879;
  var c = -1732584194;
  var d =  271733878;

  for(var i = 0; i < x.length; i += 16)
  {
    var olda = a;
    var oldb = b;
    var oldc = c;
    var oldd = d;

    a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
    d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
    c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
    b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
    a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
    d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
    c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
    b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
    a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
    d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
    c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
    b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
    a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
    d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
    c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
    b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);

    a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
    d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
    c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
    b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
    a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
    d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
    c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
    b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
    a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
    d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
    c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
    b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
    a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
    d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
    c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
    b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);

    a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
    d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
    c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
    b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
    a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
    d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
    c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
    b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
    a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
    d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
    c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
    b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
    a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
    d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
    c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
    b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);

    a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
    d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
    c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
    b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
    a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
    d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
    c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
    b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
    a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
    d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
    c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
    b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
    a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
    d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
    c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
    b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);

    a = safe_add(a, olda);
    b = safe_add(b, oldb);
    c = safe_add(c, oldc);
    d = safe_add(d, oldd);
  }
  return Array(a, b, c, d);

}

/*
 * These functions implement the four basic operations the algorithm uses.
 */
function md5_cmn(q, a, b, x, s, t)
{
  return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
}
function md5_ff(a, b, c, d, x, s, t)
{
  return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function md5_gg(a, b, c, d, x, s, t)
{
  return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function md5_hh(a, b, c, d, x, s, t)
{
  return md5_cmn(b ^ c ^ d, a, b, x, s, t);
}
function md5_ii(a, b, c, d, x, s, t)
{
  return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
 * Calculate the HMAC-MD5, of a key and some data
 */
function core_hmac_md5(key, data)
{
  var bkey = str2binl(key);
  if(bkey.length > 16) bkey = core_md5(bkey, key.length * chrsz);

  var ipad = Array(16), opad = Array(16);
  for(var i = 0; i < 16; i++)
  {
    ipad[i] = bkey[i] ^ 0x36363636;
    opad[i] = bkey[i] ^ 0x5C5C5C5C;
  }

  var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
  return core_md5(opad.concat(hash), 512 + 128);
}

/*
 * Add integers, wrapping at 2^32. This uses 16-bit operations internally
 * to work around bugs in some JS interpreters.
 */
function safe_add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

/*
 * Bitwise rotate a 32-bit number to the left.
 */
function bit_rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}

/*
 * Convert a string to an array of little-endian words
 * If chrsz is ASCII, characters >255 have their hi-byte silently ignored.
 */
function str2binl(str)
{
  var bin = Array();
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < str.length * chrsz; i += chrsz)
    bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
  return bin;
}

/*
 * Convert an array of little-endian words to a string
 */
function binl2str(bin)
{
  var str = "";
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < bin.length * 32; i += chrsz)
    str += String.fromCharCode((bin[i>>5] >>> (i % 32)) & mask);
  return str;
}

/*
 * Convert an array of little-endian words to a hex string.
 */
function binl2hex(binarray)
{
  var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i++)
  {
    str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) +
           hex_tab.charAt((binarray[i>>2] >> ((i%4)*8  )) & 0xF);
  }
  return str;
}

/*
 * Convert an array of little-endian words to a base-64 string
 */
function binl2b64(binarray)
{
  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i += 3)
  {
    var triplet = (((binarray[i   >> 2] >> 8 * ( i   %4)) & 0xFF) << 16)
                | (((binarray[i+1 >> 2] >> 8 * ((i+1)%4)) & 0xFF) << 8 )
                |  ((binarray[i+2 >> 2] >> 8 * ((i+2)%4)) & 0xFF);
    for(var j = 0; j < 4; j++)
    {
      if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
      else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
    }
  }
  return str;
}
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(3($){$.X.3J=3(4){2 x={1o:0,1A:"G",M:F};4=$.1b({},x,4);2 o=$(6);2 m=$(o).1("m");$(o).1c();c(4.M){$(o).2w();4.1o=$(o).2m().1("1o");$(o).2m().3H()}2 I=$("<16 1o=\'"+4.1o+"\'></16>");$(I).1("Y",$(o).1("Y"));$(I).1("12",$(o).1("12"));$(I).g({"13":"1V-1i"});2 1r=$("<1M></1M>");$(I).21(1r);$(1r).1("Y","2l-2j-2p");2 1G=$(o).f("2r:2p");$(1r).18("<n>"+1G.18()+"</n><i></i>");$(1r).1("10",1G.1("10"));2 W=$("<S></S>");$(I).21(W);$(o).f("2r").27(3(3M,1D){2 1k=$("<a 2V=\'3G:3F(0);\'></a>");$(1k).g({"13":"1i"});$(1k).1("10",$(1D).1("10"));$(1k).18($(1D).18());c(1G.1("10")==$(1D).1("10"))1k.q("25");$(W).21(1k)});$(o).23(I);$(W).g({"Z":"2H","z-2K":50});$(W).q("2l-2j-3A");2 A=$(I).Z().A+$(I).m();2 v=$(I).Z().v;$(W).g("v",v);$(W).g("A",A);c(m&&$(W).m()>2k(m)){$(W).g("m",2k(m))}$(W).1c();c(4.M)$(o).1c();c(4.1A=="G"){$(I).t("G",3(){2 A=$(6).Z().A+$(6).m();2 v=$(6).Z().v;$(6).f("S").g("v",v);$(6).f("S").g("A",A);$(6).f("S").2h("2f");$(6).q("2b")})}14{$(I).1h(3(){$(6).3D(20,3(){2 A=$(6).Z().A+$(6).m();2 v=$(6).Z().v;$(6).f("S").g("v",v);$(6).f("S").g("A",A);$(6).f("S").2h("2f");$(6).q("2b")})},3(){$(6).3C();$(6).f("S").3O("2f");$(6).7("2b")})}$(I).f("S a").t("G",3(){2 16=$(6).P().P();2 n=$(6);$(16).f("1M").18("<n>"+$(n).18()+"</n><i></i>");$(16).f("1M").1("10",$(n).1("10"));$(16).2a().E($(n).1("10"));$(16).2a().19("44");$(16).f("S a").7("25");$(6).q("25")})},$.X.45=3(){2 D=$(6);c(D.g("13")=="2c")1j;$(D).1c();2 o=$("<1t><1t><n></n></1t></1t>");$(D).23(o);$(o).1("Y",$(D).1("Y"));$(o).q($(D).1("j"));$(o).1("j",$(D).1("j"));$(o).f("n").18($(D).18());$(o).t("G",3(){c(D.1("Q")=="2M"){2 P=D.P();3Z{3Y(P.3S(0).3R.3Q()!="3T"){P=P.P()}P.2M()}3w(e){$(D).G()}}14 $(D).G()});$(o).t("2y",3(){$(o).7($(o).1("j")+"R");$(o).7($(o).1("j")+"1u");$(o).7($(o).1("j"));$(o).q($(o).1("j")+"R")});$(o).t("2A",3(){$(o).7($(o).1("j")+"R");$(o).7($(o).1("j")+"1u");$(o).7($(o).1("j"));$(o).q($(o).1("j"))});$(o).t("3W",3(){$(o).7($(o).1("j")+"R");$(o).7($(o).1("j")+"1u");$(o).7($(o).1("j"));$(o).q($(o).1("j")+"1u")});$(o).t("3V",3(){$(o).7($(o).1("j")+"R");$(o).7($(o).1("j")+"1u");$(o).7($(o).1("j"));$(o).q($(o).1("j")+"R")})},$.X.3o=3(){2 k=$(6);$(k).t("26",3(){$(k).7("1h");$(k).7("1f");$(k).q("1h")});$(k).t("2J",3(){$(k).7("1h");$(k).7("1f");$(k).q("1f")});c($(k).1("r")==""||!$(k).1("r"))1j;c(\'1H\'33 30.34(\'B\')){$(k).1("1H",$(k).1("r"))}14{2 r=$(k).2a();c($(r).1("j")!="r"){r=$("<n 15=\'Z:2H; K:#3c;\' j=\'r\'>"+$(k).1("r")+"</n>");$(r).g({"l-17":$(k).g("l-17"),"V-v":$(k).g("V-v"),"V-2I":$(k).g("V-2I"),"V-A":$(k).g("V-A"),"V-2L":$(k).g("V-2L")});$(r).g("v",0);$(r).g("A",0);$(r).g("l-1e","1f");$(r).g("13","1i");$(r).g("z-2K","20");2 37=$(k).2v("<i 15=\'l-15:1f;l-1e:1f; 13:1i;\'></i>");$(k).35(r)}c($.2D($(k).E())!=""){$(r).g("13","2c")}$(r).G(3(){$(k).26()});$(k).26(3(){$(r).g("13","2c")});$(k).2J(3(){c($.2D($(k).E())=="")$(r).2w()})}},$.X.3q=3(4){2 x={M:F};4=$.1b({},x,4);2 9=$(6);2 o=$(9).f("B[Q=\'22\']");$(o).1c();2 d=$(o).1("d");2 8=$(9).1("j");$(9).q(8);$(9).1("12",$(o).1("12"));$(9).g({"13":"1V-1i"});$(9).1("d",d?C:F);c(d){$(9).7(8);$(9).7(8+"T");$(9).q(8+"T")}14{$(9).7(8);$(9).7(8+"T");$(9).q(8)}c(4.M)1j;$(o).t("G",3(){1j F});$(9).1h(3(){2 J=$(6).f("B[Q=\'22\']");2 d=$(J).1("d");2 8=$(9).1("j");c(!d)$(6).q(8+"R")},3(){$(6).7(8+"R")});$(9).t("G",3(){2 h=$(6);2 J=$(h).f("B[Q=\'22\']");2 d=$(J).1("d");2 8=$(9).1("j");d=d?F:C;$(J).1("d",d);$(h).1("d",d);$(h).7(8+"R");c(d){$(J).19("3p");$(h).7(8);$(h).7(8+"T");$(h).q(8+"T")}14{$(J).19("3e");$(h).7(8);$(h).7(8+"T");$(h).q(8)}})},$.X.3r=3(4){2 x={M:F,1w:5};4=$.1b({},x,4);2 1a=$(6);$(1a).1c();2 29=$(1a).1("29");2 E=$(1a).E();c(3s(E))E=0;c(E<0)E=0;c(E>4.1w)E=4.1w;c(!4.M)$(1a).2v("<n><n></n></n>");2 w=$(1a).P().P();w.1("Y",$(1a).1("Y"));$(w).f("n").g("y",(3n(E)/4.1w*20)+"%");c(!4.M&&!29){2 2x=$(w).y();2 1z=2x/4.1w;$(w).t("3i 2y",3(1A){2 2d=1A.2d;2 v=$(w).2P().v;2 2B=2d-v;2 1g=3X.4n(2B/1z);2 1B=(1g*1z)+"2z";$(w).f("B").1("1g",1g);$(w).f("n").g("y",1B);$(w).f("B").19("2E")});$(w).t("2A",3(){2 1q=$(w).f("n").f("B").E();2 1B=(1q*1z)+"2z";$(w).f("n").g("y",1B);$(w).f("B").1("1g",1q);$(w).f("B").19("2E")});$(w).t("G",3(){2 1q=$(w).f("B").1("1g");$(w).f("n").f("B").E(1q);$(w).f("B").19("4N")})}},$.X.2F=3(4){2 x={M:F};4=$.1b({},x,4);2 9=$(6);2 o=$(9).f("B[Q=\'1C\']");$(o).1c();2 d=$(o).1("d");2 8=$(9).1("j");$(9).q(8);$(9).1("12",$(o).1("12"));$(9).g({"13":"1V-1i"});$(9).1("d",d?C:F);c(d){$(9).7(8);$(9).7(8+"T");$(9).q(8+"T")}14{$(9).7(8);$(9).7(8+"T");$(9).q(8)}c(4.M)1j;$(o).t("G",3(){1j F});$(9).1h(3(){2 J=$(6).f("B[Q=\'1C\']");2 d=$(J).1("d");2 8=$(9).1("j");c(!d)$(6).q(8+"R")},3(){$(6).7(8+"R")});$(9).t("G",3(){2 h=$(6);2 J=$(h).f("B[Q=\'1C\']");2 d=$(J).1("d");2 8=$(9).1("j");2 2G=d;d=C;$(J).1("d",d);$(h).1("d",d);$(h).7(8+"R");$("B[12=\'"+h.1("12")+"\'][Q=\'1C\']").P().27(3(i,2t){$(2t).2F({M:C})});c(!2G){$(J).19("G");$(h).7(8);$(h).7(8+"T");$(h).q(8+"T")}})},$.X.4l=3(4){2 x={1n:4k,2g:C,1K:N,1L:N,1E:N,1I:N};4=$.1b({},x,4);2 D=$(6);2 L=4j 4m.4p({4o:D[0],1n:4.1n,4h:4b,4a:49,4c:4.2g,4e:{4r:4E,4D:[{1p:"4C 1m",4F:4G}]}});L.4I();L.t(\'1K\',3(L,1m){c(4.1K!=N){c(4.1K.1x(N,1m)!=F){L.2N()}}14{L.2N()}});L.t(\'1L\',3(L,4A,2q){c(4.1L!=N){2 1X=$.4u(2q.4s);4.1L.1x(N,1X);c(1X.4y!=0){L.5m()}}});L.t(\'1E\',3(L,1m){c(4.1E!=N)4.1E.1x(N,1m)});L.t(\'1I\',3(L,2o){c(4.1I!=N)4.1I.1x(N,2o)})},$.X.5c=3(4){2 x=$.1b({},{"1n":"","y":56,"m":4R,"2T":N},4);2 2u=$(6);2 4M=4W.3k(2u,{4O:x.1n,4d:4f,4q:4z,2U:C,2U:F,4x:C,y:x.y,m:x.m,4w:[\'4v\',\'4t\',\'|\',\'4B\',\'4H\',\'4g\',\'4i\',\'4J\',\'4K\',\'|\',\'5a\',\'5b\',\'59\',\'58\',\'55\',\'|\',\'57\',\'5d\',\'5e\'],5k:{l:[\'K\',\'17\',\'5l\',\'.U-K\'],n:[\'.K\',\'.U-K\',\'.l-17\',\'.l-1v\',\'.U\',\'.l-1e\',\'.l-15\',\'.O-1s\',\'.1y-H\',\'.5j-m\'],1t:[\'H\',\'.1d\',\'.1F\',\'.V\',\'.O-H\',\'.K\',\'.U-K\',\'.l-17\',\'.l-1v\',\'.l-1e\',\'.U\',\'.l-15\',\'.O-1s\',\'.1y-H\',\'.1F-v\'],5i:[\'1d\',\'5f\',\'5g\',\'y\',\'m\',\'H\',\'5h\',\'.V\',\'.1F\',\'.1d\',\'2R\',\'.O-H\',\'.K\',\'.U-K\',\'.l-17\',\'.l-1v\',\'.l-1e\',\'.l-15\',\'.O-1s\',\'.U\',\'.y\',\'.m\',\'.1d-54\'],\'53,4Q\':[\'H\',\'4S\',\'y\',\'m\',\'4P\',\'4L\',\'2R\',\'.O-H\',\'.K\',\'.U-K\',\'.l-17\',\'.l-1v\',\'.l-1e\',\'.l-15\',\'.O-1s\',\'.1y-H\',\'.U\',\'.1d\'],a:[\'2V\',\'4T\',\'12\'],4U:[\'11\',\'y\',\'m\',\'Q\',\'51\',\'52\',\'4Z\',\'.y\',\'.m\',\'H\',\'4Y\'],h:[\'11\',\'y\',\'m\',\'1d\',\'4V\',\'1p\',\'H\',\'.y\',\'.m\',\'.1d\'],\'p,4X,48,3l,3j,3f,3g,3h,3m,3t,3u\':[\'H\',\'.O-H\',\'.K\',\'.U-K\',\'.l-17\',\'.l-1v\',\'.U\',\'.l-1e\',\'.l-15\',\'.O-1s\',\'.1y-H\',\'.O-32\',\'.1F-v\'],31:[\'Y\'],2X:[\'Y\',\'.2Y-2Z-23\'],\'39,38,3b,3a,b,3d,47,3U,i,u,46,s,43\':[]},40:3(){6.42()},3P:x.2T})},$.X.3E=3(4){2 x={1H:"",11:"",M:F};4=$.1b({},x,4);2 2Q=6;2Q.27(3(){2 h=$(6);2 28=$(2O).3x();2 2W=$(2O).m();2 2e=h.2P().A;c(!h.1("2s")||4.M){$(h).1("11",4.1H);c(2W+28>=2e&&28<=2e+h.m()){c(4.11!="")h.1("11",4.11);14 h.1("11",h.1("3I-11"));h.1("2s",C)}}})}})(3K);$.3L=3(1l,1N){$.1J.1O(1l,{1Y:\'3N\',1U:\'O\',1T:C,1S:F,1P:C,1p:\'错误\',y:1Q,Q:\'1W\',1Z:3(){1R()},24:1N})};$.3z=3(1l,1N){$.1J.1O(1l,{1Y:\'3y\',1U:\'O\',Z:\'3B\',1T:C,1S:F,1P:C,1p:\'提示\',y:1Q,Q:\'1W\',1Z:3(){1R()},24:1N})};$.36=3(1l,2S,2C){2 2n=3(){$.1J.3v("2i");2S.1x()};$.1J.1O(1l,{1Y:\'2i\',1U:\'O\',1T:C,1S:C,1P:C,1p:\'确认\',y:1Q,Q:\'1W\',1Z:3(){1R()},24:2C,41:2n})};',62,333,'|attr|var|function|options||this|removeClass|relClass|ImgCbo|||if|checked||find|css|img||rel|obj|font|height|span|||addClass|holder||bind||left|outBar|op|width||top|input|true|btn|val|false|click|align|DLselect|cbo|color|uploader|refresh|null|text|parent|type|_hover|dd|_checked|background|padding|DDselect|fn|class|position|value|src|name|display|else|style|dl|size|html|trigger|ipt|extend|hide|border|weight|normal|sector|hover|block|return|SPANselect|str|files|url|id|title|current_sec|DTselect|decoration|div|_active|family|max|call|vertical|sec_width|event|cssWidth|radio|oo|UploadComplete|margin|selectNode|placeholder|Error|weeboxs|FilesAdded|FileUploaded|dt|func|open|showOk|250|init_ui_button|showCancel|showButton|contentType|inline|wee|ajaxobj|boxid|onopen|100|append|checkbox|after|onclose|current|focus|each|scrolltop|disabled|prev|dropdown|none|pageX|imgoffset|fast|multi|slideDown|fanwe_confirm_box|select|parseInt|ui|next|okfunc|errObject|selected|responseObject|option|isload|olb|dom|wrap|show|total_width|mouseover|px|mouseout|move_left|funcclose|trim|uichange|ui_radiobox|ochecked|absolute|right|blur|index|bottom|submit|start|window|offset|imgs|bgcolor|funcok|fun|allowFileManager|href|windheight|hr|page|break|document|pre|indent|in|createElement|before|showConfirm|outer|tbody|br|strong|tr|8596B0|sub|checkoff|h1|h2|h3|mousemove|blockquote|create|li|h4|parseFloat|ui_textbox|checkon|ui_checkbox|ui_starbar|isNaN|h5|h6|close|catch|scrollTop|fanwe_success_box|showSuccess|drop|center|stopTime|oneTime|ui_lazy|void|javascript|remove|data|ui_select|jQuery|showErr|ii|fanwe_error_box|fadeOut|afterCreate|toLowerCase|tagName|get|form|em|mouseup|mousedown|Math|while|try|afterBlur|onok|sync|del|change|ui_button|strike|sup|ul|UPLOAD_XAP|silverlight_xap_url|UPLOAD_SWF|multi_selection|basePath|filters|K_BASE_PATH|bold|flash_swf_url|italic|new|UPLOAD_URL|ui_upload|plupload|ceil|browse_button|Uploader|themesPath|max_file_size|response|fontsize|parseJSON|fontname|items|filterMode|error|K_THEMES_PATH|file|forecolor|Image|mime_types|MAX_IMAGE_SIZE|extensions|ALLOW_IMAGE_EXT|hilitecolor|init|underline|removeformat|rowspan|keditor|onchange|uploadJson|colspan|th|300|valign|target|embed|alt|KindEditor|ol|allowscriptaccess|quality||loop|autostart|td|collapse|insertunorderedlist|400|emoticons|insertorderedlist|justifyright|justifyleft|justifycenter|ui_editor|image|link|cellspacing|cellpadding|bordercolor|table|line|htmlTags|face|stop'.split('|'),0,{}))
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('8h(7($){$.8i({8j:7(8g,3S){j(3S.z.8f("?")==-1){3S.z+="?4q="+4w}F{3S.z+="&4q="+4w}}})});$(23).8c(7(){$("#5Y").1s("2u",$(23).2A()+4M);$("2B").8d("V",7(){$(J).G("1y",72)});$.2v($("2B"),7(i,n){j($(n).G("1y")==\'\')$(n).G("1y",72)});$(".8e").2e(7(){$(J).C(".2E").1j("1r");8 w=$(J).6Z();8 3x=$(J).C(".2E").6Z();8 3p=0;j(w>3x){3p=(w-3x)/2}F{3p=-(3x-w)/2}$(J).C(".2E").1s({"2p":3p})},7(){$(J).C(".2E").1w("1r")});j($("#2K .3o").14>0){$("#2K  .8k").2e(7(){$("#2K  .3o").2g()});$("#2K  .3o a.47").21("1b",7(){$("#2K  .3o").2T();$("#2K  .8l").1j("8r")})}$(".8s 8t.6t").2e(7(){$(J).1w("3s")},7(){$(J).1j("3s")});$(".8q").21("1b",7(){8 1S=$(J).G("1L");j(1Q(1S)==0){H}$.1v.1q(O+"/R.N?P=m&Q=8p&1S="+1S,{1z:\'m\',1A:L,1m:"举报用户",1d:8m,1k:8n,D:\'1B\'})});$("#6L 58").1b(7(){$("#6L 58").1j("5j");$(J).1w("5j");$("#51 .8o").1w("1r");$("#51 .8b"+$(J).G("1T")).1j("1r")});$(1u).7b(7(){$("#5Y").1s("2u",$(23).2A()+4M)});71();$(\'#3y-5t-4e,#3m-3y-6i-5t\').1b(7(){8a($(J))});$("#7X").21("1b",7(){$(J).1r();$("#7Y").2g();$("#7Z").1r()});$(".7W").C("a").21("1b",7(){8 v=O+"/R.N?P=5F&Q=7V&z="+$(J).G("1U");$.m({z:v,S:7(u){}})});$(\'#5I\').21("1b",7(){8 3L=$(J).I().C("13[E=\'3L\']").q();8 3F=$(J).I().C("13[E=\'3F\']").q();8 v=O+"/R.N?P=m&Q=5I&3L="+3L+"&3F="+3F;$.m({z:v,S:7(1D){$.1p(1D)},V:7(y){}})});$("#7R").1b(7(){7S()});$(".7T").C("a").21("1P",7(){$(J).7U()});73();$("#80").1b(7(){8 3R=1;j($(J).1Z("1q")){3R=0}$.m({z:O+"/R.N?P=81&Q=87&3R="+3R,10:"17",6w:L,S:7(1i){j(1i.Z==1){1u.1G.1U=1u.1G.1U}F{$.U(1i.W)}}})});$("a.88").1b(7(){8 37=$(J).G("37");8 1L=$(J).G("1L");8 u=\'<1o B="\'+1L+\'4P" 1C="89">\';u+=\'<1o 1C="86">\';u+=\'<1n B="\'+1L+\'6I" 1C="f-1D 1F-1n" 85="5" 82="60"></1n>\';u+=\'</1o>\';u+=\'<1o 1C="83"></1o>\';u+=\'<p><13 D="6K" 1f="留言" B="84" 6N="6r(\\\'\'+37+\'\\\',\\\'\'+1L+\'\\\',\\\'\'+1L+\'6I\\\')" 1C="8u">\';u+=\'<13 D="6K" 1f="取消" 6N="6T(\\\'\'+1L+\'4P\\\')" 1C="8v 8V">\';u+=\'</p></1o>\';j($("#"+1L+"4P").14==0){$(J).I().8W(u);$(".1F-1n").5l({1W:16})}});$(".8X").21("1b",7(){8 1S=$(J).G("1L");j(1Q(1S)==0){H}$.1v.1q(O+"/R.N?P=m&Q=8U&1S="+1S,{1z:\'m\',1A:L,1m:"发送站内消息",1d:8T,1k:4M,D:\'1B\'})});$("#8Q .6t").2e(7(){j(!$(J).1Z("8R")){$(J).1w("3s")}},7(){$(J).1j("3s")});$("#8S").3y(7(){8 k=$(J);j($.1l(k.C("#E").q())==""){$.U(T.3l+T.8Y,7(){k.C("#E").1P()});H L}j(!k.C("#2M").1Z("6z")){j($.1l(k.C("#2M").q())==""){$.U(T.3l+T.8Z,7(){k.C("#2M").1P()});H L}8 12=$.1l(k.C("#2M").q());8 95=12.14;j(12.14>18||12.14<15){$.U(T.96,7(){k.C("#2M").1P()});H L}j($.1l(k.C("#2M").q())!=$.1l(k.C("#6C").q())){$.U(T.97,7(){k.C("#6C").1P()});H L}}j(!$("#30").1Z("6z")){j($.1l($("#30").q())==""){$.U(T.94,7(){$("#30").1P()});H L}j(!$.2C($("#30").q())){$.U(T.2U,7(){$("#30").1P()});H L}j($.1l(k.C("#66").q())==""){$.U(T.3l+T.93,7(){k.C("#66").1P()});H L}}8 M=k.2N();$.m({z:O+"/R.N?P=6i&Q=90",1h:M,10:"17",S:7(1i){j(1i.Z==1){2X(1i.W);1G.2b()}F{$.U(1i.W)}}});H L});$("#91").1b(7(){$.m({z:O+\'/R.N?P=m&Q=92\',10:"17",S:7(1i){j(1i.Z==0){$.U(1i.W);H L}F{1u.1G.1U=1i.7Q}}})});$("#43-34").1b(7(){j($(J).u()=="编辑资料"){$(J).u("取消编辑");$(".34-74-3n").1w("1r");$(".34-43-3n").1j("1r")}F{$(J).u("编辑资料");$(".34-74-3n").1j("1r");$(".34-43-3n").1w("1r")}});$("#8O a").1b(7(){8 k=$(J);8 z=k.G("1U");$.1v.1q("<1o 1C=\'6Q\'><2B 1y=\'"+z+"\'  /></1o>",{1z:\'1D\',1A:16,2H:L,2I:16,1m:\'扫描下载手机客户端\',1d:5c,D:\'1B\'});H L});$("#8B").1b(7(){8 k=$(J);8 z=k.G("1U");$.1v.1q("<1o 1C=\'6Q\'><2B 1y=\'"+z+"\'  /></1o>",{1z:\'1D\',1A:16,2H:L,2I:16,1m:\'扫描访问微信端\',1d:5c,D:\'1B\'});H L});5B();4i();4W();4j();5S();56();$("#4A").4A()});7 56(){j($("#35 .2E a.4f").14>0){$("#35 .2E a.4f").I().I().1w(\'4f\')}}7 4j(){$(".1F-8C[1g!=\'1g\'],.1F-1n[1g!=\'1g\']").2v(7(i,o){$(o).G("1g","1g");$(o).5l()})}7 4i(){$("4X.1F-8D[1g!=\'1g\']").2v(7(i,2s){$(2s).G("1g","1g");$(2s).8A()})}7 4W(){$("4X.1F-8z[1g!=\'1g\']").2v(7(i,2s){$(2s).G("1g","1g");$(2s).8w()})}8 2n=1E;8 2P=0;7 5S(){$("Y.1F-Y[1g!=\'1g\']").2v(7(i,o){2P++;8 B="5Z"+3M.5T(3M.5H()*5u)+""+2P;8 3O={B:B};$(o).G("1g","1g");$(o).1R(3O)});$("Y.1F-3Z[1g!=\'1g\']").2v(7(i,o){2P++;8 B="5Z"+3M.5T(3M.5H()*5u)+""+2P;8 3O={B:B,8x:"2e"};$(o).G("1g","1g");$(o).1R(3O)});$(23.48).1b(7(e){j($(e.2R).G("1C")!=\'1F-Y-5x\'&&$(e.2R).I().G("1C")!=\'1F-Y-5x\'){$(".1F-Y-3Z").41("46");$(".1F-Y").1j("5z");2n=1E}F{j(2n!=1E&&2n.G("B")!=$(e.2R).I().G("B")){$(2n).C(".1F-Y-3Z").41("46");$(2n).1j("5z")}2n=$(e.2R).I()}})}7 5B(){j($("1n.4h").14>0){8 K=76}j($("1n.4h").14>0){8 75=K.8y(\'1n.4h\',{6B:L,8E:6S,8F:O+"/8L/5r/",8M:7(){J.8N()},1k:3C,8K:[\'8J\',\'8G\',\'8H\',\'8I\',\'98\',\'7h\',\'7j\',\'7g\',\'7l\',\'7k\',\'7i\',\'7P\',\'7G\',\'7H\',\'7F\',\'7E\',\'7C\',\'7D\',\'7I\',\'7m\',\'7J\',\'7O\',\'/\',\'1m\',\'7N\',\'7M\',\'7K\',\'7L\',\'7B\',\'7A\',\'7r\',\'7s\',\'7q\',\'4e\',\'7p\',\'7n\',\'7o\',\'7t\',\'5r\',\'5F\',\'7u\']})}7e()}7 7e(){j($(".3f").14>0){j(K==4n)8 K=76}j($(".3f").14>0){8 3G=K.75({6B:L,7z:7y});K(\'.3f\').5M("1b");K(\'.3f\').1b(7(){8 1N=K(J);8 1t=$(1N).I().I().I().I();3G.7x(\'4e\',7(){3G.7v.7w({8P:1t.C("#4H"+1N.G("1T")).q(),9K:7(z,1m,1d,1k,b5,ba){1t.C("#7a"+1N.G("1T")).G("1U",z),1t.C("#6c"+1N.G("1T")).G("1y",z),1t.C("#4H"+1N.G("1T")).q(z),1t.C(".4d[1T=\'"+1N.G("1T")+"\']").2g(),3G.b8()}})})});K(\'.4d\').5M("1b");K(\'.4d\').1b(7(){8 1N=K(J);K(J).1r();8 1t=$(1N).I().I().I().I();1t.C("#7a"+1N.G("1T")).G("1U","");1t.C("#6c"+1N.G("1T")).G("1y",bl+"/6w/br/au/av/aW/aV.aU");1t.C("#4H"+1N.G("1T")).q("")})}}$.U=7(12,1c){$.1v.1q(12,{2Q:\'aX\',1z:\'1D\',1A:16,2H:L,2I:16,1m:\'错误\',1d:3C,D:\'1B\',3h:1c})};$.1p=7(12,1c){$.1v.1q(12,{2Q:\'aY\',1z:\'1D\',1A:16,2H:L,2I:16,1m:\'提示\',1d:3C,D:\'1B\',3h:1c})};$.b0=7(12,4V,5P){$.1v.1q(12,{2Q:\'5J\',1z:\'1D\',1A:16,2H:16,2I:16,1m:\'确认\',1d:3C,D:\'1B\',aM:7(){$.1v.47("5J");j(4V!=1E){4V.2k(J)}},3h:5P})};$.aK=7(1f,14,3Q){8 2q=$.1l(1f).14;j(3Q)2q=$.4J(1f);H 2q>=14};$.aN=7(1f,14,3Q){8 2q=$.1l(1f).14;j(3Q)2q=$.4J(1f);H 2q<=14};$.4J=7(12,55){12=$.1l(12);j(55=="1D"){12=12.2i(/<(?:2B|aR).*?>/aP,\'K\').2i(/\\r\\n|\\n|\\r/g,\'\').2i(/<\\/?[^>]*>/g,\'\')}j(12=="")H 0;8 14=0;2j(8 i=0;i<12.14;i++){j(12.3g(i)>aQ)14+=2;F 14++}H 14};$.aO=7(1f){j($.1l(1f)!=\'\')H!6X($.1l(1f));F H 16};$.2C=7(1f){j($.1l(1f)!=\'\')H/^\\d{11}$/i.4L($.1l(1f));F H 16};$.aL=7(q){8 3i=/^\\w+((-\\w+)|(\\.\\w+))*\\@[A-4Q-4E-9]+((\\.|-)[A-4Q-4E-9]+)*\\.[A-4Q-4E-9]+$/;H 3i.4L(q)};7 3X(){8 G="aS";8 13=23.aT("13");H G 4u 13}7 aZ(k,2a){j(!3X()){k=$(k).I()}j(2a!=\'\'){$(k).I().C(".49").1s({"42":"#67","4x":"3T","3W-1k":"6F%"});$(k).I().C(".f-13-3m").u("<2z 1C=\'aJ\'>"+2a+"</2z>")}F{$(k).I().C(".49").1s({"42":"#aI","4x":"aw","3W-1k":"ax"});$(k).I().C(".f-13-3m").u("")}}7 ay(k,2a){j(!3X()){k=$(k).I()}k.I().C(".49").1s({"42":"#67","4x":"3T","3W-1k":"6F%"});k.I().C(".f-13-3m").u("<2z 1C=\'as\'>"+2a+"</2z>")}7 at(o,k,i,z){j($(o).1Z("1x")){H L}j(i==1E){i=\'0\'}j($.1l($(k).q())==""){$.U(T.4O);H L}j(!$.2C($(k).q())){$.U(T.2U);H L}j(!$(o).1Z(\'1x\')){$(o).1w(\'1x\');3b(k,z,7(){2r(o,60,i)})}}8 4k=2h az();7 2r(o,2Z,i){j(i==1E){i="0"}3u(4k[i]);j(2Z>0){2Z--;$(o).1w("1x");$(o).q(T.5K+T.5s+" "+2Z);4k[i]=4F(7(){2r(o,2Z,i)},6b)}F{$(o).1j("1x");$(o).q(T.5K+T.5s)}}7 3b(k,z,1c){8 22=$(k).q();8 v="";j(z==1E)v=O+"/R.N?P=m&Q=3b";F v=z;8 M=2h 32();M.22=22;$.m({z:v,1h:M,D:"4U",10:"17",S:7(k){j(k.Z){j(1c!=1E){1c.2k(J)}6v=16;$.1p(k.W)}F{$("#3D").1j("1x");$.U(k.W)}},V:7(y){}})}7 aA(o,k){j(!$(o).1Z(\'1x\')){$(o).1w(\'1x\');3b(k,O+"/R.N?P=m&Q=aG",7(){2r(o,60)})}}7 6o(k,1c){8 v=O+"/R.N?P=m&Q=6o";$.m({z:v,10:"17",S:7(y){j(y.Z){j(1c!=1E){1c.2k(J)}6v=16;$.1p(y.W)}F{$("#3D").1j("1x");$.U(y.W)}},V:7(y){}})}7 aH(4K,4D){$.m({z:O+"/aF.N?4K="+4K+"&4D="+4D,1h:"m=1",10:"17",S:7(k){j(k.Z==2){1u.1q(k.2a)}j(k.Z==1){$.1v.1q(k.2a,{1z:\'u\',1A:L,1m:T[\'aE\'],1d:aB,1k:aC,D:\'1B\'})}j(k.Z==0){$.U(k.2a)}}})}7 5v(D,4p){8 v=O+"/R.N?P=m&Q=5v&D="+D+"&4p="+4p;$.m({z:v,S:7(1D){1G.2b()},V:7(y){}})}7 5h(D){8 v=O+"/R.N?P=m&Q=5h&D="+D;$.m({z:v,S:7(1D){1G.2b()},V:7(y){}})}7 aD(B){8 v=O+"/R.N?P=m&Q=3N";$.m({z:v,10:"17",D:"1e",S:7(y){j(y.Z==0){2c()}F{b2(B)}},V:7(y){}})}7 b1(o,62,1c){8 v=O+"/R.N?P=m&Q=bk&B="+62;$.m({z:v,10:"17",S:7(k){j(k.bv==1){$.1v.1q(k.u,{1z:\'1D\',1A:L,1m:T[\'4o\'],1d:5g,D:\'1B\'})}F{j(1c!=1E)1c.2k(J,o);F $.1p(k.W)}},V:7(y){}})}7 bn(3c,o){8 v=O+"/R.N?P=m&Q=1P&3c="+3c;$.m({z:v,10:"17",S:7(k){j(k.1J==1){$(o).1j("4N");$(o).1j("4T");$(o).1w("4T");$(o).u(k.u)}j(k.1J==2){$(o).1j("4N");$(o).1j("4T");$(o).1w("4N");$(o).u(k.u)}j(k.1J==3){$.1p(k.u)}j(k.1J==4){2c()}},V:7(y){}})}7 6U(1H,1J,o){8 v=O+"/R.N?P=m&Q=6U&1J="+1J+"&1H="+1H;$.m({z:v,10:"17",S:7(k){j(k.Z)$(o).C("2z").u(k.1h);F $.U(k.1h)},V:7(y){}})}7 bq(k){j($(k).C("*[E=\'2l\']").q()==\'\'){$.U(T.6m);$(k).C("*[E=\'2l\']").1P();H L}F{H 16}}7 6p(B){8 M=2h 32();M.B=B;M.6H=$("13[E=\'6H\']").q();M.6M=$("Y[E=\'6M\']").q();M.78=$("Y[E=\'78\']").q();M.6d=$("13[E=\'6d\']").q();M.6D=$("13[E=\'6D\']:4a").q();M.3r=$("13[E=\'3r\']").q();j(!$.2C(M.3r)||M.3r==\'\'){$.U(T[\'2U\']);H}8 v=O+"/bp.N?P=bo&Q=6p";$.m({z:v,10:"17",1h:M,D:"1e",S:7(k){j(k.Z==1){40();$.1p(k.W)}F{$(".3V-1m").u(T[\'4o\']);$(".3V-2l").u(k.u)}},V:7(y){}})}7 6x(B){8 v=O+"/R.N?P=m&Q=3N";$.m({z:v,10:"17",D:"1e",S:7(y){j(y.Z==0){2c()}F{8 v=O+"/R.N?P=m&Q=6x&B="+B;$.1v.1q(v,{1z:\'m\',1A:L,1m:T[\'bm\'],1d:bs,D:\'1B\'})}},V:7(y){}})}7 5f(B){8 v=O+"/R.N?P=m&Q=5f&B="+B;8 M=2h 32();M.2l=$("1n[E=\'bw\']").q();$.m({z:v,10:"17",1h:M,D:"1e",S:7(k){j(k.Z){$("#6E"+B).u(1Q($("#6E"+B).u())+1);40();$.1p(k.W);8 26=$("13[E=\'26\']");j(26){2Y($(26).q(),$("#4m"))}}F{$.U(k.W)}},V:7(y){}})}7 bu(B){8 v=O+"/R.N?P=m&Q=bx&B="+B;$.m({z:v,10:"17",D:"1e",S:7(k){j(k.Z){$("#5A"+B).u(1Q($("#5A"+B).u())+1);$.1p(k.W);8 26=$("13[E=\'26\']");j(26){2Y($(26).q(),$("#4m"))}}F{8 v=O+"/R.N?P=m&Q=3N";$.m({z:v,10:"17",D:"1e",S:7(y){j(y.Z==0){2c()}F{$.1p(k.W)}},V:7(y){}})}},V:7(y){}})}7 bt(k){8 o=k;8 1J=$(o).G(\'1J\');8 5D=$(o).G(\'b\');8 5q=$(o).G(\'s\');8 5E=$(o).G(\'o\');8 w=$(o).G(\'w\');8 h=$(o).G(\'h\');j(1J==\'s\'){8 3P=0;j(w>5C){3P=5C}$(o).G(\'1y\',5D);$(o).G(\'1J\',\'b\');j(3P>0)$(o).G(\'1d\',3P);F $(o).5p(\'1d\');8 u=\'<1o><a 1U=\\"\'+5E+\'\\" 2R=\\"b9\\">查看原图</a></1o>\'+$(o).I().u();$(o).I().u(u)}F{$(o).G(\'1y\',5q);$(o).G(\'1J\',\'s\');$(o).5p(\'1d\');$(o).I().C(\'1o\').2T()}}7 2Y(v,1t){$.m({z:v,1h:"m=1",D:"1e",S:7(u){$(1t).u(u)},V:7(y){}})}7 b7(B,k){j($(k).I().I().C(".3I").u()==\'\'){$(".3I").u("");8 v=O+"/R.N?P=m&Q=5o&B="+B;$.m({z:v,1h:"m=1",D:"1e",S:7(u){$(k).I().I().C(".3I").u(u)},V:7(y){}})}F $(k).I().I().C(".3I").u("")}7 b6(k){8 1a=$(k).I().I().I();8 5U=$(k).I().C("2B");8 v=$(1a).G("3z");8 5V=$(1a).C("#b3");8 1n=$(1a).C("1n");j($.1l(1n.q())==\'\'){$.U("请输入分享内容");H}8 5W=$(1a).C("13[E=\'b4\']");8 5X=$(1a).C("13[E=\'bb\']");8 z=$(1a).C("13[E=\'26\']").q();8 M=$(1a).2N()+"&m=1";$.m({z:v,10:"17",1h:M,D:"1e",S:7(k){j(k.Z==0){$.U(k.W);H}$.1p(k.W);$(5V).u("");$(5U).1b();$(1a).C("13[E=\'77\']").q("");$(1n).q("");$(1n).G("bc",0);$(5W).q("");$(5X).q("");$("13[E=\'61\']").G("4a",L);$(".61").1r();$(".99").1j("bj");$("13[E=\'1J[]\']").q("");j($("13[E=\'bh\']").G("4a")){8 3E=$(".3E");2j(i=0;i<3E.14;i++){5L(k.1h,$(3E[i]).q())}}j(z)2Y(z,$("#4m"))},V:7(y){}})}7 5L(1H,2o){8 v=O+"/R.N?P=m&Q=bg&1H="+1H+"&2o="+2o;$.m({z:v,D:"1e",S:7(1h){},V:7(y){}})}7 bd(k){8 1a=$(k).I().I().I();8 v=$(1a).G("3z");8 1n=$(1a).C("1n");8 1H=$(1a).C("13[E=\'1H\']").q();8 z=O+"/R.N?P=m&Q=5o&B="+1H;8 M=$(1a).2N()+"&m=1&54=1";$.m({z:v,10:"17",1h:M,D:"1e",S:7(y){j(y.Z){$("#5N"+1H).u(1Q($("#5N"+1H).u())+1);$.1p(y.W);2Y(z,$(k).I().I().I().I())}F $.U(y.W)},V:7(y){}})}7 52(v,5Q){j(5Q){8 5O=O+"/R.N?P=m&Q=3N";$.m({z:5O,10:"17",D:"1e",S:7(y){j(y.Z==0){2c(7(){$("#3U").u("正在加载评论");$.m({z:v,D:"1e",S:7(u){$("#3U").u(u)},V:7(y){}})})}},V:7(y){}})}F{$("#3U").u("正在加载评论");$.m({z:v,D:"1e",S:7(u){$("#3U").u(u)},V:7(y){}})}}7 be(k){8 1a=$(k).I().I().I();8 v=$(1a).G("3z");8 1n=$(1a).C("1n");8 1H=$(1a).C("13[E=\'1H\']").q();8 4g=$("#4g").q();8 M=$(1a).2N()+"&m=1&54=1";$.m({z:v,10:"17",1h:M,D:"1e",S:7(y){j(y.Z){$("#4Z").u(1Q($("#4Z").u())+1);$.1p(y.W);52(4g)}F $.U(y.W)},V:7(y){}})}7 4Y(B,1t){j(5n(T.ar)){8 v=O+"/R.N?P=m&Q=4Y&B="+B;$.m({z:v,10:"17",D:"1e",S:7(y){j(y.Z){$(1t).2T()}F $.U(y.W)},V:7(y){}})}}7 5i(B,1t){j(5n(T.ap)){8 v=O+"/R.N?P=m&Q=5i&B="+B;$.m({z:v,10:"17",D:"1e",S:7(y){j(y.Z){$(1t).2T()}F $.U(y.W)},V:7(y){}})}}7 2c(1c){$.1v.1q(O+"/R.N?P=m&Q=2c",{2Q:\'5m\',1z:\'m\',1A:L,1m:T[\'4o\'],1d:5g,D:\'1B\',53:7(){4i();4j()},3h:1c})}7 9A(5e){8 v=O+"/R.N?P=m&Q=9B&B="+5e;$.1v.1q(v,{1z:\'m\',1A:L,1m:T[\'9y\'],1d:9x,D:\'1B\'})}7 5b(){8 4b=$(".9u");2j(8 i=0;i<4b.14;i++){8 3B=$(4b[i]);j($(3B).C("13").q()==\'\'){$.U(T[\'3l\']+$(3B).C("2z").u());$(3B).C("13").1P();H}}8 M=$("1a[E=\'9v\']").2N();8 v=O+"/R.N?P=m&Q=5b";$.m({z:v,10:"17",D:"1e",1h:M,S:7(y){j(y.Z==1){$.1p(y.W)}F j(y.Z==2){2X(y.W);1G.2b()}F{2c()}},V:7(y){}})}8 3d;6g=(7(){8 1Y;8 4l="6g";8 2J,2W;8 4s=7(){3d=4F(7(){1Y.1r()},6S)};8 4v=7(){3u(3d)};8 6P=7(){1Y=$("<1o B=\'"+4l+2W+"\' 1C=\'6V\'><1o 1C=\'4r\'>正在加载，请稍后...</1o></1o>");$("48").9w(1Y)};8 6W=7(){8 2F=2J.2F();8 39=0;j(2F.2p+63+2J.1d()>$(23).1d()){39=2F.2p-63}F{39=2F.2p+2J.1d()}1Y.1s({2u:2F.2u,2p:39})};8 4t=7(){6W();1Y.2g()};8 79=7(){$(".6V").1r();1Y=$("#"+4l+2W);j(!1Y.14){6P();4t();1Y.4r(O+"/R.N?P=m&Q=9C&3c="+2W)}F{4t()};1Y.2e(4v,4s);2J.2e(4v,4s)};H{4r:7(e,B){3u(3d);j(e===4n||B===4n||6X(B)||B<1){H L};2J=$(e);2W=B;79()}}})();7 7c(7d){8 v=O+"/R.N?P=m&Q=7c&9D="+7d;$.m({z:v,D:"1e",10:"17",S:7(1h){2X(1h.W);1G.2b()},V:7(y){}})}7 7f(2o,D){8 v=O+"/R.N?P=m&Q=7f&2o="+2o+"&D="+D+"&4q="+4w;$.m({z:v,D:"1e",S:7(1h){$("#9J"+2o+"aq"+D).u(1h)},V:7(y){}})}7 73(){$("#33-38-1a").21("3y",7(){8 v=$(J).G("3z");8 M=$(J).2N();$.m({z:v,10:"17",1h:M,D:"1e",S:7(y){j(y.Z==1){$("#33-38-1a").C("*[E=\'1m\']").q("");$("#33-38-1a").C("*[E=\'2l\']").q("");$("#33-38-1a").C("*[E=\'77\']").q("");2X(y.W);1G.2b()}F{$.U(y.W)}},V:7(y){}});H L})}7 71(){$(1u).7b(7(){8 6f=$(23).2A()+$(1u).1k()-70;j($.6G.9I&&$.6G.9H=="6.0"){$("#1O").1s("2u",6f);j($(23).2A()>0){$("#1O").1s("6e","9E")}F{$("#1O").1s("6e","3T")}}F{j($(23).2A()>0){$("#1O").1s("45","6n");$("#1O").1s("68","1");j($("#1O").1s("6l")=="6k")$("#1O").9F()}F{j($("#1O").1s("6l")!="6k")$("#1O").41()}}});$("#1O").21("1b",7(){$("u,48").64({2A:0},"46","9G",7(){});65()})}7 65(){$("#1O").64({45:"9t",68:"0"},6b,"9s",7(){$("#1O").1s("45","6n")})}7 9f(){8 v=O+"/R.N?P=m&Q=9g";$.m({z:v,10:"1D",D:"1e",S:7(44){j(44!="")1G.1U=44},V:7(y){}})}7 9h(2S,1X){1X=1X>0&&1X<=20?1X:2;2S=9e((2S+"").2i(/[^\\d\\.-]/g,"")).6h(1X)+"";8 l=2S.3q(".")[0].3q("").6q(),r=2S.3q(".")[1];t="";2j(i=0;i<l.14;i++){t+=l[i]+((i+1)%3==0&&(i+1)!=l.14?",":"")}8 28=t.3q("").6q().9d("")+"."+r;H 28.2i("-,","-")}7 9a(D){9b(D){6s"9c":$("#2V").q(1Q($("#2V").q())+50);3k;6s"9i":j(1Q($("#2V").q())-50>=50)$("#2V").q(1Q($("#2V").q())-50);3k}}7 6T(k){$("#"+k).2T()}7 6r(37,1L,k){8 M=2h 32();M.P="m";M.Q="9j";M.2l=$("#"+k).q();M.9p=37;M.9q=1L;M.6y=$("#33-38-1a 13[E=\'6y\']").q();j($.1l(M.2l)==""){$.U(T[\'6m\']);H L}$.m({z:O+"/R.N",1h:M,D:"4U",10:"17",S:7(1i){j(1i.Z==1){2X(1i.W);1G.2b()}F{$.U(1i.W)}}})}7 9r(2f){2f=9o(2f.6h(2));8 28=/(\\d+)(\\d{3})/;5k(28.4L(2f)){2f=2f.2i(28,"$1,$2")}H 2f}8 4z=1E;7 6Y(){3u(4z);j($("#3w").27()+$("#4S").27()+$("#35").27()+20<$(1u).1k()){$("#3w").1s({"9n":(($(1u).1k()-$("#4S").27()-$("#35").27()-20)-$("#3w").27())/2,"9k":(($(1u).1k()-$("#4S").27()-$("#35").27()-20)-$("#3w").27())/2})}4z=4F(6Y,9l)}7 9m(D,1S,1c){8 M=2h 32();M.P="9M";M.Q="9N";M.ad=D;M.1S=1S;M.ae=1;$.m({z:O+"/R.N",1h:M,D:"4U",10:"17",S:7(1i){j(1c!=1E)1c.2k(J,1i)}})}7 af(1y,3j,31,24){j(24>=$(1u).1k()){24=$(1u).1k()-59}$.1v.1q(\'<5a ac=\\\'0\\\' 1d=\\\'\'+(31-36)+\'\\\' 1k=\\\'\'+24+\'\\\' 1y=\\\'\'+1y+\'\\\'></5a>\',{1z:\'1D\',1A:L,1m:3j,1d:31,1k:24,D:\'1B\'})}7 ab(1y,3j,31,24){j(24>=$(1u).1k()){24=$(1u).1k()-59}1u.1q(1y,3j,\'1k=\'+24+\',1d=\'+31+\'2u=0,2p=0,a8=2t,a9=2t,aa=2t,ag=2t,1G=2t,Z=2t\')}7 ah(o){8 12=$(o).q();j(12==""){H L}8 2w=$("Y[E=\'2w\']");8 2y=$("Y[E=\'2y\']");8 2x=$("Y[E=\'2x\']");j(12.14==15){8 28=/(\\d{6})(\\d{2})(\\d{2})(\\d{2})(\\d{3})/;8 B=28.5R(12);2w.q(19+B[2]);2y.q(B[3]);2x.q(B[4])}F j(12.14==18){8 28=/(\\d{6})(\\d{4})(\\d{2})(\\d{2})(\\d{3})([0-9]|X|x)/;8 B=28.5R(12);2w.q(B[2]);2y.q(B[3]);2x.q(B[4])}F{2w.q("");2y.q("");2x.q("");H L}$("Y[E=\'2w\']").1R({1W:16});$("Y[E=\'2y\']").1R({1W:16});$("Y[E=\'2x\']").1R({1W:16});8 3H=L;j(4I)4I.an();4I=$.m({z:"R.N?P=m&Q=ao&am="+12,10:"17",S:7(1i){j(1i[\'Z\']==1){j(1i[\'2m\']=="男")$("Y[E=\'2m\']").q(1);F j(1i[\'2m\']=="女")$("Y[E=\'2m\']").q(0);F{$("Y[E=\'2m\']").q(-1);3H=16}}F{$("Y[E=\'2m\']").q(-1);3H=16}$("Y[E=\'2m\']").1R({1W:16})}});j(3H){H L}F H 16}7 al(o,k){j($.1l($(k).q())==""){$.U(T.4O);H L}j(!$.2C($(k).q())){$.U(T.2U);H L}j(!$(o).1Z(\'1x\')){$(o).1w(\'1x\');4R(k,7(){2r(o,60)})}}7 ai(o,k){j($.1l($(k).q())==""){$.U(T.4O);H L}j(!$.2C($(k).q())){$.U(T.2U);H L}j(!$(o).1Z(\'1x\')){$(o).1w(\'1x\');4B(k,7(){2r(o,60)})}}7 4R(k,1c){8 22=$(k).q();8 v=O+"/R.N?P=m&Q=4R&22="+22;$.m({z:v,10:"17",S:7(k){j(k.Z){j(1c!=1E){1c.2k(J)}$.1p(k.W)}F{$("#3D").1j("1x");$.U(k.W)}},V:7(y){}})}7 4B(k,1c){8 22=$(k).q();8 v=O+"/R.N?P=m&Q=4B&22="+22;$.m({z:v,10:"17",S:7(k){j(k.Z){j(1c!=1E){1c.2k(J)}$.1p(k.W)}F{$("#3D").1j("1x");$.U(k.W)}},V:7(y){}})}7 6A(12){8 29,2O,3v;8 1V="9T+/";8 i=0,1X=12.14,1I=\'\';5k(i<1X){29=12.3g(i++)&9U;j(i==1X){1I+=1V.25(29>>2);1I+=1V.25((29&4C)<<4);1I+="==";3k}2O=12.3g(i++);j(i==1X){1I+=1V.25(29>>2);1I+=1V.25(((29&4C)<<4)|((2O&6O)>>4));1I+=1V.25((2O&6J)<<2);1I+="=";3k}3v=12.3g(i++);1I+=1V.25(29>>2);1I+=1V.25(((29&4C)<<4)|((2O&6O)>>4));1I+=1V.25(((2O&6J)<<2)|((3v&9V)>>6));1I+=1V.25(3v&9S)}H 1I}7 9R(6u){H 6A(9O(9P+"%9Q%9W"+6u+"%9X%a3"))}7 40(){$(".3V-47").1b()}7 a4(69,6a){8 B=69.q();8 1K="3t.r"+B+".c";j(B==0){8 u="<1M 1f=\'0\'>="+T[\'3e\']+"=</1M>"}F{8 3a=2G(1K);1K+=".";8 u="<1M 1f=\'0\'>="+T[\'3e\']+"=</1M>";2j(8 2L 4u 3a){u+="<1M 1f=\'"+2G(1K+2L+".i")+"\'>"+2G(1K+2L+".n")+"</1M>"}}6a.u(u);$("Y[E=\'a5\']").1R({1W:16})}7 5d(2d){8 E="6j"+2d;8 6R="6j"+(1Q(2d)+1);8 B=$("Y[E=\'"+E+"\']").q();j(2d==1)8 1K="3t.r"+B+".c";j(2d==2)8 1K="3t.r"+$("Y[E=\'4c\']").q()+".c.r"+B+".c";j(2d==3)8 1K="3t.r"+$("Y[E=\'4c\']").q()+".c.r"+$("Y[E=\'57\']").q()+".c.r"+B+".c";j(B==0){8 u="<1M 1f=\'0\'>="+T[\'3e\']+"=</1M>"}F{8 3a=2G(1K);1K+=".";8 u="<1M 1f=\'0\'>="+T[\'3e\']+"=</1M>";2j(8 2L 4u 3a){u+="<1M 1f=\'"+2G(1K+2L+".i")+"\'>"+2G(1K+2L+".n")+"</1M>"}}$("Y[E=\'"+6R+"\']").u(u);j(2d!=4){5d(1Q(2d)+1)}$("Y[E=\'4c\']").1R({1W:16});$("Y[E=\'57\']").1R({1W:16});$("Y[E=\'a1\']").1R({1W:16});$("Y[E=\'9Y\']").1R({1W:16})}7 3Y(){j(4y==1){$.m({z:O+"/R.N?P=m&Q=3Y",D:"1e",S:7(Z){j(Z==1){4y=0;$.1p("登录成功!");1G.2b()}}})}}7 a0(5w,5y){$(5w).1b(7(){$2D=$(5y);$3J=$("#5G").C("#3J");$3K=$("#5G").C("#3K");j($2D.bi(":3T")){$("13[E=\'2D\']").q(1);$2D.2g();$3J.1r();$3K.2g()}F{$("13[E=\'2D\']").q(0);$2D.1r();$3K.1r();$3J.2g()}})}7 9Z(4G){8 3A=[[\'^0(\\\\d+)$\',\'$1\'],[\'[^\\\\d\\\\.]+$\',\'\'],[\'\\\\.(\\\\d?)\\\\.+\',\'.$1\'],[\'^(\\\\d+\\\\.\\\\d{2}).+\',\'$1\']];2j(i=0;i<3A.14;i++){8 3i=2h a2(3A[i][0]);4G.1f=4G.1f.2i(3i,3A[i][1])}}$.a6.4A=7(){$(J).a7(\'1b\',7(){4y=1;$.1v.1q(O+"/R.N?P=ak&Q=aj",{2Q:\'5m\',1z:\'m\',1A:L,2H:L,2I:L,1m:\'微信登录\',1d:9L,D:\'1B\',53:7(){bf(3Y,9z)}})})}',62,716,'|||||||function|var|||||||||||if|obj||ajax||||val||||html|ajaxurl|||ajaxobj|url||id|find|type|name|else|attr|return|parent|this||false|query|php|APP_ROOT|ctl|act|index|success|LANG|showErr|error|info||select|status|dataType||str|input|length||true|json|||form|click|func|width|POST|value|init|data|result|removeClass|height|trim|title|textarea|div|showSuccess|open|hide|css|dom|window|weeboxs|addClass|btn_disable|src|contentType|showButton|wee|class|text|null|ui|location|topic_id|string|tag|evalStr|dataid|option|node|gotop|focus|parseInt|ui_select|user_id|rel|href|base64EncodeChars|refresh|len|cardDiv|hasClass||bind|user_mobile|document|sheight|charAt|ajax_url|outerHeight|re|c1|msg|reload|ajax_login|lv|hover|num|show|new|replace|for|call|content|sex|droped_select|class_name|left|strLength|ResetsendPhoneCode|ImgCbo|no|top|each|byear|bday|bmonth|span|scrollTop|img|checkMobilePhone|more_search|sub_main_nav|offset|eval|showCancel|showOk|qObj|user_head_tip|key|idno|serialize|c2|uiselect_idx|boxid|target|price|remove|FILL_CORRECT_MOBILE_PHONE|ten_value|userId|alert|ajax_load_page|times|J_Vphone|swidth|Object|consult|account|header||dealid|add|of_left|regionConfs|get_verify_code|uid|timer|SELECT_PLEASE|keimg|charCodeAt|onclose|reg|stitle|break|PLEASE_INPUT|tip|box|tip_box|lf|split|mobile|item_cur|regionConf|clearTimeout|c3|J_wrap|sw|submit|action|regStrs|row|300|reveiveActiveCode|syn_class|ecvpassword|ieditor|is_err|col_item_reply_box|iconfont_down|iconfont_up|ecvsn|Math|check_login_status|op|img_width|isByte|is_effect|self|hidden|topic_page_reply|dialog|line|hasPlaceholderSupport|do_weixin_login|drop|close_pop|fadeOut|color|edit|jumpurl|bottom|fast|close|body|hint|checked|submit_rows|region_lv1|keimg_d|image|current|load_url|ketext|init_ui_checkbox|init_ui_textbox|resetSpcThread|userCardStr|col_list|undefined|PLEASE_LOGIN_FIRST|module|fhash|load|mout|showUserCard|in|mover|__HASH_KEY__|overflow|open_weixin_login|resetTimeact|weixin_login|get_authorized_verify_code|0x3|express_id|z0|setTimeout|th|keimg_h_|idcheck_act|getStringLength|express_sn|test|200|add_focus|VERIFY_MOBILE_EMPTY|_commentBox|Za|get_unit_verify_code|ftw|remove_focus|post|funok|init_ui_radiobox|label|delete_topic|reply_count||J_deal_tab_box|load_topic_replys|onopen|no_verify|mode|init_top_nav|region_lv2|li|120|iframe|do_event_submit|360|load_select|event_id|do_relay_topic|1060|set_event_sort|delete_topic_reply|cur|while|ui_textbox|pop_user_login|confirm|load_reply_col_form|removeAttr|s_src|emoticons|MOBILE_VERIFY_CODE|mail|10000000|set_sort|more_search_btn|selected|more_search_box|dropdown|topic_fav_|bindKindeditor|525|b_src|o_src|link|account_search|random|verify_ecv|fanwe_msg_box|DO_GET|syn_topic_to_weibo|unbind|topic_reply_|ajaxurl_ck|funcls|checklogin|exec|init_ui_select|round|verify_img|img_box|groupbox|groupdatabox|vote|uiselect_||other_tag|deal_id|230|animate|fly_gotop|validateCode2|fff|opacity|pname|cname|1000|keimg_m_|order_count|visibility|s_top|userCard|toFixed|deal|region_lv|none|display|MESSAGE_CONTENT_EMPTY|10px|get_authorized_paypwd_verify_code|send_sms|reverse|replyCommentSubmit|case|item|pwd|to_send_msg|cache|relay_topic|rel_table|readonly|des|allowFileManager|idno_re|is_private_room|topic_relay_|100000|browser|date_time|_comment|0xF|button|J_deal_tab_select|date_time_h|onclick|0xF0|createLoadDiv|tc|next_name|500|cancelReply|vote_topic|nameCard|resetXY|isNaN|resetWindowBox|outerWidth||init_gotop|ERROR_IMG|submit_message|view|editor|KindEditor|verify|date_time_m|loadCard|keimg_a_|scroll|set_syn|syn_field|bindKeUpload|load_api_url|copy|print|wordpaste|cut|plainpaste|paste|subscript|media|table|flash|removeformat|underline|strikethrough|hr|unlink|plugin|imageDialog|loadPlugin|MAX_FILE_SIZE|imageSizeLimit|italic|bold|insertunorderedlist|indent|insertorderedlist|justifyfull|justifycenter|justifyright|outdent|superscript|forecolor|hilitecolor|fontsize|fontname|selectall|justifyleft|jump|order_done|submit_buy|main_nav|blur|go|flink|modify_bind|lottery_mobile_input|lottery_mobile_word|J_autoBidEnable|uc_autobid|cols|blank5|loanCommentBtn|rows|comment_edit|autoopen|J_comment_reply|clearfix|submit_mail|box_view_|ready|one|jcur|indexOf|xhr|jQuery|ajaxSetup|beforeSend|msg_count|pm|620|340|box_view|reportguy|J_reportGuy|new_pm|deal_list_table|tr|sub_btn|reset_btn|ui_radiobox|event|create|radiobox|ui_checkbox|weixim|textbox|checkbox|minWidth|emoticonsPath|fsource|fullscreen|undo|source|items|public|afterBlur|sync|J_APP_DOWN|imageUrl|J_biao_list|item_1|stepVerifyIdCardAndPhone|560|send_msg|ml10|after|J_send_msg|URGENTCONTACT|IDNO|dobidstepone|J_bind_ips|check_user_info|VERIFY_CODE|MOBILE_EMPTY_TIP|str_len|FILL_CORRECT_IDNO|TWO_ENTER_IDNO_ERROR|redo|tag_item|jiajian|switch|jia|join|parseFloat|skip_user_profile|gopreview|foramtmoney|jian|msg_reply|marginBottom|100|checkIpsBalance|marginTop|String|rel_id|pid|formatNum|linear|600px|event_submit_row|event_submit_form|append|370|EVENT_SUBMIT|3000|show_event_submit|submit_event|usercard|field|visible|fadeIn|swing|version|msie|api_|clickFn|270|collocation|QueryForAccBalance|escape|__LOGIN_KEY|u65B9|FW_Password|0x3F|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|0xff|0xC0|u7EF4|u8F6F|region_lv4|amount|account_more_search|region_lv3|RegExp|u4EF6|load_city|city_id|fn|live|toolbar|menubar|scrollbars|openNewWindow|frameborder|user_type|is_ajax|openWeeboxFrame|resizable|idcheck|sendAuthorizedPhoneCode|wx_login|user|sendUnitPhoneCode|card|abort|getIdCardinfo|CONFIRM_DELETE_RELAY|_|CONFIRM_DELETE_TOPIC|form_err|sendPhoneCode|default|Common|inherit|26px|formError|Array|sendPhoneCode0|550|280|add_score|TRACK_EXPRESS|express|get_paypwd_verify_code|track_express|989898|form_success|minLength|checkEmail|onok|maxLength|checkNumber|ig|255|embed|placeholder|createElement|gif|no_pic|images|fanwe_error_box|fanwe_success_box|formSuccess|showCfm|collect_deal|add_cart|image_box|group|border|ajax_submit_form|reply_topic|hideDialog|_blank|align|group_data|position|ajax_submit_reply_form|ajax_submit_reply_form_topic_page|setInterval|syn_to_weibo|syn_weibo|is|tag_item_c|collect|ROOT_PATH|RELAY_TOPIC|focus_user|fdetail|store|check_content|Tpl|570|zoom|fav_topic|open_win|relay_content|do_fav_topic'.split('|'),0,{}))

/**
 * 理财计算器代码,创建一个理财计算器窗口
 */
licaiCalWindow = function(rate,time,max) {
	var rate		= rate? rate : 10;
	var time		= time? time : 12;
	var max			= max? max : 10000;
	var val			= max&max<10000? max : max;
	var container	= null;
	var closed		= true;
	var self		= this;
	this.item		= null;
	this.creatable	= true;

	this.show = function(rate,time,remain,event) {
		if (container == null) { create(); }

		var pos = getMousePos(event);
		container.find("input#LOANRATE").val(rate);
		container.find("input#LOANTERM").val(time);
		container.css({"left":(pos.x+20)+"px","top":(pos.y-160)+"px"});
		container.show();
		bind_event();
		closed = false;	
		container.find(".submitBtn").trigger("click");
	}

	this.hide = function() {
		close();
		$(container).hide();
	}

	function create() {
		var txt = "";
		txt += "<div class='calc_container'>";
		txt += "<div class='header' title='双击此处可关闭'>";
		txt += "<div class='title'>理财计算器</div>";
		txt += "<div class='close'>关闭</div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>投标金额：</div>";
		txt += "<div class='inp'><input type='text' id='BUSINESSSUM' maxlength='12' value='10000' /><div class='mydiv'>元</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>年化收益：</div>";
		txt += "<div class='inp'><input type='text' id='LOANRATE' maxlength='5' /><div class='mydiv'>%</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>投资期限：</div>";
		txt += "<div class='inp'><input type='text' id='LOANTERM' maxlength='3' /><div class='mydiv' id='term_txt'>月</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>期限类型：</div>";
		txt += "<div class='int'><input type='radio' name='type' value='1' checked id='tpmonth' /><label for='tpmonth'>月</label><input type='radio' name='type' value='2' style='margin-left:36px;' id='tpday' /><label for='tpday'>天</label></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>本息合计：</div>";
		txt += "<div class='int'><div class='total'>￥<span class='num'></span></div></div>";
		txt += "</div>";
		txt += "<div class='submitBtn'>立即计算收益</div>";
		txt += "</div>";

		container = jQuery(txt);
		$(document.body).append(container);
		set_style();
		jqDnR_support();
		container.hide();
	}

	function close() {
		//unbind_event();
	}

	function set_style() {
		$(container).css({'width':'420px','height':'506px','background':'white','position':'absolute','z-index':'100','top':'50%','box-shadow':'rgb(40, 40, 40) 0px 0px 6px','display':'none','border':'1px solid #DDDDDD'});
		$(container).find(".header").css({'background':'#CA8B24','height':'40px','font-size':'16px','line-height':'40px','color':'white','cursor':'move','margin-bottom':'40px'});
		$(container).find(".header .title").css({'float':'left','margin-left':'8px'});
		$(container).find(".header .close").css({'float':'right','margin-right':'8px','cursor':'pointer'});
		$(container).find(".dl-comm1").css({'height':'40px'});
		$(container).find(".item").css({'height':'40px','margin-bottom':'20px'});
		$(container).find(".item > div").css({'height':'40px','line-height':'40px','float':'left'});
		$(container).find(".item .mr2").css({'float':'left','width':'137px','text-align':'right'});
		$(container).find(".item .mr2 b").css({'margin-right':'2px','color':'#CA8B24'});
		$(container).find(".item .inp").css({'width':'208px','border':'1px solid #E1DDD8'});
		$(container).find(".item .inp input").css({'height':'38px','border':'0','line-height':'38px','font-size':'16px','width':'160px'});
		$(container).find(".item .inp .mydiv").css({'float':'right','width':'37px','height':'100%','border-left':'1px solid #E1DDD8','background':'#F8F5F5','text-align':'center'});
		$(container).find(".item .int").css({'float':'left','width':'208px'});
		$(container).find(".item .int input").css({'display':'block','float':'left','width':'12px','margin-top':'15px','margin-right':'3px'});
		$(container).find(".item .int label").css({'display':'block','float':'left','height':'100%'});
		$(container).find(".item .int .total").css({'font-size':'18px','color':'#F5A811'});
		$(container).find(".submitBtn").css({'width':'200px','height':'40px','line-height':'40px','text-align':'center','font-size':'20px','color':'white','cursor':'pointer','margin-left':'105px','background':'#EFB14D','margin-top':'10px'});
	}

	function bind_event() {
		// 投资金额输入
		container.find("input#BUSINESSSUM").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode > 47 && ev.keyCode < 58) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = parseInt($(this).val());
				// 判断是否为数字
				if (isNaN(val)) {
					$(this).val("请输入数字!");
					return false;
				}
				if ($(this).val() == 0) {
					$(this).val("10000");
					container.find(".submitBtn").trigger("click");
				}				
			});
		});

		// 年化收益
		$(container).find("input#LOANRATE").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode == 46 || (ev.keyCode > 47 && ev.keyCode < 58)) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = $(this).val();
				// 判断是否为数字
				if (isNaN(val)) {
					$(this).val("请输入年化收益!");
				}
			});
		});
		
		// 投资期限
		$(container).find("input#LOANTERM").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode > 47 && ev.keyCode < 58) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = $(this).val();
				// 判断是否为数字
				if (isNaN(val) || val == 0) {
					$(this).val("请输入投资期限!");
				}
			});
		});

		// 期限类型设置
		$(container).find("#tpmonth").bind("click", function() {
			$(container).find("#term_txt").html("月");
			container.find(".submitBtn").trigger("click");
		});
		$(container).find("#tpday").bind("click", function() {
			$(container).find("#term_txt").html("天");
			container.find(".submitBtn").trigger("click");
		});

		// 计算收益
		container.find(".submitBtn").bind("click", function() {
			// 输入金额
			var input = container.find("#BUSINESSSUM").val();
			// 年化收益
			var rate = container.find("#LOANRATE").val();
			// 投资期限
			var term = container.find("#LOANTERM").val();
			// 期限类型

			var type = container.find("#tpmonth").attr("checked") == "checked"? "month" : "day";
			
			var res = input * rate * (type=="month"? (term/12):(term/360)) / 100;
			var total = parseFloat(input) + parseFloat(res);
			total = total.toFixed(2);
			container.find(".total .num").html(total);
		});

		// 关闭计算器
		container.bind("dblclick", function() {
			container.hide();
		}).find(".close").bind("click", function() {
			container.hide();
		});
	}

	function unbind_event() {
		//
	}

	function jqDnR_support() {
		if ($.jqDnR) { $('.calc_container').jqDrag(".header"); }
	}

	function getMousePos(event) { 
		var e = event || window.event; 
		var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft; 
		var scrollY = document.documentElement.scrollTop || document.body.scrollTop; 
		var x = e.pageX || e.clientX + scrollX; 
		var y = e.pageY || e.clientY + scrollY; 
		return { 'x': x, 'y': y }; 
    }
}
/*
    radialIndicator.js v 1.0.0
    Author: Sudhanshu Yadav
    Copyright (c) 2015 Sudhanshu Yadav - ignitersworld.com , released under the MIT license.
    Demo on: ignitersworld.com/lab/radialIndicator.html
*/

;(function ($, window, document) {
    "use strict";
    //circumfence and quart value to start bar from top
    var circ = Math.PI * 2,
        quart = Math.PI / 2;

    //function to convert hex to rgb

    function hexToRgb(hex) {
        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function (m, r, g, b) {
            return r + r + g + g + b + b;
        });

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)] : null;
    }

    function getPropVal(curShift, perShift, bottomRange, topRange) {
        return Math.round(bottomRange + ((topRange - bottomRange) * curShift / perShift));
    }


    //function to get current color in case of 
    function getCurrentColor(curPer, bottomVal, topVal, bottomColor, topColor) {
        var rgbAryTop = topColor.indexOf('#') != -1 ? hexToRgb(topColor) : topColor.match(/\d+/g),
            rgbAryBottom = bottomColor.indexOf('#') != -1 ? hexToRgb(bottomColor) : bottomColor.match(/\d+/g),
            perShift = topVal - bottomVal,
            curShift = curPer - bottomVal;

        if (!rgbAryTop || !rgbAryBottom) return null;

        return 'rgb(' + getPropVal(curShift, perShift, rgbAryBottom[0], rgbAryTop[0]) + ',' + getPropVal(curShift, perShift, rgbAryBottom[1], rgbAryTop[1]) + ',' + getPropVal(curShift, perShift, rgbAryBottom[2], rgbAryTop[2]) + ')';
    }

    //to merge object
    function merge() {
        var arg = arguments,
            target = arg[0];
        for (var i = 1, ln = arg.length; i < ln; i++) {
            var obj = arg[i];
            for (var k in obj) {
                if (obj.hasOwnProperty(k)) {
                    target[k] = obj[k];
                }
            }
        }
        return target;
    }

    //function to apply formatting on number depending on parameter
    function formatter(pattern) {
        return function (num) {
            if(!pattern) return num.toString();
            num = num || 0
            var numRev = num.toString().split('').reverse(),
                output = pattern.split("").reverse(),
                i = 0,
                lastHashReplaced = 0;

            //changes hash with numbers
            for (var ln = output.length; i < ln; i++) {
                if (!numRev.length) break;
                if (output[i] == "#") {
                    lastHashReplaced = i;
                    output[i] = numRev.shift();
                }
            }

            //add overflowing numbers before prefix
            output.splice(lastHashReplaced+1, output.lastIndexOf('#') - lastHashReplaced, numRev.reverse().join(""));

            return output.reverse().join('');
        }
    }


    //circle bar class
    function Indicator(container, indOption) {
        indOption = indOption || {};
        indOption = merge({}, radialIndicator.defaults, indOption);

        this.indOption = indOption;

        //create a queryselector if a selector string is passed in container
        if (typeof container == "string")
            container = document.querySelector(container);

        //get the first element if container is a node list
        if (container.length)
            container = container[0];

        this.container = container;

        //create a canvas element
        var canElm = document.createElement("canvas");
        container.appendChild(canElm);

        this.canElm = canElm; // dom object where drawing will happen

        this.ctx = canElm.getContext('2d'); //get 2d canvas context

        //add intial value 
        this.current_value = indOption.initValue || indOption.minValue || 0;

    }


    Indicator.prototype = {
        constructor: radialIndicator,
        init: function () {
            var indOption = this.indOption,
                canElm = this.canElm,
                ctx = this.ctx,
                dim = (indOption.radius + indOption.barWidth) * 2, //elm width and height
                center = dim / 2; //center point in both x and y axis


            //create a formatter function
            this.formatter = typeof indOption.format == "function" ? indOption.format : formatter(indOption.format);

            //maximum text length;
            this.maxLength = indOption.percentage ? 4 : this.formatter(indOption.maxValue).length;

            canElm.width = dim;
            canElm.height = dim;

            //draw a grey circle
            ctx.strokeStyle = indOption.barBgColor; //background circle color
            ctx.lineWidth = indOption.barWidth;
            ctx.beginPath();
            ctx.arc(center, center, indOption.radius, 0, 2 * Math.PI);
            ctx.stroke();

            //store the image data after grey circle draw
            this.imgData = ctx.getImageData(0, 0, dim, dim);

            //put the initial value if defined
            this.value(this.current_value);

            return this;
        },
        //update the value of indicator without animation
        value: function (val) {
            //return the val if val is not provided
            if (val === undefined || isNaN(val)) {
                return this.current_value;
            }

            val = parseInt(val);
            
            var ctx = this.ctx,
                indOption = this.indOption,
                curColor = indOption.barColor,
                dim = (indOption.radius + indOption.barWidth) * 2,
                minVal = indOption.minValue,
                maxVal = indOption.maxValue,
                center = dim / 2;

            //limit the val in range of 0 to 100
            val = val < minVal ? minVal : val > maxVal ? maxVal : val;

            var perVal = Math.round(((val - minVal) * 100 / (maxVal - minVal)) * 100) / 100, //percentage value tp two decimal precision
                dispVal = indOption.percentage ? perVal + '%' : this.formatter(val); //formatted value

            //save val on object
            this.current_value = val;


            //draw the bg circle
            ctx.putImageData(this.imgData, 0, 0);

            //get current color if color range is set
            if (typeof curColor == "object") {
                var range = Object.keys(curColor);

                for (var i = 1, ln = range.length; i < ln; i++) {
                    var bottomVal = range[i - 1],
                        topVal = range[i],
                        bottomColor = curColor[bottomVal],
                        topColor = curColor[topVal],
                        newColor = val == bottomVal ? bottomColor : val == topVal ? topColor : val > bottomVal && val < topVal ? indOption.interpolate ? getCurrentColor(val, bottomVal, topVal, bottomColor, topColor) : topColor : false;

                    if (newColor != false) {
                        curColor = newColor;
                        break;
                    }
                }
            }

            //draw th circle value
            ctx.strokeStyle = curColor;

            //add linecap if value setted on options
            if (indOption.roundCorner) ctx.lineCap = "round";

            ctx.beginPath();
            ctx.arc(center, center, indOption.radius, -(quart), ((circ) * perVal / 100) - quart, false);
            ctx.stroke();

            //add percentage text
            if (indOption.displayNumber) {
                var cFont = ctx.font.split(' '),
                    weight = indOption.fontWeight,
                    fontSize = indOption.fontSize || (dim / (this.maxLength - (Math.floor(this.maxLength*1.4/4)-1)));

                cFont = indOption.fontFamily || cFont[cFont.length - 1];


                ctx.fillStyle = indOption.fontColor || curColor;
                ctx.font = weight +" "+ fontSize + "px " + cFont;
                ctx.textAlign = "center";
                ctx.textBaseline = 'middle';
                ctx.fillText(dispVal, center, center);
            }

            return this;
        },
        //animate progressbar to the value
        animate: function (val) {

            var indOption = this.indOption,
                counter = this.current_value || indOption.minValue,
                self = this,
                incBy = Math.ceil((indOption.maxValue - indOption.minValue) / (indOption.frameNum || (indOption.percentage ? 100 : 500))), //increment by .2% on every tick and 1% if showing as percentage
                back = val < counter;

            //clear interval function if already started
            if (this.intvFunc) clearInterval(this.intvFunc); 

            this.intvFunc = setInterval(function () {

                if ((!back && counter >= val) || (back && counter <= val)) {
                    if (self.current_value == counter) {
                        clearInterval(self.intvFunc);
                        return;
                    } else {
                        counter = val;
                    }
                }

                self.value(counter); //dispaly the value

                if (counter != val) {
                    counter = counter + (back ? -incBy : incBy)
                }; //increment or decrement till counter does not reach  to value
            }, indOption.frameTime);

            return this;
        },
        //method to update options
        option: function (key, val) {
            if (val === undefined) return this.option[key];

            if (['radius', 'barWidth', 'barBgColor', 'format', 'maxValue', 'percentage'].indexOf(key) != -1) {
                this.indOption[key] = val;
                this.init().value(this.current_value);
            }
            this.indOption[key] = val;
        }

    };

    /** Initializer function **/
    function radialIndicator(container, options) {
        var progObj = new Indicator(container, options);
        progObj.init();
        return progObj;
    }

    //radial indicator defaults
    radialIndicator.defaults = {
        radius: 50, //inner radius of indicator
        barWidth: 5, //bar width
        barBgColor: '#eeeeee', //unfilled bar color
        barColor: '#99CC33', //filled bar color , can be a range also having different colors on different value like {0 : "#ccc", 50 : '#333', 100: '#000'}
        format: null, //format indicator numbers, can be a # formator ex (##,###.##) or a function
        frameTime: 10, //miliseconds to move from one frame to another
        frameNum: null, //Defines numbers of frame in indicator, defaults to 100 when showing percentage and 500 for other values
        fontColor: null, //font color
        fontFamily: null, //defines font family
        fontWeight: 'bold', //defines font weight
        fontSize : null, //define the font size of indicator number
        interpolate: true, //interpolate color between ranges
        percentage: false, //show percentage of value
        displayNumber: true, //display indicator number
        roundCorner: false, //have round corner in filled bar
        minValue: 0, //minimum value
        maxValue: 100, //maximum value
        initValue: 0 //define initial value of indicator
    };
    
    window.radialIndicator = radialIndicator;

    //add as a jquery plugin
    if ($) {
        $.fn.radialIndicator = function (options) {
            return this.each(function () {
                var newPCObj = radialIndicator(this, options);
                $.data(this, 'radialIndicator', newPCObj);
            });
        };
    }

}(window.jQuery, window, document, void 0));
function SlideShow(c,u,v,w,m) {
    var a = document.getElementById(u), f = document.getElementById(v).getElementsByTagName("li"), h = document.getElementById(w), n = h.getElementsByTagName("li"), d = f.length, c = c || 3000, e = lastI = 0, j;
    function b() {
        m = setInterval(function () {
            e = e + 1 >= d ? e + 1 - d : e + 1;
            g()
        }, c)
    }
    function k() {
        clearInterval(m)
    }
    function g() {
        f[lastI].style.display = "none";
        n[lastI].className = "";
        f[e].style.display = "block";
        n[e].className = "on";
        lastI = e
    }
    f[e].style.display = "block";
    a.onmouseover = k;
    a.onmouseout = b;
    h.onmouseover = function (i) {
        j = i ? i.target : window.event.srcElement;
        if (j.nodeName === "LI") {
            e = parseInt(j.innerHTML, 10) - 1;
            g()
        }
    };
    b()
}
/*
    countUp.js
    by @inorganik
*/

// target = id of html element or var of previously selected html element where counting occurs
// startVal = the value you want to begin at
// endVal = the value you want to arrive at
// decimals = number of decimal places, default 0
// duration = duration of animation in seconds, default 2
// options = optional object of options (see below)

var CountUp = function(target, startVal, endVal, decimals, duration, options) {

    // make sure requestAnimationFrame and cancelAnimationFrame are defined
    // polyfill for browsers without native support
    // by Opera engineer Erik Möller
    var lastTime = 0;
    var vendors = ['webkit', 'moz', 'ms', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame =
          window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }
    if (!window.cancelAnimationFrame) {
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }

    var self = this;

     // default options
    self.options = {
        useEasing : true, // toggle easing
        useGrouping : true, // 1,000,000 vs 1000000
        separator : ',', // character to use as a separator
        decimal : '.', // character to use as a decimal
        easingFn: null, // optional custom easing closure function, default is Robert Penner's easeOutExpo
        formattingFn: null // optional custom formatting function, default is self.formatNumber below
    };
    // extend default options with passed options object
    for (var key in options) {
        if (options.hasOwnProperty(key)) {
            self.options[key] = options[key];
        }
    }
    if (self.options.separator === '') { self.options.useGrouping = false; }
    if (!self.options.prefix) self.options.prefix = '';
    if (!self.options.suffix) self.options.suffix = '';

    self.d = (typeof target === 'string') ? document.getElementById(target) : target;
    self.startVal = Number(startVal);
    self.endVal = Number(endVal);
    self.countDown = (self.startVal > self.endVal);
    self.frameVal = self.startVal;
    self.decimals = Math.max(0, decimals || 0);
    self.dec = Math.pow(10, self.decimals);
    self.duration = Number(duration) * 1000 || 2000;

    self.formatNumber = function(nStr) {
        nStr = nStr.toFixed(self.decimals);
        nStr += '';
        var x, x1, x2, rgx;
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? self.options.decimal + x[1] : '';
        rgx = /(\d+)(\d{3})/;
        if (self.options.useGrouping) {
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + self.options.separator + '$2');
            }
        }
        return self.options.prefix + x1 + x2 + self.options.suffix;
    };
    // Robert Penner's easeOutExpo
    self.easeOutExpo = function(t, b, c, d) {
        return c * (-Math.pow(2, -10 * t / d) + 1) * 1024 / 1023 + b;
    };

    self.easingFn = self.options.easingFn ? self.options.easingFn : self.easeOutExpo;
    self.formattingFn = self.options.formattingFn ? self.options.formattingFn : self.formatNumber;

    self.version = function () { return '1.7.1'; };

    // Print value to target
    self.printValue = function(value) {
        var result = self.formattingFn(value);

        if (self.d.tagName === 'INPUT') {
            this.d.value = result;
        }
        else if (self.d.tagName === 'text' || self.d.tagName === 'tspan') {
            this.d.textContent = result;
        }
        else {
            this.d.innerHTML = result;
        }
    };

    self.count = function(timestamp) {

        if (!self.startTime) { self.startTime = timestamp; }

        self.timestamp = timestamp;
        var progress = timestamp - self.startTime;
        self.remaining = self.duration - progress;

        // to ease or not to ease
        if (self.options.useEasing) {
            if (self.countDown) {
                self.frameVal = self.startVal - self.easingFn(progress, 0, self.startVal - self.endVal, self.duration);
            } else {
                self.frameVal = self.easingFn(progress, self.startVal, self.endVal - self.startVal, self.duration);
            }
        } else {
            if (self.countDown) {
                self.frameVal = self.startVal - ((self.startVal - self.endVal) * (progress / self.duration));
            } else {
                self.frameVal = self.startVal + (self.endVal - self.startVal) * (progress / self.duration);
            }
        }

        // don't go past endVal since progress can exceed duration in the last frame
        if (self.countDown) {
            self.frameVal = (self.frameVal < self.endVal) ? self.endVal : self.frameVal;
        } else {
            self.frameVal = (self.frameVal > self.endVal) ? self.endVal : self.frameVal;
        }

        // decimal
        self.frameVal = Math.round(self.frameVal*self.dec)/self.dec;

        // format and print value
        self.printValue(self.frameVal);

        // whether to continue
        if (progress < self.duration) {
            self.rAF = requestAnimationFrame(self.count);
        } else {
            if (self.callback) { self.callback(); }
        }
    };
    // start your animation
    self.start = function(callback) {
        self.callback = callback;
        self.rAF = requestAnimationFrame(self.count);
        return false;
    };
    // toggles pause/resume animation
    self.pauseResume = function() {
        if (!self.paused) {
            self.paused = true;
            cancelAnimationFrame(self.rAF);
        } else {
            self.paused = false;
            delete self.startTime;
            self.duration = self.remaining;
            self.startVal = self.frameVal;
            requestAnimationFrame(self.count);
        }
    };
    // reset to startVal so animation can be run again
    self.reset = function() {
        self.paused = false;
        delete self.startTime;
        self.startVal = startVal;
        cancelAnimationFrame(self.rAF);
        self.printValue(self.startVal);
    };
    // pass a new endVal and start animation
    self.update = function (newEndVal) {
        cancelAnimationFrame(self.rAF);
        self.paused = false;
        delete self.startTime;
        self.startVal = self.frameVal;
        self.endVal = Number(newEndVal);
        self.countDown = (self.startVal > self.endVal);
        self.rAF = requestAnimationFrame(self.count);
    };

    // format startVal on initialization
    self.printValue(self.startVal);
};
$(document).ready(function() {
// 获取终端的相关信息
var TerminalCCC = {
	// 辨别移动终端类型
	platform : function(){
		var u = navigator.userAgent, app = navigator.appVersion;
		return {
			// android终端或者uc浏览器
			android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
			// 是否为iPhone或者QQHD浏览器
			iPhone: u.indexOf('iPhone') > -1 ,
			// 是否iPad
			iPad: u.indexOf('iPad') > -1
		};
	}(),
	// 辨别移动终端的语言：zh-cn、en-us、ko-kr、ja-jp...
	language : (navigator.browserLanguage || navigator.language).toLowerCase()
}

// 根据不同的终端，跳转到不同的地址
if(TerminalCCC.platform.android || TerminalCCC.platform.iPhone || TerminalCCC.platform.iPad){
	location.href = '/wap/index.php';
	return;
} 
});
var doexchange_lock = false;
$(document).ready(function(){
	$("#sku label").click(function(){
		$(this).siblings("label").removeClass("this_Property");
		$(this).addClass("this_Property");
		
	});
	
	$("#quxiao").live("click",function(){
		$.weeboxs.close("WB_ADDRESS");
	});
	
	$("#sku .Other_Property").click(function(){
		var t_score = parseFloat(sum_score);
		$("#sku .this_Property .mt").each(function(){
			if($(this).attr("checked")=="checked" || $(this).attr("checked")==true){
				t_score += parseFloat($(this).attr("rel"));
			}
		});
		$(".score").html(t_score);
		eachattr();
	});
	
	$("#add_newaddress").live("click",function(){
		$("#add_newaddress").removeClass("reset_btn");
		$("#add_newaddress").addClass("true_btn");
		$("#old_newaddress").removeClass("true_btn");
		$("#old_newaddress").addClass("reset_btn");
		$(".old_addr_box").addClass("hide");
		$(".new_addr_box").removeClass("hide");
		$("#add_addr").val(1);
	});
	
	$("#old_newaddress").live("click",function(){
		$("#old_newaddress").removeClass("reset_btn");
		$("#old_newaddress").addClass("true_btn");
		$("#add_newaddress").removeClass("true_btn");
		$("#add_newaddress").addClass("reset_btn");
		$(".new_addr_box").addClass("hide");
		$(".old_addr_box").removeClass("hide");
		$("#add_addr").val(0);
	});

});

function eachattr(){
	if(json_attr_stock!=null){
		var attr_str = "";
		var stock_number = 0;
		$("#sku input.mt:checked").each(function(){
			attr_str += $(this).attr("attrstr");
		});
		
		$.each(json_attr_stock,function(i,v){
			if(v.attr_str==attr_str){
				stock_number = v.stock_cfg - v.buy_count;
			}
		});
		$("#stock_number").html(stock_number);
	}
}


function doexchange(id,delivery,max_bought,user_can_buy_number)
{
	var stock_number = $.trim($("#stock_number").html());
	var number =  $.trim($("#number").val());
	var user_can_buy_number =  user_can_buy_number;
	if(number=="" || parseInt(number) <= 0){
		$.showErr("请输入正确的兑换数量",function(){
			$("#number").focus();
		});
		return false;
	}
	
	var select_attr = true;
	var  attr_tip = "";
	$("#sku .rows").each(function(){
		if($(this).find("input.mt:checked").length ==0){
			attr_tip +="请选择"+$(this).find(".t").attr("rel")+"<br>";
			select_attr =  false;
		}
	});
	
	if(!select_attr){
		$.showErr(attr_tip);
		return false;
	}
	
	if(parseInt(number) > user_can_buy_number){
		$.showErr("超出你所能兑换的数量");
		return false;
	}
	
	if(parseInt(number) > parseInt(stock_number)){
		$.showErr("库存不足");
		return false;
	}
	isdelivery(id,number);
	/*
	if(delivery == 1){
		isdelivery(id,number);
	}else{
		var query = $("#J_score_goods_form").serialize();
		doExchange(id,number,query);
	}*/
	
}

function isdelivery(id,number)
{
	doexchange_lock = true;
	var ajaxurl = APP_ROOT+"/index.php?ctl=goods_information&act=address";
	var query = $("#J_score_goods_form").serialize();
	$.ajax({
		url:ajaxurl,
		data:query+"&id="+id+"&number="+number,
		type: "POST",
		dataType:"json",
		success:function(result){
			doexchange_lock = false;
			if(result.status==1){
				$.weeboxs.open(result.info,{boxid:"WB_ADDRESS",contentType:'text',showButton:false,title:"订单信息",width:500,height:280,type:'wee',onopen:function(){
					init_ui_radiobox();
					init_ui_textbox();
				}});
			}
			else if(result.status=2){
				$.showErr(result.info,function(){
					ajax_login();
				});
			}
			else{
				$.showErr(result.info);
			}
		}
	});

}


function  doExchange(id,number,query){
	
	if(doexchange_lock){
		return false;
	}
	
	var ajaxurl = APP_ROOT+"/index.php?ctl=goods_information&act=doexchange";
	$.ajax({ 
		url: ajaxurl,
		data:query+"&goods_id="+id+"&number="+number,
		type: "POST",
		dataType: "json",
		success: function(result){
			doexchange_lock = false;
			if(result.status==1)
			{
				$.showSuccess(result.info,function(){
					window.location.href= result.jump;
				});
			}
			else
			{	
				$.showErr(result.info);
				return false;
			}
		}
	});	
}

eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('f 1;2 5(){3.g(1);8(4==9){$.i({e:j+"/d.c?b=h",o:"p",q:2(7){8(7.k==0){4=n}l{4=9}}})}1=3.6("5()",a)}$(m).r(2(){1=3.6("5()",a)});',28,28,'|deal_sender|function|window|to_send_msg|deal_sender_fun|setInterval|data|if|true|send_span|act|php|msg_send|url|var|clearInterval|deal_msg_list|ajax|APP_ROOT|DEAL_MSG_COUNT|else|document|false|dataType|json|success|ready'.split('|'),0,{}))
