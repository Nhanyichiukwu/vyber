/**
 * This section of the script controls composition of posts, comments
 * adding of image and media to posts and comments. As well as the overall
 * behaviour of the user timeline, posts and comments threads
 * @type
 */
    // $('.creatorBtn').click(function (e) {
    //     APP.showCreator();
    // });
let composer = $('.composer');
let postComposer = $('.composer.post-composer');
//        let commentTextbox = commentComposer.find('[role="textbox"]');
let postOpts = $('.fxjd2lmp');
let postSubmit = $('.postSubmit');

// Check if there is an unfinished draft data for this form and
// restore it
// Prefill the post editor wtith content of the previous input, enabling
// the user to continue from where they left off
var draft = $.cookie('Drafts_post');
if (typeof draft !== 'undefined' && draft.length > 0 && $(composer).text().length < 1) {
    $('.post-editor').html(draft);
}

/**
 * If the editor was already loaded from the php server, then we enable the
 * submit button, which is disabled by default
 */
if ($('.post-editor').text().length > 0) {
    $($('.post-editor').data('placeholder')).hide();
    postSubmit.enable();
}
$(document).on('change', 'input[type="radio"].post-type-option',function() {
    if ($(this).is(':checked')) {
        $('.postSubmit').find('.btn-text').text(
            $(this).siblings('.fxjd2lmp').data('submit')
        );
        suggestPostStartingPhrases($(this).val());
        $('.post-editor').attr('data-post-type', $(this).val());
    }
});

// Each time the user stops typing for at least 3 seconds, this
// code should check if the input box has a value, and
// automatically saves it as draft, in case the user, for
// some reason, is unable to continue at the moment.
let lastInputTime, draftDelay = 3000; // 3 seconds

// Check whether the use stopped typing and save draft
$(document).on('editor.input.stopped', '.text-editor[data-draftable="true"]', () => {
    let now = $.now();
    if ((now - lastInputTime) < draftDelay) {
        return false;
    }

    let text = $(postComposer).text();
    let html = $(postComposer).html();
    if (text.length < 1) {
        return false;
    }
    /**
     * If the user is currently connected to the internet, it should save
     * the draft in a php cookie. Otherwise, it will be saved locally with
     * javascript cookie
     */
    if (navigator.onLine) { // Save the draft with cakephp response cookie
        var draftUrl = $('#postEditorConfig input#draft').val();
        doAjax(draftUrl, function(data, status) {
            if (status === 'success' && data.length > 0) {
                $(draftFeedback).fadeIn(1000).html(data).fadeOut(10000);
            } else {
                var msg = 'Sorry an error occured while trying to save your draft...';
                $(draftFeedback).fadeIn(1000).html(msg).fadeOut(10000);
            }
        }, {
            dataType: 'json',
            type: 'POST',
            data: html,
            processData: true
        });
    } else { // Store the draft in JavaScript's cookie
        if ($.cookie('Drafts_post', html, {path: '/'})) {
            //$(draftFeedback).fadeIn(1000).html('Draft Saved').fadeOut(10000);
            console.log('Draft saved');
        }
    }
});

/**
 * Whenever an editor is focused on
 */
$(document).on('focus', '.text-editor', function() {
    if ($(this).is('.post-editor')) {
        let po = $('.publishing-options');
        po.slideDown();
        if (po.find('.starting-phrases').length < 1) {
            suggestPostStartingPhrases($(this).data('post-type'));
        }
        // Force the caret to the end of the existing content whenever
        // the text editor gets focused on
        moveCaretToEndOfEditor($('.post-editor').attr('id'));
    }
});

$(document).on('input', '.text-editor', function () {
    if ($(this).text().length > 0) {
        $($(this).data('placeholder')).hide();
        $(this).parents('.composer').find('.submitBtn').enable();
//                    let text = $('<span class="post_text"></span>');
//                    let ec;
//                    if ($(this).find('.post_text').length > 0) {
//                        ec = $(this).find('.post_text').html();
//                    } else {
//                        ec = $(this).html();
//                    }
//                    text.html(ec);
//                    $(this).html(text);
    } else {
        $(this).trigger('emptied');
    }
    let text = $(this).text();

    let lastInput = text;
    if (text.length > 1) {
        lastInput = text.substr(text.length - 1);
    }
    if (lastInput === '&nbsp;') {
        // console.log($(this).contents());
    }
//                console.log(lastInput);
//                if ($(composer).text().length > 0) {
//                    postSubmit.enable();
//                } else {
//                    postSubmit.disable();
//                }
    if ($(this).is('[data-draftable="true"]')) {
        lastInputTime = $.now();

        window.setTimeout(function() {
            $(this).trigger('editor.input.stopped');
        }, draftDelay);
    }
});

$(document).on('emptied', '.text-editor', function () {
    $($(this).data('placeholder')).show();
    $(this).parents('.composer').find('.submitBtn').disable();
});
$(document).on('editor.hasValue', '.text-editor', function () {
    $($(this).data('placeholder')).hide();
    moveCaretToEndOfEditor($(this).attr('id'));
    $(this).parents('.composer').find('.submitBtn').enable();
});

// Inserting a suggested phrase into the textbox
$(document).on('click', '.starting-phrases .phrase', function(e) {
    let elem;
    if ($(e.target).is('.phrase-text')) {
        elem = $(e.target);
    } else if ($(e.target).children().is('.phrase-text')) {
        elem = $(e.target).find('.phrase-text');
    }
    let text = elem.text(),
        editor = $('.post-editor');
    editor.html(text).trigger('editor.hasValue');
    editor.html(text).trigger('focus');
});

