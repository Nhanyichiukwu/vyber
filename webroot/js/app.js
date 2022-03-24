'use strict';

/*
Application Server Interface
 */
class App {
    cookieName = 'launchDate';
    cookieLifetime = '365';
    starter () {
        doAjax(baseUri + '/home/starter', function (data, status, xhrs) {
            if (status === 'success') {
                $('.main').html(data);
            }
        }, {dataType: 'html'});
    };

    dashboard () {
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

App.prototype.ajaxLoader = {
    /**
     *
     * @param {Object} settings
     * @returns {Boolean}
     */

    ping: function(settings = {})
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

        doFetch(url, {type: 'get', dataType: settings.dataType})
            .then(data => {
                settings.onPing(data, 'success');
            })
            .catch(error => {
                settings.onPing(null, 'error');
            });

        // doAjax(url, function (data, status, xhrs) {
        //     settings.onPing(data, status);
        // }, {type: 'get', dataType: settings.dataType});

        if (settings.afterPing && $.isFunction(settings.afterPing)) {
            settings.afterPing();
        }
        return true;
    },
    load: function(obj)
    {
        const config = $(obj).data('config') || {};
        const url = config.src || $(obj).attr('data-src'),
            name = config.content || $(obj).data('rfc'),
            category = $(obj).data('category') || 'page',
            initEvent = category + ':content:' + name + ':oninit',
            beforeReadyEvent = category + ':content:' + name + ':beforeReady';

        $(document).trigger(initEvent, {obj: obj});

        this.ping({
            url: url,
            dataType: $(obj).data('type') || 'html',
            beforePing: function () {

            },
            onPing: function (data, status) {
                if (status === 'success') {
                    if (data.length > 0) {
                        let onReadyEvent = category + ':content:' + name + ':ready';
                        $(document).trigger(onReadyEvent, {obj: obj, content: data});
                    }
                } else {
                    console.error('Your request could not be completed.');
                }
            },
            beforeReady: function() {
                $(document).trigger(beforeReadyEvent, {obj: obj});
            },
            afterPing: function () {

            }
        });
    },

    // ajaxify: function(ajaxifiables, delay)
    // {
    //     if (typeof ajaxifiables === 'string') {
    //         ajaxifiables = $(ajaxifiables);
    //     }
    //     let obj = this;
    //     ajaxifiables.map(function (index, theElem) {
    //         obj.load(theElem);
    //         const config = $(theElem).data('config'),
    //             contentCategory = $(theElem).data('category');
    //             // loadType = $(theElem).data('load-type');
    //         // obj.onContentReady(contentName, function (e, eventData) {
    //         //     if (loadType === 'r') {
    //         //         $(ajaxifiables).eq(index).replaceWith(eventData.content);
    //         //     } else if (loadType === 'a') {
    //         //         $(ajaxifiables).eq(index).append(eventData.content);
    //         //     } else {
    //         //         $(ajaxifiables).eq(index).html(eventData.content);
    //         //     }
    //         // });
    //
    //         try {
    //             obj.onContentReady(
    //                 contentCategory,
    //                 config.content,
    //                 function (e, eventData) {
    //                     if (!config.load_type) {
    //                         config.load_type = 'replace';
    //                     }
    //                     if (config.load_type === 'replace') {
    //                         $(theElem).replaceWith(eventData.content);
    //                     } else if (config.load_type === 'append') {
    //                         $(theElem).append(eventData.content);
    //                     } else {
    //                         $(theElem).html(eventData.content);
    //                     }
    //                 }
    //             );
    //         } catch (e) {
    //             return false;
    //         }
    //
    //     });
    //     // let $this = this;
    //     // delay = delay || 2000;
    //     // window.setTimeout(function () {
    //     //     $this.load(obj);
    //     // }, delay);
    // },

    ajaxify: function(ajaxifiable, delay)
    {
        if (typeof ajaxifiable === 'string') {
            ajaxifiable = $(ajaxifiable);
        }

        let $this = this;
        delay = delay || 0;
        window.setTimeout(function () {
            $this.load(ajaxifiable);
            const config = $(ajaxifiable).data('config'),
                contentCategory = $(ajaxifiable).data('category');

            try {
                $this.onContentReady(
                    contentCategory,
                    config.content,
                    function (e, eventData) {
                        if (!config.load_type) {
                            config.load_type = 'replace';
                        }
                        if (config.load_type === 'replace') {
                            $(ajaxifiable).replaceWith(eventData.content);
                        } else if (config.load_type === 'append') {
                            $(ajaxifiable).append(eventData.content);
                        } else {
                            $(ajaxifiable).html(eventData.content);
                        }
                    }
                );
            } catch (e) {
                return false;
            }
        }, delay);
    },

    onInit: function(type, callback)
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
    },

