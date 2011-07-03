/**
 * jQuery.Intercept - Event Delegation with jQuery 
 * Copyright (c) 2007-2008 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 3/9/2008
 * @author Ariel Flesler
 * @version 1.1.2
 **/
;(function($){var f='intercept',g='.'+f,j=$[f]=function(a,b,c){$('html').intercept(a,b,c)};$.fn.intercept=function(b,c,d){var e,f,h;if(d){e={};e[c]=d;c=e}return this.each(function(){f=this;$.each(b.split(' '),function(i,a){h=$.data(f,a+g);if(!h){$.data(f,a+g,$.extend({},c));$.event.add(f,a,j.handle)}else $.extend(h,c)})})};j.absolute=/[\s>+~]/;j.handle=function(e){var a=$.data(this,e.type+g),b=e.target,c=$(b),d,f;if(!a)return;for(d in a){if(d=='self'&&b==this||j.absolute.test(d)?$(d).index(b)!=-1:c.is(d))f=a[d].apply(b,arguments)!==false&&f}return f}})(jQuery);