// Adding media (photo,video,audio) to posts or comments.
// Uses File previewer Class to preview the files and also prepare them
// for upload
// let filePicker = $('[data-action="select-file"]');
//    let fileInput = filePicker.data('target');
let selectedMedia = {};
$(document).on('change', 'input[type="file"].post-media', function(e) {
    let $this = $(this);
    if ($this.data('haspreview') === false) {
        return false;
    }

    if ($this.data('preview').length < 1) {
        throw new Error('No output defined for preview! When using data-haspreview="true", you must define data-preview="#outputId"');
    }

    let fileProcessor = new FilePreviewer(e.target);
    fileProcessor.processFiles(function (file) {
        let thisComposer = $this.parents('.composer'),
            composerID = thisComposer.attr('id');

        thisComposer.find('.text-editor')
            .attr('aria-hasattachment', 'true')
            .attr('data-attachment-type', 'media');

        if (!selectedMedia.hasOwnProperty(composerID)) {
            selectedMedia[composerID] = [];
        }
        selectedMedia[composerID].push(file.rawData);

        let media = file.processedData,
            // The main container
            mediaOut = $($this.data('preview'));
        if (mediaOut.length < 1) {
            throw new Error('The output element is missing!');
//                    uf.appendTo('.composer-content-wrapper');
        }
        if (mediaOut.find('.media-list').length < 1) {
            mediaOut.html('<div class="_tqGl _5sXN media-list" aria-layout="grid"></div>');
        }
        // Existing Media
        let existingMedia = mediaOut.find('.media-group'),

            // Total media added
            counter = existingMedia.length,

            mediaColumn = $('<div class="media-groups _LFwB _2w5s" role="column" aria-layout="stack"></div>'),
            // The file wrapper
            mediaWrapper = $('<div class="media-box _kx7 _poYC _3PpE border o-hidden"></div>').html(media),
            // The file editor
            mediaModifier = $('<div class="media-options _ibpR _f8AF _qRwCre remove-media z-9">\n\
                        <!-- <div class="media-modifier-option YKoRoF btn lzkw2xxp s1KmMn wh_30 mb-3" \
                        role="button" data-action="addTags" data-index="' + counter + '" \
                        aria-haspopup="false">\n\
                        <span class="lh_Ut7" aria-hidden="false" data-toggle="tooltip" \
                        title="Tag @Someone" data-placement="top">\n\
                        <i class="mdi mdi-18px mdi-account-plus"></i></span></div>\
                        \
                        <div class="media-modifier-option YKoRoF btn lzkw2xxp s1KmMn wh_30 mb-3" \
                        role="button" data-action="applyFilters" data-index="' + counter + '" \
                        aria-haspopup="false">\n\
                        <span class="lh_Ut7" aria-hidden="false" data-toggle="tooltip" \
                        title="Apply filters" data-placement="top">\n\
                        <i class="mdi mdi-18px mdi-brush"></i></span></div> -->\
                        \
                        <div class="modify-media YKoRoF btn hQmK4pv lzkw2xxp p-0 s1KmMn" \
                        role="button" data-action="loadMediaEditor" data-index="' + counter + '" \
                        aria-haspopup="false">\n\
                        <span class="lh_Ut7 px-2" aria-hidden="false" data-bs-toggle="tooltip" \
                        title="Add caption" data-placement="top">\n\
                        Edit <i class="mdi mdi-18px mdi-pencil"></i></span></div>\
                        </div>'),
            // Remove button
            mediaRemoveBtn = $('<div class="_ibpR _qCNR _qRwCre remove-media z-9">\n\
                        <div class="YKoRoF btn lzkw2xxp s1KmMn wh_30" \
                        role="button" data-action="removeMedia" data-target=".media-group" \
                        aria-haspopup="false">\n\
                        <span class="lh_Ut7" aria-hidden="false" data-bs-toggle="tooltip" \
                        title="Remove media"\
                         data-placement="top">\n\
                        <i class="mdi mdi-18px mdi-close"></i></span></div></div>');
        $(media).addClass('media');
        if (file.fileType === 'image') {
            $(media).parent().css({backgroundImage: 'url('+media.src+')'}).addClass('_XZA1 _v6nr');
            $(media).addClass('_Aqj');
        }

        let mediaGroup = $('<div class="media-group _oFb7Hd _pbe" role="group"></div>');
        $([mediaRemoveBtn, mediaWrapper, mediaModifier]).each(function() {
            $(this).appendTo(mediaGroup);
        });

        // If there are already two existing media, insert the third one
        // in the same container as the second, and compress their heights
        if (existingMedia.length === 2) {
            $(existingMedia.eq(1)).addClass('half-height');
            mediaGroup.insertAfter(existingMedia.eq(1)).addClass('half-height');
        }
            // Otherwise, if the existing media is upto three (3), move the
            // the second to the container of the first one, and insert the
        // forth in same container as the third
        else if (existingMedia.length === 3) {
            $(existingMedia.eq(0), existingMedia.eq(1)).addClass('half-height');
            $(existingMedia.eq(1)).insertAfter(existingMedia.eq(0)); // First move the second one to the container of the first
            mediaGroup.insertAfter(existingMedia.eq(2)).addClass('half-height');
        } else {
            mediaColumn.html(mediaGroup);
            mediaColumn.appendTo(mediaOut.find('.media-list'));
        }
        mediaOut.show();

        existingMedia.each(function () {
            $(this).attr('data-index', existingMedia.index($(this)));
        });

        $this.parents('.composer').trigger('media.added');
    });
});