    beforeContentReady: function(contentName, callback)
    {
        let beforeReadyEvent = 'page:centent:' + contentName + ':beforeReady';
        $(document).on(beforeReadyEvent, function (e, data) {
            if ($.isFunction(callback)) {
                callback(e, data);
            }
        });
    },

    onContentReady: function(contentCategory, contentName, callback) {
        const contentReady = contentCategory + ':content:' + contentName + ':ready';
            // widgetContentReady = contentCategory + ':content:' + contentName + ':ready';
        $(document).on(contentReady, function (e, data) {
            if ($.isFunction(callback)) {
                callback(e, data);
            }
        });
    },
    fetch: function(url) {

        const settings = {
            "async": true,
            "crossDomain": true,
            "url": url,
            "method": "GET",
            "headers": {
                "content-type": "application/json",
                "x-rapidapi-host": "city-api-io.p.rapidapi.com",
                "x-rapidapi-key": "1e5149384bmshafc6a71a4e006f8p1b59e3jsna7f88be2de8f"
            },
            "processData": false,
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
        });
    }
};


App.prototype.showCreator = function () {
    // this.backdrop.show();
    // doAjax('posts/')
};
App.prototype.backdrop = {
    show: function(cssClass = '', overwriteClass = false)
    {
        let classList = 'backdrop',
            screen;
        if (cssClass.length > 0) {
            if (overwriteClass) {
                classList = cssClass
            } else {
                classList += ' ' + cssClass;
            }
        }
        screen = '.' + classList.replaceAll(' ', '.');
        if ($.find(screen).length < 1) {
            $('<div class="'+ classList + '"></div>').appendTo('body');
        }
        // $('.backdrop').addClass(cssClass);

        const BACKDROP = $.find(screen);
        $(BACKDROP).show();
        $('body').addClass('with-backdrop');
    },
    hide: function() {
        $('.backdrop, .modal-backdrop').hide();
        $('body').removeClass('with-backdrop');
    },
    manager: function() {

    }
};

