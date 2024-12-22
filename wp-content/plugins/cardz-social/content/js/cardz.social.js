/*
 *	jQuery CardZ Social v1.0.17
 *
 *	http://www.agapastudio.com/
 *
 *	Copyright (c) 2015 By Agapa Studio.All rights reserved.
 *
 *	License:
 *		http://www.agapastudio.com/licenses/cardz-social
 */
(function (window, document, undefined)
{
	'use strict';

var speedo = function ()
{
	return new speedo.fn.init();
};

speedo.fn = speedo.prototype =
{
	version: '1.3.14',
	constructor: speedo,
	init: function ()
	{
		return this;
	}
};

// Prepare for later instantiation.
speedo.fn.init.prototype = speedo.fn;

speedo.fn.browser = (function ()
{
	var browser = {};

	/**
	 *	Holds the version of the browser.
	 *
	 *	@param string version The version string.
	 */
	var Version = function (version)
	{
		this.version = version;
		this.high = parseInt(version, 10);
	};

	Version.prototype.toString = function ()
	{
		return this.version;
	};

	/**
	 *	Update the data in the browser object.
	 */
	browser.update = function ()
	{
		var user_agent = navigator.userAgent;
		var browsers = ['msie', 'opera', 'chrome', 'safari', 'firefox'];
		var matches = null;
		var browsers_count = browsers.length;

		for (var i = 0; i < browsers_count; i++)
		{
			matches = user_agent.match(new RegExp(browsers[i], 'i'));

			browser['is_' + browsers[i]] = (matches !== null);
		}

		// Add is_ie for backword compatibility.
		browser.is_ie = browser.is_msie;

		// Get the version. of the browser.
		matches = user_agent.match(new RegExp('(' + browsers.join('|') + ')[\\/\\s]*?([\\.\\d]+)', 'i'));

		var temp = null;

		if (matches && (temp = user_agent.match(/version\/([\.\d]+)/i)) != null)
		{
			matches[2] = temp[1];
		}

		matches = (matches) ? matches[2] : navigator.appVersion;

		browser.version = new Version(matches);
	};

	browser.update();

	return browser;
})();

speedo.fn.utility = (function ($)
{
	var self = {};
	var virtualElement = document.createElement('div');

	self.vendors = ['webkit', 'Moz', 'O', 'ms'];

	self.vendor = '';

	// Get the vendor for the current browser.
	for (var i = 0; i < self.vendors.length; i++)
	{
		var vendor = self.vendors[i];

		if ((vendor + 'Transition') in virtualElement.style)
		{
			self.vendor = vendor;
			self.cssVendor = '-' + vendor.toLowerCase() + '-';
		}
	}
		
	/**
	 *	For jQuery Older than 1.8 make the css() add vendor prefix if needed.
	 */
	(function ()
	{
		if (Number($.fn.jquery.replace(/[a-zA-Z\.]/g, '')) >= 180)
		{
			return ;
		}

		if (speedo().browser.is_ie && speedo().browser.version.high < 9)
		{
			return ;
		}

		var style = document.createElement('div').style;

		var replace_vendor = function (vendor)
		{
			return key.replace(vendor, '').replace(/^[A-Z]/g, function($0) {return $0.toLowerCase(); });
		};

		var hook_key = function (key)
		{
			$.cssHooks[newKey] = {
				get: function (/*el*/)
				{
					//console.log(key);
					//return $.css(el, key);
				},
				set: function (el, value)
				{
					el.style[key] = value;
					//$(el).css(key, value);
				}
			};
		};

		for (var key in style)
		{
			if (~key.indexOf(self.vendor))
			{
				var newKey = replace_vendor(self.vendor);
					
				hook_key(key);
			}
		}

	})();

	/**
	 *	Create and set cookie.
	 *
	 *	@param string name		The cookie name.
	 *	@param string value		The cookie value.
	 *	@param int expire_days	The expiration data of the cookie in days.
	 */
	self.set_cookie = function (name, value, expire_days)
	{
		var date = new Date();

		date.setDate(date.getDate() + expire_days);

		value = escape(value) + ((expire_days === null) ? '' : '; expires='+date.toUTCString());

		document.cookie = name + '=' + value;
	};

	/**
	 *	Geat a cookie.
	 *
	 *	@param string name	The cookie name.
	 *
	 *	@return string	Returns the value of the cookie on success, NULL on failure.
	 */
	self.get_cookie = function (name)
	{
		var cookies = document.cookie.split(';');
		var cookie = [];

		for (var i = 0; i < cookies.length; i++)
		{
			cookie = cookies[i].split('=');

			if (cookie[0].replace(/^\s+|\s+$/g, '') === name)
			{
				return unescape(cookie[1]);
			}
		}

		return null;
	};

	/**
	 *	Remove cookie.
	 *
	 *	@param string name	The cookie name.
	 */
	self.remove_cookie = function (name)
	{
		self.set_cookie(name, '', -10);
	};

	/**
	 *	Read query url paramters.
	 *
	 *	@param string url	The URL.
	 *
	 *	@return object	An object with name and value on success, empty object on failed.
	 */
	self.query_parameters = function (url)
	{
		url = (typeof(url) !== 'string') ? String(url) : url;
		url = url.split('?')[1];

		var params = {};
		var regex = /[?&]?([^=]+)=([^&]*)/g;
		var tokens;

		while (tokens = regex.exec(url))
		{
			params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
		}

		return params;
	};

	/**
	 *	Check if the URLs are from the same domain.
	 *
	 *	@param string url_a	First URL.
	 *	@param string url_b	Second URL.
	 *
	 *	@return Returns true if the URL is on same domain, otherwise retruns false.
	 */
	self.same_domain = function (url_a, url_b)
	{
		var regex = /^(https?:\/\/)?([\da-z\.-]+)\/?/;
		url_a = url_a.match(regex);
		url_b = url_b.match(regex);

		return (url_a[2] !== undefined && url_b[2] !== undefined && url_a[2].toLowerCase() === url_b[2].toLowerCase());
	};

	/**
	 *	Get the size of the HTML content.
	 *
	 *	@param object|string content	The content.
	 *
	 *	@param object	Returns an JSON object of the following form:
	 *						{width: 100, height: 100}
	 */
	self.get_content_size = function (content)
	{
		var temp_element = $('<div style="position: absolute; visibility: hidden"></div>').append(content);
			
		$('body').append(temp_element);

		var result = {width: temp_element.width(), height: temp_element.height()};

		temp_element.remove();

		return result;
	};

	/**
	 *	Compare 2 string versions.
	 *
	 *	@param string version_a	First string version.
	 *	@param string version_b	Second string version.
	 *	@param string operator	Compare operator.
	 *
	 *	@return bool Tru, false.
	 */
	self.compare_versions = function (version_a, version_b, operator)
	{
		var length = 0, compare=0,
			vm={
				'dev': -6,
				'alpha': -5,
				'a': -5,
				'beta': -4,
				'b': -4,
				'RC': -3,
				'rc': -3,
				'#': -2,
				'p': 1,
				'pl': 1
			},
			prepVersion = function(v)
			{
				v = (''+v).replace(/[_\-+]/g,'.');
				v = v.replace(/([^.\d]+)/g,'.$1.').replace(/\.{2,}/g,'.');
				return (!v.length?[-8]:v.split('.'));
			},
			numVersion=function(v)
			{
				return !v?0:(isNaN(v)?vm[v]||-7:parseInt(v,10));
			};

		version_a = prepVersion(version_a);
		version_b = prepVersion(version_b);

		length = Math.max(version_a.length, version_b.length);

		for (var i = 0; i < length; i++)
		{
			if (version_a[i] === version_b[i])
			{
				continue;
			}

			version_a[i] = numVersion(version_a[i]);
			version_b[i] = numVersion(version_b[i]);

			if (version_a[i] < version_b[i])
			{
				compare=-1;
				break;
			}
			else if (version_a[i] > version_b[i])
			{
				compare=1;
				break;
			}
		}

		if (!operator)
		{
			return compare;
		}

		switch (operator)
		{
			case '>':
			case 'gt':
				return (compare > 0);
			case '>=':
			case 'ge':
				return (compare >= 0);
			case '<=':
			case 'le':
				return (compare <= 0);
			case '==':
			case '=':
			case 'eq':
				return (compare === 0);
			case '<>':
			case '!=':
			case 'ne':
				return (compare !== 0);
			case '':
			case '<':
			case 'lt':
				return (compare < 0);
			default:
				return null;
		}
	};

	/**
	 *	Get the percentage from two values.
	 */
	self.percent = function (a, b)
	{
		return a / b * 100;
	};

	/**
	 *	Get a specific percentage from a value.
	 */
	self.from_percent = function (a, b)
	{
		return a / 100 * b;
	};

	/**
	 *	Resize all childrens of an element to specific percentage.
	 *
	 *	This function doesn't handle the CSS3 transform.
	 *
	 *	@param object parent_el	The parent element from which we want to resize all childrens.
	 *	@param number percent	The percentage to which we want to resize the elements.
	 *	@param bool position	[optional] Whether to change the position or not. Default is true.
	 */
	self.proportional_resize = function (parent_el, percent, position)
	{
		var childElements = parent_el.children();
		var textElements = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'a'];

		position = (position === undefined) ? true : position;

		childElements.each(function ()
		{
			var $this = $(this);
			var tagName = this.tagName.toLowerCase();

			if (position)
			{
				/*
					*	Note: This will not handle the translated position.
					*/
				var currentPosition = {top: parseInt($this.css('top')), left: parseInt($this.css('left'))};
				var originalPosition = $this.data('originalPosition') || ($this.data('originalPosition', currentPosition), currentPosition);
				var top = self.fromPercent(originalPosition.top, percent);
				var left = self.fromPercent(originalPosition.left, percent);

				/*if (~$this.get(0).style.webkitTransform.indexOf('translate3d'))
				{
					var mtc = $this.get(0).style.webkitTransform.match(/translate3d\((.*)\)/i);
					var originalTransform = $this.data('originalTransform') || ($this.data('originalTransform', mtc), mtc);

					var data = originalTransform[1].split(', ');

					for (var i = 0; i < data.length; i++)
					{
						data[i] = self.fromPercent(parseInt(data[i]), percent) + 'px';
					}

					$this.css('transform', $this.get(0).style.webkitTransform.replace(/translate3d\((.*)\)/i, 'translate3d(' + data.join(', ') + ')'));
				}*/

				$this.css({top: top, left: left});
			}

			// We use the inArray function because IE8 doesn't have Array.indexOf().
			if (~$.inArray(tagName, textElements))
			{
				/*
					*	For text elements we need to change its font size and not its font size and
					*	the width and height only if the element has the display to block.
					*/
				var originalSize = $this.data('originalSize') || ($this.data('originalSize', $this.css('font-size')), $this.css('font-size'));
				var fontSize = self.fromPercent(parseInt(originalSize), percent);

				$this.css('font-size', fontSize);

				//if ($this.css('display') != 'block' && $this.css('display') != 'inline-block')
				{
					return ;
				}
			}

			/*
				*	For any other elements we need to change width and height, but not the font size.
				*	Also, we need to calculate the size in pixels and not in percent, because, the
				*	percent value will be relative to the parent size and not to the element's last size.
				*/

			// Get the original width and height and if necessarly set them.
			var originalWidth = $this.data('originalWidth') || ($this.data('originalWidth', $this.width()), $this.width());
			var originalHeight = $this.data('originalHeight') || ($this.data('originalHeight', $this.height()), $this.height());

			var width = self.fromPercent(originalWidth, percent);
			var height = self.fromPercent(originalHeight, percent);
					
			$this.width(width);
			$this.height(height);
		});
	};

	/*
	 *	Handle deprecated functions.
	 */
	self.getContentSize = self.get_content_size;
	self.compareVersions = self.compare_versions;
	self.fromPercent = self.from_percent;
	self.proportionalResize = self.proportional_resize;

	return self;

})(jQuery);

speedo.fn.template = (function ($)
{
	var self = {};

	var delimiters_stack = {};

	/**
	 *	Register template delimiters.
	 *
	 *	If the name already exists, the delimiters will be replaced.
	 *
	 *	@param string name Delimiters name.
	 *	@param string start Start delimiter.
	 *	@param string end End delimiter.
	 */
	self.register_delimiters = function (name, start, end)
	{
		// Generate RegExp patterns.
		var pattern = '([\\s\\S]+?)';
		var start_esc = start.replace(/(.)/g, '\\$1');
		var end_esc = end.replace(/(.)/g, '\\$1');
		var patterns = 
		{
			evaluate: new RegExp(start_esc + pattern + end_esc, 'g'),
			interpolate: new RegExp(start_esc + '=' + pattern + end_esc, 'g'),
			escape: new RegExp(start_esc + '-' + pattern + end_esc, 'g'),
            /*
             *  Evaluate condition of the form '{{? true }} .... {{? end img }}'.
             *  This assumes that the delimiters are '{{' and '}}'.
             */
            condition: new RegExp(start_esc + '\\?([a-zA-Z0-9]*?)\\s([\\s\\S]+?)' + end_esc + '([\\s\\S]+?)' + start_esc + '\\? end \\1\\s*' + end_esc, 'g')
		};

		delimiters_stack[name] = {start: start, end: end, patterns: patterns};
	};

	/**
	 *	Process template.
	 *
	 *	@param string content The template to process.
	 *	@param object options Template options
	 *	{
	 *		@type object scope The data available to the template for replacing.
	 *		@type string delimiters The delimiters name.
	 *	}
	 *
	 *	@return string Returns the template after it has been processed.
	 */
	self.process = function (content, options)
	{
		options = $.extend(
		{
			scope: {},
			delimiters: 'default'
		}, options);

		var delimiters = delimiters_stack[(options.delimiters in delimiters_stack) ? options.delimiters : 'default'];

		try
		{
			content = content.replace(delimiters.patterns.interpolate, function ($0, expression)
			{
				return self.interpolate(expression, options.scope);
			});

            content = content.replace(delimiters.patterns.condition, function ($0, $1, expression, data)
			{
				return self.evaluate_condition(expression, data, options.scope);
			});

			content = content.replace(delimiters.patterns.evaluate, function ($0, expression)
			{
				try
				{
					return self.evaluate(expression, options.scope);
				}
				catch (ex)
				{
				}

				return '';
			});
		}
		catch (ex)
		{
			
		}

		return content;
	};

	/**
	 *	Evaluate allowed expressions.
	 *
	 *	@param string expression String expresion to evaluate.
	 *	@param object scope The available properties and functions.
	 *
	 *	@returns mixed The value of the computed expression or empty string.
	 */
	/*jshint -W054 */
	self.evaluate = function (expression, scope)
	{
		// Make math functions available.
		scope = $.extend(true, Math, scope);

		return new Function('scope', 'return ' + sanitize_expression(expression) + ';')(scope);
	};
	
	/**
	 *	Interpolate expression.
	 *
	 *	@param string expression String expresion to evaluate.
	 *	@param object scope The available properties and functions.
	 *
	 *	@returns mixed The value of the computed expression or empty string.
	 */
	/*jshint loopfunc: true */
	self.interpolate = function (expression, scope)
	{
		var expressions = expression.split('|');
		var value = '';

		for (var i = 0; i < expressions.length; i++)
		{
			expression = expressions[i].replace(/^\s|\s$/g, '');

			value = expression.replace(/([a-zA-Z_][a-zA-Z0-9_.]*)/g, function ($0, $1)
			{
				var props = $1.split('.');

				var last = scope;

				for (var i = 0; i < props.length; i++)
				{
					if (props[i] in last)
					{
						last = last[props[i]];
					}
					else
					{
						return '';
					}
				}

				return last;
			});

			if (value !== '')
			{
				return value;
			}
		}

		return value;
	};

    /**
	 *	Evaluate conditional expression.
	 *
	 *	@param string expression String expresion to evaluate.
     *  @param string data Data to be returned if the expression is true.
	 *	@param object scope The available properties and functions.
	 *
	 *	@returns mixed The value of the computed expression or empty string.
	 */
	/*jshint loopfunc: true */
    /*jshint -W054 */
	self.evaluate_condition = function (expression, data, scope)
	{
        if (new Function('scope', 'return (' + sanitize_expression(expression) + ');')(scope))
        {
            return data;
        }

        return '';
	};

	/**
	 *	Sanitize expression.
	 *
	 *	Note, this should not be considered a full proof function. We recommend to make sure
	 *	the expression doesn't come from a use input or similar.
	 *
	 *	@param string expression String expresion to evaluate.
	 *
	 *	@return True if the expression is safe, otherwise false.
	 */
	function sanitize_expression(expression)
	{
		var unallowed_words =
		[
			'__defineGetter__',
			'__defineSetter__',
			'__lookupGetter__',
			'__lookupSetter__',
			'__proto__'
		];
		var unallowed = new RegExp('scope.(' + unallowed_words.join('|') + ')', 'g');

		expression = expression.replace(/^\s|\s$/g, '');

		return expression.replace(/([a-zA-Z_][a-zA-Z0-9_.]*)/g, '$-scope-$.$1')
						 .replace(/(["'][\s\S]*?["'])/g, function ($0, $1)
		{
			return $1.replace(/\$-scope-\$\./g, '');
		}).replace(/\$-scope-\$/g, 'scope')
		  .replace(unallowed, '');
	}

	// Register default delimiters.
	self.register_delimiters('default', '{{', '}}');

	return self;
})(jQuery);


	// Copy all the attached plugin versions to the new speedo object.
	if (window.speedo !== undefined)
	{
		var old_instance = window.speedo(),
			ignore_list = ['browser', 'utility', 'init', 'constructor', 'version'];

		for (var sp_name in old_instance)
		{
			if (!~ignore_list.indexOf(sp_name))
			{
				speedo.fn[sp_name] = old_instance[sp_name];
			}
		}
	}

	/*
	 *	Make sure we don't add the speedo library twice.
	 */
	if (window.speedo === undefined || speedo().version.split('.').join('') < 121)
	{
		window.speedo = speedo;
	}
}(window, document));

(function (window, document, $, undefined)
{
	//'use strict';

/*!
 * Masonry PACKAGED v3.3.0
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

/**
 * Bridget makes jQuery widgets
 * v1.1.0
 * MIT license
 */

( function( window ) {



// -------------------------- utils -------------------------- //

var slice = Array.prototype.slice;

function noop() {}

// -------------------------- definition -------------------------- //

function defineBridget( $ ) {

// bail if no jQuery
if ( !$ ) {
  return;
}

// -------------------------- addOptionMethod -------------------------- //

/**
 * adds option method -> $().plugin('option', {...})
 * @param {Function} PluginClass - constructor class
 */
function addOptionMethod( PluginClass ) {
  // don't overwrite original option method
  if ( PluginClass.prototype.option ) {
    return;
  }

  // option setter
  PluginClass.prototype.option = function( opts ) {
    // bail out if not an object
    if ( !$.isPlainObject( opts ) ){
      return;
    }
    this.options = $.extend( true, this.options, opts );
  };
}

// -------------------------- plugin bridge -------------------------- //

// helper function for logging errors
// $.error breaks jQuery chaining
var logError = typeof console === 'undefined' ? noop :
  function( message ) {
    console.error( message );
  };

/**
 * jQuery plugin bridge, access methods like $elem.plugin('method')
 * @param {String} namespace - plugin name
 * @param {Function} PluginClass - constructor class
 */
function bridge( namespace, PluginClass ) {
  // add to jQuery fn namespace
  $.fn[ namespace ] = function( options ) {
    if ( typeof options === 'string' ) {
      // call plugin method when first argument is a string
      // get arguments for method
      var args = slice.call( arguments, 1 );

      for ( var i=0, len = this.length; i < len; i++ ) {
        var elem = this[i];
        var instance = $.data( elem, namespace );
        if ( !instance ) {
          logError( "cannot call methods on " + namespace + " prior to initialization; " +
            "attempted to call '" + options + "'" );
          continue;
        }
        if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
          logError( "no such method '" + options + "' for " + namespace + " instance" );
          continue;
        }

        // trigger method with arguments
        var returnValue = instance[ options ].apply( instance, args );

        // break look and return first value if provided
        if ( returnValue !== undefined ) {
          return returnValue;
        }
      }
      // return this if no return value
      return this;
    } else {
      return this.each( function() {
        var instance = $.data( this, namespace );
        if ( instance ) {
          // apply options & init
          instance.option( options );
          instance._init();
        } else {
          // initialize new instance
          instance = new PluginClass( this, options );
          $.data( this, namespace, instance );
        }
      });
    }
  };

}

// -------------------------- bridget -------------------------- //

/**
 * converts a Prototypical class into a proper jQuery plugin
 *   the class must have a ._init method
 * @param {String} namespace - plugin name, used in $().pluginName
 * @param {Function} PluginClass - constructor class
 */
$.bridget = function( namespace, PluginClass ) {
  addOptionMethod( PluginClass );
  bridge( namespace, PluginClass );
};

return $.bridget;

}

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'jquery-bridget/jquery.bridget',[ 'jquery' ], defineBridget );
} else if ( typeof exports === 'object' ) {
  defineBridget( require('jquery') );
} else {
  // get jquery from browser global
  defineBridget( window.jQuery );
}

})( window );

/*!
 * eventie v1.0.6
 * event binding helper
 *   eventie.bind( elem, 'click', myFn )
 *   eventie.unbind( elem, 'click', myFn )
 * MIT license
 */

/*jshint browser: true, undef: true, unused: true */
/*global define: false, module: false */

( function( window ) {



var docElem = document.documentElement;

var bind = function() {};

function getIEEvent( obj ) {
  var event = window.event;
  // add event.target
  event.target = event.target || event.srcElement || obj;
  return event;
}

if ( docElem.addEventListener ) {
  bind = function( obj, type, fn ) {
    obj.addEventListener( type, fn, false );
  };
} else if ( docElem.attachEvent ) {
  bind = function( obj, type, fn ) {
    obj[ type + fn ] = fn.handleEvent ?
      function() {
        var event = getIEEvent( obj );
        fn.handleEvent.call( fn, event );
      } :
      function() {
        var event = getIEEvent( obj );
        fn.call( obj, event );
      };
    obj.attachEvent( "on" + type, obj[ type + fn ] );
  };
}

var unbind = function() {};

if ( docElem.removeEventListener ) {
  unbind = function( obj, type, fn ) {
    obj.removeEventListener( type, fn, false );
  };
} else if ( docElem.detachEvent ) {
  unbind = function( obj, type, fn ) {
    obj.detachEvent( "on" + type, obj[ type + fn ] );
    try {
      delete obj[ type + fn ];
    } catch ( err ) {
      // can't delete window object properties
      obj[ type + fn ] = undefined;
    }
  };
}

var eventie = {
  bind: bind,
  unbind: unbind
};

// ----- module definition ----- //

if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'eventie/eventie',eventie );
} else if ( typeof exports === 'object' ) {
  // CommonJS
  module.exports = eventie;
} else {
  // browser global
  window.eventie = eventie;
}

})( window );

