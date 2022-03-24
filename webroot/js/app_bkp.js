'use strict';

/*
Application Server Interface
 */
function App(keyframes, options)
{
    this.cookieName = 'launchDate';
    this.cookieLifetime = '365';
    this.starter = function () {
        doAjax(baseUri + '/home/starter', function (data, status, xhrs) {
            if (status === 'success') {
                $('.main').html(data);
            }
        }, {dataType: 'html'});
    };

    this.dashboard = function () {
        // let url = $('body').data('base-uri') + '/home';
        // window.location.assign(url);
        // doAjax(url, function (data, status, xhrs) {
        //     if (status === 'success') {
        //         $('.main').html(data);
        //     }
        // }, {dataType: 'html'});
    };
}


/**
 * Check if the app is being launched for the first time
 * This method uses data previously stord in the cookie to identify the use case
 *
 * @return boolean
 */
App.prototype.isFirstLaunch = function () {
    let cookie = $.cookie(this.cookieName);
    return cookie === undefined;
};

App.prototype.isAuthenticated = function (jqxhr = null) {
    let authenticated;
    let url = $('body').data('base-uri') + '/auth/checkpoint';
    // if (jqxhr === null) {
    //     let url = $('body').data('base-uri') + '/auth/checkpoint';
    //     $.ajax({
    //         url: url,
    //         type: 'GET',
    //         dataType: "json",
    //         success: function (result, status, jqxhr) {
    //             App.isAuthenticated(jqxhr);
    //             console.dir(jqxhr);
    //             console.log(jqxhr.responseText);
    //         }
    //     });
    // }

    // console.dir(
    //     Object.keys(jqxhr)
    // );

    var xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         myFunction(this);
    //     }
    // };


    if (xmlhttp.readyState == 4) {
        console.log(xmlhttp.readyState);
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();


    return authenticated;
};

App.prototype.registerLaunch = function () {
    let today = new Date();
    let expiration = new Date(this.cookieLifetime);
    console.log(expiration);
    $.cookie(this.cookieName, today, {expires: expiration});
};

App.prototype.requireLogin = function () {

};

App.prototype.ajaxLoader = function()
{
    /**
     *
     * @param {Object} settings
     * @returns {Boolean}
     */
    const app = this;

    ping = function(settings = {})
    {
        if (settings.url === undefined) {
            return false;
        }
        if (settings.dataType === null) {
            settings.dataType = 'html';
        }
        if (settings.beforePing && $.isFunction(settings.beforePing)) {
            settings.beforePing();
        }

        let doc = $('body'),
            server = doc.data('base-uri'),
            url;
        if (settings.url === undefined) {
            url = window.location.href;
        } else if (settings.url.startsWith('http')) {
            url = settings.url;
        } else {
            // if (settings.url.includes(server)) {
            //     let hostname = window.location.hostname,
            //         prefixIds;
            //     // prefix = (hostname === 'localhost' ? hostname :)
            //     console.log(window.location);
            //     if (hostname === 'localhost') {
            //         prefix =
            //     }
            //     settings.url = window.location.protocol + '//' +
            //     //settings.url.ltrim('/');
            // }
            // console.log(settings.url);
            url = server + '/xhrs/' + settings.url.ltrim('/');
        }
        doAjax(url, settings.onPing, {type: 'get', dataType: settings.dataType});
        // doAjax(url, settings.onPing, {type: 'get', dataType: settings.dataType});

        if (settings.afterPing && $.isFunction(settings.afterPing)) {
            settings.afterPing();
        }
        return true;
    }
    this.load = function(obj)
    {
        let url = $(obj).data('src'),
            ref = $(obj).data('rfc'),
            initEvent = 'page:content:' + ref + ':oninit',
            beforeReadyEvent = 'page:content:' + ref + ':beforeReady';

        $(document).trigger(initEvent, {obj: obj});
        $(document).trigger(beforeReadyEvent, {obj: obj});

        this.ping({
            url: url,
            dataType: $(obj).data('type') || 'html',
            beforePing: function () {

            },
            onPing: function (data, status) {
                if (status === 'success') {
                    if (data.length > 0) {
                        let onReadyEvent = 'page:content:' + ref + ':ready';
                        $(document).trigger(onReadyEvent, {obj: obj, content: data});
                    }
                }
            },
            afterPing: function () {

            }
        });
    }

    this.ajaxify = function(ajaxifiables, delay)
    {
        if (typeof ajaxifiables === 'string') {
            ajaxifiables = $(ajaxifiables);
        }
        let obj = this;
        ajaxifiables.map(function (index, theElem) {

            obj.load(theElem);
            let contentName = $(theElem).data('rfc'),
                loadType = $(theElem).data('load-type');
            obj.onContentReady(contentName, function (e, eventData) {
                if (loadType === 'r') {
                    $(ajaxifiables).eq(index).replaceWith(eventData.content);
                } else if (loadType === 'a') {
                    $(ajaxifiables).eq(index).append(eventData.content);
                } else {
                    $(ajaxifiables).eq(index).html(eventData.content);
                }
            });
        });
        // let $this = this;
        // delay = delay || 2000;
        // window.setTimeout(function () {
        //     $this.load(obj);
        // }, delay);
    };

    this.onInit(type, callback);
    {
        let $this = this;
        $(document).on(type + ':oninit', function (e) {
            let data = e.detail;
            if ($.isFunction(callback) && false === callback(data)) {
                return false;
            }
            let delay = 5000;
            /** 5 Seconds after page is fully loaded **/
            $(document).ready(() => {
                window.setTimeout(() => {
                    let loadType = 'get' + type.upperCaseFirstLetter();
                    $this[loadType](data);
                }, delay);
            });
        });
    }

    function beforeContentReady(contentName, callback)
    {
        let beforeReadyEvent = 'page:centent:' + contentName + ':beforeReady';
        $(document).on(beforeReadyEvent, function (e, data) {
            if ($.isFunction(callback)) {
                callback(e, data);
            }
        });
    }

    function onContentReady(contentName, callback) {
        let readyEvent = 'page:content:' + contentName + ':ready';
        $(document).on(readyEvent, function (e, data) {
            if ($.isFunction(callback)) {
                callback(e, data);
            }
        });
    }
};

App.prototype.showCreator = function () {
    // this.backdrop.show();
    // doAjax('posts/')
};
App.prototype.backdrop = function()
{
    function show(cssClass = '', overwriteClass = false)
    {
        let className = 'backdrop',
            screen;
        if (cssClass.length > 0) {
            if (overwriteClass) {
                className = cssClass
            } else {
                className += ' ' + cssClass;
            }
        }
        screen = '.' + className.replaceAll(' ', '.');
        if ($.find(screen).length < 1) {
            $('<div class="'+ className + '"></div>').appendTo('#app-container');
        }
        // $('.backdrop').addClass(cssClass);

        let backdrop = $.find(screen);
        $(backdrop).show();
        $('body').addClass('with-backdrop');
    }
    function hide() {
        $('.backdrop, .modal-backdrop').hide();
        $('body').removeClass('with-backdrop');
    }
    function manager() {

    }
};

App.prototype.form = function()
{
    function processing(description)
    {
        description = description ?? 'Processing...';
        const APP_CONTAINER = $('#app-container'),
            FORM_PROCESSING = $('<div class="form-processing"></div>'),
            SPINNER = spinner('login-processing', {
                state: 'process-running',
            });
        $(SPINNER).find('.process-desc').eq(0).html(description);
        FORM_PROCESSING.html(SPINNER);

        if (APP_CONTAINER.find('.form-processing') > 0) {
            APP_CONTAINER.children('.form-processing').replaceWith(FORM_PROCESSING);
        } else {
            APP_CONTAINER.append(FORM_PROCESSING);
        }
    }
    function successful(description)
    {
        const SUCCESSFUL = $('<div class="process-icon">' +
            '<i class="fe fe-check-circle"></i></div>' +
            '<span class="process-desc">' + description + '</span>');
        $('.form-processing .process-state').html(SUCCESSFUL)
            .removeClass('process-running process-failed')
            .addClass('process-successful');
    }
    function failed(description)
    {
        const SUCCESSFUL = $('<div class="process-icon">' +
            '<i class="fe fe-alert-circle"></i></div>' +
            '<span class="process-desc">' + description + '</span>');
        $('.form-processing .process-state').html(SUCCESSFUL)
            .removeClass('process-running process-successful')
            .addClass('process-failed');
    }
    function hideProcessor()
    {
        $('.form-processing').animate({opacity: 0},{
            easing: 'linear',
            duration: 1000,
            complete: function () {
                this.remove();
            }
        });
    }
};

/**
 *
 * @param opener
 */
App.prototype.drawer = function() {
    function create(drawerID, type = 'page')
    {

        drawerID = drawerID.ltrim('#');

        let drawer = '<div id="' + drawerID + '"\n' +
            '    class="' + type + ' shadow-lg pos-r"\n' +
            '    data-auto-close="false"\n' +
            '    data-role="' + type + '">\n' +
            // '    <div class="' + type + '-data h-100 n1ft4jmn ofjtagoh otgeu7ew' +
            // ' p3n2yi2f pos-r view-port"></div>\n' +
            '</div>';

        let precedent = $('.page, .drawer');

        let previous = precedent.eq(precedent.length - 1);
        if (previous.length < 1) {
            previous = $('.app-bottom-nav');
        }

        $(drawer).insertAfter(previous);
    }

    function open(controller)
    {
        let config = $(controller).data('config') ?? {},
            drawerType = config.drawerType ?? 'drawer',
            drawer = $(controller).attr('aria-controls'),
            headerWidget = config.headerWidget ?? null,
            footerWidget = config.footerWidget ?? null,
            title = config.drawerTitle ?? null,
            direction = config.direction ?? 'fb',
            drawerMax = config.drawerMax ?? '100%',
            dataSrc = config.dataSrc ?? $(controller).attr('href') ?? '',
            hasCloseBtn = config.hasCloseBtn ?? true,
            isAlwaysReloadEnabled = config.alwaysReload || false,
            keyFrame = {};

        if ($(drawer).length < 1) {
            this.create(drawer, 'drawer');
        }
        if (hasCloseBtn && $(drawer).find('.close-drawer').length < 1) {
            let btn = '    <div class="ml-auto hls5zrir px-0 z_24fwo fnd05akr et9hrxaz">\n' +
                '        <button class="bgcH-grey-300 btn bzakvszf c-grey-600 ' +
                'close-drawer lzkw2xxp n1ft4jmn patuzxjv qrfe0hvl rmgay8tp"\n' +
                '                type="button"\n' +
                '                role="button"\n' +
                '                data-role="drawer-close-button"\n' +
                '                data-toggle="drawer"\n' +
                '                aria-controls="' + drawer + '">\n' +
                '            <i class="mdi mdi-close mdi-24px"></i>\n' +
                '        </button>\n' +
                '    </div>';
            $(drawer).prepend(btn);
        }

        if ($.inArray(direction, ['ltr','rtl']) > -1) {
            if (direction === 'ltr') {
                $(drawer).addClass('left-to-right');
            } else if (direction === 'rtl') {
                $(drawer).addClass('right-to-left');
            }
            $(drawer).addClass('side-drawer');
            keyFrame.width = drawerMax;
        } else if (direction === 'fb') {
            $(drawer).addClass('bottom-drawer');
            keyFrame.height = drawerMax;
        }
        (new App()).backdrop.show();


        if (
            $(drawer).find('.drawer-header').length < 1
        ) {
            const header = $('<div class="border-bottom q3ywbqi8 p-4 drawer-header">\n' +
                '    </div>');
            // Set drawer title if configured
            if (title !== null) {
                $(header).prepend('<div class="drawer-title">' + title + '</div>');
            }
            if (headerWidget !== null) {
                $(header).append('<div class="aqeur4se">' + headerWidget + '</div>');
            }
            if ($(header).children().length > 0) {
                $(drawer).append(header);
            }
        }

        if (
            $(drawer).find('.drawer-footer').length < 1
        ) {
            const footer = $('<div class="border-top q3ywbqi8 p-4 drawer-footer">\n' +
                '    </div>')
            if (footerWidget !== null) {
                $(footer).append('<div class="ce6uqzho">' + footerWidget + '</div>');
            }
            if ($(footer).children().length > 0) {
                $(drawer).append(footer);
            }
        }

        if ($(drawer).has('.drawer-header')) {
            $('<div class="drawer-body h-100 ofy-auto"></div>').insertAfter($(drawer).find('.drawer-header').eq(0));
        } else if ($(drawer).has('.drawer-footer')) {
            $(drawer).insertBefore('<div class="drawer-body"></div>', '.drawer-footer');
        }

        $(drawer).css({display: 'flex'});
        $(drawer).animate(keyFrame, {
            duration: 50,
            easing: 'linear',
            complete: function () {
                $(drawer).removeClass('closed').addClass('open');
                $('body').addClass('drawer-open');
            }
        });

        if (!$(drawer).is('.drawer-loaded') || isAlwaysReloadEnabled) {
            let loading = spinner(),
                output = $(drawer).find('.drawer-body').eq(0);
            if (output.length < 1) {
                output = drawer;
            }

            $(output).html(loading);

            let url = (
                dataSrc.startsWith('http') ?
                    dataSrc :
                    window.getBaseUri().rtrim('/') + '/' + dataSrc.ltrim('')
            );
            $.get(url, function (result, status) {
                $(output).find('.content-loading').replaceWith(result);
                $(drawer).addClass('drawer-loaded');
                if ($(drawer).find('[data-role="drawer-close-button"]').length > 0) {
                    $(drawer).find('[data-role="drawer-close-button"]').attr('aria-controls', drawer);
                }
            });
        }
        window.triggerEvent('drawer:loaded', document, {drawer: drawer});
    }
    function loadPage(config)
    {
        let page = '#'+config.pageId;

        if ($(page).length < 1) {
            this.create(page);
        }
        if ($(page).find('.page-header').length < 1) {
            let header = $('<div class="page-header n1ft4jmn page-title-bar px-3 py-2 q3ywbqi8 bzakvszf">\n' +
                '    </div>');
            if ($(page).find('.close-page').length < 1) {
                let btn = '    <div class="px-0">\n' +
                    '        <button class="_ah49Gn btn bzakvszf close-page' +
                    ' lzkw2xxp n1ft4jmn patuzxjv qrfe0hvl rmgay8tp"\n' +
                    '                type="button"\n' +
                    '                role="button"\n' +
                    '                data-role="page-close-button"\n' +
                    '                data-toggle="page"\n' +
                    '                data-page-id="' + config.pageId + '">\n' +
                    '            <i class="mdi mdi-arrow-left mdi-24px"></i>\n' +
                    '        </button>\n' +
                    '    </div>\n';
                $(header).prepend(btn);
            }

            // Set drawer title if configured
            if (config.showTitle && config.pageTitle !== null) {
                $(header).append('<h5 class="page-title mx-auto mb-0">' + config.pageTitle + '</h5>');
            }
            if ($(page).find('.context-menu') < 1 && config.contextMenu !== null) {
                $(header).append('<a href="#" data-src="' + config.contextMenu +
                    '" class="context-menu aqeur4se"><i class="mdi mdi-dots-vertical mdi-24px"></i></a>');
            }

            $(page).prepend(header);
        }
        if (!$(page).is('.page-loaded')) {
            if (
                $(page).find('.page-header').length > 0 &&
                $(page).find('.page-body').length < 1
            ) {
                $('<div class="page-body h-100"></div>').insertAfter(
                    $(page).find('.page-header').eq(0)
                );
            }
            let output = $(page).find('.page-body').eq(0),
                loading = spinner();
            if (output.length < 1) {
                output = page;
            }

            $(output).html(loading);

            let url = (
                config.dataSrc.startsWith('http')
                    ? config.dataSrc
                    : window.getBaseUri().rtrim('/') + '/' +
                    config.dataSrc.ltrim('')
            );
            doAjax(url, function(result, status) {
                if (status === 'success') {
                    $(output).find('.content-loading').replaceWith(result);
                    $(page).removeClass('loading-failed').addClass('page-loaded');
                    if ($(page).find('[data-role="page-close-button"]').length > 0) {
                        $(page).find('[data-role="page-close-button"]').attr('aria-controls', page);
                    }
                } else if (status === 'error') {
                    const response = $('<div class="p-3 text-center"></div>');
                    $(response).html('<div>Oops! Something went wrong... Try refreshing the page</div>');
                    $(response).append('<a href="'+ config.dataSrc+'" ' +
                        'data-action="retry">Retry</a>');
                    $(output).html(response);
                    // $(output).addClass('retryable');
                    $(page).addClass('loading-failed');
                }
            });
        }

        $(page).css({display: 'flex'});
        $(page).animate({width: '100%'}, {
            duration: 50,
            easing: 'linear',
            complete: function () {
                $(page).removeClass('blurred').addClass('active focused');
                $('body').attr('active-page', config.pageId);
            }
        });

        window.triggerEvent('page:loaded', document, {page: page});
    }

    function close(object)
    {
        let app = new App(),
            keyframe = {};

        if ($(object).hasClass('bottom-drawer')) {
            keyframe.height = 0;
        } else {
            keyframe.width = 0;
        }
        $(object).animate(
            keyframe,
            {
                duration: 100,
                easing: 'linear',
                complete: function () {
                    $(object).css({display: 'none'});
                    app.backdrop.hide();
                    if ($(object).hasClass('page')) {
                        let otherPages = $('.page.blurred'),
                            previousPage = $(
                                otherPages.eq(otherPages.length - 1)
                            );
                        $(object).removeClass('active focused').addClass('inactive blurred');
                        $('body').attr(
                            'active-page',
                            previousPage.attr('id') ?? ''
                        );
                    } else {
                        $(object).removeClass('open').addClass('closed');
                        $('body').removeClass('drawer-open');
                    }
                }
            }
        );
    }
    function closeAll()
    {
        this.close('.drawer.open');
        this.close('.page.active');
    }

    function isOpen(objectID)
    {
        if (!objectID.startsWith('#')) {
            objectID = '#' + objectID;
        }
        const object = $(objectID);

        if (object.length < 1) {
            return false;
        }

        if (object.hasClass('page')) {
            return object.hasClass('active');
        } else {
            return object.hasClass('open');
        }
    }

    function toggleState(controller)
    {
        let drawer = $(controller).attr('aria-controls');
        if (this.isOpen(drawer)) {
            console.log('Closing drawer...');
            this.close(drawer);
        } else {
            console.log('Opening drawer...');
            this.open(controller);
        }
    }
    function toggleDrawer(controller)
    {
        const drawer = $(controller).attr('aria-controls');
        if (this.isOpen(drawer)) {
            console.log('Closing drawer...');
            this.close(drawer);
        } else {
            console.log('Opening drawer...');
            this.open(controller);
        }
    }
    function togglePage(controller)
    {
        const pageID = $(controller).data('page-id');
        if (this.isOpen(pageID)) {
            console.log('Closing page...');
            this.close('#' + pageID);
        } else {
            console.log('Opening page...');
            const config = {
                showTitle: true,
                pageTitle: $(controller).data('page-title') ?? $(controller).text(),
                pageId: pageID ?? 'page' + $('.page').length,
                dataSrc: $(controller).data('src') ?? $(controller).attr('href') ?? $(controller).data('url') ?? '',
                contextMenu: $(controller).data('context-menu') ?? null,
                direction: 'rtl',
                drawerMax: '100%',
            };
            this.loadPage(config);
        }
    }
}
App.prototype.modal = function()
{
    let app = this;
    function handleBasicModal() {
        let parent = this;
        $(document).on('click', '[data-ov-toggle="modal"]', function (e) {
            e.preventDefault();
            let trigger = this,
                $target = $(trigger).data('ov-target'), // #theModalID
                plainTarget = $target.replace('#', ''),
                modalSize = $(trigger).data('ov-modal-size') || '',
                modalControl = $(trigger).data('modal-control'),
                dialogControl = $(trigger).data('dialog-control');

            if ($($target).length < 1) {
                let $thisModal = $('#commonModal').clone(true);
                $thisModal.attr('id', plainTarget);
                $thisModal.insertAfter('.modal').last();
                $($target).attr('aria-labelledby', plainTarget + 'Label');
                $($target).find('.modal-title').html(
                    $(trigger).data('title')
                ).attr('id', plainTarget + 'Label');

                let url = $(trigger).attr('href');
                if (url.indexOf('/') < 1) {
                    url = $(trigger).data('uri');
                }
                if (url.indexOf('/') < 1) {
                    console.log('Unable to find a valid url to fetch data from');
                    return false;
                }
                $.get({
                    url: url,
                    dataType: 'html',
                    success: function (result, status) {
                        // if (result.indexOf('orx-ajax-result') >= 1) {
                        $($target).find('.modal-body').html(result);
                        $($target).find('.modal-dialog').addClass(modalSize);
                        // }
                    },
                    error: function (result, status) {
                        console.log(result);
                    }
                });
            }

            let thisInstance = parent.getInstance(plainTarget);
            thisInstance.toggle();

            let instantiated = $('#'+ plainTarget);

            if (modalControl.css) {
                instantiated.css(modalControl.css);
            }
            if (modalControl.class) {
                instantiated.addClass(modalControl.class);
            }
            if (dialogControl.css) {
                instantiated.find('.modal-dialog').css(dialogControl.css);
            }
            if (dialogControl.class) {
                instantiated.find('.modal-dialog').addClass(dialogControl.class);
            }
        });
        $('.modal').on('hide.bs.modal', function (e) {
            if ($(this).hasClass('d-flex') || $(this).hasClass('d-block')) {
                $(this).removeClass('d-flex d-block');
            }
        });
    }
    function getInstance(modalId)
    {
        return new bootstrap.Modal(document.getElementById(modalId), {
            keyboard: true
        });
    }
}