App.prototype.form = {
    processing: function (description)
    {
        description = description || 'Processing...';
        const APP_CONTAINER = $('#app-container'),
            FORM_PROCESSING = $('<div class="form-processing"></div>'),
            SPINNER = spinner('form-processing', {
                state: 'process-running',
            });
        $(SPINNER).find('.process-desc').eq(0).html(description);
        FORM_PROCESSING.html(SPINNER);

        if (APP_CONTAINER.find('.form-processing') > 0) {
            APP_CONTAINER.children('.form-processing').replaceWith(FORM_PROCESSING);
        } else {
            APP_CONTAINER.append(FORM_PROCESSING);
        }
    },

    successful: function (description)
    {
        const SUCCESSFUL = $('<div class="process-icon">' +
            '<i class="fe fe-check-circle"></i></div>' +
            '<span class="process-desc">' + description + '</span>');
        $('.form-processing .process-state').html(SUCCESSFUL)
            .removeClass('process-running process-failed')
            .addClass('process-successful');
    },

    failed: function (description)
    {
        const SUCCESSFUL = $('<div class="process-icon">' +
            '<i class="fe fe-alert-circle"></i></div>' +
            '<span class="process-desc">' + description + '</span>');
        $('.form-processing .process-state').html(SUCCESSFUL)
            .removeClass('process-running process-successful')
            .addClass('process-failed');
    },

    hideProcessor: function ()
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
App.prototype.drawer = {
    create: function(drawerID, type)
    {
        if (type === undefined) {
            type = 'page';
        }
        drawerID = drawerID.ltrim('#');

        let drawer = '<div id="' + drawerID + '"\n' +
            '    class="' + type + ' pos-r"\n' +
            '    data-auto-close="false"\n' +
            '    data-role="' + type + '">\n' +
            // '    <div class="' + type + '-data h-100 n1ft4jmn ofjtagoh otgeu7ew' +
            // ' p3n2yi2f pos-r view-port"></div>\n' +
            '</div>';

        if (type === 'page') {
            // const cp = $('#pageContent #page-content-wrapper').html();
            $('#pageContent #page-content-wrapper').append(drawer);
        } else {
            let precedent = $('.page, .drawer');

            let previous = precedent.eq(precedent.length - 1);
            if (previous.length < 1) {
                previous = $('.app-bottom-nav');
            }

            $(drawer).insertAfter(previous);
        }

    },
    open: function(controller)
    {
        let config = $(controller).data('config') || {},
            drawerType = config.drawerType || 'drawer',
            drawer = $(controller).attr('aria-controls'),
            headerWidget = config.headerWidget || null,
            footerWidget = config.footerWidget || null,
            title = config.drawerTitle || null,
            direction = config.direction || 'fb',
            drawerMax = config.drawerMax || '100%',
            dataSrc = config.dataSrc || $(controller).attr('href') || '',
            hasCloseBtn = config.hasCloseBtn || true,
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
            $.get({
                url: url,
                success: function (result, status) {
                    $(output).find('.content-loading').replaceWith(result);
                    $(drawer).addClass('drawer-loaded');
                    if ($(drawer).find('[data-role="drawer-close-button"]').length > 0) {
                        $(drawer).find('[data-role="drawer-close-button"]').attr('aria-controls', drawer);
                    }
                    window.triggerEvent('drawer:loaded', document, {drawer: drawer});
                },
                error: function () {
                    // if (!$(drawer).is('.drawer-loaded') && !$(drawer).is('.drawer-load-failed')) {
                    // }
                    $(drawer).addClass('drawer-load-failed');
                }
            });
        }
    },
    loadPage: function(config)
    {
        let page = '#'+config.pageId;

        if ($(page).length < 1) {
            this.create(page);
        }
        $(page).attr('data-page-type', 'overlay');

        if ($(page).find('.page-header').length < 1) {
            let header = $('<div class="page-header n1ft4jmn page-title-bar px-3 py-2 bzakvszf border-bottom">\n' +
                '    </div>');
            if ($(page).find('.close-page').length < 1) {
                let btn = '    <div class="me-4">\n' +
                    '        <button class="_ah49Gn btn bzakvszf close-page' +
                    ' lzkw2xxp n1ft4jmn patuzxjv qrfe0hvl rmgay8tp bgcH-grey-200"\n' +
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
                $(header).append('<h5 class="page-title mb-0">' + config.pageTitle + '</h5>');
            }
            if ($(page).find('.context-menu') < 1 && config.contextMenu !== null) {
                $(header).append('<a href="#" data-src="' + config.contextMenu +
                    '" class="context-menu aqeur4se"><i class="mdi mdi-dots-vertical mdi-24px"></i></a>');
            }

            $(page).prepend(header);
        }

        let url = (
            config.dataSrc.startsWith('http')
                ? config.dataSrc
                : window.getBaseUri().rtrim('/') + '/' +
                config.dataSrc.ltrim('')
        );
        window.history.pushState(null, config.pageTitle, url);
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
    },
    close: function(object)
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
    },
    closeAll: function()
    {
        this.close('.drawer.open');
        this.close('.page.active');
    }
