/**
 * Makes "skip to content" link work correctly in IE9, Chrome, and Opera
 * for better accessibility.
 *
 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 */

( function() {
    var ua = navigator.userAgent.toLowerCase();

    if ( ( ua.indexOf( 'webkit' ) > -1 || ua.indexOf( 'opera' ) > -1 || ua.indexOf( 'msie' ) > -1 ) &&
        document.getElementById && window.addEventListener ) {

        window.addEventListener( 'hashchange', function() {
            var element = document.getElementById( location.hash.substring( 1 ) );

            if ( element ) {
                if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.nodeName ) ) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false );
    }
} )();

/*!
 * EventEmitter v4.2.6 - git.io/ee
 * Oliver Caldwell
 * MIT license
 * @preserve
 */

(function () {
    
    'use strict';
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
     * Finds the index of the listener for the event in it's storage array.
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
        if (typeof evt === 'object') {
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
     * automatically removed after it's first execution.
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

        // If evt is an object then pass each of it's properties to this method
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
        else if (type === 'object') {
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
        this.EventEmitter = EventEmitter;
    }
}.call(this));

/*!
 * eventie v1.0.4
 * event binding helper
 *   eventie.bind( elem, 'click', myFn )
 *   eventie.unbind( elem, 'click', myFn )
 */

/*jshint browser: true, undef: true, unused: true */
/*global define: false */

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

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'eventie/eventie',eventie );
} else {
  // browser global
  window.eventie = eventie;
}

})( this );

/*!
 * imagesLoaded v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

( function( window, factory ) { 
  // universal module definition

  /*global define: false, module: false, require: false */

  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( [
      'eventEmitter/EventEmitter',
      'eventie/eventie'
    ], function( EventEmitter, eventie ) {
      return factory( window, EventEmitter, eventie );
    });
  } else if ( typeof exports === 'object' ) {
    // CommonJS
    module.exports = factory(
      window,
      require('wolfy87-eventemitter'),
      require('eventie')
    );
  } else {
    // browser global
    window.imagesLoaded = factory(
      window,
      window.EventEmitter,
      window.eventie
    );
  }

})( window,

// --------------------------  factory -------------------------- //

function factory( window, EventEmitter, eventie ) {



var $ = window.jQuery;
var console = window.console;
var hasConsole = typeof console !== 'undefined';

// -------------------------- helpers -------------------------- //

// extend objects
function extend( a, b ) {
  for ( var prop in b ) {
    a[ prop ] = b[ prop ];
  }
  return a;
}

var objToString = Object.prototype.toString;
function isArray( obj ) {
  return objToString.call( obj ) === '[object Array]';
}

// turn element or nodeList into an array
function makeArray( obj ) {
  var ary = [];
  if ( isArray( obj ) ) {
    // use object if already an array
    ary = obj;
  } else if ( typeof obj.length === 'number' ) {
    // convert nodeList to array
    for ( var i=0, len = obj.length; i < len; i++ ) {
      ary.push( obj[i] );
    }
  } else {
    // array of single index
    ary.push( obj );
  }
  return ary;
}

  // -------------------------- imagesLoaded -------------------------- //

  /**
   * @param {Array, Element, NodeList, String} elem
   * @param {Object or Function} options - if function, use as callback
   * @param {Function} onAlways - callback function
   */
  function ImagesLoaded( elem, options, onAlways ) {
    // coerce ImagesLoaded() without new, to be new ImagesLoaded()
    if ( !( this instanceof ImagesLoaded ) ) {
      return new ImagesLoaded( elem, options );
    }
    // use elem as selector string
    if ( typeof elem === 'string' ) {
      elem = document.querySelectorAll( elem );
    }

    this.elements = makeArray( elem );
    this.options = extend( {}, this.options );

    if ( typeof options === 'function' ) {
      onAlways = options;
    } else {
      extend( this.options, options );
    }

    if ( onAlways ) {
      this.on( 'always', onAlways );
    }

    this.getImages();

    if ( $ ) {
      // add jQuery Deferred object
      this.jqDeferred = new $.Deferred();
    }

    // HACK check async to allow time to bind listeners
    var _this = this;
    setTimeout( function() {
      _this.check();
    });
  }

  ImagesLoaded.prototype = new EventEmitter();

  ImagesLoaded.prototype.options = {};

  ImagesLoaded.prototype.getImages = function() {
    this.images = [];

    // filter & find items if we have an item selector
    for ( var i=0, len = this.elements.length; i < len; i++ ) {
      var elem = this.elements[i];
      // filter siblings
      if ( elem.nodeName === 'IMG' ) {
        this.addImage( elem );
      }
      // find children
      // no non-element nodes, #143
      var nodeType = elem.nodeType;
      if ( !nodeType || !( nodeType === 1 || nodeType === 9 || nodeType === 11 ) ) {
        continue;
      }
      var childElems = elem.querySelectorAll('img');
      // concat childElems to filterFound array
      for ( var j=0, jLen = childElems.length; j < jLen; j++ ) {
        var img = childElems[j];
        this.addImage( img );
      }
    }
  };

  /**
   * @param {Image} img
   */
  ImagesLoaded.prototype.addImage = function( img ) {
    var loadingImage = new LoadingImage( img );
    this.images.push( loadingImage );
  };

  ImagesLoaded.prototype.check = function() {
    var _this = this;
    var checkedCount = 0;
    var length = this.images.length;
    this.hasAnyBroken = false;
    // complete if no images
    if ( !length ) {
      this.complete();
      return;
    }

    function onConfirm( image, message ) {
      if ( _this.options.debug && hasConsole ) {
        console.log( 'confirm', image, message );
      }

      _this.progress( image );
      checkedCount++;
      if ( checkedCount === length ) {
        _this.complete();
      }
      return true; // bind once
    }

    for ( var i=0; i < length; i++ ) {
      var loadingImage = this.images[i];
      loadingImage.on( 'confirm', onConfirm );
      loadingImage.check();
    }
  };

  ImagesLoaded.prototype.progress = function( image ) {
    this.hasAnyBroken = this.hasAnyBroken || !image.isLoaded;
    // HACK - Chrome triggers event before object properties have changed. #83
    var _this = this;
    setTimeout( function() {
      _this.emit( 'progress', _this, image );
      if ( _this.jqDeferred && _this.jqDeferred.notify ) {
        _this.jqDeferred.notify( _this, image );
      }
    });
  };

  ImagesLoaded.prototype.complete = function() {
    var eventName = this.hasAnyBroken ? 'fail' : 'done';
    this.isComplete = true;
    var _this = this;
    // HACK - another setTimeout so that confirm happens after progress
    setTimeout( function() {
      _this.emit( eventName, _this );
      _this.emit( 'always', _this );
      if ( _this.jqDeferred ) {
        var jqMethod = _this.hasAnyBroken ? 'reject' : 'resolve';
        _this.jqDeferred[ jqMethod ]( _this );
      }
    });
  };

  // -------------------------- jquery -------------------------- //

  if ( $ ) {
    $.fn.imagesLoaded = function( options, callback ) {
      var instance = new ImagesLoaded( this, options, callback );
      return instance.jqDeferred.promise( $(this) );
    };
  }


  // --------------------------  -------------------------- //

  function LoadingImage( img ) {
    this.img = img;
  }

  LoadingImage.prototype = new EventEmitter();

  LoadingImage.prototype.check = function() {
    // first check cached any previous images that have same src
    var resource = cache[ this.img.src ] || new Resource( this.img.src );
    if ( resource.isConfirmed ) {
      this.confirm( resource.isLoaded, 'cached was confirmed' );
      return;
    }

    // If complete is true and browser supports natural sizes,
    // try to check for image status manually.
    if ( this.img.complete && this.img.naturalWidth !== undefined ) {
      // report based on naturalWidth
      this.confirm( this.img.naturalWidth !== 0, 'naturalWidth' );
      return;
    }

    // If none of the checks above matched, simulate loading on detached element.
    var _this = this;
    resource.on( 'confirm', function( resrc, message ) {
      _this.confirm( resrc.isLoaded, message );
      return true;
    });

    resource.check();
  };

  LoadingImage.prototype.confirm = function( isLoaded, message ) {
    this.isLoaded = isLoaded;
    this.emit( 'confirm', this, message );
  };

  // -------------------------- Resource -------------------------- //

  // Resource checks each src, only once
  // separate class from LoadingImage to prevent memory leaks. See #115

  var cache = {};

  function Resource( src ) {
    this.src = src;
    // add to cache
    cache[ src ] = this;
  }

  Resource.prototype = new EventEmitter();

  Resource.prototype.check = function() {
    // only trigger checking once
    if ( this.isChecked ) {
      return;
    }
    // simulate loading on detached element
    var proxyImage = new Image();
    eventie.bind( proxyImage, 'load', this );
    eventie.bind( proxyImage, 'error', this );
    proxyImage.src = this.src;
    // set flag
    this.isChecked = true;
  };

  // ----- events ----- //

  // trigger specified handler for event type
  Resource.prototype.handleEvent = function( event ) {
    var method = 'on' + event.type;
    if ( this[ method ] ) {
      this[ method ]( event );
    }
  };

  Resource.prototype.onload = function( event ) {
    this.confirm( true, 'onload' );
    this.unbindProxyEvents( event );
  };

  Resource.prototype.onerror = function( event ) {
    this.confirm( false, 'onerror' );
    this.unbindProxyEvents( event );
  };

  // ----- confirm ----- //

  Resource.prototype.confirm = function( isLoaded, message ) {
    this.isConfirmed = true;
    this.isLoaded = isLoaded;
    this.emit( 'confirm', this, message );
  };

  Resource.prototype.unbindProxyEvents = function( event ) {
    eventie.unbind( event.target, 'load', this );
    eventie.unbind( event.target, 'error', this );
  };

  // -----  ----- //

  return ImagesLoaded;

});
/**
 * @preserve
 * Project: Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Version: v2.1.3
 * Contributors: Mattia Larentis
 * Dependencies: Bootstrap's Dropdown plugin, jQuery
 * Description: A simple plugin to enable Bootstrap dropdowns to active on hover and provide a nice user experience.
 * License: MIT
 * Homepage: http://cameronspear.com/blog/bootstrap-dropdown-on-hover-plugin/
 */