$(document).on('media.added', '.composer', function () {
    if ($(this).is('.post-composer')) {
        if (!$('.postSubmit').isEnabled()) {
            $('.postSubmit').enable();
        }
    }
    if ($(this).is('.comment-composer')) {
        $(this).find('.commentSubmit').enable();
    }
});

// Turn on file picker events
// This will help fire a click event on any input of type 'file'
// when a corresponding button is clicked. It covers posts and comments
// media
// $(document).on('click', '[data-action="select-file"]', function () {
//     $($(this).data('target')).trigger('click');
// });

$(document).on('media.removed', function (e, eventData) {
    // Should disable the buttons, remove
});

// Enable media removal
$(document).on('click', '[data-action="removeMedia"]', function () {
    let t = $(this).data('target'),
        set = $(this).closest('.media-group').parent(),
        groupsInSet = $(set).find('.media-group'),
        allMedia = set.parents('.media-container').find('.media-group');

    if (allMedia.length === 1) {
        set.parents('.media-container').hide().empty();
        if ($(composer).text().length < 1) {
            $(postSubmit).disable();
        }
    } else if (groupsInSet.length === 1) {
        $(set).remove();
    } else {
        $(this).closest(t).remove();
    }
    let thisComposer = $(this).parents('.composer');
    $(thisComposer).trigger('media.removed', [{itemIndex: $(t).data('index')}]);
});

class MediaModifier {
    option;
    viewBox;
    constructor(viewBox) {
        this.viewBox = viewBox;
        return this;
    }

    // init(option) {
    //     let action = $(option).data('action');
    //     if (!$.isFunction(this[action])) {
    //         return false;
    //     }
    //
    //     // Create a copy of the media to be shown on the editor screen
    //     let media = $($(option).parent().prev().html()).clone(true),
    //         mediaIndex = $(option).data('index'),
    //         mediaModifierScreen = $(this.viewBox).find('.media-modifier'),
    //         loading = $(spinner()).clone(true);
    //
    //     if (mediaModifierScreen.length < 1) {
    //         mediaModifierScreen = $('<div class="media-modifier"></div>');
    //         $(this.viewBox).append(mediaModifierScreen).css({position: 'relative'});
    //     }
    //     mediaModifierScreen = mediaModifierScreen.html(loading);
    //     mediaModifierScreen.show();
    //
    //     return this[action](media, mediaIndex);
    // }

    initFactory(callback) {
        const $this = this;
        $(document).on('click', '.modify-media', function () {
            let option = this,
                action = $(option).data('action');

            if (!$.isFunction($this[action])) {
                return false;
            }

            // Create a copy of the media to be shown on the editor screen
            let media = $($(option).parent().prev().html()).clone(true),
                mediaIndex = $(option).data('index'),
                mediaModifierScreen = $($this.viewBox).find('#media-' + mediaIndex + '-modifier'),
                loading = $(spinner()).clone(true);

            if (mediaModifierScreen.length > 0) {
                $('body ' + '#media-' + mediaIndex + '-modifier').show();
            } else {
                mediaModifierScreen = $('<div id="media-' + mediaIndex + '-modifier" ' +
                    'class="media-modifier" data-role="page">' +
                    '   <div class="media-modifier-content h-100 n1ft4jmn ofjtagoh q3ywbqi8"></div>' +
                    '</div>');
                mediaModifierScreen.find('.media-modifier-content').html(loading);
                $($this.viewBox).append(mediaModifierScreen).css({position: 'relative'});
                return $this[action](media, mediaIndex);
            }
        });
        $(document).on('click', '.modification-option', function (e) {
            let option = this,
                action = $(option).data('action');

            if (!$.isFunction($this[action])) {
                return false;
            }
            let screenId = $(option).data('screen-id');
            if ($('#' + screenId).length > 0) {
                $('#' + screenId).show();
            } else {
                return $this[action](option);
            }
        });
        $(document).on('click', '[data-toggle="modifying-tool"]', function (e) {
            return $this.switchTools(this);
        });
        // $(document).on('input', 'lfls', function () {
        //
        // });
        $(document).on('submit', '.media-modification-form', function (e) {
            e.preventDefault();
            return callback(this);
        });
    }

    switchTools(option) {
        let action = 'get' + $(option).data('action').upperCaseFirstLetter(),
            tools = this[action](),
            toolbox = $(option).closest('.modifying-tools').find('.toolbox');
        toolbox.html(tools);
    }

    showModifierScreen() {
        let mediaModifierScreen = $('<div class="media-modifier"></div>');

    }
    createHeader(title, mediaIndex, options = {}) {
        let closeBtn = '<button class="btn btn-sm rmgay8tp text-white"\n' +
            '   type="button" role="button" data-role="close-button">' +
            '<i class="mdi mdi-arrow-left mdi-24px"></i>' +
            '</button>',
            saveBtn = '<button aria-controls="#media-' + mediaIndex +
                '-modifier">Done <i class="' + 'mdi mdi-check"></i></button>';
        if (options.cbt) {
            closeBtn = options.cbt;
        }
        if (options.sb) {
            saveBtn = options.sb;
        }
        closeBtn = $(closeBtn).addClass('close-page patuzxjv qrfe0hvl lzkw2xxp n1ft4jmn');
        saveBtn = $(saveBtn).addClass('btn btn-app btn-pill close-page lh_wxx p-2');

        let header = $('<div class="media-modifier-header"></div>'),
            titleBar = '<div class="title-area p-1 n1ft4jmn patuzxjv qrfe0hvl">' +
                    '       <h5 class="media-modifier-title">' + title + '</h5>' +
                    '   </div>';
        titleBar = $(titleBar).prepend(closeBtn);
        header = $(header).html(titleBar);
        header = $(header).append(saveBtn);
        return header;
    }

