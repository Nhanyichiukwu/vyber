'use strict';
function enableDisplayToggle()
{
    // Toggle element display
    var displayToggle = $('[data-toggle=display]');
    var defaultState = displayToggle.data('default-state');
    var obj = displayToggle.data('target');
    var animation = displayToggle.data('animate');

    if (defaultState === 'visible') {
        $(obj).show();
    } else {
        $(obj).hide();
    }
    displayToggle.click(function () {
        if (animation === true) {
            $(obj).slideToggle();
        } else {
            $(obj).toggle();
        }
    });
}

String.prototype.upperCaseFirstLetter = function()
{
    return this.charAt(0).toUpperCase() + this.slice(1);
};

String.prototype.lowerCaseFirstLetter = function()
{
    return this.charAt(0).toLowerCase() + this.slice(1);
};
String.prototype.singularize = function() {
    let word = this.trim();
    let ies = word.substr(word.length - 3);
    let s = word.substr(word.length - 1);
    if ('ies' === ies)
        word = word.substr(0, word.length - 3) + 'y';
    else if ('s' === s)
        word = word.substr(0, word.length - 1);

    return word;
};
String.prototype.upperCaseFirstLetters = function ()
{
    let upperCasedLetters = '';
    let upperCasedList = [];

    // Convert all hyphens and underscores to whitespaces
    let str = this.replaceAll('_', ' ');
    str = str.replaceAll('-', ' ');
    let strParts = str.split(' ');

    for (var x in strParts) {
        let newWord = (new String(strParts[x])).upperCaseFirstLetter();
        upperCasedList.push(newWord);
    }
    upperCasedLetters = upperCasedList.join(' ');

    return upperCasedLetters;
};

String.prototype.replaceAll = function (haystack, niddle)
{
    return this.split(haystack).join(niddle);
};

String.prototype.camelize = function ()
{
    let upperCasedList = [];

    // Convert all hyphens and underscores to whitespaces
    let str = this.replaceAll('_', ' ');
    str = str.replaceAll('-', ' ');
    let strParts = str.split(' ');

    if (typeof arr !== 'undefined' && arr.length > 0) {
        for (var x in strParts) {
            let newWord = (String(strParts[x])).upperCaseFirstLetter();
            upperCasedList.push(newWord);
        }
        str = upperCasedList.join('');
    }
    str = str.lowerCaseFirstLetter();

    return str;
};

String.prototype.hyphenize = function()
{
    var str = this;

    if (str.indexOf(' ') > -1)
        str = str.replace(/ /g, '-');
    if (str.indexOf('_') > -1)
        str = str.replace(/_/g, '-');

    return str;
};
String.prototype.ltrim = function (char = null) {
    let str = this;
    if (typeof char === 'string') {
        if (str.startsWith(char, 0)) {
            return str.substr(1, str.length);
        }
        return str;
    }
    return str.substr(1, str.length);
};
String.prototype.rtrim = function (char = null) {
    let str = this;
    if (typeof char === 'string') {
        if (str.endsWith(char, str.length)) {
            return str.substr(0, str.length - 1);
        }
        return str;
    }
    return str.substr(0, str.length - 1);
};

Window.prototype.triggerEvent = function (eName, eHandler, detail) {
    let event = new CustomEvent(eName, {bubbles: true, detail: detail});
    eHandler.dispatchEvent(event);
};

Window.prototype.getBaseUri = function (level = 1)
{
    var path = this.location.pathname;
    var uriParts = path.split('/');
    var baseUri = uriParts[level];
    if (baseUri.length === 0) {
        return '/';
    }
    return '/' + baseUri + '/';
}

String.prototype.deserializeString = function () {
    if (this === undefined || this.length < 1) {
        return null;
    }
    const deserialized = {};
    const params = new URLSearchParams(this);

    for (const key of params.keys()) {
        if (params.getAll(key).length > 1) {
            deserialized[key] = params.getAll(key);
        } else {
            deserialized[key] = params.get(key);
        }
    }

    return deserialized;
}