/*!
 * EventEmitter v4.2.11 - git.io/ee
 * Unlicense - http://unlicense.org/
 * Oliver Caldwell - http://oli.me.uk/
 * @preserve
 */

;(function () {
    

    /**
     * Class for managing events.
     * Can be extended to provide event functionality in other classes.
     *
     * @class EventEmitter Manages event registering and emitting.
     */
    function EventEmitter() {}

    // Shortcuts to improve speed and size
    var proto = EventEmitter.prototype;
    var exports = this;
    var originalGlobalValue = exports.EventEmitter;

    /**
     * Finds the index of the listener for the event in its storage array.
     *
     * @param {Function[]} listeners Array of listeners to search through.
     * @param {Function} listener Method to look for.
     * @return {Number} Index of the specified listener, -1 if not found
     * @api private
     */
    function indexOfListener(listeners, listener) {
        var i = listeners.length;
        while (i--) {
            if (listeners[i].listener === listener) {
                return i;
            }
        }

        return -1;
    }

    /**
     * Alias a method while keeping the context correct, to allow for overwriting of target method.
     *
     * @param {String} name The name of the target method.
     * @return {Function} The aliased method
     * @api private
     */
    function alias(name) {
        return function aliasClosure() {
            return this[name].apply(this, arguments);
        };
    }

    /**
     * Returns the listener array for the specified event.
     * Will initialise the event object and listener arrays if required.
     * Will return an object if you use a regex search. The object contains keys for each matched event. So /ba[rz]/ might return an object containing bar and baz. But only if you have either defined them with defineEvent or added some listeners to them.
     * Each property in the object response is an array of listener functions.
     *
     * @param {String|RegExp} evt Name of the event to return the listeners from.
     * @return {Function[]|Object} All listener functions for the event.
     */
    proto.getListeners = function getListeners(evt) {
        var events = this._getEvents();
        var response;
        var key;

        // Return a concatenated array of all matching events if
        // the selector is a regular expression.
        if (evt instanceof RegExp) {
            response = {};
            for (key in events) {
                if (events.hasOwnProperty(key) && evt.test(key)) {
                    response[key] = events[key];
                }
            }
        }
        else {
            response = events[evt] || (events[evt] = []);
        }

        return response;
    };

    /**
     * Takes a list of listener objects and flattens it into a list of listener functions.
     *
     * @param {Object[]} listeners Raw listener objects.
     * @return {Function[]} Just the listener functions.
     */
    proto.flattenListeners = function flattenListeners(listeners) {
        var flatListeners = [];
        var i;

        for (i = 0; i < listeners.length; i += 1) {
            flatListeners.push(listeners[i].listener);
        }

        return flatListeners;
    };

    /**
     * Fetches the requested listeners via getListeners but will always return the results inside an object. This is mainly for internal use but others may find it useful.
     *
     * @param {String|RegExp} evt Name of the event to return the listeners from.
     * @return {Object} All listener functions for an event in an object.
     */
    proto.getListenersAsObject = function getListenersAsObject(evt) {
        var listeners = this.getListeners(evt);
        var response;

        if (listeners instanceof Array) {
            response = {};
            response[evt] = listeners;
        }

        return response || listeners;
    };

    /**
     * Adds a listener function to the specified event.
     * The listener will not be added if it is a duplicate.
     * If the listener returns true then it will be removed after it is called.
     * If you pass a regular expression as the event name then the listener will be added to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to attach the listener to.
     * @param {Function} listener Method to be called when the event is emitted. If the function returns true then it will be removed after calling.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addListener = function addListener(evt, listener) {
        var listeners = this.getListenersAsObject(evt);
        var listenerIsWrapped = typeof listener === 'object';
        var key;

        for (key in listeners) {
            if (listeners.hasOwnProperty(key) && indexOfListener(listeners[key], listener) === -1) {
                listeners[key].push(listenerIsWrapped ? listener : {
                    listener: listener,
                    once: false
                });
            }
        }

        return this;
    };

    /**
     * Alias of addListener
     */
    proto.on = alias('addListener');

    /**
     * Semi-alias of addListener. It will add a listener that will be
     * automatically removed after its first execution.
     *
     * @param {String|RegExp} evt Name of the event to attach the listener to.
     * @param {Function} listener Method to be called when the event is emitted. If the function returns true then it will be removed after calling.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addOnceListener = function addOnceListener(evt, listener) {
        return this.addListener(evt, {
            listener: listener,
            once: true
        });
    };

    /**
     * Alias of addOnceListener.
     */
    proto.once = alias('addOnceListener');

    /**
     * Defines an event name. This is required if you want to use a regex to add a listener to multiple events at once. If you don't do this then how do you expect it to know what event to add to? Should it just add to every possible match for a regex? No. That is scary and bad.
     * You need to tell it what event names should be matched by a regex.
     *
     * @param {String} evt Name of the event to create.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.defineEvent = function defineEvent(evt) {
        this.getListeners(evt);
        return this;
    };

    /**
     * Uses defineEvent to define multiple events.
     *
     * @param {String[]} evts An array of event names to define.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.defineEvents = function defineEvents(evts) {
        for (var i = 0; i < evts.length; i += 1) {
            this.defineEvent(evts[i]);
        }
        return this;
    };

    /**
     * Removes a listener function from the specified event.
     * When passed a regular expression as the event name, it will remove the listener from all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to remove the listener from.
     * @param {Function} listener Method to remove from the event.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeListener = function removeListener(evt, listener) {
        var listeners = this.getListenersAsObject(evt);
        var index;
        var key;

        for (key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                index = indexOfListener(listeners[key], listener);

                if (index !== -1) {
                    listeners[key].splice(index, 1);
                }
            }
        }

        return this;
    };

    /**
     * Alias of removeListener
     */
    proto.off = alias('removeListener');

    /**
     * Adds listeners in bulk using the manipulateListeners method.
     * If you pass an object as the second argument you can add to multiple events at once. The object should contain key value pairs of events and listeners or listener arrays. You can also pass it an event name and an array of listeners to be added.
     * You can also pass it a regular expression to add the array of listeners to all events that match it.
     * Yeah, this function does quite a bit. That's probably a bad thing.
     *
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to add to multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to add.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addListeners = function addListeners(evt, listeners) {
        // Pass through to manipulateListeners
        return this.manipulateListeners(false, evt, listeners);
    };

    /**
     * Removes listeners in bulk using the manipulateListeners method.
     * If you pass an object as the second argument you can remove from multiple events at once. The object should contain key value pairs of events and listeners or listener arrays.
     * You can also pass it an event name and an array of listeners to be removed.
     * You can also pass it a regular expression to remove the listeners from all events that match it.
     *
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to remove from multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to remove.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeListeners = function removeListeners(evt, listeners) {
        // Pass through to manipulateListeners
        return this.manipulateListeners(true, evt, listeners);
    };

    /**
     * Edits listeners in bulk. The addListeners and removeListeners methods both use this to do their job. You should really use those instead, this is a little lower level.
     * The first argument will determine if the listeners are removed (true) or added (false).
     * If you pass an object as the second argument you can add/remove from multiple events at once. The object should contain key value pairs of events and listeners or listener arrays.
     * You can also pass it an event name and an array of listeners to be added/removed.
     * You can also pass it a regular expression to manipulate the listeners of all events that match it.
     *
     * @param {Boolean} remove True if you want to remove listeners, false if you want to add.
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to add/remove from multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to add/remove.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.manipulateListeners = function manipulateListeners(remove, evt, listeners) {
        var i;
        var value;
        var single = remove ? this.removeListener : this.addListener;
        var multiple = remove ? this.removeListeners : this.addListeners;

        // If evt is an object then pass each of its properties to this method
        if (typeof evt === 'object' && !(evt instanceof RegExp)) {
            for (i in evt) {
                if (evt.hasOwnProperty(i) && (value = evt[i])) {
                    // Pass the single listener straight through to the singular method
                    if (typeof value === 'function') {
                        single.call(this, i, value);
                    }
                    else {
                        // Otherwise pass back to the multiple function
                        multiple.call(this, i, value);
                    }
                }
            }
        }
        else {
            // So evt must be a string
            // And listeners must be an array of listeners
            // Loop over it and pass each one to the multiple method
            i = listeners.length;
            while (i--) {
                single.call(this, evt, listeners[i]);
            }
        }

        return this;
    };

    /**
     * Removes all listeners from a specified event.
     * If you do not specify an event then all listeners will be removed.
     * That means every event will be emptied.
     * You can also pass a regex to remove all events that match it.
     *
     * @param {String|RegExp} [evt] Optional name of the event to remove all listeners for. Will remove from every event if not passed.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeEvent = function removeEvent(evt) {
        var type = typeof evt;
        var events = this._getEvents();
        var key;

        // Remove different things depending on the state of evt
        if (type === 'string') {
            // Remove all listeners for the specified event
            delete events[evt];
        }
        else if (evt instanceof RegExp) {
            // Remove all events matching the regex.
            for (key in events) {
                if (events.hasOwnProperty(key) && evt.test(key)) {
                    delete events[key];
                }
            }
        }
        else {
            // Remove all listeners in all events
            delete this._events;
        }

        return this;
    };

    /**
     * Alias of removeEvent.
     *
     * Added to mirror the node API.
     */
    proto.removeAllListeners = alias('removeEvent');

    /**
     * Emits an event of your choice.
     * When emitted, every listener attached to that event will be executed.
     * If you pass the optional argument array then those arguments will be passed to every listener upon execution.
     * Because it uses `apply`, your array of arguments will be passed as if you wrote them out separately.
     * So they will not arrive within the array on the other side, they will be separate.
     * You can also pass a regular expression to emit to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to emit and execute listeners for.
     * @param {Array} [args] Optional array of arguments to be passed to each listener.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.emitEvent = function emitEvent(evt, args) {
        var listeners = this.getListenersAsObject(evt);
        var listener;
        var i;
        var key;
        var response;

        for (key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                i = listeners[key].length;

                while (i--) {
                    // If the listener returns true then it shall be removed from the event
                    // The function is executed either with a basic call or an apply if there is an args array
                    listener = listeners[key][i];

                    if (listener.once === true) {
                        this.removeListener(evt, listener.listener);
                    }

                    response = listener.listener.apply(this, args || []);

                    if (response === this._getOnceReturnValue()) {
                        this.removeListener(evt, listener.listener);
                    }
                }
            }
        }

        return this;
    };

    /**
     * Alias of emitEvent
     */
    proto.trigger = alias('emitEvent');

    /**
     * Subtly different from emitEvent in that it will pass its arguments on to the listeners, as opposed to taking a single array of arguments to pass on.
     * As with emitEvent, you can pass a regex in place of the event name to emit to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to emit and execute listeners for.
     * @param {...*} Optional additional arguments to be passed to each listener.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.emit = function emit(evt) {
        var args = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(evt, args);
    };

    /**
     * Sets the current value to check against when executing listeners. If a
     * listeners return value matches the one set here then it will be removed
     * after execution. This value defaults to true.
     *
     * @param {*} value The new value to check for when executing listeners.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.setOnceReturnValue = function setOnceReturnValue(value) {
        this._onceReturnValue = value;
        return this;
    };

    /**
     * Fetches the current value to check against when executing listeners. If
     * the listeners return value matches this one then it should be removed
     * automatically. It will return true by default.
     *
     * @return {*|Boolean} The current value to check for or the default, true.
     * @api private
     */
    proto._getOnceReturnValue = function _getOnceReturnValue() {
        if (this.hasOwnProperty('_onceReturnValue')) {
            return this._onceReturnValue;
        }
        else {
            return true;
        }
    };

    /**
     * Fetches the events object and creates one if required.
     *
     * @return {Object} The events storage object.
     * @api private
     */
    proto._getEvents = function _getEvents() {
        return this._events || (this._events = {});
    };

    /**
     * Reverts the global {@link EventEmitter} to its previous value and returns a reference to this version.
     *
     * @return {Function} Non conflicting EventEmitter class.
     */
    EventEmitter.noConflict = function noConflict() {
        exports.EventEmitter = originalGlobalValue;
        return EventEmitter;
    };

    // Expose the class either via AMD, CommonJS or the global object
    if (typeof define === 'function' && define.amd) {
        define('eventEmitter/EventEmitter',[],function () {
            return EventEmitter;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = EventEmitter;
    }
    else {
        exports.EventEmitter = EventEmitter;
    }
}.call(this));

/*!
 * getStyleProperty v1.0.4
 * original by kangax
 * http://perfectionkills.com/feature-testing-css-properties/
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false, exports: false, module: false */

( function( window ) {



var prefixes = 'Webkit Moz ms Ms O'.split(' ');
var docElemStyle = document.documentElement.style;

function getStyleProperty( propName ) {
  if ( !propName ) {
    return;
  }

  // test standard property first
  if ( typeof docElemStyle[ propName ] === 'string' ) {
    return propName;
  }

  // capitalize
  propName = propName.charAt(0).toUpperCase() + propName.slice(1);

  // test vendor specific properties
  var prefixed;
  for ( var i=0, len = prefixes.length; i < len; i++ ) {
    prefixed = prefixes[i] + propName;
    if ( typeof docElemStyle[ prefixed ] === 'string' ) {
      return prefixed;
    }
  }
}

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'get-style-property/get-style-property',[],function() {
    return getStyleProperty;
  });
} else if ( typeof exports === 'object' ) {
  // CommonJS for Component
  module.exports = getStyleProperty;
} else {
  // browser global
  window.getStyleProperty = getStyleProperty;
}

})( window );

/*!
 * getSize v1.2.2
 * measure size of elements
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false, exports: false, require: false, module: false, console: false */

( function( window, undefined ) {



// -------------------------- helpers -------------------------- //

// get a number from a string, not a percentage
function getStyleSize( value ) {
  var num = parseFloat( value );
  // not a percent like '100%', and a number
  var isValid = value.indexOf('%') === -1 && !isNaN( num );
  return isValid && num;
}

function noop() {}

var logError = typeof console === 'undefined' ? noop :
  function( message ) {
    console.error( message );
  };

// -------------------------- measurements -------------------------- //

var measurements = [
  'paddingLeft',
  'paddingRight',
  'paddingTop',
  'paddingBottom',
  'marginLeft',
  'marginRight',
  'marginTop',
  'marginBottom',
  'borderLeftWidth',
  'borderRightWidth',
  'borderTopWidth',
  'borderBottomWidth'
];

function getZeroSize() {
  var size = {
    width: 0,
    height: 0,
    innerWidth: 0,
    innerHeight: 0,
    outerWidth: 0,
    outerHeight: 0
  };
  for ( var i=0, len = measurements.length; i < len; i++ ) {
    var measurement = measurements[i];
    size[ measurement ] = 0;
  }
  return size;
}



function defineGetSize( getStyleProperty ) {

// -------------------------- setup -------------------------- //

var isSetup = false;

var getStyle, boxSizingProp, isBoxSizeOuter;

/**
 * setup vars and functions
 * do it on initial getSize(), rather than on script load
 * For Firefox bug https://bugzilla.mozilla.org/show_bug.cgi?id=548397
 */
function setup() {
  // setup once
  if ( isSetup ) {
    return;
  }
  isSetup = true;

  var getComputedStyle = window.getComputedStyle;
  getStyle = ( function() {
    var getStyleFn = getComputedStyle ?
      function( elem ) {
        return getComputedStyle( elem, null );
      } :
      function( elem ) {
        return elem.currentStyle;
      };

      return function getStyle( elem ) {
        var style = getStyleFn( elem );
        if ( !style ) {
          logError( 'Style returned ' + style +
            '. Are you running this code in a hidden iframe on Firefox? ' +
            'See http://bit.ly/getsizebug1' );
        }
        return style;
      };
  })();

  // -------------------------- box sizing -------------------------- //

  boxSizingProp = getStyleProperty('boxSizing');

  /**
   * WebKit measures the outer-width on style.width on border-box elems
   * IE & Firefox measures the inner-width
   */
  if ( boxSizingProp ) {
    var div = document.createElement('div');
    div.style.width = '200px';
    div.style.padding = '1px 2px 3px 4px';
    div.style.borderStyle = 'solid';
    div.style.borderWidth = '1px 2px 3px 4px';
    div.style[ boxSizingProp ] = 'border-box';

    var body = document.body || document.documentElement;
    body.appendChild( div );
    var style = getStyle( div );

    isBoxSizeOuter = getStyleSize( style.width ) === 200;
    body.removeChild( div );
  }

}

// -------------------------- getSize -------------------------- //

function getSize( elem ) {
  setup();

  // use querySeletor if elem is string
  if ( typeof elem === 'string' ) {
    elem = document.querySelector( elem );
  }

  // do not proceed on non-objects
  if ( !elem || typeof elem !== 'object' || !elem.nodeType ) {
    return;
  }

  var style = getStyle( elem );

  // if hidden, everything is 0
  if ( style.display === 'none' ) {
    return getZeroSize();
  }

  var size = {};
  size.width = elem.offsetWidth;
  size.height = elem.offsetHeight;

  var isBorderBox = size.isBorderBox = !!( boxSizingProp &&
    style[ boxSizingProp ] && style[ boxSizingProp ] === 'border-box' );

  // get all measurements
  for ( var i=0, len = measurements.length; i < len; i++ ) {
    var measurement = measurements[i];
    var value = style[ measurement ];
    value = mungeNonPixel( elem, value );
    var num = parseFloat( value );
    // any 'auto', 'medium' value will be 0
    size[ measurement ] = !isNaN( num ) ? num : 0;
  }

  var paddingWidth = size.paddingLeft + size.paddingRight;
  var paddingHeight = size.paddingTop + size.paddingBottom;
  var marginWidth = size.marginLeft + size.marginRight;
  var marginHeight = size.marginTop + size.marginBottom;
  var borderWidth = size.borderLeftWidth + size.borderRightWidth;
  var borderHeight = size.borderTopWidth + size.borderBottomWidth;

  var isBorderBoxSizeOuter = isBorderBox && isBoxSizeOuter;

  // overwrite width and height if we can get it from style
  var styleWidth = getStyleSize( style.width );
  if ( styleWidth !== false ) {
    size.width = styleWidth +
      // add padding and border unless it's already including it
      ( isBorderBoxSizeOuter ? 0 : paddingWidth + borderWidth );
  }

  var styleHeight = getStyleSize( style.height );
  if ( styleHeight !== false ) {
    size.height = styleHeight +
      // add padding and border unless it's already including it
      ( isBorderBoxSizeOuter ? 0 : paddingHeight + borderHeight );
  }

  size.innerWidth = size.width - ( paddingWidth + borderWidth );
  size.innerHeight = size.height - ( paddingHeight + borderHeight );

  size.outerWidth = size.width + marginWidth;
  size.outerHeight = size.height + marginHeight;

  return size;
}

// IE8 returns percent values, not pixels
// taken from jQuery's curCSS
function mungeNonPixel( elem, value ) {
  // IE8 and has percent value
  if ( window.getComputedStyle || value.indexOf('%') === -1 ) {
    return value;
  }
  var style = elem.style;
  // Remember the original values
  var left = style.left;
  var rs = elem.runtimeStyle;
  var rsLeft = rs && rs.left;

  // Put in the new values to get a computed value out
  if ( rsLeft ) {
    rs.left = elem.currentStyle.left;
  }
  style.left = value;
  value = style.pixelLeft;

  // Revert the changed values
  style.left = left;
  if ( rsLeft ) {
    rs.left = rsLeft;
  }

  return value;
}

return getSize;

}

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD for RequireJS
  define( 'get-size/get-size',[ 'get-style-property/get-style-property' ], defineGetSize );
} else if ( typeof exports === 'object' ) {
  // CommonJS for Component
  module.exports = defineGetSize( require('desandro-get-style-property') );
} else {
  // browser global
  window.getSize = defineGetSize( window.getStyleProperty );
}

})( window );

/*!
 * docReady v1.0.4
 * Cross browser DOMContentLoaded event emitter
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true*/
/*global define: false, require: false, module: false */

( function( window ) {



var document = window.document;
// collection of functions to be triggered on ready
var queue = [];

function docReady( fn ) {
  // throw out non-functions
  if ( typeof fn !== 'function' ) {
    return;
  }

  if ( docReady.isReady ) {
    // ready now, hit it
    fn();
  } else {
    // queue function when ready
    queue.push( fn );
  }
}

docReady.isReady = false;

// triggered on various doc ready events
function onReady( event ) {
  // bail if already triggered or IE8 document is not ready just yet
  var isIE8NotReady = event.type === 'readystatechange' && document.readyState !== 'complete';
  if ( docReady.isReady || isIE8NotReady ) {
    return;
  }

  trigger();
}

function trigger() {
  docReady.isReady = true;
  // process queue
  for ( var i=0, len = queue.length; i < len; i++ ) {
    var fn = queue[i];
    fn();
  }
}

function defineDocReady( eventie ) {
  // trigger ready if page is ready
  if ( document.readyState === 'complete' ) {
    trigger();
  } else {
    // listen for events
    eventie.bind( document, 'DOMContentLoaded', onReady );
    eventie.bind( document, 'readystatechange', onReady );
    eventie.bind( window, 'load', onReady );
  }

  return docReady;
}

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'doc-ready/doc-ready',[ 'eventie/eventie' ], defineDocReady );
} else if ( typeof exports === 'object' ) {
  module.exports = defineDocReady( require('eventie') );
} else {
  // browser global
  window.docReady = defineDocReady( window.eventie );
}

})( window );

/**
 * matchesSelector v1.0.3
 * matchesSelector( element, '.selector' )
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false, module: false */

( function( ElemProto ) {

  

  var matchesMethod = ( function() {
    // check for the standard method name first
    if ( ElemProto.matches ) {
      return 'matches';
    }
    // check un-prefixed
    if ( ElemProto.matchesSelector ) {
      return 'matchesSelector';
    }
    // check vendor prefixes
    var prefixes = [ 'webkit', 'moz', 'ms', 'o' ];

    for ( var i=0, len = prefixes.length; i < len; i++ ) {
      var prefix = prefixes[i];
      var method = prefix + 'MatchesSelector';
      if ( ElemProto[ method ] ) {
        return method;
      }
    }
  })();

  // ----- match ----- //

  function match( elem, selector ) {
    return elem[ matchesMethod ]( selector );
  }

  // ----- appendToFragment ----- //

  function checkParent( elem ) {
    // not needed if already has parent
    if ( elem.parentNode ) {
      return;
    }
    var fragment = document.createDocumentFragment();
    fragment.appendChild( elem );
  }

  // ----- query ----- //

  // fall back to using QSA
  // thx @jonathantneal https://gist.github.com/3062955
  function query( elem, selector ) {
    // append to fragment if no parent
    checkParent( elem );

    // match elem with all selected elems of parent
    var elems = elem.parentNode.querySelectorAll( selector );
    for ( var i=0, len = elems.length; i < len; i++ ) {
      // return true if match
      if ( elems[i] === elem ) {
        return true;
      }
    }
    // otherwise return false
    return false;
  }

  // ----- matchChild ----- //

  function matchChild( elem, selector ) {
    checkParent( elem );
    return match( elem, selector );
  }

  // ----- matchesSelector ----- //

  var matchesSelector;

  if ( matchesMethod ) {
    // IE9 supports matchesSelector, but doesn't work on orphaned elems
    // check for that
    var div = document.createElement('div');
    var supportsOrphans = match( div, 'div' );
    matchesSelector = supportsOrphans ? match : matchChild;
  } else {
    matchesSelector = query;
  }

  // transport
  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( 'matches-selector/matches-selector',[],function() {
      return matchesSelector;
    });
  } else if ( typeof exports === 'object' ) {
    module.exports = matchesSelector;
  }
  else {
    // browser global
    window.matchesSelector = matchesSelector;
  }

})( Element.prototype );

