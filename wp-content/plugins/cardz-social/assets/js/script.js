/*
 *	CardZ Social Stream v1.0.52
 *
 *	Copyright (c) 2015 By Agapa Studio.All rights reserved.
 */
(function(b,e,c){b.ss_client={version:"0.0.1"}})(window,jQuery);
(function(b,e,c){ss_client.Analytics=function(){function e(a){a!==c&&null!==a&&a instanceof Date||(a=new Date);return a.toISOString().slice(0,19).replace("T"," ")}var a={};this.add_item=function(b,d,c){a.hasOwnProperty(d)||(a[d]={views:0,clicks:0,conversions:0,conversion_rate:0,start_time:null,close_time:null});"show"===b?(a[d].views++,a[d].start_time=e()):"hide"===b?a[d].close_time=e():"click"===b?(a[d].clicks++,a[d].conversions++,a[d].conversion_rate+=.01):a[d][b]=c};this.send=function(){b.ajax({method:"GET",
url:ss_urls.ajaxurl,async:!1,data:{action:"ss_analytics_add",data:a}})}}})(jQuery,window);jQuery(function(b){var e=new ss_client.Analytics,c=b(".cardz-social");0<c.length&&c.each(function(){e.add_item("show",b(this).data("ss-name"))});b(document).on("click",".cardz-social",function(c){e.add_item("click",b(this).data("ss-name"))});b(window).unload(function(){0<c.length&&c.each(function(){e.add_item("hide",b(this).data("ss-name"))});e.send()})});