jQuery.fn.extend({
    isEnabled: function () {
        let isEnabled;
        this.each(function () {
            isEnabled = !(jQuery(this).is('.disabled') ||
                jQuery(this).is(':disabled') ||
                jQuery(this).is('[aria-disabled="true"]'));
        });
        return isEnabled;
    },
    enable: function () {
        return this.each(function () {
            jQuery(this).removeAttr('disabled').attr('aria-disabled', 'false').removeClass('disabled');
        });
    },
    disable: function () {
        return this.each(function () {
            jQuery(this).addClass('disabled').attr('disabled', 'disabled').attr('aria-disabled', 'true');
        });
    },
    serializeObject: function () {
        var serialized = '';
        Object.entries(this[0]).forEach(function (entry) {
            serialized += entry[0] + '=' + entry[1];
            serialized += '&';
        });
        serialized = serialized.slice(0, serialized.length - 1);
        return serialized;
    }
});

function stringToFunc(str, scope = null) {
    scope = scope || window;
    let parts = str.split('.');
    if (str.indexOf('.')) {
        let currentScope;
        for (var i = 0; i < parts.length; i++) {
            currentScope = scope[parts[i]];
            if (typeof currentScope === 'undefined') {
                break;
            }
            scope = currentScope;
        }
        return scope;
    }
    return str;
}
/**
 * File Upload previewer
 *
 * @param {Object} input
 * @param {string} output
 * @returns {Array}
 */
//function readUploadedFile(input, output) {
//    var files = [];
//    if (! (window.XMLHttpRequest || window.blob)) {
//        console.log('This browser does not support either or both of the following: XMLHttpRequest, blob');
//        return false;
//    }
//    if (input.files) {
//        var fL =  input.files.length;
//        const reader = new FileReader();
//        reader.onload = function (e) {
//              var fileUrl = e.target.result;
////            $(previewTarget).attr('src', e.target.result);
////            $(previewTarget).hide();
////            $(previewTarget).fadeIn(500);
////            $('.custom-file-label').text(filename);
//        };
//
//        for (var i = 0; i < fL; ++i) {
//            var file = input.files.item(i);
//            const fileMime = file.type;
//            const fileSize = file.size;
//            var fileName = file.name;
//            file = reader.readAsDataURL(file);
////            var blob = new Blob(file);
//            console.log(fileMime);
////            filename = filename.substring(filename.lastIndexOf('\\') + 1);
//
////            return;
//        }
//    };


//}

/**
 *
 * @param {type} input
 * @returns {FilePreviewer}
 */
function FilePreviewer(input)
{
    this.input = input;
    this.files = [];
    this.acceptedFileExtensions = [];
    this.acceptedMimeTypes = [];

    /**
     *
     * @param {Array} acceptedTypes
     * @returns {FilePreviewer}
     */
    this.acceptOnly = function (acceptedTypes)
    {
        this.acceptedFileExtensions = acceptedTypes;

        return this;
    };

    this.processFiles = function (callback)
    {
        if (this.input.files.length < 1) {
            return false;
        }

        let i = 0;
        for (i; i < this.input.files.length; i++) {
            let file = this.input.files[i];
            this.readFile(file, i);
        }
        if (typeof callback === 'function') {
            this.files.forEach(function (item, index) {
                callback(item);
            });
        }
        return this;
    };

    this.readFile = function (file, index)
    {
        let f = {};
        f.index = index || 0;
        f.mimeType = file.type;
        f.fileType = f.mimeType.split('/')[0];
        f.fileName = file.name;
        f.fileSize = file.size;
        f.ext = f.fileName.split('.').pop();
        f.rawData = file;

        // Ensure that the selected file matches the acceptedTypes (if specified).
        if (this.acceptedFileExtensions.length > 0) {
            if (! this.acceptedFileExtensions.includes(f.ext)) {
                throw new TypeError('Invalid file type...' + "\n" + 'Only ' + this.acceptedFileExtensions.join(', ') + ' are allowed.');
                return false;
            }
        }

        let blobUri = URL.createObjectURL(file)
        if (f.fileType === 'image')
        {
            let image = new Image();
            image.title = f.fileName;
            image.src = blobUri;
            f.processedData = image;
        }
        else if (['audio', 'video'].includes(f.fileType))
        {
            let media = document.createElement(f.fileType);
            let  src = document.createElement('source');
            media.src = src.src = blobUri;
            media.type = f.mimeType;
            media.controls = true;
            let src2 = src.cloneNode(true);
            src.type = f.mimeType;
            src2.type = f.fileType + "/ogg; codecs='theora, vorbis'";
            media.appendChild(src);
            media.appendChild(src2);
            f.processedData = media;
        } else {
            // Code for any other valid file type
        }

        this.files.push(f);

    };
}