/**
 * Fizzy UI utils v1.0.1
 * MIT license
 */

/*jshint browser: true, undef: true, unused: true, strict: true */

( function( window, factory ) {
  /*global define: false, module: false, require: false */
  
  // universal module definition

  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'fizzy-ui-utils/utils',[
      'doc-ready/doc-ready',
      'matches-selector/matches-selector'
    ], function( docReady, matchesSelector ) {
      return factory( window, docReady, matchesSelector );
    });
  } else if ( typeof exports == 'object' ) {
    // CommonJS
    module.exports = factory(
      window,
      require('doc-ready'),
      require('desandro-matches-selector')
    );
  } else {
    // browser global
    window.fizzyUIUtils = factory(
      window,
      window.docReady,
      window.matchesSelector
    );
  }

}( window, function factory( window, docReady, matchesSelector ) {



var utils = {};

// ----- extend ----- //

// extends objects
utils.extend = function( a, b ) {
  for ( var prop in b ) {
    a[ prop ] = b[ prop ];
  }
  return a;
};

// ----- modulo ----- //

utils.modulo = function( num, div ) {
  return ( ( num % div ) + div ) % div;
};

// ----- isArray ----- //
  
var objToString = Object.prototype.toString;
utils.isArray = function( obj ) {
  return objToString.call( obj ) == '[object Array]';
};

// ----- makeArray ----- //

// turn element or nodeList into an array
utils.makeArray = function( obj ) {
  var ary = [];
  if ( utils.isArray( obj ) ) {
    // use object if already an array
    ary = obj;
  } else if ( obj && typeof obj.length == 'number' ) {
    // convert nodeList to array
    for ( var i=0, len = obj.length; i < len; i++ ) {
      ary.push( obj[i] );
    }
  } else {
    // array of single index
    ary.push( obj );
  }
  return ary;
};

// ----- indexOf ----- //

// index of helper cause IE8
utils.indexOf = Array.prototype.indexOf ? function( ary, obj ) {
    return ary.indexOf( obj );
  } : function( ary, obj ) {
    for ( var i=0, len = ary.length; i < len; i++ ) {
      if ( ary[i] === obj ) {
        return i;
      }
    }
    return -1;
  };

// ----- removeFrom ----- //

utils.removeFrom = function( ary, obj ) {
  var index = utils.indexOf( ary, obj );
  if ( index != -1 ) {
    ary.splice( index, 1 );
  }
};

// ----- isElement ----- //

// http://stackoverflow.com/a/384380/182183
utils.isElement = ( typeof HTMLElement == 'function' || typeof HTMLElement == 'object' ) ?
  function isElementDOM2( obj ) {
    return obj instanceof HTMLElement;
  } :
  function isElementQuirky( obj ) {
    return obj && typeof obj == 'object' &&
      obj.nodeType == 1 && typeof obj.nodeName == 'string';
  };

// ----- setText ----- //

utils.setText = ( function() {
  var setTextProperty;
  function setText( elem, text ) {
    // only check setTextProperty once
    setTextProperty = setTextProperty || ( document.documentElement.textContent !== undefined ? 'textContent' : 'innerText' );
    elem[ setTextProperty ] = text;
  }
  return setText;
})();

// ----- getParent ----- //

utils.getParent = function( elem, selector ) {
  while ( elem != document.body ) {
    elem = elem.parentNode;
    if ( matchesSelector( elem, selector ) ) {
      return elem;
    }
  }
};

// ----- getQueryElement ----- //

// use element as selector string
utils.getQueryElement = function( elem ) {
  if ( typeof elem == 'string' ) {
    return document.querySelector( elem );
  }
  return elem;
};

// ----- handleEvent ----- //

// enable .ontype to trigger from .addEventListener( elem, 'type' )
utils.handleEvent = function( event ) {
  var method = 'on' + event.type;
  if ( this[ method ] ) {
    this[ method ]( event );
  }
};

// ----- filterFindElements ----- //

utils.filterFindElements = function( elems, selector ) {
  // make array of elems
  elems = utils.makeArray( elems );
  var ffElems = [];

  for ( var i=0, len = elems.length; i < len; i++ ) {
    var elem = elems[i];
    // check that elem is an actual element
    if ( !utils.isElement( elem ) ) {
      continue;
    }
    // filter & find items if we have a selector
    if ( selector ) {
      // filter siblings
      if ( matchesSelector( elem, selector ) ) {
        ffElems.push( elem );
      }
      // find children
      var childElems = elem.querySelectorAll( selector );
      // concat childElems to filterFound array
      for ( var j=0, jLen = childElems.length; j < jLen; j++ ) {
        ffElems.push( childElems[j] );
      }
    } else {
      ffElems.push( elem );
    }
  }

  return ffElems;
};

// ----- debounceMethod ----- //

utils.debounceMethod = function( _class, methodName, threshold ) {
  // original method
  var method = _class.prototype[ methodName ];
  var timeoutName = methodName + 'Timeout';

  _class.prototype[ methodName ] = function() {
    var timeout = this[ timeoutName ];
    if ( timeout ) {
      clearTimeout( timeout );
    }
    var args = arguments;

    var _this = this;
    this[ timeoutName ] = setTimeout( function() {
      method.apply( _this, args );
      delete _this[ timeoutName ];
    }, threshold || 100 );
  };
};

// ----- htmlInit ----- //

// http://jamesroberts.name/blog/2010/02/22/string-functions-for-javascript-trim-to-camel-case-to-dashed-and-to-underscore/
utils.toDashed = function( str ) {
  return str.replace( /(.)([A-Z])/g, function( match, $1, $2 ) {
    return $1 + '-' + $2;
  }).toLowerCase();
};

var console = window.console;
/**
 * allow user to initialize classes via .js-namespace class
 * htmlInit( Widget, 'widgetName' )
 * options are parsed from data-namespace-option attribute
 */
utils.htmlInit = function( WidgetClass, namespace ) {
  docReady( function() {
    var dashedNamespace = utils.toDashed( namespace );
    var elems = document.querySelectorAll( '.js-' + dashedNamespace );
    var dataAttr = 'data-' + dashedNamespace + '-options';

    for ( var i=0, len = elems.length; i < len; i++ ) {
      var elem = elems[i];
      var attr = elem.getAttribute( dataAttr );
      var options;
      try {
        options = attr && JSON.parse( attr );
      } catch ( error ) {
        // log error, do not initialize
        if ( console ) {
          console.error( 'Error parsing ' + dataAttr + ' on ' +
            elem.nodeName.toLowerCase() + ( elem.id ? '#' + elem.id : '' ) + ': ' +
            error );
        }
        continue;
      }
      // initialize
      var instance = new WidgetClass( elem, options );
      // make available via $().data('layoutname')
      var jQuery = window.jQuery;
      if ( jQuery ) {
        jQuery.data( elem, namespace, instance );
      }
    }
  });
};

// -----  ----- //

return utils;

}));

/**
 * Outlayer Item
 */

( function( window, factory ) {
  
  // universal module definition
  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( 'outlayer/item',[
        'eventEmitter/EventEmitter',
        'get-size/get-size',
        'get-style-property/get-style-property',
        'fizzy-ui-utils/utils'
      ],
      function( EventEmitter, getSize, getStyleProperty, utils ) {
        return factory( window, EventEmitter, getSize, getStyleProperty, utils );
      }
    );
  } else if (typeof exports === 'object') {
    // CommonJS
    module.exports = factory(
      window,
      require('wolfy87-eventemitter'),
      require('get-size'),
      require('desandro-get-style-property'),
      require('fizzy-ui-utils')
    );
  } else {
    // browser global
    window.Outlayer = {};
    window.Outlayer.Item = factory(
      window,
      window.EventEmitter,
      window.getSize,
      window.getStyleProperty,
      window.fizzyUIUtils
    );
  }

}( window, function factory( window, EventEmitter, getSize, getStyleProperty, utils ) {


// ----- helpers ----- //

var getComputedStyle = window.getComputedStyle;
var getStyle = getComputedStyle ?
  function( elem ) {
    return getComputedStyle( elem, null );
  } :
  function( elem ) {
    return elem.currentStyle;
  };


function isEmptyObj( obj ) {
  for ( var prop in obj ) {
    return false;
  }
  prop = null;
  return true;
}

// -------------------------- CSS3 support -------------------------- //

var transitionProperty = getStyleProperty('transition');
var transformProperty = getStyleProperty('transform');
var supportsCSS3 = transitionProperty && transformProperty;
var is3d = !!getStyleProperty('perspective');

var transitionEndEvent = {
  WebkitTransition: 'webkitTransitionEnd',
  MozTransition: 'transitionend',
  OTransition: 'otransitionend',
  transition: 'transitionend'
}[ transitionProperty ];

// properties that could have vendor prefix
var prefixableProperties = [
  'transform',
  'transition',
  'transitionDuration',
  'transitionProperty'
];

// cache all vendor properties
var vendorProperties = ( function() {
  var cache = {};
  for ( var i=0, len = prefixableProperties.length; i < len; i++ ) {
    var prop = prefixableProperties[i];
    var supportedProp = getStyleProperty( prop );
    if ( supportedProp && supportedProp !== prop ) {
      cache[ prop ] = supportedProp;
    }
  }
  return cache;
})();

// -------------------------- Item -------------------------- //

function Item( element, layout ) {
  if ( !element ) {
    return;
  }

  this.element = element;
  // parent layout class, i.e. Masonry, Isotope, or Packery
  this.layout = layout;
  this.position = {
    x: 0,
    y: 0
  };

  this._create();
}

// inherit EventEmitter
utils.extend( Item.prototype, EventEmitter.prototype );

Item.prototype._create = function() {
  // transition objects
  this._transn = {
    ingProperties: {},
    clean: {},
    onEnd: {}
  };

  this.css({
    position: 'absolute'
  });
};

// trigger specified handler for event type
Item.prototype.handleEvent = function( event ) {
  var method = 'on' + event.type;
  if ( this[ method ] ) {
    this[ method ]( event );
  }
};

Item.prototype.getSize = function() {
  this.size = getSize( this.element );
};

/**
 * apply CSS styles to element
 * @param {Object} style
 */
Item.prototype.css = function( style ) {
  var elemStyle = this.element.style;

  for ( var prop in style ) {
    // use vendor property if available
    var supportedProp = vendorProperties[ prop ] || prop;
    elemStyle[ supportedProp ] = style[ prop ];
  }
};

 // measure position, and sets it
Item.prototype.getPosition = function() {
  var style = getStyle( this.element );
  var layoutOptions = this.layout.options;
  var isOriginLeft = layoutOptions.isOriginLeft;
  var isOriginTop = layoutOptions.isOriginTop;
  var x = parseInt( style[ isOriginLeft ? 'left' : 'right' ], 10 );
  var y = parseInt( style[ isOriginTop ? 'top' : 'bottom' ], 10 );

  // clean up 'auto' or other non-integer values
  x = isNaN( x ) ? 0 : x;
  y = isNaN( y ) ? 0 : y;
  // remove padding from measurement
  var layoutSize = this.layout.size;
  x -= isOriginLeft ? layoutSize.paddingLeft : layoutSize.paddingRight;
  y -= isOriginTop ? layoutSize.paddingTop : layoutSize.paddingBottom;

  this.position.x = x;
  this.position.y = y;
};

// set settled position, apply padding
Item.prototype.layoutPosition = function() {
  var layoutSize = this.layout.size;
  var layoutOptions = this.layout.options;
  var style = {};

  // x
  var xPadding = layoutOptions.isOriginLeft ? 'paddingLeft' : 'paddingRight';
  var xProperty = layoutOptions.isOriginLeft ? 'left' : 'right';
  var xResetProperty = layoutOptions.isOriginLeft ? 'right' : 'left';

  var x = this.position.x + layoutSize[ xPadding ];
  // set in percentage
  x = layoutOptions.percentPosition && !layoutOptions.isHorizontal ?
    ( ( x / layoutSize.width ) * 100 ) + '%' : x + 'px';
  style[ xProperty ] = x;
  // reset other property
  style[ xResetProperty ] = '';

  // y
  var yPadding = layoutOptions.isOriginTop ? 'paddingTop' : 'paddingBottom';
  var yProperty = layoutOptions.isOriginTop ? 'top' : 'bottom';
  var yResetProperty = layoutOptions.isOriginTop ? 'bottom' : 'top';

  var y = this.position.y + layoutSize[ yPadding ];
  // set in percentage
  y = layoutOptions.percentPosition && layoutOptions.isHorizontal ?
    ( ( y / layoutSize.height ) * 100 ) + '%' : y + 'px';
  style[ yProperty ] = y;
  // reset other property
  style[ yResetProperty ] = '';

  this.css( style );
  this.emitEvent( 'layout', [ this ] );
};


// transform translate function
var translate = is3d ?
  function( x, y ) {
    return 'translate3d(' + x + 'px, ' + y + 'px, 0)';
  } :
  function( x, y ) {
    return 'translate(' + x + 'px, ' + y + 'px)';
  };


Item.prototype._transitionTo = function( x, y ) {
  this.getPosition();
  // get current x & y from top/left
  var curX = this.position.x;
  var curY = this.position.y;

  var compareX = parseInt( x, 10 );
  var compareY = parseInt( y, 10 );
  var didNotMove = compareX === this.position.x && compareY === this.position.y;

  // save end position
  this.setPosition( x, y );

  // if did not move and not transitioning, just go to layout
  if ( didNotMove && !this.isTransitioning ) {
    this.layoutPosition();
    return;
  }

  var transX = x - curX;
  var transY = y - curY;
  var transitionStyle = {};
  // flip cooridinates if origin on right or bottom
  var layoutOptions = this.layout.options;
  transX = layoutOptions.isOriginLeft ? transX : -transX;
  transY = layoutOptions.isOriginTop ? transY : -transY;
  transitionStyle.transform = translate( transX, transY );

  this.transition({
    to: transitionStyle,
    onTransitionEnd: {
      transform: this.layoutPosition
    },
    isCleaning: true
  });
};

// non transition + transform support
Item.prototype.goTo = function( x, y ) {
  this.setPosition( x, y );
  this.layoutPosition();
};

// use transition and transforms if supported
Item.prototype.moveTo = supportsCSS3 ?
  Item.prototype._transitionTo : Item.prototype.goTo;

Item.prototype.setPosition = function( x, y ) {
  this.position.x = parseInt( x, 10 );
  this.position.y = parseInt( y, 10 );
};

// ----- transition ----- //

/**
 * @param {Object} style - CSS
 * @param {Function} onTransitionEnd
 */

// non transition, just trigger callback
Item.prototype._nonTransition = function( args ) {
  this.css( args.to );
  if ( args.isCleaning ) {
    this._removeStyles( args.to );
  }
  for ( var prop in args.onTransitionEnd ) {
    args.onTransitionEnd[ prop ].call( this );
  }
};

/**
 * proper transition
 * @param {Object} args - arguments
 *   @param {Object} to - style to transition to
 *   @param {Object} from - style to start transition from
 *   @param {Boolean} isCleaning - removes transition styles after transition
 *   @param {Function} onTransitionEnd - callback
 */
Item.prototype._transition = function( args ) {
  // redirect to nonTransition if no transition duration
  if ( !parseFloat( this.layout.options.transitionDuration ) ) {
    this._nonTransition( args );
    return;
  }

  var _transition = this._transn;
  // keep track of onTransitionEnd callback by css property
  for ( var prop in args.onTransitionEnd ) {
    _transition.onEnd[ prop ] = args.onTransitionEnd[ prop ];
  }
  // keep track of properties that are transitioning
  for ( prop in args.to ) {
    _transition.ingProperties[ prop ] = true;
    // keep track of properties to clean up when transition is done
    if ( args.isCleaning ) {
      _transition.clean[ prop ] = true;
    }
  }

  // set from styles
  if ( args.from ) {
    this.css( args.from );
    // force redraw. http://blog.alexmaccaw.com/css-transitions
    var h = this.element.offsetHeight;
    // hack for JSHint to hush about unused var
    h = null;
  }
  // enable transition
  this.enableTransition( args.to );
  // set styles that are transitioning
  this.css( args.to );

  this.isTransitioning = true;

};

var itemTransitionProperties = transformProperty && ( utils.toDashed( transformProperty ) +
  ',opacity' );

Item.prototype.enableTransition = function(/* style */) {
  // only enable if not already transitioning
  // bug in IE10 were re-setting transition style will prevent
  // transitionend event from triggering
  if ( this.isTransitioning ) {
    return;
  }

  // make transition: foo, bar, baz from style object
  // TODO uncomment this bit when IE10 bug is resolved
  // var transitionValue = [];
  // for ( var prop in style ) {
  //   // dash-ify camelCased properties like WebkitTransition
  //   transitionValue.push( toDash( prop ) );
  // }
  // enable transition styles
  // HACK always enable transform,opacity for IE10
  this.css({
    transitionProperty: itemTransitionProperties,
    transitionDuration: this.layout.options.transitionDuration
  });
  // listen for transition end event
  this.element.addEventListener( transitionEndEvent, this, false );
};

Item.prototype.transition = Item.prototype[ transitionProperty ? '_transition' : '_nonTransition' ];

// ----- events ----- //

Item.prototype.onwebkitTransitionEnd = function( event ) {
  this.ontransitionend( event );
};

Item.prototype.onotransitionend = function( event ) {
  this.ontransitionend( event );
};

// properties that I munge to make my life easier
var dashedVendorProperties = {
  '-webkit-transform': 'transform',
  '-moz-transform': 'transform',
  '-o-transform': 'transform'
};

Item.prototype.ontransitionend = function( event ) {
  // disregard bubbled events from children
  if ( event.target !== this.element ) {
    return;
  }
  var _transition = this._transn;
  // get property name of transitioned property, convert to prefix-free
  var propertyName = dashedVendorProperties[ event.propertyName ] || event.propertyName;

  // remove property that has completed transitioning
  delete _transition.ingProperties[ propertyName ];
  // check if any properties are still transitioning
  if ( isEmptyObj( _transition.ingProperties ) ) {
    // all properties have completed transitioning
    this.disableTransition();
  }
  // clean style
  if ( propertyName in _transition.clean ) {
    // clean up style
    this.element.style[ event.propertyName ] = '';
    delete _transition.clean[ propertyName ];
  }
  // trigger onTransitionEnd callback
  if ( propertyName in _transition.onEnd ) {
    var onTransitionEnd = _transition.onEnd[ propertyName ];
    onTransitionEnd.call( this );
    delete _transition.onEnd[ propertyName ];
  }

  this.emitEvent( 'transitionEnd', [ this ] );
};

Item.prototype.disableTransition = function() {
  this.removeTransitionStyles();
  this.element.removeEventListener( transitionEndEvent, this, false );
  this.isTransitioning = false;
};

/**
 * removes style property from element
 * @param {Object} style
**/
Item.prototype._removeStyles = function( style ) {
  // clean up transition styles
  var cleanStyle = {};
  for ( var prop in style ) {
    cleanStyle[ prop ] = '';
  }
  this.css( cleanStyle );
};

var cleanTransitionStyle = {
  transitionProperty: '',
  transitionDuration: ''
};

Item.prototype.removeTransitionStyles = function() {
  // remove transition
  this.css( cleanTransitionStyle );
};

// ----- show/hide/remove ----- //

// remove element from DOM
Item.prototype.removeElem = function() {
  this.element.parentNode.removeChild( this.element );
  // remove display: none
  this.css({ display: '' });
  this.emitEvent( 'remove', [ this ] );
};

Item.prototype.remove = function() {
  // just remove element if no transition support or no transition
  if ( !transitionProperty || !parseFloat( this.layout.options.transitionDuration ) ) {
    this.removeElem();
    return;
  }

  // start transition
  var _this = this;
  this.once( 'transitionEnd', function() {
    _this.removeElem();
  });
  this.hide();
};

Item.prototype.reveal = function() {
  delete this.isHidden;
  // remove display: none
  this.css({ display: '' });

  var options = this.layout.options;

  var onTransitionEnd = {};
  var transitionEndProperty = this.getHideRevealTransitionEndProperty('visibleStyle');
  onTransitionEnd[ transitionEndProperty ] = this.onRevealTransitionEnd;

  this.transition({
    from: options.hiddenStyle,
    to: options.visibleStyle,
    isCleaning: true,
    onTransitionEnd: onTransitionEnd
  });
};

Item.prototype.onRevealTransitionEnd = function() {
  // check if still visible
  // during transition, item may have been hidden
  if ( !this.isHidden ) {
    this.emitEvent('reveal');
  }
};

/**
 * get style property use for hide/reveal transition end
 * @param {String} styleProperty - hiddenStyle/visibleStyle
 * @returns {String}
 */
Item.prototype.getHideRevealTransitionEndProperty = function( styleProperty ) {
  var optionStyle = this.layout.options[ styleProperty ];
  // use opacity
  if ( optionStyle.opacity ) {
    return 'opacity';
  }
  // get first property
  for ( var prop in optionStyle ) {
    return prop;
  }
};

Item.prototype.hide = function() {
  // set flag
  this.isHidden = true;
  // remove display: none
  this.css({ display: '' });

  var options = this.layout.options;

  var onTransitionEnd = {};
  var transitionEndProperty = this.getHideRevealTransitionEndProperty('hiddenStyle');
  onTransitionEnd[ transitionEndProperty ] = this.onHideTransitionEnd;

  this.transition({
    from: options.visibleStyle,
    to: options.hiddenStyle,
    // keep hidden stuff hidden
    isCleaning: true,
    onTransitionEnd: onTransitionEnd
  });
};

Item.prototype.onHideTransitionEnd = function() {
  // check if still hidden
  // during transition, item may have been un-hidden
  if ( this.isHidden ) {
    this.css({ display: 'none' });
    this.emitEvent('hide');
  }
};

Item.prototype.destroy = function() {
  this.css({
    position: '',
    left: '',
    right: '',
    top: '',
    bottom: '',
    transition: '',
    transform: ''
  });
};

return Item;

}));