    loadMediaEditor(media, mediaIndex, callback) {
        let $this = this,
            mediaType = $this.getMediaType(media),
            title = 'Edit ' + mediaType,
            header = $this.createHeader(title, mediaIndex),
            mediaContainer = $('<div class="border o-hidden sample-media"></div>'),
            output = $($this.viewBox + ' #media-' + mediaIndex + '-modifier ' +
                '.media-modifier-content');

        output.prepend(header);
        let theMedia = $this.recreateMedia(media);
        theMedia.onload = function () {
            let mediaModifierTools = $('<div class="media-modifier-footer">' +
                // '   <div class="editing-tools" style="display: none"></div>' +
                '   <div class="row modification-options">' +
                '       <div class="col-auto">' +
                '           <div class="modify text-center">\
                               <div class="btn k3cvXacW lzkw2xxp mb-1 \
                               modification-option mx-auto s1KmMn text-white\
                                wh_40 wh_opzWcA" \
                                    role="button" data-action="loadModifier" data-index="' + mediaIndex + '" \
                                    data-screen-id="' + generateID(20) + '"\
                                    aria-haspopup="false">\
                                    <span class="lh_Ut7" aria-hidden="false" data-bs-toggle="tooltip" \
                                    title="Modify" data-placement="top">\
                                    <i class="mdi mdi-18px mdi-pencil"></i></span>\
                                </div>\
                                <span class="text-white">Modify</span>\
                            </div>\
                        </div>\
                        <div class="col-auto">\
                            <div class="add-caption text-center">\
                                <div class="btn k3cvXacW lzkw2xxp mb-1 \
                                modification-option mx-auto s1KmMn text-white\
                                 wh_40 wh_opzWcA" \
                                    role="button" data-action="addCaption" data-index="' + mediaIndex + '" \
                                    data-screen-id="' + generateID(20) + '"\
                                    aria-haspopup="false">\
                                    <span class="lh_Ut7" aria-hidden="false" data-bs-toggle="tooltip" \
                                    title="Add Caption" data-placement="top">\
                                    <i class="icofont-justify-left  "></i></span>\
                                </div>\
                                <span class="text-white">Caption</span>\
                            </div>\
                        </div>\
                        <div class="col-auto">\
                            <div class="add-tag text-center">\
                                <div class="btn k3cvXacW lzkw2xxp mb-1 \
                                modification-option mx-auto s1KmMn text-white\
                                 wh_40 wh_opzWcA" \
                                    role="button" data-action="addTag" data-index="' + mediaIndex + '" \
                                    data-screen-id="' + generateID(20) + '"\
                                    aria-haspopup="false">\
                                    <span class="lh_Ut7" aria-hidden="false" data-bs-toggle="tooltip" \
                                    title="Tag @Someone" data-placement="top">\
                                    <i class="mdi mdi-18px mdi-account-plus-outline"></i></span>\
                                </div>\
                                <span class="text-white">Tag</span>\
                            </div>\
                        </div>\
                    </div>' +
                '</div>');

            mediaContainer = mediaContainer.html(theMedia);
            let modifierBody = $('<div class="modifier-body"></div>');
            modifierBody.append(mediaContainer);
            output.find('.content-loading').replaceWith(modifierBody);
            output.append(mediaModifierTools);
        };
        theMedia.src = media.attr('src');
    }
    loadModifier(option) {
        let output = $(option).closest('.media-modifier'),
            sId = $(option).data('screen-id'),
            screen = '<div id="' + sId + '" class="modifier-overlay media-modifier" data-role="page"></div>',
            wrapper = '<div class="media-modifier-content h-100 n1ft4jmn ofjtagoh q3ywbqi8"></div>',
            body = '<div class="modifier-body"></div>',
            footer = '<div class="media-modifier-footer"></div>',
            screenTitle = 'Modify Media',
            mediaIndex = $(option).data('index'),
            cbt = '<button class="btn lh_wxx p-1 text-white" data-action="save"><i class="mdi' +
                ' mdi-close"></i> Cancel</button>',
            sb = '<button data-action="save">Save <i class="mdi mdi-check"></i></button>',
            header = this.createHeader(screenTitle, mediaIndex, {
                cbt: cbt,
                sb: sb
            }),
            theMedia = $(option).closest('.media-modifier-content').find('img').eq(0).clone(),
            toolsbar = '<div class="modifying-tools">\
                            <div class="tools-nav toolsbar-bottom">\
                                <ul class="modifier-nav nav nav-tabs mjCyKejS">\
                                    <li class="nav-item"><a class="active nav-link" href="javascript:void(0)" \
                                    data-toggle="modifying-tool" data-action="croppingTools"><span class="icofont-crop\
                                     me-2 text-center u2mX"></span>Crop</a></li>\
                                    <li class="nav-item"><a class="nav-link" href="javascript:void(0)" \
                                    data-toggle="modifying-tool" data-action="filteringTools"><span\
                                     class="icofont-brush me-2 u2mX"></span>Filter</a></li>\
                                    <li class="nav-item"><a class="nav-link" href="javascript:void(0)" \
                                    data-toggle="modifying-tool" data-action="effectTools"><span class="icofont-paint\
                                     me-2 u2mX"></span>Effect</a></li>\
                                </ul>\
                            </div>\
                        </div>',
            toolbox = $('<div class="toolbox"></div>');
        body = $(body);
        body.html('<div class="cropping-box">\n' +
            '        <span class="cropping-grid"></span>\n' +
            '       <span class="resize-indicator w-resize"></span>' +
            '       <span class="resize-indicator n-resize"></span>' +
            '       <span class="resize-indicator e-resize"></span>' +
            '       <span class="resize-indicator s-resize"></span>' +
            '    </div>');
        body.find('.cropping-box').prepend(theMedia);
        toolsbar = $(toolsbar);
        let croppingTools = this.getCroppingTools(option);
        toolbox.html(croppingTools);
        toolsbar.prepend(toolbox);

        footer = $(footer).html(toolsbar);
        wrapper = $(wrapper).prepend(header);
        wrapper.append(body).append(footer);

        screen = $(screen).html(wrapper);
        $(output).append(screen);
    }
    addCaption(media, mediaIndex, callback) {
        let mediaType = this.getMediaType(media),
            title = 'Edit Media',
            header = this.createHeader(title, mediaIndex),
            mediaContainer = $('<div class="border xoj5za5y o-hidden sample-media"></div>'),
            output = $(this.viewBox).find('.media-modifier');
        output.prepend(header);
        let theMedia = this.recreateMedia(media);
        theMedia.onload = function () {
            mediaContainer.html(theMedia);
            output.find('.content-loading').replaceWith(mediaContainer);
        };
        theMedia.src = media.attr('src');
        let captionForm = $('<form id="media-' + mediaIndex + '-caption-form" ' +
            'class="media-modification-form">' +
            '  <div class="form-group">' +
            '       <textarea name="media_caption" ' +
            'class="form-control xoj5za5y"></textarea>' +
            '   </div>' +
            '   <div class="form-group text-end">' +
            '       <button class="btn btn-app btn-pill close-page" ' +
            'aria-controls="#media-' + mediaIndex + '-modifier">Save</button>' +
            '   </div>' +
            '</form>');
        output.append(captionForm);
    }
    applyFilters() {

    }
    addTags() {

    }

