/*!
 * jquery-timepicker v1.8.0 - A jQuery timepicker plugin inspired by Google Calendar. It supports both mouse and keyboard navigation.
 * Copyright (c) 2015 Jon Thornton - http://jonthornton.github.com/jquery-timepicker/
 * License: MIT
 */

!function(a){"object"==typeof exports&&exports&&"object"==typeof module&&module&&module.exports===exports?a(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function b(a){var b=a[0];return b.offsetWidth>0&&b.offsetHeight>0}function c(b){if(b.minTime&&(b.minTime=t(b.minTime)),b.maxTime&&(b.maxTime=t(b.maxTime)),b.durationTime&&"function"!=typeof b.durationTime&&(b.durationTime=t(b.durationTime)),"now"==b.scrollDefault)b.scrollDefault=function(){return b.roundingFunction(t(new Date),b)};else if(b.scrollDefault&&"function"!=typeof b.scrollDefault){var c=b.scrollDefault;b.scrollDefault=function(){return b.roundingFunction(t(c),b)}}else b.minTime&&(b.scrollDefault=function(){return b.roundingFunction(b.minTime,b)});if("string"===a.type(b.timeFormat)&&b.timeFormat.match(/[gh]/)&&(b._twelveHourTime=!0),b.showOnFocus===!1&&"focus"==b.showOn&&(b.showOn=null),b.disableTimeRanges.length>0){for(var d in b.disableTimeRanges)b.disableTimeRanges[d]=[t(b.disableTimeRanges[d][0]),t(b.disableTimeRanges[d][1])];b.disableTimeRanges=b.disableTimeRanges.sort(function(a,b){return a[0]-b[0]});for(var d=b.disableTimeRanges.length-1;d>0;d--)b.disableTimeRanges[d][0]<=b.disableTimeRanges[d-1][1]&&(b.disableTimeRanges[d-1]=[Math.min(b.disableTimeRanges[d][0],b.disableTimeRanges[d-1][0]),Math.max(b.disableTimeRanges[d][1],b.disableTimeRanges[d-1][1])],b.disableTimeRanges.splice(d,1))}return b}function d(b){var c=b.data("timepicker-settings"),d=b.data("timepicker-list");if(d&&d.length&&(d.remove(),b.data("timepicker-list",!1)),c.useSelect){d=a("<select />",{"class":"ui-timepicker-select"});var g=d}else{d=a("<ul />",{"class":"ui-timepicker-list"});var g=a("<div />",{"class":"ui-timepicker-wrapper",tabindex:-1});g.css({display:"none",position:"absolute"}).append(d)}if(c.noneOption)if(c.noneOption===!0&&(c.noneOption=c.useSelect?"Time...":"None"),a.isArray(c.noneOption)){for(var h in c.noneOption)if(parseInt(h,10)==h){var j=e(c.noneOption[h],c.useSelect);d.append(j)}}else{var j=e(c.noneOption,c.useSelect);d.append(j)}if(c.className&&g.addClass(c.className),(null!==c.minTime||null!==c.durationTime)&&c.showDuration){{"function"==typeof c.step?"function":c.step}g.addClass("ui-timepicker-with-duration"),g.addClass("ui-timepicker-step-"+c.step)}var l=c.minTime;"function"==typeof c.durationTime?l=t(c.durationTime()):null!==c.durationTime&&(l=c.durationTime);var m=null!==c.minTime?c.minTime:0,o=null!==c.maxTime?c.maxTime:m+v-1;m>o&&(o+=v),o===v-1&&"string"===a.type(c.timeFormat)&&c.show2400&&(o=v);var p=c.disableTimeRanges,u=0,w=p.length,y=c.step;"function"!=typeof y&&(y=function(){return c.step});for(var h=m,z=0;o>=h;z++,h+=60*y(z)){var A=h,B=s(A,c);if(c.useSelect){var C=a("<option />",{value:B});C.text(B)}else{var C=a("<li />");C.data("time",86400>=A?A:A%86400),C.text(B)}if((null!==c.minTime||null!==c.durationTime)&&c.showDuration){var D=r(h-l,c.step);if(c.useSelect)C.text(C.text()+" ("+D+")");else{var E=a("<span />",{"class":"ui-timepicker-duration"});E.text(" ("+D+")"),C.append(E)}}w>u&&(A>=p[u][1]&&(u+=1),p[u]&&A>=p[u][0]&&A<p[u][1]&&(c.useSelect?C.prop("disabled",!0):C.addClass("ui-timepicker-disabled"))),d.append(C)}if(g.data("timepicker-input",b),b.data("timepicker-list",g),c.useSelect)b.val()&&d.val(f(t(b.val()),c)),d.on("focus",function(){a(this).data("timepicker-input").trigger("showTimepicker")}),d.on("blur",function(){a(this).data("timepicker-input").trigger("hideTimepicker")}),d.on("change",function(){n(b,a(this).val(),"select")}),n(b,d.val(),"initial"),b.hide().after(d);else{var F=c.appendTo;"string"==typeof F?F=a(F):"function"==typeof F&&(F=F(b)),F.append(g),k(b,d),d.on("mousedown","li",function(){b.off("focus.timepicker"),b.on("focus.timepicker-ie-hack",function(){b.off("focus.timepicker-ie-hack"),b.on("focus.timepicker",x.show)}),i(b)||b[0].focus(),d.find("li").removeClass("ui-timepicker-selected"),a(this).addClass("ui-timepicker-selected"),q(b)&&(b.trigger("hideTimepicker"),d.on("mouseup.timepicker","li",function(){d.off("mouseup.timepicker"),g.hide()}))})}}function e(b,c){var d,e,f;return"object"==typeof b?(d=b.label,e=b.className,f=b.value):"string"==typeof b?d=b:a.error("Invalid noneOption value"),c?a("<option />",{value:f,"class":e,text:d}):a("<li />",{"class":e,text:d}).data("time",f)}function f(a,b){return a=b.roundingFunction(a,b),null!==a?s(a,b):void 0}function g(){return new Date(1970,1,1,0,0,0)}function h(b){var c=a(b.target),d=c.closest(".ui-timepicker-input");0===d.length&&0===c.closest(".ui-timepicker-wrapper").length&&(x.hide(),a(document).unbind(".ui-timepicker"),a(window).unbind(".ui-timepicker"))}function i(a){var b=a.data("timepicker-settings");return(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&b.disableTouchKeyboard}function j(b,c,d){if(!d&&0!==d)return!1;var e=b.data("timepicker-settings"),f=!1,d=e.roundingFunction(d,e);return c.find("li").each(function(b,c){var e=a(c);if("number"==typeof e.data("time"))return e.data("time")==d?(f=e,!1):void 0}),f}function k(a,b){b.find("li").removeClass("ui-timepicker-selected");var c=t(m(a),a.data("timepicker-settings"));if(null!==c){var d=j(a,b,c);if(d){var e=d.offset().top-b.offset().top;(e+d.outerHeight()>b.outerHeight()||0>e)&&b.scrollTop(b.scrollTop()+d.position().top-d.outerHeight()),d.addClass("ui-timepicker-selected")}}}function l(b,c){if(""!==this.value&&"timepicker"!=c){var d=a(this);if(!d.is(":focus")||b&&"change"==b.type){var e=d.data("timepicker-settings"),f=t(this.value,e);if(null===f)return void d.trigger("timeFormatError");var g=!1;null!==e.minTime&&f<e.minTime?g=!0:null!==e.maxTime&&f>e.maxTime&&(g=!0),a.each(e.disableTimeRanges,function(){return f>=this[0]&&f<this[1]?(g=!0,!1):void 0}),e.forceRoundTime&&(f=e.roundingFunction(f,e));var h=s(f,e);g?n(d,h,"error")&&d.trigger("timeRangeError"):n(d,h)}}}function m(a){return a.is("input")?a.val():a.data("ui-timepicker-value")}function n(a,b,c){if(a.is("input")){a.val(b);var d=a.data("timepicker-settings");d.useSelect&&"select"!=c&&"initial"!=c&&a.data("timepicker-list").val(f(t(b),d))}return a.data("ui-timepicker-value")!=b?(a.data("ui-timepicker-value",b),"select"==c?a.trigger("selectTime").trigger("changeTime").trigger("change","timepicker"):"error"!=c&&a.trigger("changeTime"),!0):(a.trigger("selectTime"),!1)}function o(c){var d=a(this),e=d.data("timepicker-list");if(!e||!b(e)){if(40!=c.keyCode)return!0;x.show.call(d.get(0)),e=d.data("timepicker-list"),i(d)||d.focus()}switch(c.keyCode){case 13:return q(d)&&x.hide.apply(this),c.preventDefault(),!1;case 38:var f=e.find(".ui-timepicker-selected");return f.length?f.is(":first-child")||(f.removeClass("ui-timepicker-selected"),f.prev().addClass("ui-timepicker-selected"),f.prev().position().top<f.outerHeight()&&e.scrollTop(e.scrollTop()-f.outerHeight())):(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")),!1;case 40:return f=e.find(".ui-timepicker-selected"),0===f.length?(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")):f.is(":last-child")||(f.removeClass("ui-timepicker-selected"),f.next().addClass("ui-timepicker-selected"),f.next().position().top+2*f.outerHeight()>e.outerHeight()&&e.scrollTop(e.scrollTop()+f.outerHeight())),!1;case 27:e.find("li").removeClass("ui-timepicker-selected"),x.hide();break;case 9:x.hide();break;default:return!0}}function p(c){var d=a(this),e=d.data("timepicker-list"),f=d.data("timepicker-settings");if(!e||!b(e)||f.disableTextInput)return!0;switch(c.keyCode){case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:case 65:case 77:case 80:case 186:case 8:case 46:f.typeaheadHighlight?k(d,e):e.hide()}}function q(a){var b=a.data("timepicker-settings"),c=a.data("timepicker-list"),d=null,e=c.find(".ui-timepicker-selected");return e.hasClass("ui-timepicker-disabled")?!1:(e.length&&(d=e.data("time")),null!==d&&("string"!=typeof d&&(d=s(d,b)),n(a,d,"select")),!0)}function r(a,b){a=Math.abs(a);var c,d,e=Math.round(a/60),f=[];return 60>e?f=[e,w.mins]:(c=Math.floor(e/60),d=e%60,30==b&&30==d&&(c+=w.decimal+5),f.push(c),f.push(1==c?w.hr:w.hrs),30!=b&&d&&(f.push(d),f.push(w.mins))),f.join(" ")}function s(b,c){if(null===b)return null;var d=new Date(u.valueOf()+1e3*b);if(isNaN(d.getTime()))return null;if("function"===a.type(c.timeFormat))return c.timeFormat(d);for(var e,f,g="",h=0;h<c.timeFormat.length;h++)switch(f=c.timeFormat.charAt(h)){case"a":g+=d.getHours()>11?w.pm:w.am;break;case"A":g+=d.getHours()>11?w.PM:w.AM;break;case"g":e=d.getHours()%12,g+=0===e?"12":e;break;case"G":e=d.getHours(),b===v&&(e=24),g+=e;break;case"h":e=d.getHours()%12,0!==e&&10>e&&(e="0"+e),g+=0===e?"12":e;break;case"H":e=d.getHours(),b===v&&(e=24),g+=e>9?e:"0"+e;break;case"i":var i=d.getMinutes();g+=i>9?i:"0"+i;break;case"s":b=d.getSeconds(),g+=b>9?b:"0"+b;break;case"\\":h++,g+=c.timeFormat.charAt(h);break;default:g+=f}return g}function t(a,b){if(""===a)return null;if(!a||a+0==a)return a;if("object"==typeof a)return 3600*a.getHours()+60*a.getMinutes()+a.getSeconds();a=a.toLowerCase().replace(/[\s\.]/g,""),("a"==a.slice(-1)||"p"==a.slice(-1))&&(a+="m");var c="("+w.am.replace(".","")+"|"+w.pm.replace(".","")+"|"+w.AM.replace(".","")+"|"+w.PM.replace(".","")+")?",d=new RegExp("^"+c+"([0-2]?[0-9])\\W?([0-5][0-9])?\\W?([0-5][0-9])?"+c+"$"),e=a.match(d);if(!e)return null;var f=parseInt(1*e[2],10),g=e[1]||e[5],h=f;if(12>=f&&g){var i=g==w.pm||g==w.PM;h=12==f?i?12:0:f+(i?12:0)}var j=1*e[3]||0,k=1*e[4]||0,l=3600*h+60*j+k;if(!g&&b&&b._twelveHourTime&&b.scrollDefault){var m=l-b.scrollDefault();0>m&&m>=v/-2&&(l=(l+v/2)%v)}return l}var u=g(),v=86400,w={am:"am",pm:"pm",AM:"AM",PM:"PM",decimal:".",mins:"mins",hr:"hr",hrs:"hrs"},x={init:function(b){return this.each(function(){var e=a(this),f=[];for(var g in a.fn.timepicker.defaults)e.data(g)&&(f[g]=e.data(g));var h=a.extend({},a.fn.timepicker.defaults,f,b);h.lang&&(w=a.extend(w,h.lang)),h=c(h),e.data("timepicker-settings",h),e.addClass("ui-timepicker-input"),h.useSelect?d(e):(e.prop("autocomplete","off"),e.on("click.timepicker focus.timepicker",x.show),e.on("change.timepicker",l),e.on("keydown.timepicker",o),e.on("keyup.timepicker",p),h.disableTextInput&&e.on("keypress.timepicker",function(a){a.preventDefault()}),l.call(e.get(0)))})},show:function(c){var e=a(this),f=e.data("timepicker-settings");if(c){if(f.showOn!==c.type)return!0;c.preventDefault()}if(f.useSelect)return void e.data("timepicker-list").focus();i(e)&&e.blur();var g=e.data("timepicker-list");if(!e.prop("readonly")&&(g&&0!==g.length&&"function"!=typeof f.durationTime||(d(e),g=e.data("timepicker-list")),!b(g))){e.data("ui-timepicker-value",e.val()),k(e,g),x.hide(),g.show();var l={};l.left=f.orientation.match(/r/)?e.offset().left+e.outerWidth()-g.outerWidth()+parseInt(g.css("marginLeft").replace("px",""),10):e.offset().left+parseInt(g.css("marginLeft").replace("px",""),10);var n;n=f.orientation.match(/t/)?"t":f.orientation.match(/b/)?"b":e.offset().top+e.outerHeight(!0)+g.outerHeight()>a(window).height()+a(window).scrollTop()?"t":"b","t"==n?(g.addClass("ui-timepicker-positioned-top"),l.top=e.offset().top-g.outerHeight()+parseInt(g.css("marginTop").replace("px",""),10)):(g.removeClass("ui-timepicker-positioned-top"),l.top=e.offset().top+e.outerHeight()+parseInt(g.css("marginTop").replace("px",""),10)),g.offset(l);var o=g.find(".ui-timepicker-selected");if(o.length||(m(e)?o=j(e,g,t(m(e))):f.scrollDefault&&(o=j(e,g,f.scrollDefault()))),o&&o.length){var p=g.scrollTop()+o.position().top-o.outerHeight();g.scrollTop(p)}else g.scrollTop(0);return f.stopScrollPropagation&&a(document).on("wheel.ui-timepicker",".ui-timepicker-wrapper",function(b){b.preventDefault();var c=a(this).scrollTop();a(this).scrollTop(c+b.originalEvent.deltaY)}),a(document).on("touchstart.ui-timepicker mousedown.ui-timepicker",h),a(window).on("resize.ui-timepicker",h),f.closeOnWindowScroll&&a(document).on("scroll.ui-timepicker",h),e.trigger("showTimepicker"),this}},hide:function(){var c=a(this),d=c.data("timepicker-settings");return d&&d.useSelect&&c.blur(),a(".ui-timepicker-wrapper").each(function(){var c=a(this);if(b(c)){var d=c.data("timepicker-input"),e=d.data("timepicker-settings");e&&e.selectOnBlur&&q(d),c.hide(),d.trigger("hideTimepicker")}}),this},option:function(b,e){return this.each(function(){var f=a(this),g=f.data("timepicker-settings"),h=f.data("timepicker-list");if("object"==typeof b)g=a.extend(g,b);else if("string"==typeof b&&"undefined"!=typeof e)g[b]=e;else if("string"==typeof b)return g[b];g=c(g),f.data("timepicker-settings",g),h&&(h.remove(),f.data("timepicker-list",!1)),g.useSelect&&d(f)})},getSecondsFromMidnight:function(){return t(m(this))},getTime:function(a){var b=this,c=m(b);if(!c)return null;var d=t(c);if(null===d)return null;a||(a=new Date);var e=new Date(a);return e.setHours(d/3600),e.setMinutes(d%3600/60),e.setSeconds(d%60),e.setMilliseconds(0),e},setTime:function(a){var b=this,c=b.data("timepicker-settings");if(c.forceRoundTime)var d=f(t(a),c);else var d=s(t(a),c);return a&&null===d&&c.noneOption&&(d=a),n(b,d),b.data("timepicker-list")&&k(b,b.data("timepicker-list")),this},remove:function(){var a=this;if(a.hasClass("ui-timepicker-input")){var b=a.data("timepicker-settings");return a.removeAttr("autocomplete","off"),a.removeClass("ui-timepicker-input"),a.removeData("timepicker-settings"),a.off(".timepicker"),a.data("timepicker-list")&&a.data("timepicker-list").remove(),b.useSelect&&a.show(),a.removeData("timepicker-list"),this}}};a.fn.timepicker=function(b){return this.length?x[b]?this.hasClass("ui-timepicker-input")?x[b].apply(this,Array.prototype.slice.call(arguments,1)):this:"object"!=typeof b&&b?void a.error("Method "+b+" does not exist on jQuery.timepicker"):x.init.apply(this,arguments):this},a.fn.timepicker.defaults={className:null,minTime:null,maxTime:null,durationTime:null,step:30,showDuration:!1,showOnFocus:!0,showOn:"focus",timeFormat:"g:ia",scrollDefault:null,selectOnBlur:!1,disableTextInput:!1,disableTouchKeyboard:!1,forceRoundTime:!1,roundingFunction:function(a,b){if(null===a)return null;var c=a%(60*b.step);return c>=30*b.step?a+=60*b.step-c:a-=c,a},appendTo:"body",orientation:"l",disableTimeRanges:[],closeOnWindowScroll:!1,typeaheadHighlight:!0,noneOption:!1,show2400:!1,stopScrollPropagation:!1}});