/*!
 * Outlayer v1.4.0
 * the brains and guts of a layout library
 * MIT license
 */

( function( window, factory ) {
  
  // universal module definition

  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'outlayer/outlayer',[
        'eventie/eventie',
        'eventEmitter/EventEmitter',
        'get-size/get-size',
        'fizzy-ui-utils/utils',
        './item'
      ],
      function( eventie, EventEmitter, getSize, utils, Item ) {
        return factory( window, eventie, EventEmitter, getSize, utils, Item);
      }
    );
  } else if ( typeof exports == 'object' ) {
    // CommonJS
    module.exports = factory(
      window,
      require('eventie'),
      require('wolfy87-eventemitter'),
      require('get-size'),
      require('fizzy-ui-utils'),
      require('./item')
    );
  } else {
    // browser global
    window.Outlayer = factory(
      window,
      window.eventie,
      window.EventEmitter,
      window.getSize,
      window.fizzyUIUtils,
      window.Outlayer.Item
    );
  }

}( window, function factory( window, eventie, EventEmitter, getSize, utils, Item ) {


// ----- vars ----- //

var console = window.console;
var jQuery = window.jQuery;
var noop = function() {};

// -------------------------- Outlayer -------------------------- //

// globally unique identifiers
var GUID = 0;
// internal store of all Outlayer intances
var instances = {};


/**
 * @param {Element, String} element
 * @param {Object} options
 * @constructor
 */
function Outlayer( element, options ) {
  var queryElement = utils.getQueryElement( element );
  if ( !queryElement ) {
    if ( console ) {
      console.error( 'Bad element for ' + this.constructor.namespace +
        ': ' + ( queryElement || element ) );
    }
    return;
  }
  this.element = queryElement;
  // add jQuery
  if ( jQuery ) {
    this.$element = jQuery( this.element );
  }

  // options
  this.options = utils.extend( {}, this.constructor.defaults );
  this.option( options );

  // add id for Outlayer.getFromElement
  var id = ++GUID;
  this.element.outlayerGUID = id; // expando
  instances[ id ] = this; // associate via id

  // kick it off
  this._create();

  if ( this.options.isInitLayout ) {
    this.layout();
  }
}

// settings are for internal use only
Outlayer.namespace = 'outlayer';
Outlayer.Item = Item;

// default options
Outlayer.defaults = {
  containerStyle: {
    position: 'relative'
  },
  isInitLayout: true,
  isOriginLeft: true,
  isOriginTop: true,
  isResizeBound: true,
  isResizingContainer: true,
  // item options
  transitionDuration: '0.4s',
  hiddenStyle: {
    opacity: 0,
    transform: 'scale(0.001)'
  },
  visibleStyle: {
    opacity: 1,
    transform: 'scale(1)'
  }
};

// inherit EventEmitter
utils.extend( Outlayer.prototype, EventEmitter.prototype );

/**
 * set options
 * @param {Object} opts
 */
Outlayer.prototype.option = function( opts ) {
  utils.extend( this.options, opts );
};

Outlayer.prototype._create = function() {
  // get items from children
  this.reloadItems();
  // elements that affect layout, but are not laid out
  this.stamps = [];
  this.stamp( this.options.stamp );
  // set container style
  utils.extend( this.element.style, this.options.containerStyle );

  // bind resize method
  if ( this.options.isResizeBound ) {
    this.bindResize();
  }
};

// goes through all children again and gets bricks in proper order
Outlayer.prototype.reloadItems = function() {
  // collection of item elements
  this.items = this._itemize( this.element.children );
};


/**
 * turn elements into Outlayer.Items to be used in layout
 * @param {Array or NodeList or HTMLElement} elems
 * @returns {Array} items - collection of new Outlayer Items
 */
Outlayer.prototype._itemize = function( elems ) {

  var itemElems = this._filterFindItemElements( elems );
  var Item = this.constructor.Item;

  // create new Outlayer Items for collection
  var items = [];
  for ( var i=0, len = itemElems.length; i < len; i++ ) {
    var elem = itemElems[i];
    var item = new Item( elem, this );
    items.push( item );
  }

  return items;
};

/**
 * get item elements to be used in layout
 * @param {Array or NodeList or HTMLElement} elems
 * @returns {Array} items - item elements
 */
Outlayer.prototype._filterFindItemElements = function( elems ) {
  return utils.filterFindElements( elems, this.options.itemSelector );
};

/**
 * getter method for getting item elements
 * @returns {Array} elems - collection of item elements
 */
Outlayer.prototype.getItemElements = function() {
  var elems = [];
  for ( var i=0, len = this.items.length; i < len; i++ ) {
    elems.push( this.items[i].element );
  }
  return elems;
};

// ----- init & layout ----- //

/**
 * lays out all items
 */
Outlayer.prototype.layout = function() {
  this._resetLayout();
  this._manageStamps();

  // don't animate first layout
  var isInstant = this.options.isLayoutInstant !== undefined ?
    this.options.isLayoutInstant : !this._isLayoutInited;
  this.layoutItems( this.items, isInstant );

  // flag for initalized
  this._isLayoutInited = true;
};

// _init is alias for layout
Outlayer.prototype._init = Outlayer.prototype.layout;

/**
 * logic before any new layout
 */
Outlayer.prototype._resetLayout = function() {
  this.getSize();
};


Outlayer.prototype.getSize = function() {
  this.size = getSize( this.element );
};

/**
 * get measurement from option, for columnWidth, rowHeight, gutter
 * if option is String -> get element from selector string, & get size of element
 * if option is Element -> get size of element
 * else use option as a number
 *
 * @param {String} measurement
 * @param {String} size - width or height
 * @private
 */
Outlayer.prototype._getMeasurement = function( measurement, size ) {
  var option = this.options[ measurement ];
  var elem;
  if ( !option ) {
    // default to 0
    this[ measurement ] = 0;
  } else {
    // use option as an element
    if ( typeof option === 'string' ) {
      elem = this.element.querySelector( option );
    } else if ( utils.isElement( option ) ) {
      elem = option;
    }
    // use size of element, if element
    this[ measurement ] = elem ? getSize( elem )[ size ] : option;
  }
};

/**
 * layout a collection of item elements
 * @api public
 */
Outlayer.prototype.layoutItems = function( items, isInstant ) {
  items = this._getItemsForLayout( items );

  this._layoutItems( items, isInstant );

  this._postLayout();
};

/**
 * get the items to be laid out
 * you may want to skip over some items
 * @param {Array} items
 * @returns {Array} items
 */
Outlayer.prototype._getItemsForLayout = function( items ) {
  var layoutItems = [];
  for ( var i=0, len = items.length; i < len; i++ ) {
    var item = items[i];
    if ( !item.isIgnored ) {
      layoutItems.push( item );
    }
  }
  return layoutItems;
};

/**
 * layout items
 * @param {Array} items
 * @param {Boolean} isInstant
 */
Outlayer.prototype._layoutItems = function( items, isInstant ) {
  this._emitCompleteOnItems( 'layout', items );

  if ( !items || !items.length ) {
    // no items, emit event with empty array
    return;
  }

  var queue = [];

  for ( var i=0, len = items.length; i < len; i++ ) {
    var item = items[i];
    // get x/y object from method
    var position = this._getItemLayoutPosition( item );
    // enqueue
    position.item = item;
    position.isInstant = isInstant || item.isLayoutInstant;
    queue.push( position );
  }

  this._processLayoutQueue( queue );
};

/**
 * get item layout position
 * @param {Outlayer.Item} item
 * @returns {Object} x and y position
 */
Outlayer.prototype._getItemLayoutPosition = function( /* item */ ) {
  return {
    x: 0,
    y: 0
  };
};

/**
 * iterate over array and position each item
 * Reason being - separating this logic prevents 'layout invalidation'
 * thx @paul_irish
 * @param {Array} queue
 */
Outlayer.prototype._processLayoutQueue = function( queue ) {
  for ( var i=0, len = queue.length; i < len; i++ ) {
    var obj = queue[i];
    this._positionItem( obj.item, obj.x, obj.y, obj.isInstant );
  }
};

/**
 * Sets position of item in DOM
 * @param {Outlayer.Item} item
 * @param {Number} x - horizontal position
 * @param {Number} y - vertical position
 * @param {Boolean} isInstant - disables transitions
 */
Outlayer.prototype._positionItem = function( item, x, y, isInstant ) {
  if ( isInstant ) {
    // if not transition, just set CSS
    item.goTo( x, y );
  } else {
    item.moveTo( x, y );
  }
};

/**
 * Any logic you want to do after each layout,
 * i.e. size the container
 */
Outlayer.prototype._postLayout = function() {
  this.resizeContainer();
};

Outlayer.prototype.resizeContainer = function() {
  if ( !this.options.isResizingContainer ) {
    return;
  }
  var size = this._getContainerSize();
  if ( size ) {
    this._setContainerMeasure( size.width, true );
    this._setContainerMeasure( size.height, false );
  }
};

/**
 * Sets width or height of container if returned
 * @returns {Object} size
 *   @param {Number} width
 *   @param {Number} height
 */
Outlayer.prototype._getContainerSize = noop;

/**
 * @param {Number} measure - size of width or height
 * @param {Boolean} isWidth
 */
Outlayer.prototype._setContainerMeasure = function( measure, isWidth ) {
  if ( measure === undefined ) {
    return;
  }

  var elemSize = this.size;
  // add padding and border width if border box
  if ( elemSize.isBorderBox ) {
    measure += isWidth ? elemSize.paddingLeft + elemSize.paddingRight +
      elemSize.borderLeftWidth + elemSize.borderRightWidth :
      elemSize.paddingBottom + elemSize.paddingTop +
      elemSize.borderTopWidth + elemSize.borderBottomWidth;
  }

  measure = Math.max( measure, 0 );
  this.element.style[ isWidth ? 'width' : 'height' ] = measure + 'px';
};

/**
 * emit eventComplete on a collection of items events
 * @param {String} eventName
 * @param {Array} items - Outlayer.Items
 */
Outlayer.prototype._emitCompleteOnItems = function( eventName, items ) {
  var _this = this;
  function onComplete() {
    _this.emitEvent( eventName + 'Complete', [ items ] );
  }

  var count = items.length;
  if ( !items || !count ) {
    onComplete();
    return;
  }

  var doneCount = 0;
  function tick() {
    doneCount++;
    if ( doneCount === count ) {
      onComplete();
    }
  }

  // bind callback
  for ( var i=0, len = items.length; i < len; i++ ) {
    var item = items[i];
    item.once( eventName, tick );
  }
};

// -------------------------- ignore & stamps -------------------------- //


/**
 * keep item in collection, but do not lay it out
 * ignored items do not get skipped in layout
 * @param {Element} elem
 */
Outlayer.prototype.ignore = function( elem ) {
  var item = this.getItem( elem );
  if ( item ) {
    item.isIgnored = true;
  }
};

/**
 * return item to layout collection
 * @param {Element} elem
 */
Outlayer.prototype.unignore = function( elem ) {
  var item = this.getItem( elem );
  if ( item ) {
    delete item.isIgnored;
  }
};

/**
 * adds elements to stamps
 * @param {NodeList, Array, Element, or String} elems
 */
Outlayer.prototype.stamp = function( elems ) {
  elems = this._find( elems );
  if ( !elems ) {
    return;
  }

  this.stamps = this.stamps.concat( elems );
  // ignore
  for ( var i=0, len = elems.length; i < len; i++ ) {
    var elem = elems[i];
    this.ignore( elem );
  }
};

/**
 * removes elements to stamps
 * @param {NodeList, Array, or Element} elems
 */
Outlayer.prototype.unstamp = function( elems ) {
  elems = this._find( elems );
  if ( !elems ){
    return;
  }

  for ( var i=0, len = elems.length; i < len; i++ ) {
    var elem = elems[i];
    // filter out removed stamp elements
    utils.removeFrom( this.stamps, elem );
    this.unignore( elem );
  }

};

/**
 * finds child elements
 * @param {NodeList, Array, Element, or String} elems
 * @returns {Array} elems
 */
Outlayer.prototype._find = function( elems ) {
  if ( !elems ) {
    return;
  }
  // if string, use argument as selector string
  if ( typeof elems === 'string' ) {
    elems = this.element.querySelectorAll( elems );
  }
  elems = utils.makeArray( elems );
  return elems;
};

Outlayer.prototype._manageStamps = function() {
  if ( !this.stamps || !this.stamps.length ) {
    return;
  }

  this._getBoundingRect();

  for ( var i=0, len = this.stamps.length; i < len; i++ ) {
    var stamp = this.stamps[i];
    this._manageStamp( stamp );
  }
};

// update boundingLeft / Top
Outlayer.prototype._getBoundingRect = function() {
  // get bounding rect for container element
  var boundingRect = this.element.getBoundingClientRect();
  var size = this.size;
  this._boundingRect = {
    left: boundingRect.left + size.paddingLeft + size.borderLeftWidth,
    top: boundingRect.top + size.paddingTop + size.borderTopWidth,
    right: boundingRect.right - ( size.paddingRight + size.borderRightWidth ),
    bottom: boundingRect.bottom - ( size.paddingBottom + size.borderBottomWidth )
  };
};

/**
 * @param {Element} stamp
**/
Outlayer.prototype._manageStamp = noop;

/**
 * get x/y position of element relative to container element
 * @param {Element} elem
 * @returns {Object} offset - has left, top, right, bottom
 */
Outlayer.prototype._getElementOffset = function( elem ) {
  var boundingRect = elem.getBoundingClientRect();
  var thisRect = this._boundingRect;
  var size = getSize( elem );
  var offset = {
    left: boundingRect.left - thisRect.left - size.marginLeft,
    top: boundingRect.top - thisRect.top - size.marginTop,
    right: thisRect.right - boundingRect.right - size.marginRight,
    bottom: thisRect.bottom - boundingRect.bottom - size.marginBottom
  };
  return offset;
};

// -------------------------- resize -------------------------- //

// enable event handlers for listeners
// i.e. resize -> onresize
Outlayer.prototype.handleEvent = function( event ) {
  var method = 'on' + event.type;
  if ( this[ method ] ) {
    this[ method ]( event );
  }
};

/**
 * Bind layout to window resizing
 */
Outlayer.prototype.bindResize = function() {
  // bind just one listener
  if ( this.isResizeBound ) {
    return;
  }
  eventie.bind( window, 'resize', this );
  this.isResizeBound = true;
};

/**
 * Unbind layout to window resizing
 */
Outlayer.prototype.unbindResize = function() {
  if ( this.isResizeBound ) {
    eventie.unbind( window, 'resize', this );
  }
  this.isResizeBound = false;
};

// original debounce by John Hann
// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/

// this fires every resize
Outlayer.prototype.onresize = function() {
  if ( this.resizeTimeout ) {
    clearTimeout( this.resizeTimeout );
  }

  var _this = this;
  function delayed() {
    _this.resize();
    delete _this.resizeTimeout;
  }

  this.resizeTimeout = setTimeout( delayed, 100 );
};

// debounced, layout on resize
Outlayer.prototype.resize = function() {
  // don't trigger if size did not change
  // or if resize was unbound. See #9
  if ( !this.isResizeBound || !this.needsResizeLayout() ) {
    return;
  }

  this.layout();
};

/**
 * check if layout is needed post layout
 * @returns Boolean
 */
Outlayer.prototype.needsResizeLayout = function() {
  var size = getSize( this.element );
  // check that this.size and size are there
  // IE8 triggers resize on body size change, so they might not be
  var hasSizes = this.size && size;
  return hasSizes && size.innerWidth !== this.size.innerWidth;
};

// -------------------------- methods -------------------------- //

/**
 * add items to Outlayer instance
 * @param {Array or NodeList or Element} elems
 * @returns {Array} items - Outlayer.Items
**/
Outlayer.prototype.addItems = function( elems ) {
  var items = this._itemize( elems );
  // add items to collection
  if ( items.length ) {
    this.items = this.items.concat( items );
  }
  return items;
};

/**
 * Layout newly-appended item elements
 * @param {Array or NodeList or Element} elems
 */
Outlayer.prototype.appended = function( elems ) {
  var items = this.addItems( elems );
  if ( !items.length ) {
    return;
  }
  // layout and reveal just the new items
  this.layoutItems( items, true );
  this.reveal( items );
};

/**
 * Layout prepended elements
 * @param {Array or NodeList or Element} elems
 */
Outlayer.prototype.prepended = function( elems ) {
  var items = this._itemize( elems );
  if ( !items.length ) {
    return;
  }
  // add items to beginning of collection
  var previousItems = this.items.slice(0);
  this.items = items.concat( previousItems );
  // start new layout
  this._resetLayout();
  this._manageStamps();
  // layout new stuff without transition
  this.layoutItems( items, true );
  this.reveal( items );
  // layout previous items
  this.layoutItems( previousItems );
};

/**
 * reveal a collection of items
 * @param {Array of Outlayer.Items} items
 */
Outlayer.prototype.reveal = function( items ) {
  this._emitCompleteOnItems( 'reveal', items );

  var len = items && items.length;
  for ( var i=0; len && i < len; i++ ) {
    var item = items[i];
    item.reveal();
  }
};

/**
 * hide a collection of items
 * @param {Array of Outlayer.Items} items
 */
Outlayer.prototype.hide = function( items ) {
  this._emitCompleteOnItems( 'hide', items );

  var len = items && items.length;
  for ( var i=0; len && i < len; i++ ) {
    var item = items[i];
    item.hide();
  }
};

/**
 * reveal item elements
 * @param {Array}, {Element}, {NodeList} items
 */
Outlayer.prototype.revealItemElements = function( elems ) {
  var items = this.getItems( elems );
  this.reveal( items );
};

/**
 * hide item elements
 * @param {Array}, {Element}, {NodeList} items
 */
Outlayer.prototype.hideItemElements = function( elems ) {
  var items = this.getItems( elems );
  this.hide( items );
};

/**
 * get Outlayer.Item, given an Element
 * @param {Element} elem
 * @param {Function} callback
 * @returns {Outlayer.Item} item
 */
Outlayer.prototype.getItem = function( elem ) {
  // loop through items to get the one that matches
  for ( var i=0, len = this.items.length; i < len; i++ ) {
    var item = this.items[i];
    if ( item.element === elem ) {
      // return item
      return item;
    }
  }
};

/**
 * get collection of Outlayer.Items, given Elements
 * @param {Array} elems
 * @returns {Array} items - Outlayer.Items
 */
Outlayer.prototype.getItems = function( elems ) {
  elems = utils.makeArray( elems );
  var items = [];
  for ( var i=0, len = elems.length; i < len; i++ ) {
    var elem = elems[i];
    var item = this.getItem( elem );
    if ( item ) {
      items.push( item );
    }
  }

  return items;
};

/**
 * remove element(s) from instance and DOM
 * @param {Array or NodeList or Element} elems
 */
Outlayer.prototype.remove = function( elems ) {
  var removeItems = this.getItems( elems );

  this._emitCompleteOnItems( 'remove', removeItems );

  // bail if no items to remove
  if ( !removeItems || !removeItems.length ) {
    return;
  }

  for ( var i=0, len = removeItems.length; i < len; i++ ) {
    var item = removeItems[i];
    item.remove();
    // remove item from collection
    utils.removeFrom( this.items, item );
  }
};

// ----- destroy ----- //

// remove and disable Outlayer instance
Outlayer.prototype.destroy = function() {
  // clean up dynamic styles
  var style = this.element.style;
  style.height = '';
  style.position = '';
  style.width = '';
  // destroy items
  for ( var i=0, len = this.items.length; i < len; i++ ) {
    var item = this.items[i];
    item.destroy();
  }

  this.unbindResize();

  var id = this.element.outlayerGUID;
  delete instances[ id ]; // remove reference to instance by id
  delete this.element.outlayerGUID;
  // remove data for jQuery
  if ( jQuery ) {
    jQuery.removeData( this.element, this.constructor.namespace );
  }

};

// -------------------------- data -------------------------- //

/**
 * get Outlayer instance from element
 * @param {Element} elem
 * @returns {Outlayer}
 */
Outlayer.data = function( elem ) {
  elem = utils.getQueryElement( elem );
  var id = elem && elem.outlayerGUID;
  return id && instances[ id ];
};


// -------------------------- create Outlayer class -------------------------- //

/**
 * create a layout class
 * @param {String} namespace
 */
Outlayer.create = function( namespace, options ) {
  // sub-class Outlayer
  function Layout() {
    Outlayer.apply( this, arguments );
  }
  // inherit Outlayer prototype, use Object.create if there
  if ( Object.create ) {
    Layout.prototype = Object.create( Outlayer.prototype );
  } else {
    utils.extend( Layout.prototype, Outlayer.prototype );
  }
  // set contructor, used for namespace and Item
  Layout.prototype.constructor = Layout;

  Layout.defaults = utils.extend( {}, Outlayer.defaults );
  // apply new options
  utils.extend( Layout.defaults, options );
  // keep prototype.settings for backwards compatibility (Packery v1.2.0)
  Layout.prototype.settings = {};

  Layout.namespace = namespace;

  Layout.data = Outlayer.data;

  // sub-class Item
  Layout.Item = function LayoutItem() {
    Item.apply( this, arguments );
  };

  Layout.Item.prototype = new Item();

  // -------------------------- declarative -------------------------- //

  utils.htmlInit( Layout, namespace );

  // -------------------------- jQuery bridge -------------------------- //

  // make into jQuery plugin
  if ( jQuery && jQuery.bridget ) {
    jQuery.bridget( namespace, Layout );
  }

  return Layout;
};

// ----- fin ----- //

// back in global
Outlayer.Item = Item;

return Outlayer;

}));