    getMediaType(media) {
        let name = media.prop('tagName').toLowerCase(),
            type;
        if (name === 'img') {
            type = 'photo';
        } else if (name === 'video') {
            type === 'video';
        } else if (name === 'audio') {
            type = 'audio';
        }

        return type;
    }

    recreateMedia(media) {
        let mediaType = this.getMediaType(media),
            theMedia;
        switch (mediaType) {
            case 'photo':
                theMedia = new Image(media.prop('outerWidth'), media.prop('outerHeight'));
                theMedia.alt = '';
                break;
            case 'video':

                break;
            case 'audio':

                break;
            default:

        }

        return theMedia;
    }

    getCroppingTools(option) {
        let screenId = generateID(20);
        return '<div class="cropping-tools"> \
                    <div class="form-group mb-2">\
                        <div class="row align-items-center">\
                            <div class="col-auto">\
                                <label class="text-white fsz-12">Mirror</label> \
                            </div>\
                            <div class="col">\
                                <div class="mirror-btns d-flex">\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="loadModifier" \
                                     data-index="0" data-screen-id="' + screenId + '" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow sideways" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-horizontal"></i></span>\
                                    </button>\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="mi" \
                                     data-index="0" data-screen-id="' + screenId + '" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow vertically" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-vertical"></i></span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group mb-2">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white fsz-12">Rotate</label>\
                            </div>\
                            <div class="col">\
                                <div class="row align-items-center gutters-xs">\
                                    <div class="col-auto">\
                                        <span><i class="mdi mdi-24px mdi-rotate-left"></i></span>\
                                    </div>\
                                    <div class="col">\
                                        <input type="range" class="form-control custom-range bg-transparent" \
                                        name="rotation" step="0" min="0" max="100">\
                                    </div>\
                                    <div class="col-auto">\
                                        <span><i class="mdi mdi-24px mdi-rotate-right"></i></span>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group mb-2">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white fsz-12">Zoom</label> \
                            </div>\
                            <div class="col">\
                                <div class="row gutters-xs align-items-center">\
                                    <div class="col-auto">\
                                        <span><i class="icofont-minus"></i></span>\
                                    </div>\
                                    <div class="col">\
                                        <input type="range" class="form-control custom-range bg-transparent" \
                                        name="zoom" step="0" min="0" max="100">\
                                    </div>\
                                    <div class="col-auto">\
                                        <span><i class="icofont-plus"></i></span>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>';
    }

    getFilteringTools(option) {
        return '<div class="filtering-tools"> \
                    <div class="form-group">\
                        <div class="row align-items-center">\
                            <div class="col-auto">\
                                <label class="text-white">Mirror</label> \
                            </div>\
                            <div class="col">\
                                <div class="mirror-btns d-flex">\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="loadModifier" \
                                     data-index="0" data-screen-id="modifier-screen" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow sideways" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-horizontal"></i></span>\
                                    </button>\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="mi" \
                                     data-index="0" data-screen-id="modifier-screen" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow vertically" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-vertical"></i></span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white">Rotate</label>\
                            </div>\
                            <div class="col">\
                                <input type="range" class="form-control custom-range bg-transparent" \
                                name="rotation" step="0" min="0" max="100">\
                            </div>\
                            <div class="col-auto">\
                                <input type="number" class="bg-transparent \
                                border-0 form-control no-focus p-0 text-azure w-6" value="50">\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white">Zoom</label> \
                            </div>\
                            <div class="col">\
                                <input type="range" class="form-control custom-range bg-transparent" \
                                name="zoom" step="0" min="0" max="100">\
                            </div>\
                            <div class="col-auto">\
                                <input type="number" class="bg-transparent \
                                border-0 form-control no-focus p-0 text-azure w-6" value="50">\
                            </div>\
                        </div>\
                    </div>\
                </div>';
    }