,
    isOpen: function(objectID)
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
,
    toggleState: function(controller)
    {
        let drawer = $(controller).attr('aria-controls');
        if (this.isOpen(drawer)) {
            console.log('Closing drawer...');
            this.close(drawer);
        } else {
            console.log('Opening drawer...');
            this.open(controller);
        }
    },
    toggleDrawer: function(controller)
    {
        const drawer = $(controller).attr('aria-controls');
        if (this.isOpen(drawer)) {
            console.log('Closing drawer...');
            this.close(drawer);
        } else {
            console.log('Opening drawer...');
            this.open(controller);
        }
    },
    togglePage: function(controller)
    {
        const pageID = $(controller).data('page-id');
        if (this.isOpen(pageID)) {
            console.log('Closing page...');
            this.close('#' + pageID);
            window.history.back();
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
App.prototype.modal = {
    handleBasicModal: function() {
        let parent = this;
        $(document).on('click', '[data-ov-toggle="modal"]', function (e) {
            e.preventDefault();
            let trigger = this,
                $target = $(trigger).data('ov-target'), // #theModalID
                plainTarget = $target.replace('#', ''),
                modalSize = $(trigger).data('ov-modal-size') || '',
                modalControl = $(trigger).data('modal-control') || {},
                dialogControl = $(trigger).data('dialog-control') || {},
                alwaysReload = $(trigger).data('always-reload') || false,
                hasTitle = $(trigger).data('title') || false,
                viewport = $(trigger).data('window');

            if ($($target).length < 1) {
                let $thisModal = $('#commonModal').clone(true);
                $thisModal.attr('id', plainTarget);
                $thisModal.insertAfter('.modal').last();
                $($target).attr('aria-labelledby', plainTarget + 'Label');

                let modalTitle = $(trigger).data('title'),
                    header = $('\n' +
                        '            <div class="modal-header">\n' +
                        '                <h5 class="modal-title" ' +
                        'id="' + plainTarget + 'ModalLabel">' + modalTitle + '</h5>\n' +
                        '                <button type="button" class="btn-close" ' +
                        'data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                        '            </div>');
                if (hasTitle) {
                    $($target).find('.modal-content').prepend(header);
                }

                // $($target).find('.modal-title').html(
                //     $(trigger).data('title')
                // ).attr('id', plainTarget + 'Label');
            }

            let thisInstance = parent.getInstance(plainTarget);
            thisInstance.toggle();

            let instantiated = $('#' + plainTarget);

            if (modalControl.hasOwnProperty('css')) {
                instantiated.css(modalControl.css);
            }
            if (modalControl.hasOwnProperty('class')) {
                instantiated.addClass(modalControl.class);
            }
            if (dialogControl.hasOwnProperty('css')) {
                instantiated.find('.modal-dialog').css(dialogControl.css);
            }
            if (dialogControl.hasOwnProperty('class')) {
                instantiated.find('.modal-dialog').addClass(dialogControl.class);
            }
            let $output = $($target).find('.modal-body');

            if (!$output.is('.loaded') || alwaysReload) {
                let $loading = $(spinner()).clone(true);
                $output.html($loading).addClass(':loading');
                let url = $(trigger).attr('href');
                if (url.indexOf('/') < 1) {
                    url = $(trigger).data('uri');
                }
                if (url.indexOf('/') < 1) {
                    console.log('Unable to find a valid url to fetch data from');
                    return false;
                }
                if (viewport === 'frame') {
                    if (url.indexOf('?') > 0) {
                        url += '&frame';
                    }
                    let frameID = 'frame_' + (new Date()).getTime(),
                        $frame = $('<iframe  id="' + frameID + '" src="' + url
                        + '" class="embed frame-in-modal fit-container"></iframe>');
                    $output.css({padding: 0}).html($frame).removeClass(':loading').addClass('loaded');
                    $($target).find('.modal-dialog').addClass(modalSize);
                } else {
                    $.get({
                        url: url,
                        dataType: 'html',
                        success: function (result, status) {
                            // if (result.indexOf('orx-ajax-result') >= 1) {
                            $output.html(result).removeClass(':loading').addClass('loaded');
                            $($target).find('.modal-dialog').addClass(modalSize);
                            // }
                        },
                        error: function (result, status) {
                            let retry = $(trigger).clone(true);
                            $output.html('<p>Unable to load data. Please try again later.</p>');
                            $output.append(retry);
                        }
                    });
                }
            }
        });
        $('.modal').on('hide.bs.modal', function (e) {
            if ($(this).hasClass('d-flex') || $(this).hasClass('d-block')) {
                $(this).removeClass('d-flex d-block');
            }
        });
    },

    getInstance: function(modalId)
    {
        return new bootstrap.Modal(document.getElementById(modalId), {
            keyboard: true
        });
    }
};
App.prototype.getCsrfToken = function () {
    let token;
    if (window.CSRF_TOKEN) {
        token = CSRF_TOKEN;
    } else {
        token = $('meta[name="csrfToken"]').attr('content');
    }

    return token;
};