/*!
 * Masonry v3.3.0
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

( function( window, factory ) {
  
  // universal module definition
  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( [
        'outlayer/outlayer',
        'get-size/get-size',
        'fizzy-ui-utils/utils'
      ],
      factory );
  } else if ( typeof exports === 'object' ) {
    // CommonJS
    module.exports = factory(
      require('outlayer'),
      require('get-size'),
      require('fizzy-ui-utils')
    );
  } else {
    // browser global
    window.Masonry = factory(
      window.Outlayer,
      window.getSize,
      window.fizzyUIUtils
    );
  }

}( window, function factory( Outlayer, getSize, utils ) {



// -------------------------- masonryDefinition -------------------------- //

  // create an Outlayer layout class
  var Masonry = Outlayer.create('masonry');

  Masonry.prototype._resetLayout = function() {
    this.getSize();
    this._getMeasurement( 'columnWidth', 'outerWidth' );
    this._getMeasurement( 'gutter', 'outerWidth' );
    this.measureColumns();

    // reset column Y
    var i = this.cols;
    this.colYs = [];
    while (i--) {
      this.colYs.push( 0 );
    }

    this.maxY = 0;
  };

  Masonry.prototype.measureColumns = function() {
    this.getContainerWidth();
    // if columnWidth is 0, default to outerWidth of first item
    if ( !this.columnWidth ) {
      var firstItem = this.items[0];
      var firstItemElem = firstItem && firstItem.element;
      // columnWidth fall back to item of first element
      this.columnWidth = firstItemElem && getSize( firstItemElem ).outerWidth ||
        // if first elem has no width, default to size of container
        this.containerWidth;
    }

    var columnWidth = this.columnWidth += this.gutter;

    // calculate columns
    var containerWidth = this.containerWidth + this.gutter;
    var cols = containerWidth / columnWidth;
    // fix rounding errors, typically with gutters
    var excess = columnWidth - containerWidth % columnWidth;
    // if overshoot is less than a pixel, round up, otherwise floor it
    var mathMethod = excess && excess < 1 ? 'round' : 'floor';
    cols = Math[ mathMethod ]( cols );
    this.cols = Math.max( cols, 1 );
  };

  Masonry.prototype.getContainerWidth = function() {
    // container is parent if fit width
    var container = this.options.isFitWidth ? this.element.parentNode : this.element;
    // check that this.size and size are there
    // IE8 triggers resize on body size change, so they might not be
    var size = getSize( container );
    this.containerWidth = size && size.innerWidth;
  };

  Masonry.prototype._getItemLayoutPosition = function( item ) {
    item.getSize();
    // how many columns does this brick span
    var remainder = item.size.outerWidth % this.columnWidth;
    var mathMethod = remainder && remainder < 1 ? 'round' : 'ceil';
    // round if off by 1 pixel, otherwise use ceil
    var colSpan = Math[ mathMethod ]( item.size.outerWidth / this.columnWidth );
    colSpan = Math.min( colSpan, this.cols );

    var colGroup = this._getColGroup( colSpan );
    // get the minimum Y value from the columns
    var minimumY = Math.min.apply( Math, colGroup );
    var shortColIndex = utils.indexOf( colGroup, minimumY );

    // position the brick
    var position = {
      x: this.columnWidth * shortColIndex,
      y: minimumY
    };

    // apply setHeight to necessary columns
    var setHeight = minimumY + item.size.outerHeight;
    var setSpan = this.cols + 1 - colGroup.length;
    for ( var i = 0; i < setSpan; i++ ) {
      this.colYs[ shortColIndex + i ] = setHeight;
    }

    return position;
  };

  /**
   * @param {Number} colSpan - number of columns the element spans
   * @returns {Array} colGroup
   */
  Masonry.prototype._getColGroup = function( colSpan ) {
    if ( colSpan < 2 ) {
      // if brick spans only one column, use all the column Ys
      return this.colYs;
    }

    var colGroup = [];
    // how many different places could this brick fit horizontally
    var groupCount = this.cols + 1 - colSpan;
    // for each group potential horizontal position
    for ( var i = 0; i < groupCount; i++ ) {
      // make an array of colY values for that one group
      var groupColYs = this.colYs.slice( i, i + colSpan );
      // and get the max value of the array
      colGroup[i] = Math.max.apply( Math, groupColYs );
    }
    return colGroup;
  };

  Masonry.prototype._manageStamp = function( stamp ) {
    var stampSize = getSize( stamp );
    var offset = this._getElementOffset( stamp );
    // get the columns that this stamp affects
    var firstX = this.options.isOriginLeft ? offset.left : offset.right;
    var lastX = firstX + stampSize.outerWidth;
    var firstCol = Math.floor( firstX / this.columnWidth );
    firstCol = Math.max( 0, firstCol );
    var lastCol = Math.floor( lastX / this.columnWidth );
    // lastCol should not go over if multiple of columnWidth #425
    lastCol -= lastX % this.columnWidth ? 0 : 1;
    lastCol = Math.min( this.cols - 1, lastCol );
    // set colYs to bottom of the stamp
    var stampMaxY = ( this.options.isOriginTop ? offset.top : offset.bottom ) +
      stampSize.outerHeight;
    for ( var i = firstCol; i <= lastCol; i++ ) {
      this.colYs[i] = Math.max( stampMaxY, this.colYs[i] );
    }
  };

  Masonry.prototype._getContainerSize = function() {
    this.maxY = Math.max.apply( Math, this.colYs );
    var size = {
      height: this.maxY
    };

    if ( this.options.isFitWidth ) {
      size.width = this._getContainerFitWidth();
    }

    return size;
  };

  Masonry.prototype._getContainerFitWidth = function() {
    var unusedCols = 0;
    // count unused columns
    var i = this.cols;
    while ( --i ) {
      if ( this.colYs[i] !== 0 ) {
        break;
      }
      unusedCols++;
    }
    // fit container to columns that have been used
    return ( this.cols - unusedCols ) * this.columnWidth - this.gutter;
  };

  Masonry.prototype.needsResizeLayout = function() {
    var previousWidth = this.containerWidth;
    this.getContainerWidth();
    return previousWidth !== this.containerWidth;
  };

  return Masonry;

}));

/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

var social = function (options)
{
	return new social.fn.init(options);
};

social.fn = social.prototype = 
{
	version: '0.0.5',
	constructor: social,
	/**
	 *	Extend the social.fn object.
	 */
	extend: function (func)
	{
		//func.apply(social.fn, []);
		if (!social.fn.__extend)
		{
			social.fn.__extend = [];
		}

		social.fn.__extend.push(func);


		//$.extend(social.fn, func.apply(social.fn, []));
		//$.extend(social.fn, new func());
	},
	init: function (options)
	{
		/* Private vaiables */
		var self = this;

		/* Public variables */
		self.instance_name = 'instance_' + (Math.random() * new Date());

		self.options = options;
		social.fn.options = options;

		// Extend.
		$.each(self.__extend, function ()
		{
			if ($.isFunction(this))
			{
				this.apply(self, [options]);
			}
		});

        // Load font and fx CSS.
        self.load_css_file('cardz.social.fx.css');
        self.load_css_file('skins/assets/css/reset.css');
        self.load_css_file('skins/assets/css/font.css');
        
        // Load skins before doing anything else. Also, the default skin is always loaded.
        self.load_skin('default');
        self.load_skin(options.skin);

        if (options.toolbar)
        {
            self.load_skin(options.skinFilters, 'filters');
        }

        if (options.lightbox)
        {
            self.load_skin(options.skinLightbox, 'lightbox');
        }

		/**
		 *	Create and/or init the social structure.
		 *
		 *	@param object el jQuery object which will be used as the container.
		 */
		self.create = function (el)
		{
			self.update().done(function ()
			{
                if (options.orderBy !== 'auto')
                {
                    self.order_feed(self.feed_data, options.orderBy, options.order);
                }

                self.set_working_feed(self.feed_data);

				self.create_html(el);

                if (options.lightbox)
                {
                    self.init_slideshow(self.feed_data);
                }

                // Load first page.
                self.next_page();

                self.init_grid();
                //self.init_animations();

                self.lazy_elements = self.container.find('[data-lazy="true"]');

                self.register_events();
			});
		};

		return self;
	}
};

// Prepare for later instantiation.
social.fn.init.prototype = social.fn;

social.fn.extend(function ()
{
	var self = this;

    /**
     *  Load the skin CSS and JS file, if it is a smart skin.
     *
     *  The path will be automatically be detected unless specified. If the folder structure changes,
     *  the path should be set by the user.
     *
     *  @param string name Skin name.
     *  @param string type [optional] The skin type.
     */
    self.load_skin = function (name, type)
    {
        type = type || 'grid';

        var skin_file = 'skins/' + type + '/' + name + '/' + name + '.css';

        self.load_css_file(skin_file);

        /*
         *  If the skin name has -smart prefix, this means it is a smart skin,
         *  so we need to load the js file.
         */
        if (/-smart$/i.test(name))
        {
            self.load_js_file('skins/' + name + '/' + name + '.js');
        }
    };
});

social.fn.extend(function (options)
{
	var self = this;

    var $window = $(window);
    //var $document = $(document);
	
    /**
     *  Init all events.
     */
    self.register_events = function ()
    {
        $window.scroll(self.throttle(on_scroll, 30));

        if (self.load_more && options.pagination.type === 'button')
        {
            self.load_more.click(on_load_more);
        }
        else if (options.pagination.type === 'scroll')
        {
            $window.on('mousewheel DOMMouseScroll', self.throttle(on_mouse_wheel, 30));
        }

        if (options.toolbar)
        {
            self.container.on('click', '.cardz-social-filter', on_filter_click);
            self.container.on('keyup', '.cardz-social-search', on_search_change);
        }

        if (options.share === 'window')
        {
            self.container.on('click', '.cardz-social-share-wrapper a', on_share_click);
        }

        self.items_holder.on('click', '.cardz-social-item', on_item_click);

        // If the loading of an image fails, add the social-no-image class to the parent.
        self.bind('lazy.load', function (el, type, status)
        {
            if (status === 'fail')
            {
                el.hide().closest('.cardz-social-item').addClass((options.hideIfNoImage) ? 'social-hidden' : 'social-no-image');
            }
        });

        // Trigger scroll event to run the lazy load for the first time.
        on_scroll();
    };

    /**
     *  Called when we should load more items.
     */
    function on_load_more()
    {
		var load_more = null;

		$('.cardz-social-item').each(function() {
			var value = $(this).attr('id');
			value = value.replace("isi","");

			var isi = parseFloat(value);
			isi = isi+1;
			load_more = (isi > load_more) ? isi : load_more;
		});

        self.next_page(load_more);

        // If there are no more pages, hide the load more button.
        if (self.load_more && !self.is_next_page_available())
        {
            self.load_more.hide();
        }
    }

    /**
     *  Called when the page scroll event is triggered.
     */
    function on_scroll()
    {
        if (!self.is_mobile)
        {
            self.update_item_animations();
        }

        self.lazy_elements.each(function ()
        {
            self.lazy_load(this);
        });

        self.update_grid();
    }

    /**
     *  Called when the mouse wheel is used.
     */
    function on_mouse_wheel()
    {
        var scroll_top = $(window).scrollTop();
        var stream_bottom = self.container.offset().top + self.container.height();
        
        if (scroll_top + $window.height() > stream_bottom - 100)
        {
            self.next_page();
        }
    }

    /**
     *  Handle share item.
     */
    function on_share_click()
    {
        window.open(this.href, 'sharer', 'toolbar=0,status=0,width=548,height=325');

        return false;
    }

    /**
     *  Handle filter click button.
     */
    function on_filter_click(ev)
    {
        var $this = $(this);
        var network = $this.data('network');
        var feed_data = self.feed_data;

        if (network !== 'all')
        {
            feed_data = $.map(self.feed_data, function (item)
            {
                if (item.network === network)
                {
                    return item;
                }
            });
        }

        if (options.orderBy !== 'auto')
        {
            self.order_feed(feed_data, options.orderBy, options.order);
        }

        $this.addClass('selected').siblings('.selected').removeClass('selected');

        self.items_holder.children().remove();
        self.set_working_feed(feed_data);
        self.reset_page();
        self.next_page();

        // If there are more pages, show the load more button.
        if (self.load_more)
        {
            self.load_more.toggle(self.is_next_page_available());
        }

        /*self.items = self.apply_filters(self.items_all.removeClass('visible animate'), [$this.data('network')]);

        self.items_all = self.items_all.detach();
        self.items_holder.append(self.items);

        self.init_grid();
        self.update_animations();*/

        ev.preventDefault();
    }

    /**
     *  Handle search.
     */
    function on_search_change()
    {
        var value = $(this).val();

        // Remove the highlight class.
        self.items_holder.children().find('.cardz-social-highlight').each(function ()
        {
            $(this).replaceWith(this.innerHTML);
        });

        self.items = self.apply_filters(self.items_holder.children().removeClass('visible animate'), value, 'search');

        self.init_grid();
        self.update_animations();
    }

    /**
     *  Handle event for on item click.
     */
    function on_item_click(ev)
    {
        // If the click is over a clickable element, we want to let that element to handle the click.
        if ((/social\-(author|share|external\-link)/).test(ev.target.className))
        {
            return ;
        }

        var $this = $(this);

        if (options.lightbox)
        {
            if ($(window).width() <= 500)
            {
                $this.addClass('expanded');
            }
            else
            {
                self.show_slideshow($this.index());
            }
        }
        else
        {
            var link = $this.data('link');

            if (link)
            {
                window.open(link, '_blank');
            }
        }
    }
});

social.fn.extend(function (options)
{
	var self = this;

    /**
     *  Main container element.
     *
     *  @var jQuery
     */
    self.container = null;

    /**
     *  Toolbar container element.
     *
     *  @var jQuery
     */
    self.toolbar_container = null;

    /**
     *  Items holder element.
     *
     *  @var jQuery
     */
    self.items_holder = null;

    /**
     *  Loader element.
     *
     *  @var jQuery
     */
    self.loader_el = null;

    /**
     *  Load more button element.
     *
     *  @var jQuery
     */
    self.load_more = null;

    /**
     *  Holds only used elements.
     *
     *  @var jQuery
     */
    self.items = null;

    /**
     *  Holds all elements.
     *  @var jQuery
     */
    self.items_all = null;

	/**
	 *	Create HTML structure.
	 *
	 *	@param object el jQuery object which will be used as the container.
	 */
	self.create_html = function (el)
	{
        /*
         *  Initialize the main container.
         *
         *  Note: We also add the animation, grid skin, and filters skin classes.
         */
		self.container = el.addClass('cardz-social-container cardz-social-fx-' + options.effect +
                                     ' cardz-social-skin-' + options.skin +
                                     (options.toolbar ? ' cardz-social-filter-skin-' + options.skinFilters : ''));
		self.items_holder = el.find('.cardz-social-items-holder');
		//self.items = el.find('.cardz-social-items');

        self.update_toolbar_html();

        // If the items holder is not created, create it.
		if (self.items_holder.length === 0)
		{
			self.items_holder = $(document.createElement('div')).addClass('cardz-social-items-holder');

			el.append(self.items_holder);
		}

        if (options.itemShadow)
        {
            self.items_holder.addClass('shadow');
        }

        if (options.loader !== false)
        {
            self.loader_el = new Image();
            self.loader_el.className = 'cardz-social-loader';
            self.loader_el.src = get_loader_src();
            self.loader_el = $(self.loader_el);
            el.append(self.loader_el);
        }

        //self.update_items_html(items);

        if (options.pagination.type === 'button' && self.get_page_count() > 1)
        {
            self.load_more = $(document.createElement('span')).addClass('cardz-social-load-more').html('Load More').appendTo(self.container);
        }
	};

    /**
     *  Get share HTML template.
     */
    self.get_share_buttons_html = function ()
    {
        var html = '';
        var share_url =
        {
            twitter: 'https://twitter.com/share?url={{=link}}',
			facebook: 'http://www.facebook.com/sharer.php?u={{=link}}',
			google: 'https://plus.google.com/share?url={{=link}}',
			linkedin: 'http://www.linkedin.com/shareArticle?url={{=url}}&title={{=title}}',
			delicious: 'https://delicious.com/save?v=5&provider={{=provider}}&noui&jump=close&url={{=url}}&title={{=title}}',
			pinterest: 'https://pinterest.com/pin/create/bookmarklet/?media={{=img}}&url={{=url}}&is_video={{=is_video}}&description={{=title}}',
			stumbleupon: 'http://www.stumbleupon.com/submit?url={{=url}}&title={{=title}}',
			tumblr: 'http://www.tumblr.com/share/link?url={{=url}}&name={{=title}}&description={{=desc}}',
			digg: 'http://digg.com/submit?url={{=url}}&title={{=title}}',
            vk: 'http://vk.com/share.php?url={{=link}}'
		};
        var network = '';

        for (var i = 0; i < options.shareButtons.length; i++)
        {
            network = options.shareButtons[i] || '';

            html += '<a href="' + share_url[network] + '" class="social-share-'+ network +'" target="_blank"></a>';
        }

        return html;
    };

    /**
     *  Update items HTML.
     *
     *	@param array items An array of items with the following structure.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
    self.update_items_html = function (items,load_more)
    {
        create_items_html(self.items_holder, items,load_more);
    };

    /**
     *  Update HTML structure for the filters buttons and search.
     */
    self.update_toolbar_html = function ()
    {
        if (options.toolbar)
        {
            create_toolbar(self.container);
        }
    };

	/**
	 *	Create HTML structure for the items.
	 *
	 *	@param object el jQuery object which will be used as the container.
	 *	@param array items An array of items with the following structure.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	function create_items_html(el, items, i_loadmore)
	{
		var items_html = '';
        var item = null;
        var length = items.length;

        self.loader_el.show();

		for (var i = 0; i < length; i++)
		{
            // Clone this item so we don't modify the original version.
            item = $.extend({}, items[i]);

            // Transform URL from text to links.
            if (options.clickableLinks && typeof item.message === 'string')
            {
                item.message = item.message.replace(/((?:http|ftp|https):[^\s]*)/g, '<a href="$1" target="_blank">$1</a>');

                if (item.network === 'facebook')
                {
                    item.message = item.message.replace(/\B#([a-zA-Z0-9_]+)/g, '<a href="https://www.facebook.com/hashtag/$1" target="_blank">#$1</a>');
                }
                else if (item.network === 'twitter')
                {
                    item.message = item.message.replace(/\B@([a-zA-Z0-9_]+)/g, '<a href="https://twitter.com/$1" target="_blank">@$1</a>');
                    item.message = item.message.replace(/\B#([a-zA-Z0-9_]+)/g, '<a href="https://twitter.com/hashtag/$1" target="_blank">#$1</a>');
                }
            }
            
            if (item.network === 'facebook')
            {
                item.created = item.created.replace(/T/g, ' ').replace(/-/g, '/');
            }
            
            item.created = self.format_date(+new Date(item.created));

   //          if (typeof i_loadmore === "undefined" || i_loadmore === null) {
			// 	items_html += get_html_template(item,i);
			// } else {
			// 	items_html += get_html_template(item,i_loadmore+i);
			// }

            if ((item.type !== 'html') && (typeof i_loadmore === "undefined" || i_loadmore === null))
            {
                items_html += get_html_template(item,i);
            }
            else
            {
                items_html += get_html_template(item,i_loadmore+i);
            }

            // Don't create the HTML.
            if (self.moderate(options.moderate, item, items_html))
            {
                items_html = '';
            }
		}

        //var item_width = el.width();

		el.append(items_html);

        self.items_all = el.children();

        self.loader_el.hide();

        //self.items = el.children();
	}

    /**
     *  Create HTML structure for the filters buttons and search.
     *
     *	@param object el jQuery object which will be used as the container.
     */
    function create_toolbar(el)
    {
        var toolbar = self.toolbar_container || $(document.createElement('div')).addClass('cardz-social-toolbar');
        var keys = options.filterButtons || [] /* || Object.keys(options.networks)*/;
        var items = '';
        var selected = '';
        var caption = '';
        var network = '';
        var button_type = 'button';

        keys = ['all'].concat(keys);



        /*for (var j = 0; j < options.feedData.length; j++)
        {
            if (!~keys.indexOf(options.feedData[j].network))
            {
                keys.push(options.feedData[j].network);
            }
        }*/

        for (var j = 0; j < self.feed_data.length; j++)
        {
            if (!~keys.indexOf(self.feed_data[j].network))
            {
                keys.push(self.feed_data[j].network);
            }
        }

        for (var i = 0; i < keys.length; i++)
        {
            selected = (i === 0) ? ' selected' : '';
            caption = (i === 0) ? 'All' : '';

            if (typeof keys[i] === 'string')
            {
                network = keys[i];
            }
            else if ($.isFunction(keys[i]))
            {
                network = keys[i]();
            }
            else
            {
                network = keys[i].network || '';
                button_type = keys[i].type || 'button';
                caption = keys[i].caption || '';
            }

            items += '<span class="cardz-social-filter'+ selected + ' ssi-' + network + '" data-network="' + network + '" data-btype="' + button_type + '">' + caption + '</span>';
        }

        var search_item = '<span class="cardz-social-filter-search ssi-search"><input type="text" class="cardz-social-search" placeholder="Type to search..." /></span>';

        toolbar.html('<div class="cardz-social-filter-items">' + items + '</div>' + search_item);

        if (!self.toolbar_container)
        {
            self.toolbar_container = toolbar;
            el.append(toolbar);
        }
    }
	
	/**
	 *	Render HTML item.
	 *
	 *	@param object data The data to add to the template.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 *
	 *	@return string The HTML structure prepared for the HTML template.
	 */
	function get_html_template(data,i)
	{
        var image_source = '';

        if (self.is_mobile)
        {
            image_source =
                '{{?img attachment !== ""}}' +
                '   <img src="{{=attachment}}" class="social-image" />' +
                '{{? end img }}';
        }
        else
        {
            image_source =
                '{{?img attachment !== ""}}' +
                '   <img src="{{=loader_src}}" data-lazy="true" data-src="{{=attachment}}" class="social-image" />' +
                '{{? end img }}';
        }
		var id_div = "isi"+i;
		var template = self.options.template ||
			'<div class="cardz-social-item{{=additional_classes}}" data-network="{{=network}}" data-link="{{=link}}" id='+id_div+'>' +
            '   <div class="cardz-social-share-wrapper">' +
            '       {{=share_html}}' +
            '   </div>' +
            '   <div class="social-header">' +
                (image_source) +
            //'       {{?vid video_source !== undefined && video_source !== "" }}' +
            //'           <iframe src="{{=video_source}}" class="social-video" width="260" height="260" frameborder="0"></iframe>' +
            //'	        <div src="{{=loader_src}}" data-lazy="true" data-src="{{=video_source}}" class="social-video"></div>' +
            //'       {{? end vid }}' +
            '       <a href="{{=author_link}}" target="_blank" title="{{=author_name}}" class="social-author">' +
            '           <img src="{{=author_picture}}" class="social-author-image" />' +
            '           <p class="social-author-name">{{=author_name}}</p>'+
            '       </a>' +
            '   </div>' +
			'	<h1 class="social-title">{{=message}}</h1>' +
			'	<h1 class="social-date">{{=created}}</h1>' +
            '   {{?lk show_link}}' +
            '       <a href="{{=link}}" target="_blank" class="social-external-link"></a>' +
            '   {{? end lk}}' +
			'</div>' +
			'<script type="text/javascript">'+
			'	jQuery("#'+id_div+'").click(function(){'+
			'		jQuery("#'+id_div+'").animate({opacity:"0.5"}).attr("selected","selected");'+
			'		var data = {'+
			'			"action": "insert_social_feed",'+
			'			"data": {'+
			'				"content": jQuery("#'+id_div+'").find(".social-title").html(),'+
			'				"network": "{{=network}}",'+
			'				"image": jQuery("#'+id_div+'").find(".social-header").children("img").attr("src"),'+
			'				"url": "{{=link}}",'+
			'				"username": "{{=author_name}}",'+
			'				"userphoto": "{{=author_picture}}"'+
			'			},'+
			'		};'+
			'		jQuery.post("/wp-admin/admin-ajax.php", data, function(response) {'+
			// '			console.log(response);'+
			'		});'+
			'	});'+
			'</script>';

        data.loader_src = get_loader_src();

        data.show_link = true;
        data.additional_classes = '';

        if (data.attachment && data.attachment !== '')
        {
            data.attachment = 'https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&resize_w='+ options.grid.width +'&refresh=172800&url=' + encodeURIComponent(data.attachment);
        }
        else
        {
            data.additional_classes = (options.hideIfNoImage) ? ' social-hidden' : ' social-no-image';
        }

        // Limit the text.
        data.message = self.limit_text(data.message, options.limitText, options.limitTextType);

        data.share_html = self.get_share_buttons_html();

		return speedo.fn.template.process(template, {scope: data});
	}

    /**
     *  Get loader source.
     *
     *  @return string Returns the loader source URL.
     */
    function get_loader_src()
    {
        var is_smil = self.is_smil_supported();

        // Set general loader source.
        switch (options.loader)
        {
        case 'light':
            return (is_smil) ? self.get_plugin_url() + 'skins/assets/images/loader.svg' : self.get_plugin_url() + 'skins/assets/images/loader.gif';

        case 'dark':
            return (is_smil) ? self.get_plugin_url() + 'skins/assets/images/loader_dark.svg' : self.get_plugin_url() + 'skins/assets/images/loader_dark.gif';
        }

        return options.loader;
    }
});