    getEffectTools(option) {
        return '<div class="effect-tools"> \
                    <div class="form-group">\
                        <div class="row align-items-center">\
                            <div class="col-auto">\
                                <label class="text-white">Mirror</label> \
                            </div>\
                            <div class="col">\
                                <div class="mirror-btns d-flex">\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="loadModifier" \
                                     data-index="0" data-screen-id="modifier-screen" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow sideways" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-horizontal"></i></span>\
                                    </button>\
                                    <button class="btn k3cvXacW lzkw2xxp mb-1 modification-option mx-2 s1KmMn\
                                     text-white zbzlslol" role="button" data-action="mi" \
                                     data-index="0" data-screen-id="modifier-screen" \
                                     aria-haspopup="false"><span class="lh_Ut7" aria-hidden="false" \
                                     data-bs-toggle="tooltip" title="Mirrow vertically" \
                                     data-placement="top"><i class="mdi mdi-18px mdi-flip-vertical"></i></span>\
                                    </button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white">Rotate</label>\
                            </div>\
                            <div class="col">\
                                <input type="range" class="form-control custom-range bg-transparent" \
                                name="rotation" step="0" min="0" max="100">\
                            </div>\
                            <div class="col-auto">\
                                <input type="number" class="bg-transparent \
                                border-0 form-control no-focus p-0 text-azure w-6" value="50">\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="align-items-center gutters-sm row">\
                            <div class="col-auto">\
                                <label class="text-white">Zoom</label> \
                            </div>\
                            <div class="col">\
                                <input type="range" class="form-control custom-range bg-transparent" \
                                name="zoom" step="0" min="0" max="100">\
                            </div>\
                            <div class="col-auto">\
                                <input type="number" class="bg-transparent \
                                border-0 form-control no-focus p-0 text-azure w-6" value="50">\
                            </div>\
                        </div>\
                    </div>\
                </div>';
    }
}

$(document).ready(function (e) {
    const postMediaModifier = new MediaModifier('#creatorDialog .modal-content');
    // Allows users to modify a selected media to add captions, apply filters
// and tag users on a media
//     $(document).on('click', '.post-media-modifier', function () {
//         // const mediaModifier = new MediaModifier(this, '#postComposer');
//         postMediaModifier.init(this);
//     });
    postMediaModifier.initFactory(function (data) {
        console.dir(data);
    });
});

$(document).on('click', '.close-page', function (e) {
    $(this).closest('[data-role="page"]').hide();
});