;(function ($, window, undefined) {
    // outside the scope of the jQuery plugin to
    // keep track of all dropdowns
    var $allDropdowns = $();

    // if instantlyCloseOthers is true, then it will instantly
    // shut other nav items when a new one is hovered over
    $.fn.dropdownHover = function (options) {
        // don't do anything if touch is supported
        // (plugin causes some issues on mobile)
        if('ontouchstart' in document) return this; // don't want to affect chaining

        // the element we really care about
        // is the dropdown-toggle's parent
        $allDropdowns = $allDropdowns.add(this.parent());

        return this.each(function () {
            var $this = $(this),
                $parent = $this.parent(),
                defaults = {
                    delay: 500,
                    hoverDelay: 0,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    hoverDelay: $(this).data('hover-delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                showEvent   = 'show.bs.dropdown',
                hideEvent   = 'hide.bs.dropdown',
                // shownEvent  = 'shown.bs.dropdown',
                // hiddenEvent = 'hidden.bs.dropdown',
                settings = $.extend(true, {}, defaults, options, data),
                timeout, timeoutHover;

            $parent.hover(function (event) {
                // so a neighbor can't open the dropdown
                if(!$parent.hasClass('open') && !$this.is(event.target)) {
                    // stop this event, stop executing any code
                    // in this callback but continue to propagate
                    return true;
                }

                openDropdown(event);
            }, function () {
                // clear timer for hover event
                window.clearTimeout(timeoutHover)
                timeout = window.setTimeout(function () {
                    $this.attr('aria-expanded', 'false');
                    $parent.removeClass('open');
                    $this.trigger(hideEvent);
                }, settings.delay);
            });

            // this helps with button groups!
            $this.hover(function (event) {
                // this helps prevent a double event from firing.
                // see https://github.com/CWSpear/bootstrap-hover-dropdown/issues/55
                if(!$parent.hasClass('open') && !$parent.is(event.target)) {
                    // stop this event, stop executing any code
                    // in this callback but continue to propagate
                    return true;
                }

                openDropdown(event);
            });

            // handle submenus
            $parent.find('.dropdown-submenu').each(function (){
                var $this = $(this);
                var subTimeout;
                $this.hover(function () {
                    window.clearTimeout(subTimeout);
                    $this.children('.dropdown-menu').show();
                    // always close submenu siblings instantly
                    $this.siblings().children('.dropdown-menu').hide();
                }, function () {
                    var $submenu = $this.children('.dropdown-menu');
                    subTimeout = window.setTimeout(function () {
                        $submenu.hide();
                    }, settings.delay);
                });
            });

            function openDropdown(event) {
                // clear dropdown timeout here so it doesnt close before it should
                window.clearTimeout(timeout);
                // restart hover timer
                window.clearTimeout(timeoutHover);
                
                // delay for hover event.  
                timeoutHover = window.setTimeout(function () {
                    $allDropdowns.find(':focus').blur();

                    if(settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');
                    
                    // clear timer for hover event
                    window.clearTimeout(timeoutHover);
                    $this.attr('aria-expanded', 'true');
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                }, settings.hoverDelay);
            }
        });
    };

    $(document).ready(function () {
        // apply dropdownHover to all elements with the data-hover="dropdown" attribute
        $('[data-hover="dropdown"]').dropdownHover();
          //  Fix First Click Menu /

    });
    $(document.body).on('click', '.nav [data-toggle="dropdown"]' ,function(){
        if(  this.href && this.href != '#'){
            window.location.href = this.href;
        }
    });

})(jQuery, window);


(function ($) {
    "use strict";
    $.fn.wrapStart = function(numWords){
        return this.each(function(){
            var $this = $(this);
            var node = $this.contents().filter(function(){
                return this.nodeType == 3;
            }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
            if (!node.length) return;
            node[0].nodeValue = text.slice(first.length);
            node.before('<b>' + first + '</b>');
        });
    }; 

    jQuery(document).ready(function() {
        $('.mod-heading .widget-title > span').wrapStart(1);
        function init_owl() {
            $(".owl-carousel[data-carousel=owl]").each( function(){
                var config = {
                    loop: false,
                    nav: $(this).data( 'nav' ),
                    dots: $(this).data( 'pagination' ),
                    items: 4,
                    navText: ['<span class="ion-ios-arrow-left"></span>', '<span class="ion-ios-arrow-right"></span>']
                };
            
                var owl = $(this);
                if( $(this).data('items') ){
                    config.items = $(this).data( 'items' );
                }
                if( $(this).data('loop') ){
                    config.loop = true;
                }
                if ($(this).data('margin') || $(this).data('margin') == 0) {
                    config.margin = $(this).data('margin');
                } else {
                    config.margin = 30;
                }
                if ($(this).data('large')) {
                    var desktop = $(this).data('large');
                } else {
                    var desktop = config.items;
                }
                if ($(this).data('medium')) {
                    var medium = $(this).data('medium');
                } else {
                    var medium = config.items;
                }
                if ($(this).data('smallmedium')) {
                    var smallmedium = $(this).data('smallmedium');
                } else {
                    var smallmedium = config.items;
                }
                if ($(this).data('extrasmall')) {
                    var extrasmall = $(this).data('extrasmall');
                } else {
                    var extrasmall = 2;
                }
                if ($(this).data('verysmall')) {
                    var verysmall = $(this).data('verysmall');
                } else {
                    var verysmall = 1;
                }
                config.responsive = {
                    0:{
                        items:verysmall
                    },
                    320:{
                        items:extrasmall
                    },
                    768:{
                        items:smallmedium
                    },
                    980:{
                        items:medium
                    },
                    1280:{
                        items:desktop
                    }
                }
                if ( $('html').attr('dir') == 'rtl' ) {
                    config.rtl = true;
                }
                $(this).owlCarousel( config );
                // owl enable next, preview
                var viewport = jQuery(window).width();
                var itemCount = jQuery(".owl-item", $(this)).length;

                if(
                    (viewport >= 1280 && itemCount <= desktop) //desktop
                    || ((viewport >= 980 && viewport < 1280) && itemCount <= medium) //desktop
                    || ((viewport >= 768 && viewport < 980) && itemCount <= smallmedium) //tablet
                    || ((viewport >= 320 && viewport < 768) && itemCount <= extrasmall) //mobile
                    || (viewport < 320 && itemCount <= verysmall) //mobile
                ) {
                    $(this).find('.owl-prev, .owl-next').hide();
                }
            } );
        }
        setTimeout(function(){
            init_owl();
        }, 50);
        
        // Fix owl in bootstrap tabs
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            $(".owl-carousel[data-carousel=owl]", target).each(function(){
                var carousel = $(this).data('owlCarousel');
                carousel._width = $(this).width();
                carousel.invalidate('width');
                carousel.refresh();
            });
            initProductImageLoad();
        });
        
        $('.main-menu li.dropdown a').click(function() {
            window.location = $(this).attr('href');
        });

        setTimeout(function(){
            initProductImageLoad();
        }, 500);
        function initProductImageLoad() {
            $(window).off('scroll.unveil resize.unveil lookup.unveil');
            var $images = $('.image-wrapper:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.image-wrapper').first().addClass('image-loaded');
                    });
                });
            }
        }

        //counter up
        if($('.counterUp').length > 0){
            $('.counterUp').counterUp({
                delay: 10,
                time: 800
            });
        }
        /*---------------------------------------------- 
         * Play Isotope masonry
         *----------------------------------------------*/  
        jQuery('.isotope-items,.blog-masonry').each(function(){  
            var $container = jQuery(this);
        
            $container.imagesLoaded( function(){
                $container.isotope({
                    itemSelector : '.isotope-item',
                    transformsEnabled: true         // Important for videos
                }); 
            });
        });
        /*---------------------------------------------- 
         *    Apply Filter        
         *----------------------------------------------*/
        jQuery('.isotope-filter li:first-child a').addClass('active');
        jQuery('.isotope-filter li a').on('click', function(){
           
            var parentul = jQuery(this).parents('ul.isotope-filter').data('related-grid');
            jQuery(this).parents('ul.isotope-filter').find('li a').removeClass('active');
            jQuery(this).addClass('active');
            var selector = jQuery(this).attr('data-filter'); 
            jQuery('#'+parentul).isotope({ filter: selector }, function(){ });
            
            return(false);
        });

        //Sticky Header
        // setTimeout(function(){
        //     change_margin_top();
        // }, 20);
        // $(window).resize(function(){
        //     change_margin_top();
        // });
        // function change_margin_top() {
        //     if ($(window).width() > 991) {
        //         if ( $('.main-sticky-header').length > 0 ) {
        //             var header_height = $('.main-sticky-header').outerHeight();
        //             $('.main-sticky-header-wrapper').css({'height': header_height});
        //         }
        //     }
        // }
        var main_sticky = $('.main-sticky-header');
        
        if ( main_sticky.length > 0 ){
            var _menu_action = main_sticky.offset().top;
            var Apus_Menu_Fixed = function(){
                "use strict";

                if( $(document).scrollTop() > _menu_action ){
                  main_sticky.addClass('sticky-header');
                }else{
                  main_sticky.removeClass('sticky-header');
                }
            }
            if ($(window).width() > 991) {
                $(window).scroll(function(event) {
                    Apus_Menu_Fixed();
                });
                Apus_Menu_Fixed();
            }
        }

        //Tooltip
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

        $('.topbar-mobile .dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });

        var back_to_top = function () {
            jQuery(window).scroll(function () {
                if (jQuery(this).scrollTop() > 400) {
                    jQuery('#back-to-top').addClass('active');
                } else {
                    jQuery('#back-to-top').removeClass('active');
                }
            });
            jQuery('#back-to-top').on('click', function () {
                jQuery('html, body').animate({scrollTop: '0px'}, 800);
                return false;
            });
        };
        back_to_top();
        
        // popup
        $(document).ready(function() {
            $(".popup-image").magnificPopup({type:'image'});
            $('.popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        });

        // mobile menu
        $('[data-toggle="offcanvas"], .btn-offcanvas').on('click', function (e) {
            e.stopPropagation();
            $('#apus-mobile-menu').toggleClass('active');           
            $('.over-dark').toggleClass('active');           
        });
        $('body').click(function() {
            if ($('.apus-offcanvas').hasClass('active')) {
                $('#apus-mobile-menu').toggleClass('active');
                $('.over-dark').toggleClass('active'); 
            }
        });
        $('#apus-mobile-menu').click(function(e) {
            e.stopPropagation();
        });

        // compare sidebar
        $('.compare-sidebar-btn').on('click', function (e) {
            e.stopPropagation();
            $('#compare-sidebar').toggleClass('open');
        });
        $('.compare-sidebar-wrapper').perfectScrollbar();

        $('.show-vertical').on('click', function (e) {
            e.stopPropagation();
            $('.header-v3').toggleClass('active');
        });
        
        $('body').click(function() {
            if ($('#wrapper-container').hasClass('active')) {
                $('#wrapper-container').toggleClass('active');
                $('#aups-mobile-menu').toggleClass('active');
            }
        });
        $('#apus-mobile-menu').click(function(e) {
            e.stopPropagation();
        });
        
        $("#main-mobile-menu .icon-toggle").on('click', function(){
            $(this).parent().find('> .sub-menu').slideToggle();
            if ( $(this).find('i').hasClass('fa-plus') ) {
                $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
            } else {
                $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
            }
            return false;
        } );

        // preload page
        var $body = $('body');
        if ( $body.hasClass('apus-body-loading') ) {

            setTimeout(function() {
                $body.removeClass('apus-body-loading');
                $('.apus-page-loading').fadeOut(250);
            }, 500);
        }

        // testimonial
        $("[data-testimonial=content]").each( function(){
            var self = $(this);
            var owl = $(this).find('.owl-carousel');
            setTimeout(function(){
                owl.find('.testimonial-body').removeClass('active');
                owl.find('.owl-item.active').find('.testimonial-body').addClass('active');
                self.find('.testimonial-content').html( '' ).fadeOut(200);
                self.find('.testimonial-content').html( owl.find('.owl-item.active').find('.description').html() ).fadeIn(300);
            }, 100);
            owl.on('changed.owl.carousel',function(property){
                setTimeout(function(){
                    owl.find('.testimonial-body').removeClass('active');
                    owl.find('.owl-item.active').find('.testimonial-body').addClass('active');
                    self.find('.testimonial-content').html( '' ).fadeOut(200);
                    self.find('.testimonial-content').html( owl.find('.owl-item.active').find('.description').html() ).fadeIn(300);
                }, 100);
            });
        });
        $("[data-testimonial=content-grid]").each( function(){
            var self = $(this);
            $('.testimonial-body', self).click(function(){
                self.find('.testimonial-body').removeClass('active');
                $(this).addClass('active');
                self.find('.testimonial-content').html( '' ).fadeOut(200);
                self.find('.testimonial-content').html( $(this).find('.description').html() ).fadeIn(300);
            });
            self.find('.testimonial-body').removeClass('active');
            self.find('.testimonial-body').eq(0).addClass('active');
            self.find('.testimonial-content').html( '' ).fadeOut(200);
            self.find('.testimonial-content').html( $(this).find('.description').html() ).fadeIn(300);
        });

        // gmap 3
        $('.apus-google-map').each(function(){
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');
            var zoom = $(this).data('zoom');
            var id = $(this).attr('id');
            if ( $(this).data('marker_icon') ) {
                var marker_icon = $(this).data('marker_icon');
            } else {
                var marker_icon = '';
            }
            $('#'+id).gmap3({
                map:{
                    options:{
                        "draggable": true
                        ,"mapTypeControl": true
                        ,"mapTypeId": google.maps.MapTypeId.ROADMAP
                        ,"scrollwheel": false
                        ,"panControl": true
                        ,"rotateControl": false
                        ,"scaleControl": true
                        ,"streetViewControl": true
                        ,"zoomControl": true
                        ,"center":[lat, lng]
                        ,"zoom": zoom
                        ,'styles': $(this).data('style')
                    }
                },
                marker:{
                    latLng: [lat, lng],
                    options: {
                        icon: marker_icon,
                    }
                }
            });
        });
        
        setTimeout(function(){
            vc_rtl();
        }, 100);
        $(window).resize(function(){
            vc_rtl();
        });
        function vc_rtl() {
            if( jQuery('html').attr('dir') == 'rtl' ){
                jQuery('[data-vc-full-width="true"]').each( function(i,v){
                    jQuery(this).css('right' , jQuery(this).css('left') ).css( 'left' , 'auto');
                });
            }
        }

        // popup newsletter
        setTimeout(function(){
            var hiddenmodal = getCookie('hiddenmodal');
            if (hiddenmodal == "") {
                jQuery('#popupNewsletterModal').modal('show');
            }
        }, 3000);
        $('#popupNewsletterModal').on('hidden.bs.modal', function () {
            setCookie('hiddenmodal', 1, 30);
        });

        // properties slider
        $('.widget-properties-slider .thumbnails li').each(function(e){
            $(this).click(function(event){
                $('.widget-properties-slider .owl-carousel').trigger("to.owl.carousel", [e, 0, true]);
                $('.widget-properties-slider .thumbnails li').removeClass('active');
                $(this).addClass('active');
            });
        });
        $('.widget-properties-slider .owl-carousel').on('changed.owl.carousel', function(event) {
            setTimeout(function(){
                var index = 0;
                $('.widget-properties-slider .owl-carousel .owl-item').each(function(i){
                    if ($(this).hasClass('active')){
                        index = i;
                    }
                });
                $('.widget-properties-slider .thumbnails li').removeClass('active');
                $('.widget-properties-slider .thumbnails li').eq(index).addClass('active');
            },50);
        });

        // single gallery
        $('.property-gallery-index .thumb-link').each(function(e){
            $(this).click(function(event){
                event.preventDefault();
                $('.property-gallery-preview-owl').trigger("to.owl.carousel", [e, 0, true]);
                
                $('.property-gallery-index .thumb-link').removeClass('active');
                $(this).addClass('active');
                return false;
            });
        });
        $('.property-gallery-preview-owl').on('changed.owl.carousel', function(event) {
            setTimeout(function(){
                var index = 0;
                $('.property-gallery-preview-owl .owl-item').each(function(i){
                    if ($(this).hasClass('active')){
                        index = i;
                    }
                });
                $('.property-gallery-index .thumb-link').removeClass('active');
                $('.property-gallery-index .owl-item').eq(index).find('.thumb-link').addClass('active');
            },50);
        });

        // Find all YouTube videos
        $( '[href="#tab-content-video"]' ).click(function(){
            $('#tab-content-video').find('iframe').css({
                width: '100%',
                height: '388px'
            });
            
        });

        iframe_full_width();
        function iframe_full_width(){
            var $fluidEl = $(".pro-fluid-inner, .video-embed-wrapper");
            var $videoEls = $(".pro-fluid-inner iframe, .video-embed-wrapper iframe");
            $videoEls.each(function() {
                $(this).data('aspectRatio', this.height / this.width)
                .removeAttr('height')
                .removeAttr('width');
            });

            $(window).resize(function() {
                $fluidEl.each(function(){
                    var newWidth = $(this).width();
                    var $videoEl = $(this).find("iframe");
                    $videoEl.each(function() {
                        var $el = $(this);
                        $el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
                    });
                });
            }).resize();
        }

        // Bookmark Course
        $( "body" ).on( "click", ".apus-favorite-add", function( e ) {
            e.preventDefault();
            if ( $(this).hasClass('loading') ) {
                return false;
            }
            var self = $(this);
            self.addClass('loading');
            var post_id = self.data('id');
            var url = homesweet_ajax.ajaxurl + '?action=homesweet_add_favorite&post_id=' + post_id;
            
            $.ajax({
                url: url,
                type:'POST',
                dataType: 'json',
            }).done(function(reponse) {
                self.removeClass('apus-favorite-add').removeClass('loading').addClass('apus-favorite-added');
                //self.text( homesweet_ajax.favorite_view_text );
            });
        });

        $( "body" ).on( "click", ".apus-favorite-not-login", function( e ) {
            e.preventDefault();
            $.magnificPopup.open({
                mainClass: 'apus-mfp-zoom-small-in',
                items    : {
                    src : '<div class="apus-favorite-need-login">' + $('.apus-favorite-login-info').html() + '</div>',
                    type: 'inline'
                }
            });
        });
        // favorite remove
        $( "body" ).on( "click", ".apus-favorite-remove", function( e ) {
            e.preventDefault();
            var self = $(this);
            self.addClass('loading');
            
            var post_id = $(this).data('id');
            var url = homesweet_ajax.ajaxurl + '?action=homesweet_remove_favorite&post_id=' + post_id;
            $.ajax({
                url: url,
                type:'POST',
                dataType: 'json',
            }).done(function(reponse) {
                if (reponse.status) {
                    var parent = $('#favorite-property-' + post_id).parent().parent();
                    if ( $('.favorite-item', parent).length <= 1 ) {
                        location.reload();
                    } else {
                        $('#favorite-property-' + post_id).parent().remove();
                    }
                } else {
                    $.magnificPopup.open({
                        mainClass: 'apus-mfp-zoom-small-in',
                        items: {
                            src : reponse.msg,
                            type: 'inline'
                        }
                    });
                }
            });
        });

        // sticky
        if ($(window).width() > 991) {
            setTimeout(function(){
                if ($('.sticky-this').length > 0) {
                    $('.sticky-this').stick_in_parent({
                        parent: ".sticky-v-wrapper",
                        spacer: false
                    });
                }
            }, 50);
        }

        // listing review
        if ( $('.comment-form-rating').length > 0 ) {
            var $star = $('.comment-form-rating .filled');
            var $review = $('#apus_input_rating');
            $star.find('li').on('mouseover',
                function () {
                    $(this).nextAll().find('span').removeClass('fa-star').addClass('fa-star-o');
                    $(this).prevAll().find('span').removeClass('fa-star-o').addClass('fa-star');
                    $(this).find('span').removeClass('fa-star-o').addClass('fa-star');
                    $review.val($(this).index() + 1);
                }
            );
        }

        // sticky tabs
        var affix_height = 0;
        var affix_height_top = 0;
        setTimeout(function(){
            change_margin_top_affix();
        }, 50);
        $(window).resize(function(){
            change_margin_top_affix();
        });

        function change_margin_top_affix() {
            if ($(window).width() > 991) {
                if ( $('.panel-affix').length > 0 ) {
                    affix_height_top = affix_height = $('.panel-affix').outerHeight();
                    $('.panel-affix-wrapper').css({'height': affix_height});
                }
            }
        }
        //Function from Bluthemes, lets you add li elemants to affix object without having to alter and data attributes set out by bootstrap
        setTimeout(function(){


            // name your elements here
            var stickyElement   = '.panel-affix',   // the element you want to make sticky
                bottomElement   = '#apus-footer'; // the bottom element where you want the sticky element to stop (usually the footer) 

            // make sure the element exists on the page before trying to initalize
            if($( stickyElement ).length){
                $( stickyElement ).each(function(){
                    var header_height = 0;
                    if ($('.main-sticky-header').length > 0) {
                        header_height = $('.main-sticky-header').outerHeight();
                        affix_height_top = affix_height + header_height;
                    }
                    // let's save some messy code in clean variables
                    // when should we start affixing? (the amount of pixels to the top from the element)
                    var fromTop = $( this ).offset().top, 
                        // where is the bottom of the element?
                        fromBottom = $( document ).height()-($( this ).offset().top + $( this ).outerHeight()),
                        // where should we stop? (the amount of pixels from the top where the bottom element is)
                        // also add the outer height mismatch to the height of the element to account for padding and borders
                        stopOn = $( document ).height()-( $( bottomElement ).offset().top)+($( this ).outerHeight() - $( this ).height()); 

                    // if the element doesn't need to get sticky, then skip it so it won't mess up your layout
                    if( (fromBottom-stopOn) > 200 ){
                        // let's put a sticky width on the element and assign it to the top
                        $( this ).css('width', $( this ).width()).css('top', 0).css('position', '');
                        // assign the affix to the element
                        $( this ).affix({
                            offset: { 
                                // make it stick where the top pixel of the element is
                                top: fromTop - header_height,  
                                // make it stop where the top pixel of the bottom element is
                                bottom: stopOn
                            }
                        // when the affix get's called then make sure the position is the default (fixed) and it's at the top
                        }).on('affix.bs.affix', function(){
                            var header_height = 0;
                            if ($('.main-sticky-header').length > 0) {
                                header_height = $('.main-sticky-header').outerHeight();
                            }
                            affix_height_top = affix_height + header_height;
                            $( this ).css('top', header_height).css('position', '');
                        });
                    }
                    // trigger the scroll event so it always activates 
                    $( window ).trigger('scroll'); 
                }); 
            }
        }, 50);

        //Offset scrollspy height to highlight li elements at good window height
        $('body').scrollspy({
            offset: 80
        });

        //Smooth Scrolling For Internal Page Links
          $('.panel-affix a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top - affix_height_top
                }, 1000);
                return false;
              }
            }
          });
    });
    

    // filter Property
    var homesweetFunctions = {
        propertyMap: null,
        markers: [],
        init: function(){
            // Filter Property
            $('.properties-archive-main-container .filter-property-form').on('submit', function (e) {
                e.preventDefault();
                var url = $(this).attr('action') + '?' + $(this).serialize();
                homesweetFunctions.propertiesGetPage( url );
            });
            // Sort Action
            $('body').on('click', '.properties-sort-wrapper-inner .dropdown-menu a', function(e) {
                e.preventDefault();
                var text = $(this).text();
                $(this).parent().parent().parent().find('.dropdown-toggle span').text(text);
                if ( $( '#' + $(this).data('key') ).length > 0 ) {
                    $( '#' + $(this).data('key') ).val( $(this).data('value') );
                }
                setCookie( $(this).data('key'), $(this).data('value') );

                homesweetFunctions.propertiesGetPage($(this).attr('href'));
            });
            $('body').on('click', '.property-display-mod a', function() {
                var type = $(this).data('type');
                setCookie( 'homesweet_realia_mode', type );
                return true;
            });

            $('.payment-form .gateway').each(function(){
                var $this = $(this);
                $('.gateway-header', $this).click(function(e){
                    if ( !$(this).parent().hasClass('active') ) {
                        $('.payment-form .gateway.active').removeClass('active').find('.gateway-content').slideToggle();
                        $(this).parent().addClass('active').find('.gateway-content').slideToggle();
                    }
                });
            });

            if ( $('body.fix-header').length > 0 ) {
                var header_height = $('#apus-header').outerHeight();
                $('#apus-main-content').css({'margin-top': header_height});
            }
            // ajax pagination
            if ( $('.ajax-pagination').length ) {
                homesweetFunctions.ajaxPaginationLoad();
            }
            // Single Property map
            homesweetFunctions.showGoogleMap();
            homesweetFunctions.filterPriceRange();
            // Property Search Save
            homesweetFunctions.filterSave();
            // Property Compare
            homesweetFunctions.propertyCompare();
            // Walk Score
            homesweetFunctions.propertyWalkScore();
            // Yelp Nearby
            homesweetFunctions.propertyNearbyYelp();
            // Mortgage Calculator
            homesweetFunctions.mortgageCalculator();
            //
            homesweetFunctions.loadMoreproperty();
            // chart
            homesweetFunctions.chartInit();
            // login register
            homesweetFunctions.loginRegisterPopup();
        },
        loginRegisterPopup: function() {
            $('.login a').click(function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                $('.login-register li').removeClass('active');
                $(href).addClass('active');
                var id = $(href).find('a').attr('href');
                $('.login-register .tab-pane').removeClass('active');
                $(id).addClass('active');
                $.magnificPopup.open({
                    mainClass: 'apus-mfp-zoom-small-in',
                    items: {
                        src : $('.login-register-hidden').html(),
                        type: 'inline'
                    }
                });
            });

        },
        chartInit: function() {

            var self = this;
            if( $('#property_chart').length <= 0 ) {
                return;
            }

            var $this = $('#property_chart');
            var id = $this.data('id');
            $this.addClass('loading');
            if (self.chartAjax) { return false; }

            self.chartAjax = $.ajax({
                url: homesweet_ajax.ajaxurl,
                data: 'action=homesweet_get_chart&id=' + id,
                dataType: 'json',
                cache: false,
                headers: {'cache-control': 'no-cache'},
                method: 'POST',
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Apus: AJAX error - chartInit() - ' + errorThrown);
                    $this.removeClass('loading');
                    self.chartAjax = false;
                },
                success: function(response) {
                    if (response.status == 'error') {
                        $this.remove();
                    } else {
                        var ctx = $("#property_chart").get(0).getContext("2d");
                        var myNewChart = new Chart(ctx);
                        var data = {
                            labels: response.stats_labels,
                            datasets: [
                                {
                                    label: response.stats_view,
                                    backgroundColor: response.bg_color,
                                    borderColor: response.border_color,
                                    borderWidth: 1,
                                    data: response.stats_values
                                },
                            ]
                        };

                        var options = {
                            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                            scaleBeginAtZero : true,
                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : false,
                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(0,0,0,.05)",
                            //Number - Width of the grid lines
                            scaleGridLineWidth : 1,
                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,
                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,
                            //Boolean - If there is a stroke on each bar
                            barShowStroke : false,
                            //Number - Pixel width of the bar stroke
                            barStrokeWidth : 2,
                            //Number - Spacing between each of the X value sets
                            barValueSpacing : 5,
                            //Number - Spacing between data sets within X values
                            barDatasetSpacing : 1,
                            legend: { display: false },

                            tooltips: {
                                enabled: true,
                                mode: 'x-axis',
                                cornerRadius: 4
                            },
                        }

                        var myBarChart = new Chart(ctx, {
                            type: response.chart_type,
                            data: data,
                            options: options
                        });
                    }
                    $this.removeClass('loading');
                    self.chartAjax = false;
                }
            });

        },
        loadMoreproperty: function() {
            $('body').on('click', '.view-more-property', function(e) {
                e.preventDefault();

                var self = $(this);
                if (self.hasClass('loading')) {
                    return false;
                }
                self.addClass('loading');
                var main = self;
                var page = parseInt(main.data('page')) + 1;
                var max_page = parseInt(self.data('max-page'));
                if (page > max_page) {
                    return false;
                }
                var main_container = $(main.attr('href')).find('.isotope-items');

                $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    type:'POST',
                    dataType: 'html',
                    data:  'action=homesweet_get_properties&columns=' + main.data('columns') + '&item_style=' + main.data('item_style')
                        + '&layout_type=' + main.data('layout_type') + '&contract=' + main.data('contract') + '&orderby=' + main.data('orderby')
                        + '&number=' + main.data('number') + '&types=' + main.data('types') + '&statuses=' + main.data('statuses')
                        + '&locations=' + main.data('locations') + '&page=' + page
                }).done(function(reponse) {
                    main.data('page', page );
                    self.removeClass('loading');
                    if (page >= max_page) {
                        self.addClass('hidden');
                        self.parent().find('.all-properties-loaded').removeClass('hidden');
                    }
                    if ( main.data('layout_type') == 'mansory' ) {
                        main_container.isotope( 'insert', $(reponse).appendTo(main_container) ); 
                    } else {
                        main_container.append( reponse );
                    }
                    setTimeout(function(){
                        homesweetFunctions.loadImages();
                    },300);
                });
            });
        },
        mortgageCalculator: function() {

            $('#btn_mortgage_get_results').on('click', function (e) {
                e.preventDefault();

                var property_price = $('#apus_mortgage_property_price').val();
                var deposit = $('#apus_mortgage_deposit').val();
                var interest_rate = parseFloat($('#apus_mortgage_interest_rate').val(), 10) / 100;
                var years = parseInt($('#apus_mortgage_term_years').val(), 10);
                

                var interest_rate_month = interest_rate / 12;
                var nbp_month = years * 12;

                var loan_amount = property_price - deposit;
                var monthly_payment = parseFloat((loan_amount * interest_rate_month) / (1 - Math.pow(1 + interest_rate_month, -nbp_month))).toFixed(2);

                if (monthly_payment === 'NaN') {
                    monthly_payment = 0;
                }
                
                $('.apus_mortgage_results').html( homesweet_ajax.monthly_text + homesweet_ajax.currency + monthly_payment);

            });
        },
        propertyNearbyYelp: function() {
            var self = this;
            if ( $('.property-nearby_yelp').length > 0 ) {
                var $this = $('.property-nearby_yelp');
                var id = $this.data('id');
                $this.addClass('loading');
                if (self.nearbyAjax) { return false; }
                self.nearbyAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_get_nearby_yelp&id=' + id,
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertyNearbyYelp() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.nearbyAjax = false;
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            $this.remove();
                            if ( $('.nav-property a[href=#property-section-nearby_yelp]').length > 0 ) {
                                $('.nav-property a[href=#property-section-nearby_yelp]').parent().remove();
                            }
                        } else {
                            $this.html( response.html );
                        }
                        $this.removeClass('loading');
                        self.nearbyAjax = false;
                    }
                });
            }
        },
        propertyWalkScore: function() {
            var self = this;
            if ( $('.property-walk_score').length > 0 ) {
                var $this = $('.property-walk_score');
                var id = $this.data('id');
                $this.addClass('loading');
                if (self.walkScoreAjax) { return false; }
                self.walkScoreAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_get_walk_score&id=' + id,
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertyWalkScore() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.walkScoreAjax = false;
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            $this.remove();
                            if ( $('.nav-property a[href=#property-section-walk_score]').length > 0 ) {
                                $('.nav-property a[href=#property-section-walk_score]').parent().remove();
                            }
                        } else {
                            $this.html( response.html );
                        }
                        $this.removeClass('loading');
                        self.walkScoreAjax = false;
                    }
                });
            }
        },
        propertyCompare: function() {
            var self = this;
            $('body').on('click', '.property-box-compare a:not(.added)', function(e){
                e.preventDefault();
                var $this = $(this);
                var id = $(this).data('id');
                if (self.compareAjax) { return false; }
                $this.addClass('loading');
                self.compareAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_add_to_compare&id=' + id,
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertyCompare() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.compare-sidebar-wrapper').html(response.msg);
                            $('.compare-sidebar-btn .count').html(response.count);
                            if ( !$('#compare-sidebar').hasClass('active') ) {
                                $('#compare-sidebar').addClass('active');
                            }

                            $this.addClass('added').find('i').addClass('icon-ap_check-circle').removeClass('icon-ap_plus-outline');
                            $this.attr('data-original-title', homesweet_ajax.comapre_text_added);
                        } else {
                            alert(response.msg);
                        }
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    }
                });
            });

            $('body').on('click', '.apus-remove-compare', function(e){
                e.preventDefault();
                var $this = $(this);
                var id = $(this).data('id');
                if (self.compareAjax) { return false; }
                $this.addClass('loading');
                self.compareAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_remove_compare&id=' + id,
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertyCompare() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            if ( $('.widget-properties-compare').length > 0 ) {
                                window.location = window.location
                            }
                            $('.compare-sidebar-wrapper').html(response.msg);
                            $('.compare-sidebar-btn .count').html(response.count);
                            if ( response.count == '0' ) {
                                $('#compare-sidebar').removeClass('active');
                            }
                            $('.property-box-compare a').each(function(){
                                if ( id == $(this).data('id') ) {
                                    $(this).removeClass('added').find('i').removeClass('icon-ap_check-circle').addClass('icon-ap_plus-outline');
                                    $(this).attr('data-original-title', homesweet_ajax.comapre_text);
                                }
                            });
                        } else {
                            alert(response.msg);
                        }
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    }
                });
            });

            $('body').on('click', '.apus-remove-compare-all', function(e){
                e.preventDefault();
                var $this = $(this);
                if (self.compareAjax) { return false; }
                $this.addClass('loading');
                self.compareAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_remove_all_compare',
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertyCompare() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            if ( $('.widget-properties-compare').length > 0 ) {
                                window.location = window.location
                            }
                            $('.compare-sidebar-wrapper').html(response.msg);
                            $('.compare-sidebar-btn .count').html(response.count);
                            $('#compare-sidebar').removeClass('active');
                            $('#compare-sidebar').removeClass('open');
                            $('.property-box-compare a').each(function(){
                                if ( $(this).find('i').removeClass('icon-ap_check-circle') ) {
                                    $(this).find('i').removeClass('icon-ap_check-circle').addClass('icon-ap_plus-outline');
                                }
                                $(this).removeClass('added')
                                $(this).attr('data-original-title', homesweet_ajax.comapre_text);
                            });
                        } else {
                            alert(response.msg);
                        }
                        $this.removeClass('loading');
                        self.compareAjax = false;
                    }
                });
            });
        },
        filterSave: function() {
            var self = this;
            if ($('.properties-archive-main-container .filter-property-form').length > 0) {
                $('body .save-search-btn').removeClass('hidden');
                $('body').on('click', '.save-search-btn', function(e) {
                    e.preventDefault();
                    $.magnificPopup.open({
                        mainClass: 'apus-mfp-zoom-small-in',
                        items    : {
                            src : $('.save-search-form-popup').html(),
                            type: 'inline'
                        }
                    });
                });

                $('body').on('submit', '#apus-save-search-form', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    $this.find('.btn-save').addClass('loading');
                    var data_search = $('.properties-archive-main-container .filter-property-form').serialize();
                    var this_data = $(this).serialize();

                    if (self.filterSaveAjax) { return false; }

                    self.filterSaveAjax = $.ajax({
                        url: homesweet_ajax.ajaxurl,
                        data: 'action=homesweet_save_search&' + data_search + '&' + this_data,
                        dataType: 'json',
                        cache: false,
                        headers: {'cache-control': 'no-cache'},
                        method: 'POST',
                        
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log('Apus: AJAX error - filterSave() - ' + errorThrown);
                            $this.find('.btn-save').removeClass('loading');
                            self.filterSaveAjax = false;
                        },
                        success: function(response) {
                            $this.find('.msg').html('<div class="'+response.class+'">'+response.msg+'</div>');
                            $this.find('.btn-save').removeClass('loading');
                            self.filterSaveAjax = false;
                        }
                    });
                });
            }

            $('body').on('click', '.apus-search-save-remove', function(e) {
                e.preventDefault();
                var $this = $(this);
                $this.addClass('loading');
                var $id = $this.attr('href');

                if (self.filterSaveAjax) { return false; }

                self.filterSaveAjax = $.ajax({
                    url: homesweet_ajax.ajaxurl,
                    data: 'action=homesweet_save_search_remove&id=' + $this.data('id'),
                    dataType: 'json',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'POST',
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - filterSave() - ' + errorThrown);
                        $this.removeClass('loading');
                        self.filterSaveAjax = false;
                    },
                    success: function(response) {
                        if ( response.status == 'error' ) {
                            alert('Do not have this search');
                        } else {
                            $($id).remove();
                        }
                        self.filterSaveAjax = false;
                    }
                });
            });
        },
        filterPriceRange: function() {
            $('.filter-property-form').each(function(){
                var self = $(this);
                if ( $('.price_range', self).length > 0 ) {
                    var e_price = $('.price_range', self);
                    e_price.slider({
                        range: true,
                        min: e_price.data('min'),
                        max: e_price.data('max'),
                        values: [ self.find('.filter-price-from').val(), self.find('.filter-price-to').val() ],
                        slide: function( event, ui ) {
                            self.find('.price_from .price').text( homesweetFunctions.addCommas(ui.values[ 0 ]) );
                            self.find('.filter-price-from').val( ui.values[ 0 ] )
                            self.find('.price_to .price').text( homesweetFunctions.addCommas(ui.values[ 1 ]) );
                            self.find('.filter-price-to').val( ui.values[ 1 ] )
                        }
                    });
                    self.find('.price_from .price').text( homesweetFunctions.addCommas(self.find('.filter-price-from').val()) );
                    self.find('.price_to .price').text( homesweetFunctions.addCommas(self.find('.filter-price-to').val()) );
                }

                $('.filter-amenities-title', self).click(function(){
                    $('.filter-amenities-list', self).slideToggle();
                    if ( $(this).find('i').hasClass('fa-plus-circle') ) {
                        $(this).find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
                    } else {
                        $(this).find('i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
                    }
                });
                // advance
                $('.toggle-adv', self).click(function(e){
                    $('.advance-fields', self).slideToggle();
                    return false;
                });
                // contract tab active
                $('.tab-contract-field .contract-wrap', self).click(function(e){
                    $('.tab-contract-field .contract-wrap', self).removeClass('active');
                    $(this).addClass('active');
                });
            });
        },
        addCommas: function(str) {
            var parts = (str + "").split("."),
                main = parts[0],
                len = main.length,
                output = "",
                first = main.charAt(0),
                i;
            
            if (first === '-') {
                main = main.slice(1);
                len = main.length;    
            } else {
                first = "";
            }
            i = len - 1;
            while(i >= 0) {
                output = main.charAt(i) + output;
                if ((len - i) % 3 === 0 && i > 0) {
                    output = homesweet_ajax.thousands_separator + output;
                }
                --i;
            }
            // put sign back
            output = first + output;
            // put decimal part back
            if (parts.length > 1) {
                output += homesweet_ajax.dec_point + parts[1];
            }
            return output;
        },
        propertiesGetPage: function(pageUrl, isBackButton){
            var self = this;
            if (self.filterAjax) { return false; }

            self.propertiesSetCurrentUrl();

            if (pageUrl) {
                // Show 'loader' overlay
                self.propertiesShowLoader();
                
                // Make sure the URL has a trailing-slash before query args (301 redirect fix)
                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }

                self.filterAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        load_type: 'full'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "load_type" query-string in pagination links
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - propertiesGetPage() - ' + errorThrown);
                        
                        // Hide 'loader' overlay (after scroll animation)
                        self.propertiesHideLoader();
                        
                        self.filterAjax = false;
                    },
                    success: function(response) {
                        // Update properties content
                        self.propertiesUpdateContent(response);
                        
                        self.filterAjax = false;
                    }
                });
                
            }
        },
        propertiesHideLoader: function(){
            $('body').find('.apus-properties-page-wrapper').removeClass('loading');
        },
        propertiesShowLoader: function(){
            $('body').find('.apus-properties-page-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({apusShop: true}, '', pageUrl);
        },
        propertiesSetCurrentUrl: function() {
            var self = this;
            
            // Set current page URL
            self.searchAndTagsResetURL = window.location.href;
        },
        /**
         *  Properties: Update properties content with AJAX HTML
         */
        propertiesUpdateContent: function(ajaxHTML) {
            var self = this,
                $ajaxHTML = $('<div>' + ajaxHTML + '</div>');

            var $sortby = $ajaxHTML.find('.properties-sort-wrapper'),
                $properties = $ajaxHTML.find('.apus-properties-page-wrapper'),
                $pagination = $ajaxHTML.find('.apus-pagination-wrapper');

            // Replace sortby
            // if ($sortby.length) {
            //     $('.properties-sort-wrapper').replaceWith($sortby);
            // }
            // Replace properties
            if ($properties.length) {
                $('.apus-properties-page-wrapper').replaceWith($properties);
                homesweetFunctions.filterSave();
            }
            // Replace pagination
            if ($pagination.length) {
                $('.apus-pagination-wrapper').replaceWith($pagination);
            }
            // Load images (init Unveil)
            self.loadImages();
            // pagination
            if ( $('.ajax-pagination').length ) {
                self.infloadScroll = false;
                homesweetFunctions.ajaxPaginationLoad();
            }
            homesweetFunctions.refreshGoogleMap();
            setTimeout(function() {
                // Hide 'loader'
                self.propertiesHideLoader();
            }, 100);

            $('[data-hover="dropdown"]').dropdownHover();
        },

        /**
         *  Shop: Initialize infinite load
         */
        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('body').find('.ajax-pagination'),                   
                nextPageUrl;

            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    //bufferPx = 0;
                
                /* Bind: Window resize event to re-calculate the 'pxFromMenuToBottom' value (so the items load at the correct scroll-position) */
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        var $infloadControls = $('.ajax-pagination'); // Note: Don't cache, element is dynamic
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
                    // If distance remaining in the scroll (including buffer) is less than the pagination element to bottom:
                    if (pxFromWindowBottomToBottom < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
                /* Bind: "Load" button */
                $productsWrap.on('click', '.apus-properties-main .apus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); // Trigger scroll in case the pagination element (+buffer) is above the window bottom
            }
        },
        /**
         *  Shop: AJAX load next page
         */
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.filterAjax) return false;
            
            // Get elements (these can be replaced with AJAX, don't pre-cache)
            var $nextPageLink = $('.apus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
                // Show 'loader'
                $infloadControls.addClass('apus-loader');
                
                //self.setPushState(nextPageUrl);

                self.filterAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'properties'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('APUS: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
                        // Hide 'loader'
                        $infloadControls.removeClass('apus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), // Wrap the returned HTML string in a dummy 'div' element we can get the elements
                            $gridItemElement = $('#tab-properties-grid .property-box-archive .col-property-box', $response),
                            $listItemElement = $('#tab-properties-list .property-box-archive .property-box', $response);
                        
                        // Append the new elements
                        $('#tab-properties-grid .property-box-archive .row').append($gridItemElement);
                        $('#tab-properties-list .property-box-archive').append($listItemElement);
                        
                        homesweetFunctions.refreshGoogleMap(response);

                        // Load images (init Unveil)
                        self.loadImages();
                        
                        // Get the 'next page' URL
                        nextPageUrl = $response.find('.apus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.apus-properties-main').addClass('all-properties-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true;
                            }
                            $infloadControls.find('.apus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.filterAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); // Trigger 'scroll' in case the pagination element (+buffer) is still above the window bottom
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                }
            }
        },

        loadImages: function() {
            $(window).off('scroll.unveil resize.unveil lookup.unveil');
            var $images = $('.image-wrapper:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                var scrollTolerance = 1;
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.image-wrapper').first().addClass('image-loaded');
                    });
                });
            }
        },
        showGoogleMap: function() {
            var self = this;
            if ($('#properties-map').length > 0) {
                var map = $('#properties-map');
                map.addClass('loading');
                if ( $('#tab-properties-grid .property-box').length >0 ) {
                    $('#tab-properties-grid .property-box').each(function(){
                        var $item = $(this);
                        var marker = {
                            latitude: $item.data('latitude'),
                            longitude: $item.data('longitude'),
                            content: $item.find('.property-map-content').html(),
                            marker_content: $item.find('.property-map-marker').html(),
                        };
                        self.markers.push(marker);
                    });
                }
                self.propertyMap = map.google_map({
                    geolocation: map.data('geolocation'),
                    infowindow: {
                        borderBottomSpacing: 0,
                        height: 120,
                        width: 424,
                        offsetX: 48,
                        offsetY: -87
                    },
                    zoom: map.data('zoom'),
                    marker: {
                        height: 56,
                        width: 56
                    },
                    cluster: {
                        height: 40,
                        width: 40,
                        gridSize: 60
                    },
                    styles: map.data('style'),
                    transparentMarkerImage: homesweet_ajax.transparent_marker,
                    transparentClusterImage: homesweet_ajax.transparent_marker,
                    markers: self.markers
                });
                setTimeout(function(){
                    map.removeClass('loading');
                }, 100);

                $('body').on('mouseenter', '.apus-properties-page-wrapper .property-box', function(){
                    var markerid = $(this).data('markerid');
                    if ( markerid ) {
                        $('#properties-map').find('.'+markerid).addClass('active');
                    }
                }).on('mouseleave', '.apus-properties-page-wrapper .property-box', function(){
                    var markerid = $(this).data('markerid');
                    if ( markerid ) {
                        $('#properties-map').find('.'+markerid).removeClass('active');
                    }
                });
            }
        },
        refreshGoogleMap: function(response) {
            var self = this;
            var map = $('#properties-map');
            if ($('#properties-map').length > 0) {
                map.addClass('loading');
                var newmarkers = [];
                $('body #tab-properties-grid .property-box').each(function(){
                    var $item = $(this);
                    var marker = {
                        latitude: $item.data('latitude'),
                        longitude: $item.data('longitude'),
                        content: $item.find('.property-map-content').html(),
                        marker_content: $item.find('.property-map-marker').html(),
                    };
                    newmarkers.push(marker);
                });

                if ( newmarkers.length > 0 ) {
                    map.google_map('removeMarkers');
                    map.google_map('addMarkers',{markers: newmarkers});
                }
                setTimeout(function(){
                    map.removeClass('loading');
                }, 100);
            }
        }
    };

    homesweetFunctions.init();
})(jQuery)

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires+";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