social.fn.extend(function (options)
{
	var self = this;

    /**
     *  Current page.
     *
     *  @var Number
     */
    var page = 0;

    /**
     *  Page count.
     *
     *  @var Number
     */
    var page_count = 0;

    /**
     *  Working feed array.
     *
     *  @var array
     */
    var working_feed = [];
    

    /**
     *  Set working feed data.
     *
     *  @param array The data to work on.
     */
    self.set_working_feed = function (feed_data)
    {
        working_feed = feed_data;
    };

    /**
     *  Get current page.
     *
     *  @return number Returns the current page.
     */
    self.get_page = function ()
    {
        return page;
    };

    /**
     *  Get page count.
     *
     *  @return number Returns the count of pages.
     */
    self.get_page_count = function ()
    {
        return (page_count = Math.ceil(working_feed.length / options.pagination.itemsPerPage));
    };

    /**
     *  Go to next page.
     */
    self.next_page = function (load_more)
    {
        page++;
        var feed_data = working_feed;
        var offset = Math.min(options.pagination.itemsPerPage * (page - 1), feed_data.length);
        var length = Math.min(options.pagination.itemsPerPage * page, feed_data.length);

        feed_data = feed_data.slice(offset, length);

        self.update_items_html(feed_data,load_more);
        // self.update_slideshow_items(working_feed);

        // filter items.
        self.items = self.apply_filters(self.items_all, options.filters);

        if (self.items_holder.data('masonry-loaded'))
        {
            self.items_holder.masonry('reloadItems').masonry('layout');
        }

        self.update_animations();
        self.update_grid();

        // Update lazy elements.
        self.lazy_elements = self.container.find('[data-lazy="true"]');

        self.lazy_elements.each(function ()
        {
            self.lazy_load(this);
        });
    };

    /**
     *  Reset page index to 0
     */
    self.reset_page = function ()
    {
        page = 0;
    };

    /**
     *  Check if there is a next page available.
     *
     *  @return bool Returns true if there are more pages available, otherwise false.
     */
    self.is_next_page_available = function ()
    {
        return (self.get_page_count() > page);
    };
});

social.fn.extend(function (options)
{
	var self = this;

    var table_name = 'cardz_cache';

    var is_db_available = ('openDatabase' in window)  && (options.cache.method === 'auto' || options.cache.method === 'database');
    var is_ls_available = (!!localStorage) && (options.cache.method === 'auto' || options.cache.method === 'local-storage');

    /**
     *  Add data to cache.
     *
     *  @param String key Key name.
     *  @param mixed data Data to store.
     */
    self.add_cache = function (key, data)
    {
        if (!options.cache.enabled)
        {
            return ;
        }

        data = JSON.stringify(data);

        if (is_db_available)
        {
            var db = init_cache_db();

            db.transaction(function (tx)
            {
                tx.executeSql('INSERT INTO ? (key, data) VALUES (?, ?)', [table_name, key, data]);
            });
        }
        else if (is_ls_available)   // localStorage
        {
            localStorage.setItem(table_name + '_' + key, data);
        }

        if (localStorage)
        {
            localStorage.setItem('cardz_' + key + '_date', new Date().getTime());
        }
    };

    /**
     *  Get data from cache.
     *
     *  @param String key Key name.
     *
     *  @return mixed The data available or null.
     */
    self.get_cache = function (key)
    {
        if (!options.cache.enabled)
        {
            return null;
        }

        var time_stamp = Number(localStorage.getItem('cardz_' + key + '_date'));

        // Check if we should re-update the data.
        if (localStorage && options.cache.valability < ((new Date().getTime() - time_stamp) / 60 / 60))
        {
            return null;
        }

        if (is_db_available)
        {
            var db = init_cache_db();

            db.transaction(function (tx)
            {
                tx.executeSql('SELECT * FROM ? WHERE key=?', [table_name, key], function (tx, results)
                {
                    console.log(results);
                });
            });
        }
        else if (is_ls_available)   // localStorage
        {
            return JSON.parse(localStorage.getItem(table_name + '_' + key));
        }

        return null;
    };

    /**
     *  Init the database and return a db context.
     *
     *  @return Object Returns the db context or null.
     */
    function init_cache_db()
    {
        var db = openDatabase('cardz_cache_db', '1.0', 'CardZ Cache DB', 2 * 1024 * 1024);

        db.transaction(function (tx)
        {
            tx.executeSql('CREATE TABLE IF NOT EXISTS ? (id, key, data)', [table_name]);
        });

        return db;
    }
});

social.fn.extend(function (options)
{
	var self = this;

	/**
     *  Arrange items by grid.
     */
    this.init_grid = function ()
    {
        self.items_holder.find('.cardz-social-item').width(options.grid.width).css({'margin-bottom': options.grid.gutter, 'min-width': options.grid.minWidth});

        imagesLoaded(self.items_holder, function ()
        {
            self.items_holder.masonry(
            {
                itemSelector: '.cardz-social-item',
                columnWidth: '.cardz-social-item',
                isFitWidth: options.responsive,
                transitionDuration: 0,
                //columnWidth: 200
                gutter: options.grid.gutter,
                isAnimated: false
                //columnWidth: options.grid.width || self.container.width() / options.grid.cols
            });

            self.items_holder.data('masonry-loaded', true);
        });
    };

    /**
     *  Update grid layout.
     */
    this.update_grid = function ()
    {
        self.items_holder.find('.cardz-social-item').width(options.grid.width).css({'margin-bottom': options.grid.gutter, 'min-width': options.grid.minWidth});
        self.items_holder.masonry();
    };
});