// Submitting the post/comment
$(document).on('click', '.submitBtn', function(e) {
    let $this = $(this),
        thisComposer = $this.parents('.composer'),
        thisComposerID = thisComposer.attr('id'),
        formData = new FormData(),
        postForm = thisComposer.find('form').eq(0),
        postData = postForm.serializeArray(),
        requestHandler = postForm.attr('action') || thisComposer.data('uri'),
        afterSubmitStatus = 'published',
        replyTo = thisComposer.data('id'),
        postType = $('input[name="post_type"]:checked').val();

    if (typeof replyTo === 'undefined') {
        replyTo = thisComposer.parentsUntil('.i__post').last().data('id');
    }

    if ($.inArray(postType, ['moment','story','location']) >= 1) {
        afterSubmitStatus = 'Shared';
    }

    if (
        selectedMedia.hasOwnProperty(thisComposerID) &&
        selectedMedia[thisComposerID].length > 0
    ) {
        selectedMedia[thisComposerID].forEach(function (item) {
            formData.append('attachments[]', item);
        });
    }

    let $data = $.merge(postData,postData);
    $data.forEach(function (item) {
        formData.append(item.name, item.value);
    });

    $.ajax({
        url: requestHandler,
        type: 'POST',
        data: formData,
//            dataType: 'json',
        headers: {
            'X-CSRF-Token': APP.getCsrfToken()
        },
        processData: false,
        contentType: false,
        success: function (data, status) {
            console.log(data);
            return false;
            let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
            if (status === 'success') {
                // Emptying the textbox
                thisComposer.find('.text-editor').empty().trigger('emptied');
                if (data) {
                    // Display success message
                    flash.children().first()
                        .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
                        .removeClass('alert-danger')
                        .addClass('alert-success');

                    // Announce the good news
                    $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);

                    // Empty the media container
                    thisComposer.find('.media-container').hide().empty();
                    thisComposer.attr({
                        "data-id": "",
                        "data-cc": "",
                        "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
                    });
                } else {
                    // Display error message
                    flash.children().first()
                        .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
                        .removeClass('alert-succcess')
                        .addClass('alert-danger');

                    if (window.saveFailedPost) {
                        postData.attempts = 1;
                        saveFailedPost(postData);
                    }
                }

            } else {
                flash.children().first()
                    .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
                    .removeClass('alert-success')
                    .addClass('alert-danger');
            }
            flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
        }
    });

//         doAjax(requestHandler, function (data, status) {
//             let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
//             if (status === 'success') {
//                 // Emptying the textbox
//                 thisComposer.find('.text-editor').empty().trigger('emptied');
//                 if (data) {
//                     // Display success message
//                     flash.children().first()
//                         .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
//                         .removeClass('alert-danger')
//                         .addClass('alert-success');
//
//                     // Announce the good news
//                     $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
//
//                     // Empty the media container
//                     thisComposer.find('.media-container').hide().empty();
//                     thisComposer.attr({
//                         "data-id": "",
//                         "data-cc": "",
//                         "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
//                     });
//                 } else {
//                     // Display error message
//                     flash.children().first()
//                         .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
//                         .removeClass('alert-succcess')
//                         .addClass('alert-danger');
//
//                     if (window.saveFailedPost) {
//                         postData.attempts = 1;
//                         saveFailedPost(postData);
//                     }
//                 }
//
//             } else {
//                 flash.children().first()
//                     .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
//                     .removeClass('alert-success')
//                     .addClass('alert-danger');
//             }
//             flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
//         }, {
//             type: 'POST',
//             data: formData,
// //            dataType: 'json',
//             headers: {
//                 'X-CSRF-Token': APP.getCsrfToken()
//             },
//             processData: false,
//             contentType: false
//         });
});
/*$(document).on('click', '.submitBtn', function(e) {
    let $this = $(this),
        thisComposer = $this.parents('.composer'),
        thisComposerID = thisComposer.attr('id'),
        thisEditor = thisComposer.find('.text-editor').first(),
        text = thisEditor.html(),
        type = thisEditor.data('post-type'),
        formData = new FormData(),
        postForm = thisComposer.find('form').eq(0),
        postFormValues = postForm.serializeArray(),
        requestHandler = postForm.attr('action') || thisComposer.data('uri'),
        afterSubmitStatus = 'published',
        replyTo = thisComposer.data('id');

    if (typeof replyTo === 'undefined') {
        replyTo = thisComposer.parentsUntil('.i__post').last().data('id');
    }

//        if ($(this).is('.postSubmit')) {
//            type = $('input[type="radio"].post-type:checked').val();
//        }
//        else if ($(this).is('.commentSubmit')) {
//            if (typeof replyTo !== 'undefined') {
//                type = 'reply';
//            } else {
//                type = 'comment';
//            }
//        } else {
//            type = 'post';
//        }

    if ($.inArray(type, ['moment','story','location']) >= 1) {
        afterSubmitStatus = 'Shared';
    }
    let postData = [
        {
            name: "post_text",
            value: text
        },
        {
            name: "post_type",
            value: type
        }
    ];
    if (thisEditor.attr('aria-hasattachment') === 'true') {
        postData.push({
            name: 'has_attachment',
            value: 1
        }, {
            name: "attachment_type",
            value: thisEditor.data('attachment-type')
        });
    }

    if (typeof replyTo !== 'undefined') {
        postData.push({
            name: 'reply_to',
            value: replyTo
        });
    }

    if (
        selectedMedia.hasOwnProperty(thisComposerID) &&
        selectedMedia[thisComposerID].length > 0
    ) {
        selectedMedia[thisComposerID].forEach(function (item) {
            formData.append('attachments[]', item);
        });
    }

    let $data = $.merge(postFormValues,postData);
    $data.forEach(function (item) {
        formData.append(item.name, item.value);
    });

    $.ajax({
        url: requestHandler,
        type: 'POST',
        data: formData,
//            dataType: 'json',
        headers: {
            'X-CSRF-Token': APP.getCsrfToken()
        },
        processData: false,
        contentType: false,
        success: function (data, status) {
            console.log(data);
            return false;
            let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
            if (status === 'success') {
                // Emptying the textbox
                thisComposer.find('.text-editor').empty().trigger('emptied');
                if (data) {
                    // Display success message
                    flash.children().first()
                        .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
                        .removeClass('alert-danger')
                        .addClass('alert-success');

                    // Announce the good news
                    $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);

                    // Empty the media container
                    thisComposer.find('.media-container').hide().empty();
                    thisComposer.attr({
                        "data-id": "",
                        "data-cc": "",
                        "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
                    });
                } else {
                    // Display error message
                    flash.children().first()
                        .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
                        .removeClass('alert-succcess')
                        .addClass('alert-danger');

                    if (window.saveFailedPost) {
                        postData.attempts = 1;
                        saveFailedPost(postData);
                    }
                }

            } else {
                flash.children().first()
                    .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
                    .removeClass('alert-success')
                    .addClass('alert-danger');
            }
            flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
        }
    });

//         doAjax(requestHandler, function (data, status) {
//             let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
//             if (status === 'success') {
//                 // Emptying the textbox
//                 thisComposer.find('.text-editor').empty().trigger('emptied');
//                 if (data) {
//                     // Display success message
//                     flash.children().first()
//                         .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
//                         .removeClass('alert-danger')
//                         .addClass('alert-success');
//
//                     // Announce the good news
//                     $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
//
//                     // Empty the media container
//                     thisComposer.find('.media-container').hide().empty();
//                     thisComposer.attr({
//                         "data-id": "",
//                         "data-cc": "",
//                         "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
//                     });
//                 } else {
//                     // Display error message
//                     flash.children().first()
//                         .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
//                         .removeClass('alert-succcess')
//                         .addClass('alert-danger');
//
//                     if (window.saveFailedPost) {
//                         postData.attempts = 1;
//                         saveFailedPost(postData);
//                     }
//                 }
//
//             } else {
//                 flash.children().first()
//                     .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
//                     .removeClass('alert-success')
//                     .addClass('alert-danger');
//             }
//             flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
//         }, {
//             type: 'POST',
//             data: formData,
// //            dataType: 'json',
//             headers: {
//                 'X-CSRF-Token': APP.getCsrfToken()
//             },
//             processData: false,
//             contentType: false
//         });
});*/

$(document).on({
    'comment.success': renderComment,
    'reply.success': renderComment,
    'post.success': renderPost
});