var HTML = {
    /**
     * @param {string} selector Name of the selector to create. If none is
     * provided, it will default to a div element
     * @param {object} parentNode
     * @param {string|object} childNode An html child node or text to insert into the
     * selector when created
     * @param {object} attributes A list of attributes to add to the newly
     * created element
     * @return {object} the newly created element
     */
    createNode: function (selector = 'div', parentNode, childNode = null, attributes = {}, overwrite = false)
    {
        if (! parentNode)
            throw new ReferenceError('Missing argument "parentNode"! Parent node is required...');
        if (typeof parentNode === 'string') {
            parentNode = $.find(parentNode);
            if (parentNode.length  < 1) {
                throw new ReferenceError('Parent node not found...');
            }
        }

        var s = $(parentNode).find(selector);
        document.createElement(selector);
        if (childNode) {
            if (typeof childNode === 'string') {
                childNode = document.createElement(childNode);
                {
                    if (overwrite)
                        $(s).html(childNode);
                    else
                        $(s).append(childNode);
                }
            }
        }
        if (attributes.class)
            $(s).addClass(attributes.class);
        if (attributes.id)
            $(s).attr('id', attributes.id);
        $(parentNode).append(s);

        return s;
    }
};


Window.prototype.propagateEvent = function (eName, eHandler) {
    let event = new CustomEvent(eName);
    eHandler.dispatchEvent(event);
};

function doAjax(url, callback, options = {}) {
    // var settings = {
    //     url: url,
    //     type: 'GET',
    //     cache: true,
    //     processData: true,
    //     contentType: true,
    //     success: function (data, status, xhr) {
    //         callback(data, status, xhr);
    //     },
    //     error: function (data, status, xhr) {
    //         callback(data, status, xhr);
    //     }
    // };
    var settings = {
        "async": true,
        "crossDomain": false,
        "url": url,
        "method": "GET",
        "headers": {
            "content-type": "text/html",
        },
        "processData": false,
        "error": function (response, status, xhr) {
            callback(response, status, xhr);
        }
    };
    if (!$.isEmptyObject(options)) {
        Object.keys(options).forEach(function (key) {
            settings[key] = options[key];
        });
    }

    $.ajax(settings).done(function (response, status, xhr) {
        callback(response, status, xhr);
    });
}

async function doFetch(url, options = {}) {
    var settings = {
        "method": "GET",
        "mode": "same-origin",
        "async": true,
        "crossDomain": false,
        "cache": "no-cache",
        "credentials": "same-origin",
        "headers": {
            "Content-Type": "text/html",
            "X-Requested-With": 'XMLHttpRequest',
            "X-Requested-Via": "CrowdWowAsynchronousRequestInterface"
        },
        "redirect": 'follow',
        "referrerPolicy": "same-origin",
        // "processData": false,
    };
    if (!$.isEmptyObject(options)) {
        Object.keys(options).forEach(function (key) {
            settings[key] = options[key];
        });
    }

    const result = await fetch(url, settings).catch(reason => {
        console.error(reason);
    });
    return result.text();
}

/**
 * On a dynamically filled text editor, this method forces the caret to the
 * of the line, depending on the writing direction of the client.
 * Before calling this method, ensure that the field has already been filled.
 * If the function runs prior to the filling of the text editor, it will fail.
 *
 * @param {type} elem
 * @returns {undefined}
 */
 function moveCaretToEndOfEditor(elem)
{
    let editor = document.getElementById(elem), range, selection;
    if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
    {
        range = document.createRange();
        range.selectNodeContents(editor);
        range.collapse(false);
        selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }
    else if(document.selection)//IE 8 and lower
    {
        range = document.body.createTextRange();
        range.moveToElementText(editor);
        range.collapse(false);
        range.select();
    }
}