social.fn.extend(function (options)
{
	var self = this;

    /**
     *  Filter an array of elements. Using the givent options.
     *
     *  @param array|jQuery elements An array or a jQuery object containing elements.
     *  @param array filters An array of strings with the filters to be applyed.
     *  @param string filter_type [optional] The type of filter. Used to discern the way we search.
     *
     *  @return array Returns the filtered elements as a jQuery object.
     */
    self.apply_filters = function (elements, filters, filter_type)
    {
        filter_type = filter_type || 'network';

        if (!filters || filters[0] === 'all')
        {
            return elements;
        }

        var result = $('');
        var search_options = (options.search.global) ? 'g' : '';

        search_options += (!options.search.caseSensitive) ? 'i' : '';

        $.each(elements, function (index, el)
        {
            el = $(el);

            if (filter_type === 'network')
            {
                if (~$.inArray(el.data('network'), filters))
                {
                    result = result.add(el);
                }
            }
            else if (filter_type === 'search')
            {
                var search_el = el.find('.social-title, .social-text');
                var content = search_el.html();

                // Note that the filters is escaped if it is not a RegExp.
                filters = (filters instanceof RegExp) ? filters : new RegExp('(' + filters.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', search_options);

                if (filters.test(content))
                {
                    content = content.replace(filters, '<span class="cardz-social-highlight">$1</span>');

                    search_el.html(content);

                    result = result.add(el);
                }
            }
        });

        return result;
    };

    /**
     *  Order elements.
     *
     *  @param array|jQuery elements An array or a jQuery object containing elements.
     *  @param string order_by Order by.
     *                  'name' Order by name.
     *                  'date' Order by date.
     *  @param bool asc [optional] Wheather ascendent or descendent. Default ascendent.
     *
     *  @return jQuery Returns the ordered elements as a jQuery object.
     */
    self.order_elements = function (elements, order_by, asc)
    {
        var result = $();
        var items = elements;

        items.sort(function (a, b)
        {
            a = $(a);
            b = $(b);

            if (a.data(order_by) > b.data(order_by))
            {
                return (asc) ? 1 : -1;
            }

            if (a.data(order_by) < b.data(order_by))
            {
                return (asc) ? -1 : 1;
            }

            return 0;
        });

        for (var i = 0; i < items.length; i++)
        {
            result = result.add(items[i]);
        }

        return result;
    };

    /**
     *  Order feed.
     *
     *  @param array items An array or feed data.
     *  @param string order_by Order by.
     *                  'network'           Order by network.
     *                  'title'             Order by title.
     *                  'created'           Order by date.
     *                  'id'                Order by ID.
     *                  'author_name'       Order by author name.
     *                  'message'           Order by message.
     *                  'description'       Order by description.
     *  @param string order [optional] How to order the array. Default value 'asc'. Possible values:
     *                  'asc'       Ascendent.
     *                  'desc'      Descendent.
     *                  'rand'      Random.
     *
     *  @return array Returns the ordered array.
     */
    self.order_feed = function (items, order_by, order)
    {
        items.sort(function (a, b)
        {
            if (order === 'rand')
            {
                return (Math.random() > 0.5) ? 1 : -1;
            }

            var value_a = a[order_by];
            var value_b = b[order_by];
            
            if (a.network === 'facebook')
            {
                value_a = value_a.replace(/T/g, ' ').replace(/-/g, '/');
            }
            
            if (b.network === 'facebook')
            {
                value_b = value_b.replace(/T/g, ' ').replace(/-/g, '/');
            }
            
            if (order_by === 'created')
            {
                value_a = +new Date(value_a);
                value_b = +new Date(value_b);
            }

            if (value_a > value_b)
            {
                return (order === 'asc') ? 1 : -1;
            }

            if (value_a < value_b)
            {
                return (order === 'asc') ? -1 : 1;
            }

            return 0;
        });

        return items;
    };

    /**
     *  Modorate posts.
     *
     *  @param bool|string|array|object data Moderate which posts to hide. If the value is false, this will be ignored and
     *                                       all posts will be vissible, if the value is a string, the posts which contains that string
     *                                       will be hidden, if the value is an array, the moderation will be procesed against all values
     *                                       in the array, if the value is an object, it will compare the values of the properties against the
     *                                       feed data objects, all properties in the object are optional.
     *  @param object item Original item data.
     *  @param string html The generated HTML
     *
     *  @returns bool Whether to hide the element.
     */
    self.moderate = function (data, item, html)
    {
        var result = true;

        if (data === false || data === '')
        {
            result = false;
        }
        else if (typeof(data) === 'string')
        {
            data = new RegExp('(' + data.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'g');

            result = data.test(html);
        }
        else if ($.isArray(data))
        {
            for (var i = 0; i < data.length; i++)
            {
                if (self.moderate(data[i], item, html))
                {
                    return true;
                }

                result = false;
            }
        }
        else if (typeof(data) === 'object')
        {
            var el_data = item;

            for (var key in data)
            {
                if (key in el_data && el_data[key] === data[key])
                {
                    result = true;
                }
                else
                {
                    return false;
                }
            }
        }

        return result;
    };
});

social.fn.extend(function (options)
{
	var self = this;

	var is_visible = false;
    var current_index = 0;
    var slide_count = 0;

    var scroll_position = {x: 0, y: 0};

    var $body = $('body');


    self.slideshow_container = null;

    /**
     *  Initialize slideshow.
     */
    self.init_slideshow = function (data)
    {
        if ($(window).width() > 500)
        {
            create_slideshow_html(data);
            init_events();
        }
    };

    /**
     *  Update slideshow items.
     */
    self.update_slideshow_items = function (data)
    {
    		self.slideshow_container.remove();
        self.init_slideshow(data);
        // if (options.lightbox)
        // {
        //     self.slideshow_container.remove();
        //     self.init_slideshow(data);
        // }
    };

    /**
     *  Toggle slideshow visibility.
     *
     *  @param bool show [optional] Whether to show or hide the slideshow.
     *  @param int index [optional] The slide index to which to navigate.
     */
    self.toggle_slideshow = function (show, index)
    {
        // if (!options.lightbox)
        // {
        //     return ;
        // }

        show = (show !== undefined || show !== null) ? show : !is_visible;
		is_visible = show;

        self.slideshow_container.toggleClass('show', show).css('visibility', ((show) ? 'visible': 'hidden'));

        if (!show)
        {
            self.slideshow_container.find('li').removeClass('show');
        }

        $body.css('overflow', ((show) ? 'hidden' : ''));


        self.navigate_slideshow(index);
    };

    /**
     *  Show slideshow.
     *
     *  @param int index The slide index to which to navigate.
     */
    self.show_slideshow = function (index)
    {
        // self.toggle_slideshow(true, index);
    };

    /**
     *  Hide slideshow.
     *
     *  @param int index The slide index to which to navigate.
     */
    self.hide_slideshow = function (index)
    {
        self.toggle_slideshow(false, index);
    };

    /**
     *  Go to prev slideshow.
     */
    self.prev_slideshow = function ()
    {
        self.navigate_slideshow(current_index - 1);
    };

    /**
     *  Go to next slideshow.
     */
    self.next_slideshow = function ()
    {
        self.navigate_slideshow(current_index + 1);
    };

    /**
     *  Navigate to a specific slide.
     *
     *  @param int index The slide index to which to navigate.
     */
    self.navigate_slideshow = function (index)
    {
        // if (!options.lightbox)
        // {
        //     return ;
        // }

        index = Math.max(0, Math.min(slide_count - 1, index));

        var prev_index = index - 1;
        var next_index = index + 1;

        self.slideshow_container.find('li').css('transition', '');

        center_current_item(self.slideshow_container.find('li').eq(index));

        self.slideshow_container.find('li').eq(index)
                                .addClass('show current')
                                .css('transform', '')
                                .siblings()
                                .removeClass('show current');

        var item_width = self.slideshow_container.find('li').eq(index).width();
        var item_offset = $(window).width() / 2 + item_width / 3;

        
        var transform_prev = 'translate3d(-' + item_offset + 'px, 0, 0)';
        var transform_next = 'translate3d(' + item_offset + 'px, 0, 0)';
        
        self.slideshow_container.find('li')
                                .eq(prev_index)
                                .addClass('show')
                                .css('transform', transform_prev)
                                .end()
                                .eq(next_index)
                                .addClass('show')
                                .css('transform', transform_next);


        transform_prev = 'translate3d(-' + (item_offset + 1500) + 'px, 0, 0)';
        transform_next = 'translate3d(' + (item_offset + 1500) + 'px, 0, 0)';


        self.slideshow_container.find('li')
                                .eq(prev_index - 1)
                                .addClass('show')
                                .css({'transform': transform_prev, 'transition': 'none'})
                                .end()
                                .eq(next_index + 1)
                                .addClass('show')
                                .css({'transform': transform_next, 'transition': 'none'});
        
        current_index = index;
    };

	/**
	 *	Is slideshow visible.
	 *
	 *	@return bool Whether the slideshow is visible or not.
	 */
	self.is_slideshow_visible = function ()
	{
		return is_visible;
	};

    /**
     *  Create slideshow HTML.
     */
    function create_slideshow_html(data)
    {
        self.slideshow_container = $(document.createElement('div')).addClass('cardz-social-slideshow cardz-social-slideshow-skin-' + options.skinLightbox)
                                                                   .attr('tabindex', 1).css('visibility', 'hidden');

        var items_holder = document.createElement('ul');

        items_holder.className = 'animated';

        $.each(data, function (index, item)
        {
            var item_object = $(document.createElement('li'));

            item_object.attr('data-network', item.network);

            item_object.append
            (
                '<div class="social-slide-item" data-network="'+ item.network +'">' +
                ((item.video_source !== undefined && item.video_source !== '') ? '<iframe src="' + item.video_source + '" width="100%" height="450px" frameborder="0" />' : ((item.attachment !== '') ? '<img src="' + item.attachment + '" />' : '')) +
                '   <div class="social-slide-content">' +
                '       <h3>' + item.message + '</h3>' +
                '       <p>' + item.description + '</p>' +
                '   </div>' +
                '   <div class="social-slide-footer">' +
                '       <a href="'+ item.author_link +'" target="_blank" title='+ item.author_name +'" class="social-author">' +
                '           <img src="'+ item.author_picture +'" class="social-author-image" />' +
                '           <p class="social-author-name">'+ item.author_name +'</p>'+
                '       </a>' +
                '       <div class="cardz-social-share-wrapper">' +
                            self.get_share_buttons_html() +
                '       </div>' +
                '	    <h1 class="social-date">'+ item.created +'</h1>' +
                '   </div>' +
                '</div>'
            );

            item_object.appendTo(items_holder);
        });

        slide_count = $(items_holder).children().length;

        self.slideshow_container.append(items_holder)
                                .append
        (
            '<nav>' +
            '    <span class="nav-prev"></span>' +
            '    <span class="nav-next"></span>' +
            '    <span class="nav-close"></span>' +
            '</nav>'
        );

        $('body').append(self.slideshow_container);
    }

    /**
     *  Initialize slideshow events.
     */
    function init_events()
    {
        self.slideshow_container.find('.nav-close').click(function (ev)
        {
            self.hide_slideshow();

            ev.preventDefault();
        });

        self.slideshow_container.find('.nav-prev').click(function (ev)
        {
            self.prev_slideshow();

            ev.preventDefault();
        });

        self.slideshow_container.find('.nav-next').click(function (ev)
        {
            self.next_slideshow();

            ev.preventDefault();
        });

        $(document).keydown(function (ev)
        {
            if (self.is_slideshow_visible)
            {
                var key_code = ev.keyCode || ev.which;

                switch (key_code)
                {
                case 37:    // Left arrow
                case 38:    // Up arrow
                    self.prev_slideshow();
                    break;
                case 39:    // Right arrow
                case 40:    // Down arrow
                    self.next_slideshow();
                    break;
                case 27:    // Esc
                    self.hide_slideshow();
                    break;
                }
            }
        });

        // Prevent scrolling when slideshow is visible.
        $(window).scroll(function ()
        {
            if (is_visible)
            {
                window.scrollTo(scroll_position.x, scroll_position.y);
            }
            else
            {
                scroll_position = {x: window.pageXOffset || window.document.documentElement.scrollLeft, y: window.pageYOffset || window.document.documentElement.scrollTop};
            }
        });
    }

    /**
     *  Center current item on screen.
     *
     *  This function assumes that the item has a top and left of 50%.
     *
     *  @param jQuery item The item to be centered.
     */
    function center_current_item(item)
    {
        item.css('margin-left', - (item.width() / 2));
        item.css('margin-top', - (item.height() / 2));
    }
});

social.fn.extend(function (options)
{
	var self = this;

    $.extend(options,
    {
        viewportFactor: 0.2,

        minDuration: 0.2,
        maxDuration: 0.8
    });

    /**
     *  Initialize the animation events.
     */
    this.init_animations = function ()
    {
        self.update_animations();
    };

    /**
     *  Update animations.
     */
    this.update_animations = function ()
    {
        if (self.is_mobile)
        {
            self.items.addClass('visible');

            return ;
        }

        // Make visible the items that are inside the viewport.
        self.items.each(function (index, item)
        {
            var $item = $(item);

            if (in_viewport($item))
            {
                
                $item.addClass('visible');
            }
        });
    };

    /**
     *  Update item animations.
     */
    self.update_item_animations = function ()
    {
        if (self.is_mobile)
        {
            self.items.addClass('visible');

            return ;
        }

        self.items.each(function (index, item)
        {
            var $item = $(item);

            if (!$item.hasClass('visible') && !$item.hasClass('animate') && in_viewport($item, options.viewportFactor))
            {
                var rand_duration = (Math.random() * (options.maxDuration - options.minDuration) + options.minDuration) + 's';

                $item.addClass('animate').css({'transition-duration': rand_duration, 'animation-duration': rand_duration});
            }
        });
    };

    /**
     *  Check if an element is inside the viewport.
     *
     *  @param object el The element for which to check.
     *  @param float factor Defines how much of the appearing item has to be visible in order to consider it is in viwport.
     *
     *  @return bool Returns true if the element is inside the viewport.
     */
    function in_viewport(el, factor)
    {
        var offset_height = el.outerHeight();
        var scroll_top = window.pageYOffset || document.documentElement.scrollTop;
        var viewed = scroll_top + $(window).height();
        var top = el.offset().top;
        var bottom = top + offset_height;

        factor = factor || 0;

        return (top + offset_height * factor) <= viewed && (bottom - offset_height * factor) >= scroll_top;
    }
});

$.fn.cardZSocial = function (options)
{
    options = $.extend({}, $.fn.cardZSocial.defaults, options);

    /*
     *  Disable the plugin for small screen. If the property is set to true, a width of 500 will be used.
     *  If the property is set to a number value, this will be used for comparison.
     */
    if (options.disableForSmallScreen)
	{
		if (typeof(options.disableForSmallScreen) === 'number')
		{
			if ($(window).width() <= options.disableForSmallScreen)
			{
				return false;
			}
		}
		else if ($(window).width() <= 500)
		{
			return false;
		}
	}

    /*
     *  Disable the plugin. If the property is set to true, the plugin will be disabled,
     *  if the property is set to a function, the function will be executed and if the
     *  return value is true, the plugin will be disabled.
     */
    if ($.isFunction(options.disable))
    {
        if (options.disable())
        {
            return false;
        }
    }
    else if (options.disable)
    {
        return false;
    }

    /**
     *  Instantiate and run the Social class.
     */
	function run_social()
	{
		var social_instance = null;

		if (!speedo.fn.social_instances)
		{
			speedo.fn.social_instances = 
			{
				get_from_element: function (el)
				{
					el = (el instanceof jQuery) ? el : $(el);

					if (!el.hasClass('cardz-social-container'))
					{
						el = el.closest('.cardz-social-container');
					}

					var index = el.data('social_instance');

					return speedo.fn.social_instances.list[index] || null;
				},
				get_current_instance: function ()
				{
					var instance = null;

					for (var key in speedo.fn.social_instances.list)
					{
						instance = speedo.fn.social_instances.list[key];

						if (instance.is_visible())
						{
							return instance;
						}
					}

					return null;
				},
				get_instance_by_index: function (index)
				{
					return speedo.fn.social_instances.list[index] || null;
				},
				get_instance_by_name: function (name)
				{
					var index = speedo.fn.social_instances.names[name];

					return speedo.fn.social_instances.get_instance_by_index(index);
				},
				names: {},
				list: []
			};
		}

		if (!this.data('unique-speedo-instance') || (options.closeMode === 'unload'))
		{
			social_instance = social(options);

			// Add the instance to a public array.
			speedo.fn.social_instances.list.push(social_instance);

			/*
             *	Set element for later use. This can be used in modules to access the parent instance.
             */
			social_instance.tag_element = this;

			social_instance.create(this);

			if (social_instance.container)
			{
				social_instance.container.data('social_instance', speedo.fn.social_instances.list.length - 1);
			}

			this.data('unique-speedo-instance', social_instance);
		}
		else
		{
			social_instance = this.data('unique-speedo-instance');

			social_instance.show_social();
		}

		return social_instance;
	}

	if (options.showOnEvent)
	{
		var self = this;

		$(self).on(options.showOnEvent, function (ev)
		{
			run_social.apply(self);

			ev.preventDefault();
			return false;
		});

		return null;
	}

	return run_social.apply(this);
};

/**
 *  Set the default options.
 *
 *  @var Object
 *  {
 *      @type Object networks The networks from which we get the data. The available networks:
 *                             facebook, twitter, google, youtube, vimeo, flickr, delicious,
 *                             pinterest, dribbble, rss, lastfm, stumbleupon, deviantart,
 *                             tumblr, instagram.
 *      @type array feedData Custom feed data. For more info see 'feed.js'.
 *      {
 *          @type number position 0 index based position on grid. If the iteration parameter is more than 1,
 *                                the position of the items is at every position.
 *          @type number iteration How many times these will be created.
 *		    @type string network		The network name.
 *		    @type string id				The user or page id.
 *		    @type string created		The item created time.
 *		    @type string author_link	The author link.
 *		    @type string author_picture	The author picture.
 *		    @type string author_name	The author name.
 *		    @type string message		The item message.
 *		    @type string description	The item description.
 *		    @type string link			Item link.
 *		    @type string attachment		Atached image URL.
 *      }
 *      @type bool|string|array|object moderate Moderate which posts to hide. If the value is false, this will be ignored and
 *                                              all posts will be vissible, if the value is a string, the posts which contains that string
 *                                              will be hidden, if the value is an array, the moderation will be procesed against all values
 *                                              in the array, if the value is an object, it will compare the values of the properties against the
 *                                              feed data objects, all properties in the object are optional.
 *      @type bool|string template The HTML template to be used for items. If this is null or false,
 *                                 the default template will be used.
 *      @type bool filters Show the filters bar.
 *      @type array filterButtons List of filter buttons added on the filters toolbar. It can be an array of strings conaining the networks, or an array of objects:
 *      {
 *          @type {string} type [optional] The type of the new button. This can have one of the following values:
 *                              'button'    Simple button that acts like a radio button in a group.
 *                              'toggle'    Toggle button, simply toggle on or off the filters.
 *                              'auto'      No button, it will automatically execute and filter based on the given cryteria.
 *          @type {string} network [optional] The network icon to be used.
 *          @type {string} caption [optional] The caption of the button.
 *          @type {Array|Function|string} action The action to be triggered when the button is fired. This can be a string which will represent the network or id of the network,
 *                                               it can be a function which will be executed, or it can be an array of functions or strings.
 *      }
 *      @type array shareButtons An array of share buttons and their order.
 *      @type string loader Loader image. It can be one of 'light', 'dark', or a URL to a custom loader.
 *      @type string orderBy Order by data.
 *      @type string order Order asc or desc.
 *      @type bool itemShadow Wether to add the shadow on the items. This will add a class named shadow on the items holder element.
 *      @type string|bool effect The animation effect used to show grid items.
 *      @type bool|string share If this is false the share buttons will not show. If this is a string and is 'window' the share links will open
 *                              in a new window, if it is 'popup' the share links will open in a popup.
 *      @type number duration Animation duration.
 *      @type string skin The skin name for the stream.
 *      @type string skinFilters The skin name for the filters toolbar.
 *      @type string skinLightbox The skin name for the lightbox.
 *      @type string skinsPath The URL to the skins directory. If the skins directory is in the same as the main JS file,
 *                             the skins URL should be automatically assigned.
 *      @type bool hideIfNoImage Hide the item if the image is not available. Default false.
 *      @type string limitTextType How should we limit the text? By the number of characters or by the number of words? Default to words.
 *      @type number limitText The number of character or words to limit the text. If this is less than 0 there will be no limit applied. Default to -1.
 *      @type bool toolbar Whether to show the toolbar.
 *      @type bool lightbox Whether to show the lightbox.
 *      @type Object cache Caching options
 *      {
 *          @type bool enabled Whether the client-side caching is enabled.
 *          @type string method [optional] The caching method, this can be one of:
 *                      'auto' - Choose automatically which method to use.
 *                      'local-storage' - Store data in localStorage.
 *                      'database' - Store data in a database. This will automatically choose between 'Web SQL Database' or 'Indexed Database'.
 *          @type number valability [optional] How much time to store the data. Value in hours.
 *      }
 *      @type Object search Search options
 *      {
 *          @type bool global Whether the search should be global or only the first item.
 *          @type bool caseSensitive Whether the search is case sensitive.
 *      }
 *      @type Object grid Options for the grid
 *      {
 *          @type number cols The number of columns the grid should have. If this is set the,
 *                            width of a column will be calculated automatically.
 *          @type number width The width of the columns. If this is set, the number of columns it will
 *                             be calculated.
 *          @type number minWidth The minimum width an item can have. Default is 150px
 *          @type number gutter The space between items.
 *      }
 *      @type bool responsive Whether the plugin elements are responsive.
 *      @type bool clickableLinks Whether to make the URLs clickable.
 *      @type string showOnEvent Init the plugin on a specific event. You can use all type of jQuery events.
 *      @type bool|number disableForSmallScreen Disable the plugin for small screen. If the property is set to true, a width of 500 will be used.
 *                                              If the property is set to a number value, this will be used for comparison.
 *      @type bool|function disable Disable the plugin. If the property is set to true, the plugin will be disabled, if the property is set to a
 *                                  function, the function will be executed and if the return value is true, the plugin will be disabled.
 *      
 *  }
 */
$.fn.cardZSocial.defaults = 
{
	networks: {},
    feedData: [],

    moderate: false,

	template: false,

    filters: false,
    filterButtons: null,

    shareButtons: ['facebook', 'twitter', 'google'],

    loader: 'light',

    effect: 'fade',
    duration: 200,

    skin: 'default',
    skinFilters: 'default',
    skinLightbox: 'default',

    pluginURL: null,
    skinsPath: null,

    limitTextType: 'words', // 'words' or 'chars'.
    limitText: -1,

    hideIfNoImage: false,
    toolbar: true,
    lightbox: true,
    share: 'window',

    orderBy: 'auto',
    order: 'asc',

    itemShadow: true,

    cache:
    {
        enabled: true,
        method: 'auto',
        valability: 1   // The cache is valid for 1 hour.
    },

    pagination:
    {
        itemsPerPage: 10,
        type: 'button'
    },

    search:
    {
        global: false,
        caseSensitive: false
    },

    /* Grid options */
    grid:
    {
        cols: 8,    // Columns
        width: false,
        minWidth: 150,
        gutter: 10  // Space between items.
    },

    responsive: true,
    clickableLinks: true,

	showOnEvent: '',
	disableForSmallScreen: false,
	disable: false
};

$(function ()
{
	// Create an object to register options for later use.
	speedo.fn.socialOptions = {};

	speedo.fn.socialOptions.list = {};

	speedo.fn.socialOptions.register = speedo.fn.socialOptions.update = function (name, options)
	{
		speedo.fn.socialOptions.list[name] = options;
	};

	speedo.fn.socialOptions.unregister = function (name)
	{
		delete speedo.fn.socialOptions.list[name];
	};

	speedo.fn.socialOptions.get = function (name)
	{
		if (speedo.fn.socialOptions.list.hasOwnProperty(name))
		{
			return speedo.fn.socialOptions.list[name];
		}

		return {};
	};

    // Pass options to the social via the URL.
	if (window.location.search !== '')
	{
		var query = speedo().utility.query_parameters(window.location);

		if (query.hasOwnProperty('cardz-social'))
		{
			try
			{
				var options = JSON.parse(query['cardz-social']);

				options = $.extend({
					effectIn: 'fade',
					effectOut: 'fade'
				}, options);

				$(this).cardZSocial(options);
			}
			catch (ex)
			{
					
			}
		}

		if (query.hasOwnProperty('cardz-social-use'))
		{
			try
			{
				// Delay the call, because the options will be set sometime after this.
				setTimeout(function ()
				{
					var options = speedo.fn.socialOptions.get(query['cardz-social-use']);

					$(this).cardZSocial(options);
				}, 100);
			}
			catch (ex)
			{
			}
		}		
	}

    /**
     *  Handle cardz-social tag.
     */
    var speedo_social_tag = $('cardz-social');

    // Handle IE 8.
    if (speedo().browser.is_ie && speedo().browser.version.high <= 8)
    {
        document.createElement('cardz-social');

        speedo_social_tag = $(document.getElementsByTagName('cardz-social'));
    }

    speedo_social_tag.each(function ()
    {
        var $this = $(this);
        var options = $this.attr('options');
        var use = $this.attr('use');

        if (options !== undefined)
        {
            options = JSON.parse($this.attr('options'));
        }

        if (use !== undefined)
        {
            // Delay the call, because the options will be set sometime after this.
			setTimeout(function ()
			{
                $.extend(options, speedo.fn.socialOptions.get(use));

				$this.cardZSocial(options);
			}, 100);
        }
        else
        {
            $this.cardZSocial(options);
        }
    });
});

social.fn.extend(function (options)
{
	var self = this;

    self.is_mobile = (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4)) ? true : false);

    /**
     *  Throttle to ensure we don't call a function too often.
     *
     *  @param function fn Function to call.
     *  @param number delay The amount of time to delay the function call.
     *
     *  @return function Returns a function to be called until the time passes.
     */
    self.throttle = function (fn, delay)
    {
        var last_call = 0;

        return function ()
        {
            var now = +new Date();

            if (now - last_call < delay)
            {
                return ;
            }

            last_call = now;

            return fn.apply(arguments);
        };
    };

    /**
     *  Get plugin URL.
     *
     *  Note - This function will not work if the file is renamed.
     *
     *  @return string Returns the URL of the plugin.
     */
    self.get_plugin_url = function ()
    {
        var base_url = '';

        if (options.pluginURL)
        {
            base_url = options.pluginURL;
        }
        else
        {
            var scripts = document.getElementsByTagName('script');
            var source = '';
            var pattern = /(cardz\.social\.min\.js|cardz\.social\.js|speedo\.files\.js)/i;

            for (var i = 0; i < scripts.length; i++)
            {
                source = scripts[i].src;

                if (source && pattern.test(source))
                {
                    base_url = source.replace(pattern, '').replace(/[?#].*/g, '');

                    // If we are in the debug mode. make sure we go in the source directory.
                    if (~source.indexOf('speedo.files.js'))
                    {
                        base_url += 'source/';
                    }
                }
            }
        }

        return base_url;
    };

    /**
     *  Check for SMIL support.
     */
    self.is_smil_supported = function ()
    {
        return ('createElementNS' in document && /SVGAnimate/.test(String(document.createElementNS('http://www.w3.org/2000/svg', 'animate'))));
    };

    /**
     *  Is CSS file already loaded?
     *
     *  @param string css_url The full CSS URL.
     *
     *  @return bool Returns true if the CSS file is already loaded.
     */
    self.is_css_loaded = function (css_url)
    {
        var style_sheets = document.styleSheets;

        for (var i = 0; i < style_sheets.length; i++)
        {
            if (style_sheets[i].href === css_url)
            {
                return true;
            }
        }

        return false;
    };

    /**
     *  Is JS file already loaded?
     *
     *  This is not reliable if the already loaded script is loaded with relative position
     *  and the given URL is an absolute URL, but, for our purpose it should do the job.
     *
     *  @param string js_url The full JS URL.
     *
     *  @return bool Returns true if the JS file is already loaded.
     */
    self.is_js_loaded = function (js_url)
    {
        var scripts = document.getElementsByTagName('script');

        for (var i = 0; i < scripts.length; i++)
        {
            if (scripts[i].src === js_url)
            {
                return true;
            }
        }

        return false;
    };

    /**
     *  Load CSS file.
     *
     *  @param string css_url The CSS URL relative to the plugin URL.
     *
     *  @return object DOM Link object.
     */
    self.load_css_file = function (css_url)
    {
        css_url = self.get_plugin_url() + css_url;

        // Prevent the loading of an already loaded CSS.
        if (self.is_css_loaded(css_url))
        {
            return ;
        }

        var link = document.createElement('link');

        link.rel = 'stylesheet';
        link.onload = function ()
        {
            /*
             *  Trigger event when the stylesheet is loaded.
             *
             *  @param object link The link element.
             *  @param string css_url CSS url.
             *  @param string status Wether this is an error.
             */
            self.trigger('load.css', [link, css_url, 'success']);
        };
        link.onerror = function ()
        {
            /*
             *  Trigger event if the stylesheet is not loaded because an error.
             *
             *  @param object link The link element.
             *  @param string css_url CSS url.
             *  @param string status Wether this is an error.
             */
            self.trigger('load.css', [link, css_url, 'fail']);
        };
        link.href = css_url;

        document.getElementsByTagName('head')[0].appendChild(link);

        return link;
    };

    /**
     *  Load JS file.
     *
     *  @param string js_url The JS URL relative to the plugin URL.
     *
     *  @return object DOM Script object.
     */
    self.load_js_file = function (js_url)
    {
        js_url = self.get_plugin_url() + js_url;

        // Prevent the loading of an already loaded CSS.
        if (self.is_js_loaded(js_url))
        {
            return ;
        }

        var script = document.createElement('script');

        script.onload = function ()
        {
            /*
             *  Trigger event when the JS is loaded.
             *
             *  @param object script The script element.
             *  @param string js_url JS url.
             *  @param string status Wether this is an error.
             */
            self.trigger('load.js', [script, js_url, 'success']);
        };
        script.onerror = function ()
        {
            /*
             *  Trigger event if the JS is not loaded because an error.
             *
             *  @param object script The script element.
             *  @param string js_url JS url.
             *  @param string status Wether this is an error.
             */
            self.trigger('load.js', [script, js_url, 'fail']);
        };
        script.src = js_url;

        document.getElementsByTagName('head')[0].appendChild(script);

        return script;
    };

    /**
     *  Limit the text to a number of words or characters.
     *
     *  @param string text The text to limit.
     *  @param number limit The number of characters or words.
     *  @param type Wheter to limit to the number of characters or number of words.
     *
     *  @return string Returns the limited string or the original string.
     */
    self.limit_text = function (text, limit, type)
    {
        type = type || 'words';

        if (!text || limit <= 0)
        {
            return text;
        }

        if (type === 'words')
        {
            return text.split(' ').slice(0, limit).join(' ');
        }
        else if (type === 'chars')
        {
            return text.substr(0, limit);
        }

        return text;
    };
});

social.fn.extend(function ()
{
	var self = this;

   /*var format_factors =
    {
        'millisecods': 1,
        'seconds': 1e3,
        'minutes': 6e4,
        'hours': 36e5,
        'days': 864e5,
        'months': 2592e6,
        'years': 31536e6
    };*/

    /*var _relativeTime =
	{
        future : 'in %s',
        past : '%s ago',
        s : 'a few seconds',
        m : 'a minute',
        mm : '%d minutes',
        h : 'an hour',
        hh : '%d hours',
        d : 'a day',
        dd : '%d days',
        M : 'a month',
        MM : '%d months',
        y : 'a year',
        yy : '%d years'
    };*/

    /**
     *  Format string similar to printf, but much more simple.
     *
     *  @param string format Format string composed of 0 or more directives to replace.
     *  @param mixed ...args [optional] Arguments to replace in the string.
     *
     *  @return string Returns a string formated according to the given directives.
     */
    self.format = function (format)
    {
        var args = arguments;
        var index = 0;

        return format.replace(/%([sfd])/g, function ()
        {
            return args[++index];
        });
    };

    /**
     *  Format time.
     *
     *  @param object date A date object from which to format the time.
     *  @param int [optional] The current time.
     *
     *  @return string Returns the formated time.
     */
    self.format_date = function (date, current_date)
    {
        current_date = current_date || Date.now();
        var diff_date = current_date - date;
        var future = (diff_date < 0) ? 'next_' : '';

        diff_date = (diff_date < 0) ? - diff_date : diff_date;

        //console.log(future, diff_date);
        var diff =
        {
            seconds: Math.floor(diff_date / 1e3),
            minutes: Math.floor(diff_date / 6e4),
            hours: Math.floor(diff_date / 36e5),
            days: Math.floor(diff_date / 864e5),
            weeks: Math.floor(diff_date / 6048e5),
            months: Math.floor(diff_date / 2592e6),
            years: Math.floor(diff_date / 31536e6)
        };
        var formats =
        [
            {item: 'years', single: 'last year', multiple: '%d years', next_single: 'next year', next_multiple: '%d years from now'},
            {item: 'months', single: 'last month', multiple: '%d months', next_single: 'next month', next_multiple: '%d months from now'},
            {item: 'weeks', single: 'last week', multiple: '%d weeks', next_single: 'next week', next_multiple: '%d weeks from now'},
            {item: 'days', single: 'yesterday', multiple: '%d days', next_single: 'tomorrow', next_multiple: '%d days from now'},
            {item: 'hours', single: '1 hour ago', multiple: '%d hours', next_single: '1 hour from now', next_multiple: '%d hours from now'},
            {item: 'minutes', single: '1 minute ago', multiple: '%d minutes', next_single: '1 minute from now', next_multiple: '%d minutes from now'},
            {item: 'seconds', single: 'just now', multiple: 'just now', next_single: '1 second from now', next_multiple: '%d seconds from now'}
        ];

        for (var i = 0; i < formats.length; i++)
        {
            if (diff[formats[i].item] > 0)
            {
                return (diff[formats[i].item] === 1) ? formats[i][future + 'single'] : self.format(formats[i][future + 'multiple'], diff[formats[i].item]);
            }
        }

        return 'just now';
    };
});

social.fn.extend(function (options)
{
	var self = this;

    var viewport =
    {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    };

    /**
     *  Lazy load images and frames.
     *
     *  @param object el Image or frame objct. This can be a DOM element or a jQuery element.
     *  @param bool force Force element loading.
     */
    self.lazy_load = function (el, force)
    {
        el = (el instanceof jQuery) ? el : $(el);

        set_viewport_bounds();

        if (el.get(0).nodeName.toLowerCase() === 'img' || el.data('type') === 'img')
        {
            load_image(el, force);
        }
        else
        {
            load_frame(el, force);
        }
    };

    /**
     *  Lazy load images.
     *
     *  @param object el The image object to load.
     *  @param bool force Force image loading.
     */
    function load_image(el, force)
    {
        if (force || is_in_view(el))
        {
            var source = el.data('src');

            if (source)
            {
                var image = new Image();

                image.onload = function ()
                {
                    if (el.get(0).nodeName.toLowerCase() === 'img')
                    {
                        el.attr('src', source);
                    }
                    else
                    {
                        el.css('background-image', 'url("' + source + '")');
                    }

                    // Remove the data attribute.
                    el.attr('data-src', '');

                    /*
                     *  Trigger event when image loading was finished.
                     *
                     *  @param object el The image element.
                     *  @param string The type of loaded element. This can be 'image' or 'frame'.
                     *  @param string Image loadin status.
                     */
                    self.trigger('lazy.load', [el, 'image', 'success']);
                };

                image.onerror = function ()
                {
                    /*
                     *  Trigger event when image loading was finished.
                     *
                     *  @param object el The image element.
                     *  @param string The type of loaded element. This can be 'image' or 'frame'.
                     *  @param string Image loadin status.
                     */
                    self.trigger('lazy.load', [el, 'image', 'fail']);
                };

                image.src = source;
            }
        }
    }

    /**
     *  Lazy load iframe.
     *
     *  @param object el The frame object to load.
     *  @param bool force Force iftame loading.
     */
    function load_frame(el, force)
    {
        if (force || is_in_view(el))
        {
            var source = el.data('src');

            if (source)
            {
                var frame = document.createElement('iframe');

                frame.onload = function ()
                {
                    // Replace the placeholder with the frame.
                    el.replaceWith(frame);

                    /*
                     *  Trigger event when frame loading is finished.
                     *
                     *  @param object el The image element.
                     *  @param string The type of loaded element. This can be 'image' or 'frame'.
                     */
                     self.trigger('lazy.load', [el, 'frame']);
                };

                frame.src = source;
            }
        }
    }

    /**
     *  Set viewport bounds.
     */
    function set_viewport_bounds()
    {
        var offset = options.lazyOffset || 10;

        viewport =
        {
            top: offset,
            right: (window.innerWidth || document.documentElement.clientWidth) + offset,
            bottom: (window.innerHeight || document.documentElement.clientHeight) + offset,
            left: 0
        };
    }

    /**
     *  Check if a element is in viewport.
     *
     *  @param object el The element.
     *
     *  @return bool Returns true if the element is in viewport.
     */
    function is_in_view(el)
    {
        var bounds = el.get(0).getBoundingClientRect();

        return (
            bounds.top <= viewport.bottom &&
            bounds.right >= viewport.left &&
            bounds.bottom >= viewport.top &&
            bounds.left <= viewport.right
        );
    }
});

social.fn.extend(function ()
{
	var self = this;
	var event_stack = {};

	/**
	 *	Bind an event to this instance of speedo social.
	 *
	 *	@param string type One ore more event types.
	 *	@param mixed params [optional] Parameters that will be passed to the event handler.
	 *	@param function handler A function to execute each time the event is triggered.
	 */
	self.bind = function (type, params, handler)
	{
		handler = (handler !== undefined) ? handler : params;

		if (!(type in event_stack))
		{
			event_stack[type] = [];
		}

		event_stack[type].push(
		{
			fn: handler,
			params: params || []
		});
	};

	/**
	 *	Unbind a previously-attached event from this instance of the speedo social.
	 *
	 *	@param string type One ore more event types.
	 *	@param function handler The function that was attached to the event handler.
	 */
	self.unbind = function (type, handler)
	{
		if (type in event_stack)
		{
			for (var i = 0; i < event_stack[type].length; i++)
			{
				if (event_stack[type][i].fn === handler)
				{
					delete event_stack[type][i];
				}
			}
		}
	};

	/**
	 *	Trigger an attached event.
	 *
	 *	@param string type One ore more event types.
	 *	@param mixed params [optional] Parameters that will be passed to the event handler.
	 */
	self.trigger = function (type, params)
	{
		if (type in event_stack)
		{
			for (var i = 0; i < event_stack[type].length; i++)
			{
				params = ($.isArray(params)) ? params : [params];
				params = params.concat($.isArray(event_stack[type][i].params) ? event_stack[type][i].params : [event_stack[type][i].params]);

				event_stack[type][i].fn.apply(this, params);
			}
		}
	};
});

social.fn.extend(function (options)
{
	/* Private vaiables */
	var self = this;

	/**
	 *	Hold the networks objects.
	 *
	 *	@var object
	 */
	self.networks = {};

	/**
	 *	Holds feed data.
	 *
	 *	@var object
	 */
	self.feed_data = [];

    /**
	 *	Holds custom feed data.
	 *
	 *	@var object
	 */
	self.custom_feed_data = null;

	/**
	 *	Update feed data.
	 *
	 *	@return object Returns a jQuery Promise object which gets resolved when all network request were processed.
	 */
	self.update = function ()
	{
		var promises = [];
		var options = this.options;
        var data = null;
        var deferred = $.Deferred();

        for (var network in options.networks)
		{
			if ($.isArray(options.networks[network]))
			{
				for (var i = 0; i < options.networks[network].length; i++)
				{
					data = options.networks[network][i];
					promises.push(self.request_data(network, data));
				}
			}
			else
			{
				data = options.networks[network];

				promises.push(self.request_data(network, data));
			}
		}

        $.when.apply(null, promises).done(function (feed)
        {
            var cache_data = false; //self.get_cache('czch');

            if (cache_data)
            {
                self.feed_data = feed = cache_data;
            }
            else
            {
                var custom_feeds = self.custom_feed_data || options.feedData || [];

                feed = feed || self.feed_data || [];

                feed = feed.concat(custom_feeds);

                self.feed_data = feed = process_feed(feed);

                //self.add_cache('czch', self.feed_data);
            }

            deferred.resolve(feed);
        });

        // Add custom feed data.
        //self.feed_data = self.feed_data.concat(options.feedData);

		//return $.when.apply(null, promises).promise();
        return deferred.promise();
	};

    /**
     *  Set custom feed data.
     *
     *  @param array feed_data Custom feed data.
     */
    self.set_feed_data = function (feed_data)
    {
        self.custom_feed_data = feed_data;

        self.feed_data = process_feed(feed_data);

        self.items_holder.children().remove();
        self.reset_page();
        self.next_page();

        self.update_toolbar_html();
        self.update_slideshow_items(feed_data);

        // If there are pages, show the load more button.
        if (self.load_more && self.is_next_page_available())
        {
            self.load_more.show();
        }
    };

	/**
	 *	Request data from a social network.
	 *
	 *	@param string network The social network name.
	 *	@param object options The options from which we configure the URL.
	 *	{
	 *		@type string url_type	The URL type, this can be: feed or share.
	 *		@type string id			The page or user ID for the specific social network.
	 *		@type string url		The URL of a page you want to share. This is used when url_type is share.
	 *		@type string api_key	The API Key needed by some social networks.
	 *		@type string feed		The feed name. Used for networks using RSS.
	 *		@type string title		The tile used wehn the url_type is share.
	 *		@type string img		The image used when the url_type is share.
	 *		@type int limit			The limit of items.
	 *		@type string provider	The company who is sharing the URL. Used by dribble.
	 *		@type int is_video		If the content is a video or not. Used by pintrest.
	 *	}
	 *
	 *	@return object Returns a jQuery Promise object.
	 */
	self.request_data = function (network, options)
	{
		var deferred = $.Deferred();
		var request_url = self.get_network_url(network, options);

		// If this is a request for youtube, we need to get the playlist URL first.
		if (network === 'youtube')
		{
			request_url = self.networks[network].get_playlist_url(request_url, options);
		}

        var request_data = $.extend(true,
        {
            url: request_url,
            type: 'get'
        }, self.networks[network].request_data || {});

        $.ajax(request_data).done(function (data)
		{
            var new_data = self.networks[network].get_data(data, options);
            self.feed_data = self.feed_data.concat(new_data);
			//$.extend(self.feed_data, self.networks[network].get_data(data, options));

            deferred.resolve();

			//deferred.resolve(self.feed_data);
		}).fail(function ()
		{
			// We don't want to make things hang because of one network.
			deferred.resolve();
		});

		return deferred.promise();
	};

	/**
	 *	Get URL for social networks.
	 *
	 *	@param string network The social network name.
	 *	@param object options The options from which we configure the URL.
	 *	{
	 *		@type string url_type	The URL type, this can be: feed or share.
	 *		@type string id			The page or user ID for the specific social network.
	 *		@type string url		The URL of a page you want to share. This is used when url_type is share.
	 *		@type string api_key	The API Key needed by some social networks.
	 *		@type string feed		The feed name. Used for networks using RSS.
	 *		@type string title		The tile used wehn the url_type is share.
	 *		@type string img		The image used when the url_type is share.
	 *		@type int limit			The limit of items.
	 *		@type string provider	The company who is sharing the URL. Used by dribble.
	 *		@type int is_video		If the content is a video or not. Used by pintrest.
	 *	}
	 *
	 *	@return string The URL for the specified social network.
	 */
	self.get_network_url = function (network, options)
	{
		var rss = 'http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num={{=limit}}&q=';

		var urls =
		{
			feed:
			{
                twitter: '',
				facebook: 'https://graph.facebook.com/{{=id}}/posts?pretty=0&fields=id,object_id,from,message,story,description,link,picture&limit={{=limit}}&access_token={{=api_key}}',
				google: 'https://www.googleapis.com/plus/v1/people/{{=id}}/activities/public?key={{=api_key}}',
				//youtube: 'https://gdata.youtube.com/feeds/api/users/{{=id}}/uploads?alt=json&max-results={{=limit}}',
				youtube: 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails&forUsername={{=id}}&maxResults={{=limit}}&key={{=api_key}}',
                instagram: 'https://api.instagram.com/v1/tags/{{=id}}/media/recent?client_id={{=api_key}}',
                soundcloud: 'http://api.soundcloud.com/resolve.json?url=https://soundcloud.com/{{=id}}/tracks&client_id={{=api_key}}',
                pinterest: 'https://api.pinterest.com/v3/pidgets/users/{{=id}}/pins/',
                //pinterest: rss + 'http://pinterest.com/{{=id}}/feed.rss',
                //pinterest: 'https://api.pinterest.com/v3/pidgets/boards/{{=id}}/pins/',
				vimeo: 'http://vimeo.com/api/v2/{{=id}}/videos.json',
                foursquare: rss + 'https://feeds.foursquare.com/history/{{=id}}.rss',
                vine: '',
                // Move to the new v1 api.
                dribbble: 'http://api.dribbble.com/players/{{=id}}/shots',
                flickr: 'https://api.flickr.com/services/feeds/photos_public.gne?id={{=id}}&lang=en-us&size=b&format=json&jsoncallback=?',
				//flickr: 'http://api.flickr.com/services/rest/?extras=tags%2Cdescription%2Cdate_upload&nojsoncallback=1&api_key={{=api_key}}&method=flickr.people.getPublicPhotos&format=json&per_page={{=limit}}&user_id={{=id}}',
                tumblr: 'http://{{=id}}.tumblr.com/api/read/json?callback=helpers.cb&num={{=limit}}',
                vk: 'https://api.vk.com/method/wall.get?owner_id={{=id}}&count={{=limit}}&filter=owner&extended=1',

				linkedin: 'http://www.linkedin.com/company/{{=id}}/',
				delicious: 'http://feeds.delicious.com/v2/json/{{=id}}',
				lastfm: rss + encodeURIComponent('https://ws.audioscrobbler.com/2.0/user/{{=id}}/{{=feed}}.rss'),
				stumbleupon: rss + encodeURIComponent('http://rss.stumbleupon.com/user/{{=id}}/{{=feed}}'),
				deviantart: rss + encodeURIComponent('https://backend.deviantart.com/rss.xml?type=deviation&q=by%3A{{=id}}+sort%3Atime+meta%3Aall'),
                rss: rss + '{{=id}}'
			},
			share:
			{
                twitter: 'https://twitter.com/share?url={{=url}}&text={{=title}}&via={{=via}}&hashtags={{=hashtags}}',
				facebook: 'http://www.facebook.com/sharer.php?u={{=url}}',
				google: 'https://plus.google.com/share?url={{=url}}',
				linkedin: 'http://www.linkedin.com/shareArticle?url={{=url}}&title={{=title}}',
				delicious: 'https://delicious.com/save?v=5&provider={{=provider}}&noui&jump=close&url={{=url}}&title={{=title}}',
				pinterest: 'https://pinterest.com/pin/create/bookmarklet/?media={{=img}}&url={{=url}}&is_video={{=is_video}}&description={{=title}}',
				stumbleupon: 'http://www.stumbleupon.com/submit?url={{=url}}&title={{=title}}',
				tumblr: 'http://www.tumblr.com/share/link?url={{=url}}&name={{=title}}&description={{=desc}}',
				digg: 'http://digg.com/submit?url={{=url}}&title={{=title}}',
                vk: 'http://vk.com/share.php?url={{=link}}'
			}
		};

        if (network === 'flickr' && options.type && options.type === 'tag')
        {
            urls.feed.flickr = 'https://api.flickr.com/services/feeds/photos_public.gne?tags={{=id}}&format=json&jsoncallback=?';
        }

        if (~options.id.indexOf('/'))
        {
            urls.feed.pinterest = 'https://api.pinterest.com/v3/pidgets/boards/{{=id}}/pins/';
        }

		options = $.extend({},
		{
			url_type: 'feed',
			id: '',
			url: '',
			api_key: '',
			feed: '',
			title: '',
			img: '',
			limit: 30,
			provider: '',
			is_video: 0
		}, options);

		return speedo.fn.template.process((network in urls[options.url_type]) ? urls[options.url_type][network] : '', {scope: options});
	};

    /**
     *  Go through feed data and handle iteration, position and ordering.
     *
     *  @param array feed_data An array of objects of the following structure:
     *  {
     *      @type int iteration     [optional] The number of times the item should be repeated.
     *      @type int position      [optional] The position inside the array.
	 *		@type string url_type	The URL type, this can be: feed or share.
	 *		@type string id			The page or user ID for the specific social network.
	 *		@type string url		The URL of a page you want to share. This is used when url_type is share.
	 *		@type string api_key	The API Key needed by some social networks.
	 *		@type string feed		The feed name. Used for networks using RSS.
	 *		@type string title		The tile used wehn the url_type is share.
	 *		@type string img		The image used when the url_type is share.
	 *		@type int limit			The limit of items.
	 *		@type string provider	The company who is sharing the URL. Used by dribble.
	 *		@type int is_video		If the content is a video or not. Used by pintrest.
	 *	}
     *
     *  @return array Returns the processed array.
     */
    function process_feed(feed_data)
    {
        var iteration = 1;
        var feed_length = feed_data.length;
        var new_feed_data = [];

        for (var i = 0; i < feed_length; i++)
        {
            iteration = ('iteration' in feed_data[i]) ? feed_data[i].iteration : 1;

            for (var j = 0; j < iteration; j++)
            {
                if ('position' in feed_data[i])
                {
                    new_feed_data.splice(feed_data[i].position * (j + 1), 0, feed_data[i]);

                    continue;
                }
                else
                {
                    new_feed_data.push(feed_data[i]);
                }
            }
        }

        if (options.order_by)
        {
            new_feed_data = self.order_feed(new_feed_data, options.order_by, options.order);
        }

        return new_feed_data;
    }
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.facebook = {};

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.data, function ()
		{
			var item =
			{
				network:		'facebook',
				id:				this.id,
				created:		this.created_time,
				author_link:	'http://facebook.com/' + this.from.id,
				author_picture:	'https://graph.facebook.com/' + this.from.id + '/picture',
				author_name:	this.from.name,
				message:		this.message || this.story || '',
				description:	this.description || '',
				link:			this.link || 'http://facebook.com/' + this.from.id,
				attachment:		''
			};

			if (this.picture)
			{
				// Get the largest image.
				if (~this.picture.indexOf('_b.'))
				{
					item.attachment = this.picture;
				}
                else if (~this.picture.indexOf('safe_image.php'))
                {
                    item.attachment = get_external_image_url(this.picture, 'url');
                }
                else if (~this.picture.indexOf('app_full_proxy.php'))
                {
                    item.attachment = get_external_image_url(this.picture, 'src');
                }
                else if (this.object_id)
				{
					item.attachment = 'https://graph.facebook.com/' + this.object_id + '/picture/?width=800';
				}
                else if (this.id)
                {
                    item.attachment = 'https://graph.facebook.com/' + this.id.replace(this.from.id + '_', '') + '/picture/?width=800';
                }
				else // Make sure we don't break the feed.
				{
					item.attachment = this.picture;
				}
			}

			items.push(item);
		});

		return items;
	};

    /**
     *  Get external image URL.
     *
     *  @param url string The original image URL.
     *  @param param string The parameter in the URL.
     *
     *  @return string Returns the image URL.
     */
    function get_external_image_url(url, param)
    {
        url = decodeURIComponent(url).split(param + '=')[1];

        // Is fbcdn-sphotos in the URL ?
        if (!~url.indexOf('fbcdn-sphotos'))
        {
            return url.split('&')[0];
        }

        return url;
    }
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.google = {};

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.items, function ()
		{
			var item =
			{
				network:		'google',
				id:				this.id,
				created:		this.published,
				author_link:	this.actor.url,
				author_picture:	this.actor.image.url,
				author_name:	this.actor.displayName,
				message:		this.title,
				description:	this.description || '',
				link:			this.url,
				attachment:		''
			};

			if (this.object.attachments)
			{
				$.each(this.object.attachments, function ()
				{
					if (this.fullImage)
					{
						item.attachment = this.fullImage.url;
					}
					else
					{
						if (this.objectType === 'album')
						{
							if (this.thumbnails && this.thumbnails.length > 0)
							{
								if (this.thumbnails[0].image)
								{
									item.attachment = this.thumbnails[0].image.url;
								}
							}
						}
					}
				});
			}

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.youtube = {};

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.items, function ()
		{
			var item =
			{
				network:		'youtube',
				id:				this.id,
				created:		this.snippet.publishedAt,
				author_link:	'https://www.youtube.com/channel/' + this.snippet.channelId,
				author_picture:	'',
				author_name:	this.snippet.channelTitle,
				message:		this.snippet.title,
				description:	this.snippet.description || '',
				link:			'https://www.youtube.com/watch?v=' + this.snippet.resourceId.videoId,
				attachment:		''
			};

			// Set the thumbnail.
			if (this.snippet.thumbnails)
			{
				// Try to get the largest version.
				if ('maxres' in this.snippet.thumbnails)
				{
					item.attachment = this.snippet.thumbnails.maxres.url;
				}
				else if ('standard' in this.snippet.thumbnails)
				{
					item.attachment = this.snippet.thumbnails.standard.url;
				}
				else if ('high' in this.snippet.thumbnails)
				{
					item.attachment = this.snippet.thumbnails.high.url;
				}
				else if ('medium' in this.snippet.thumbnails)
				{
					item.attachment = this.snippet.thumbnails.medium.url;
				}
				else if ('default' in this.snippet.thumbnails)
				{
					item.attachment = this.snippet.thumbnails['default'].url;
				}
			}

			items.push(item);
		});

		return items;
	};

	/**
	 *	Get the user playlist URL from a URL request to youtube.
	 *
	 *	@param string url The URL to get the youtube data.
	 *	@param object options The options.
	 *
	 *	@return string A URL for the URL.
	 */
	self.get_playlist_url = function (url, options)
	{
		options = $.extend({},
		{
			limit: 0,
			api_key: ''
		}, options);

		var request_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' + options.limit + '&key=' + options.api_key;

		$.ajax(
		{
			type: 'get',
			url: url,
			async: false,
			dataType: 'json'
		}).done(function (data)
		{
            var playlist_id = (data.items[0]) ? data.items[0].contentDetails.relatedPlaylists.uploads : '';

			request_url += '&playlistId=' + playlist_id;

		}).error(function ()
		{
			request_url = '';
		});

		return request_url;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.instagram = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.data, function ()
		{
			var item =
			{
				network:		'instagram',
				id:				this.id,
				created:		this.created_time,
				author_link:	'http://instagram.com/' + this.user.username,
				author_picture:	this.user.profile_picture,
				author_name:	this.user.full_name,
				message:		(this.caption) ? this.caption.text : '',
				description:	'',
				link:			this.link,
				attachment:		this.images.standard_resolution.url
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.soundcloud = {};

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data, function ()
		{
			var item =
			{
				network:		'soundcloud',
				id:				this.id,
				created:		this.created_at,
				author_link:	this.user.uri,
				author_picture:	this.user.avatar_url,
				author_name:	this.user.username,
				message:		this.title || '',
				description:	this.description || '',
				link:			this.uri,
				attachment:		this.artwork_url || this.waveform_url
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.pinterest = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

        if (data.status !== 'success')
        {
            return [];
        }

		$.each(data.data.pins, function ()
		{
			var item =
			{
				network:		'pinterest',
				id:				this.id,
				created:		data.generated_at,
				author_link:	data.data.user.profile_url,
				author_picture:	data.data.user.image_small_url,
				author_name:	data.data.user.full_name,
				message:		this.description || '',
				description:	this.description || '',
				link:			this.link,
				attachment:		''
			};

            var highest_width = 0;

            // Get the highest image.
            for (var image in this.images)
            {
                if (this.images[image].width > highest_width)
                {
                    item.attachment = this.images[image].url;

                    highest_width = this.images[image].width;
                }
            }

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.vimeo = {};

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data, function ()
		{
			var item =
			{
				network:		'vimeo',
				id:				this.id,
				created:		this.upload_date,
				author_link:	this.user_url,
				author_picture:	this.user_portrait_medium,
				author_name:	this.user_name,
				message:		this.title || '',
				description:	this.description || '',
				link:			this.url,
				attachment:		this.thumbnail_large
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.foursquare = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];
        var feed = data.responseData.feed;

		$.each(feed.entries, function ()
		{
			var item =
			{
				network:		'foursquare',
				id:				this.id,
				created:		this.publishedDate,
				author_link:	feed.link,
				author_picture:	'',
				author_name:	feed.title,
				message:		this.contentSnippet || '',
				description:	'',
				link:			this.link,
				attachment:		$(this.content).find('img').attr('src') || ''
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.rss = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];
        var feed = data.responseData.feed;

		$.each(feed.entries, function ()
		{
			var item =
			{
				network:		'rss',
				id:				this.id,
				created:		this.publishedDate,
				author_link:	feed.link,
				author_picture:	'',
				author_name:	feed.title,
				message:		this.contentSnippet || '',
				description:	'',
				link:			this.link,
				attachment:		$(this.content).find('img').attr('src') || ''
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.dribbble = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.shots, function ()
		{
			var item =
			{
				network:		'dribbble',
				id:				this.id,
				created:		this.created_at,
				author_link:	this.player.url,
				author_picture:	this.player.avatar_url,
				author_name:	this.player.name,
				message:		this.title || '',
				description:	this.description || '',
				link:			this.url,
				attachment:		this.image_url || ''
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.flickr = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.items, function ()
		{
			var item =
			{
				network:		'flickr',
				id:				'',
				created:		this.published,
				author_link:	'https://flickr.com/photos/' + this.author_id,
				author_picture:	'https://flickr.com/buddyicons/' + this.author_id + '.jpg',
				author_name:	this.author,
				message:		this.title || '',
				description:	this.description || '',
				link:			this.link,
				attachment:		this.media.m || ''
			};

			items.push(item);
		});

		return items;
	};
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.tumblr = {};

    /**
     *  Additional options passed to the ajax request.
     */
    self.request_data = { dataType: 'jsonp' };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.posts, function ()
		{
			var item =
			{
				network:		'tumblr',
				id:				this.id,
				created:		this.date,
				author_link:	'http://' + this.id + '.tumblr.com',
				author_picture:	'',
				author_name:	data.tumblelog.title,
				message:		this[this.type + '-caption'].replace( /<.+?>/gi, ' ') || '',
				description:	this[this.type + '-caption'] || '',
				link:			this.url,
				attachment:		get_attachement(this),
                video_source:   ''
			};

            if ('video-source' in this)
            {
                if (~this['video-source'].indexOf('vine.'))
                {
                    item.video_source = this['video-source'] + '/embed/simple';
                }
                else if (~this['video-source'].indexOf('youtube'))
                {
                    item.video_source = this['video-source'].replace(/^.*(youtu.be\/|v\/|embed\/|watch\?|youtube.com\/user\/[^#]*#([^\/]*?\/)*)\??v?=?([^#\&\?]*).*/g, 'http://www.youtube.com/embed/$3?fs=1&amp;rel=0');
                }
            }

			items.push(item);
		});

		return items;
	};

    /**
     *  Get attachment image from post.
     *
     *  @param object post The post item.
     *
     *  @return string The URL of the image or an empty string.
     */
    function get_attachement(post)
    {
        switch (post.type)
        {
        case 'photo':
            return post['photo-url-250'];
        }

        return '';
    }
});

social.fn.extend(function ()
{
	/* Private vaiables */
	var self = this.networks.vk = {};

    self.request_data = 
    {
        dataType: 'jsonp'
    };

	/**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@param object data JSON object containing the data from the social network.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
	self.get_data = function (data)
	{
		var items = [];

		$.each(data.response.wall, function ()
		{
            if (typeof this === 'number' || !this.id)
            {
                return ;
            }

			var item =
			{
				network:		'vk',
				id:				this.id,
				created:		this.date * 1000,
				author_link:	'http://vk.com/id' + this.to_id,
				author_picture:	data.response.profiles[0].photo,
				author_name:	data.response.profiles[0].first_name + ' ' + data.response.profiles[0].last_name || '',
				message:		this.text || '',
				description:	'',
				link:			'',
				attachment:		(this.attachment) ? this.attachment.photo.src_big : ''
			};

			items.push(item);
		});

		return items;
	};
});

if (!speedo.fn.plugins)
	{
		speedo.fn.plugins = {};
	}
	
	/*
	 *	Register social plugin.
	 */
	speedo.fn.plugins.social = social;

}(window, document, jQuery));