function renderComment(event, data)
{
    let replied;
    if (data.hasOwnProperty('replied')) {
        if (data.replied !== '') {
            replied = data.replied;
        }
    }
    if (typeof replied === 'undefined') {
        return false;
    }
    let target;
    switch (replied) {
        case $('[data-commentid="' + replied + '"]').length > 0:
            target = $('[data-commentid="' + replied + '"]');
            break;

        case $('[data-replyid="' + replied + '"]').length > 0:
            target = $('[data-replyid="' + replied + '"]');
            break;

        default:
            target = $('[data-postid="' + replied + '"]');
            break;
    }

    if (typeof target === 'undefined' || target.length < 1) {
        return false;
    }

    if ($(target).has('.thread-container')) {

    }

    // Assuming that the comment definitely exists
    let container = $(target).find('.thread-container').first() || $(target).find('.comment-body').first(),
        thread = container.find('[data-role="thread"]');
//        console.log(container);
    return false;
    if (thread.length < 1) {
        thread = $('<ul data-role="thread" data-thread="comments" data-default-length="3"></ul>');
        if ($(container).is('.comment-body')) {
            $(thread).addClass('replies-thread').attr('data-thread', "replies");
        } else {
            $(thread).addClass('replies-thread');
        }
        $(container).append(thread);
    }

    if ($(thread).find('._TikBHt').length > 0) {
        $(thread).append(data.data); // The data returned is already preformated
    } else {
        $(thread).html(data.data);
    }
}

function renderPost(event, data)
{

}

// Enable comments on posts
$(document).on('click', '[data-action="comment"], [data-action="reply"]', function (e) {
    e.preventDefault();

    let thisRoot = $(this).parents('.i__post'),
//            thisBackTrace = $(this).parentsUntil('._aQtRd7eh').last(),
        thisData = $(this).find('.data').attr('data'),
        recipients,
        thisEditor = $(thisRoot).find('.comment-editor');

    if ($(this).is('[data-action="reply"]')) {
        thisEditor.attr('data-post-type', 'reply');
    } else {
        thisEditor.attr('data-post-type', 'comment');
    }


//        if ($(this).is('._n2Cuoj')) {
//            thisData = $(thisBackTrace).find('.data').first().text();
//        } else {
//            thisData = $(thisBackTrace).find('.data').text();
//        }
//
    if (typeof thisData === 'string' && thisData.length > 0) {
        thisData = $.parseJSON(thisData);
    }
    if (thisData.replyingto !== 'undefined') {
        recipients = thisData.replyingto;
    }
    if (typeof recipients !== 'undefined') {
        let linkifiedRecipients = recipients.split(',');
        linkifiedRecipients = $.makeArray(linkifiedRecipients);
        linkifiedRecipients = $.map(linkifiedRecipients, function (item) {
            let username = item;
            if (username.charAt(0) === '@') {
                username = username.substr(1);
            }
            if (item.charAt(0) !== '@') {
                item = '@' + item;
            }
            return '<span class="_JF4usO"><a href="/' + username
                + '" class="_w5w _zeN4uW" role="link">' + item + '</a></span>';
        });

        linkifiedRecipients = '<span class="_vVza _wdjO _mo4J3"></span>' + linkifiedRecipients.join("\n");
        linkifiedRecipients += '&nbsp;';
        $(thisEditor).html(linkifiedRecipients).trigger('editor.hasValue');
    }
    $(thisEditor).parents('.composer').attr({
        "data-uri": thisData.uri,
        "data-replyto": thisData.id,
        "data-cc": thisData.replyingto
    });

    let commentContainer = $(this).attr('aria-controls');
    if (typeof commentContainer !== 'undefined') {
        $(commentContainer).slideToggle('fast');
    }
    $(thisEditor).trigger('focus');

    return false;
});

/**
 * Enable Post View via iframe in modal dialog
 */
// When a post section is clicked without targeting any element on
// it, such as media, read more, call-to-action btns
$(document).on('click', '.i__post', function (e) {
    if (!$(this).is('.viewable')) {
        return false;
    }

    if (!$(this).children().first().is('[aria-haspopup="true"]')) {
        return false;
    }
    let theElem = e.target,
        uri;

    if ($(theElem).is('.media, img, video, audio, .btn, a, a *, .btn *, [role="button"],[role="textbox"], .comment-area, .comment-area *, .avatar')) {
        return;
    }
    if ($(theElem).is('.i__post')) {
        uri = $(theElem).children().last().data('uri');
    } else if ($(theElem).data('uri')) {
        uri = $(theElem).data('uri');
    } else {
        uri = $(theElem).parentsUntil('.i__post').last().data('uri');
    }
    uri += '?ref=container';

    // let prospect = $('<div class="z_24fwo _ycGkU4 _Axdy _3og d-flex .justify-content-center' +
    //     ' align-items-center"></div>');
    let loading = spinner('postLoading', {text: 'Loading post. Please wait...', class: 'align-items-center' +
            ' content-loading' +
            ' d-flex' +
            ' justify-content-center pb-5'});

    let prospect = $('<div class="_NGavIJ dhc99t d-flex justify-content-center' +
        ' align-items-center"></div>');
    prospect.html(loading);
    $(prospect).find('.spinner').toggleClass('text-primary text-white');
    $(prospect).find('.spinner-text').toggleClass('text-muted text-white');

    var basicModal = $('#basicModal');
    $(basicModal).modal('show');

    let frame = $('<iframe class="_oB post-reader w-100 _a5kW87"></iframe>');
    $(basicModal).find('.modal-dialog').addClass('w_fMGsRw');
    $(frame).hide().attr({'id': 'postReader', 'src': uri});
    $(basicModal).find('.modal-body').html(loading);
    let viewHeight = $(window).innerHeight();
    $(frame).css({height: viewHeight});
    $(basicModal).find('.modal-body').append(frame);
    $('#postReader').on('load', function () {
        $('#postLoading').remove();
        $(frame).show();
    });
});