function suggestPostStartingPhrases(postType)
{
    let phraseSuggestion = $('.starting-phrases');
    if (phraseSuggestion.length < 1) {
        phraseSuggestion = $('<div class="starting-phrases mb-3"></div>');
        phraseSuggestion.prependTo('.publishing-options');
    }
    phraseSuggestion.html('<div class="loading" type="button" disabled>\n\
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\n\
        Loading...\n\
        </div>');
    doAjax('xhrs/suggestions/post_starting_phrases?post_type=' + postType,
        function(data, status) {
        if (status === 'success' && data.length > 0) {
            let suggestedStart = $('<div class="d-flex flex-wrap gutters-xs ' +
                'lh_f5 suggested-starting-phrases"></div>');
            for(var item in data) {
                if (data.hasOwnProperty(item)) {
                    let phrase = $('<div class="mb-1 phrase px-1"></div>');
                    phrase.html('<span class="_3RL badge badge-light ' +
                        'badge-pill bzakvszf lh-sm phrase-text text-dark ' +
                        'text-left x9ntpsif yuetca0c">' +
                        data[item] + '</span>').appendTo(suggestedStart);
                }
            }
            phraseSuggestion.html(suggestedStart);
        } else {
            phraseSuggestion.html('No suggestion');
        }
    }, {dataType: 'json', cache: false});
}

function either(find, orCreate) {
    if (arguments.length < 2)
        throw new Error('One argument is missing from function: either()')
    if ($(find).length > 0)
        return $(find);
    return $(orCreate);
}

// Content Loading Placeholder
function spinner(id = '', params)
{
    params = params || {};
    if (id) {
        id = ' id="' + id + '" ';
    }
    let css = 'content-loading',
        state = '';

    if (params.hasOwnProperty('class')) {
        css += ' ' + params.class;
    }
    if (params.hasOwnProperty('state')) {
        state += ' ' + params.state;
    }
    if (!params.text) {
        params.text = 'Loading...';
    }

    return '<div' + id + ' class="align-items-center ' +
        'd-flex h-100 justify-content-center ' + css + '">\n\
                <div class="process-state align-items-center d-flex flex-column \
                justify-contents-center text-center' + state + '">\n\
                    <div class="spinner spinner-border m-3 process-icon"></div>\n\
                    <div class="spinner-text process-desc">' + params.text + '</div>\n\
                </div>\n\
            </div>';
}

function generateFileDetailForm(fileType, target)
{
    doAjax('/upload/file_detail_form/' + fileType, function (data, status, xhr) {
        if (status === 'success') {
            $(target).html(data);
        }
    }, {dataType: 'html', type: 'get'});
}

function previousPage() {
     window.history.back();
     window.history.scrollRestoration;
}

/**
 * Fuction for map initialization
 */
function initMap() {
  var uluru = {lat: 12.927923, lng: 77.627108};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: uluru,
    zoomControl: true,
    scaleControl: false,
    scrollwheel: false,
    disableDoubleClickZoom: true
  });

  var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });
}


/**
 * function for attaching sticky feature
 */
function attachSticky() {
    // Sticky Chat Block
    $('#chat-block').stick_in_parent({
        parent: '#page-contents',
        offset_top: 70
    });

    // Sticky Right Sidebar
    $('#sticky-sidebar').stick_in_parent({
        parent: '#page-contents',
        offset_top: 70
    });

}
var offset = 0;
var position = 0;
function scrollSpy(target, options) {
    // let offset = 0;

    if (position > offset) {
        options.onScrollUp();
    } else {
        options.onScrollDown();
    }
    position = $(target).scrollTop();
    offset = position;
}
function toggleSticky(element, cssClass = null)
{
    cssClass = cssClass ?? 'fixed';
    $(element).toggleClass(cssClass);
}



function generateID(length) {
    let id = '',
        alpha = 'a b c d e f g h i j k l m n o p q r s t u v w x y z';
    alpha += ' ' + alpha.toUpperCase();
    alpha = alpha.split(' ');

    for (let i = 0; i < length;) {
        let rand = Math.random() * (i + (alpha.length / 3));
        rand = Math.round(rand);
        rand = rand + i;
        if (rand >= alpha.length) {
            rand = alpha.length - 1;
        }

        id += '' + alpha[rand];
        alpha = alpha.reverse();
        i++;
    }
    return id;
}
