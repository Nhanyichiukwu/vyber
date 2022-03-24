'use strict';

const APP = new App();
jQuery(document).ready(function () {

// Remove the splashscreen once page is done loading...
//     window.setTimeout(function (e) {
        $('.splashscreen').remove();
    // }, 1000);

//     /**
//      * This section of the script controls composition of posts, comments
//      * adding of image and media to posts and comments. As well as the overall
//      * behaviour of the user timeline, posts and comments threads
//      * @type
//      */
//     // $('.creatorBtn').click(function (e) {
//     //     APP.showCreator();
//     // });
//     let composer = $('.composer');
//     let postComposer = $('.composer.post-composer');
// //        let commentTextbox = commentComposer.find('[role="textbox"]');
//     let postOpts = $('.fxjd2lmp');
//     let postSubmit = $('.postSubmit');
//
//     // Check if there is an unfinished draft data for this form and
//     // restore it
//     // Prefill the post editor wtith content of the previous input, enabling
//     // the user to continue from where they left off
//     var draft = $.cookie('Drafts_post');
//     if (typeof draft !== 'undefined' && draft.length > 0 && $(composer).text().length < 1) {
//         $('.post-editor').html(draft);
//     }
//
//     /**
//      * If the editor was already loaded from the php server, then we enable the
//      * submit button, which is disabled by default
//      */
//     if ($('.post-editor').text().length > 0) {
//         $($('.post-editor').data('placeholder')).hide();
//         postSubmit.enable();
//     }
//     $(document).on('change', 'input[type="radio"].post-type-option',function() {
//         if ($(this).is(':checked')) {
//             $('.postSubmit').find('.btn-text').text(
//                 $(this).siblings('.fxjd2lmp').data('submit')
//             );
//             suggestPostStartingPhrases($(this).val());
//             $('.post-editor').attr('data-post-type', $(this).val());
//         }
//     });
//
//     // Each time the user stops typing for at least 3 seconds, this
//     // code should check if the input box has a value, and
//     // automatically saves it as draft, in case the user, for
//     // some reason, is unable to continue at the moment.
//     let lastInputTime, draftDelay = 3000; // 3 seconds
//
//     // Check whether the user stopped typing and save draft
//     $(document).on('editor.input.stopped', '.text-editor[data-draftable="true"]', () => {
//         let now = $.now();
//         if ((now - lastInputTime) < draftDelay) {
//             return false;
//         }
//
//         let text = $(postComposer).text();
//         let html = $(postComposer).html();
//         if (text.length < 1) {
//             return false;
//         }
//         /**
//          * If the user is currently connected to the internet, it should save
//          * the draft in a php cookie. Otherwise, it will be saved locally with
//          * javascript cookie
//          */
//         if (navigator.onLine) { // Save the draft with cakephp response cookie
//             var draftUrl = $('#postEditorConfig input#draft').val();
//             doAjax(draftUrl, function(data, status) {
//                 if (status === 'success' && data.length > 0) {
//                     $(draftFeedback).fadeIn(1000).html(data).fadeOut(10000);
//                 } else {
//                     var msg = 'Sorry an error occured while trying to save your draft...';
//                     $(draftFeedback).fadeIn(1000).html(msg).fadeOut(10000);
//                 }
//             }, {
//                 dataType: 'json',
//                 type: 'POST',
//                 data: html,
//                 processData: true
//             });
//         } else { // Store the draft in JavaScript's cookie
//             if ($.cookie('Drafts_post', html, {path: '/'})) {
//                 //$(draftFeedback).fadeIn(1000).html('Draft Saved').fadeOut(10000);
//                 console.log('Draft saved');
//             }
//         }
//     });
//
//     /**
//      * Whenever an editor is focused on
//      */
//     $(document).on('focus', '.text-editor', function() {
//         if ($(this).is('.post-editor')) {
//             let po = $('.publishing-options');
//             po.slideDown();
//             if (po.find('.starting-phrases').length < 1) {
//                 suggestPostStartingPhrases($(this).data('post-type'));
//             }
//             // Force the caret to the end of the existing content whenever
//             // the text editor gets focused on
//             moveCaretToEndOfEditor($('.post-editor').attr('id'));
//         }
//     });
//
//     $(document).on('input', '.text-editor', function () {
//         if ($(this).text().length > 0) {
//             $($(this).data('placeholder')).hide();
//             $(this).parents('.composer').find('.submitBtn').enable();
// //                    let text = $('<span class="post_text"></span>');
// //                    let ec;
// //                    if ($(this).find('.post_text').length > 0) {
// //                        ec = $(this).find('.post_text').html();
// //                    } else {
// //                        ec = $(this).html();
// //                    }
// //                    text.html(ec);
// //                    $(this).html(text);
//         } else {
//             $(this).trigger('emptied');
//         }
//         let text = $(this).text();
//
//         let lastInput = text;
//         if (text.length > 1) {
//             lastInput = text.substr(text.length - 1);
//         }
//         if (lastInput === '&nbsp;') {
//             // console.log($(this).contents());
//         }
// //                console.log(lastInput);
// //                if ($(composer).text().length > 0) {
// //                    postSubmit.enable();
// //                } else {
// //                    postSubmit.disable();
// //                }
//         if ($(this).is('[data-draftable="true"]')) {
//             lastInputTime = $.now();
//
//             window.setTimeout(function() {
//                 $(this).trigger('editor.input.stopped');
//             }, draftDelay);
//         }
//     });
//
//     $(document).on('emptied', '.text-editor', function () {
//         $($(this).data('placeholder')).show();
//         $(this).parents('.composer').find('.submitBtn').disable();
//     });
//     $(document).on('editor.hasValue', '.text-editor', function () {
//         $($(this).data('placeholder')).hide();
//         moveCaretToEndOfEditor($(this).attr('id'));
//         $(this).parents('.composer').find('.submitBtn').enable();
//     });
//
//     // Inserting a suggested phrase into the textbox
//     $(document).on('click', '.starting-phrases .phrase', function(e) {
//         let elem;
//         if ($(e.target).is('.phrase-text')) {
//             elem = $(e.target);
//         } else if ($(e.target).children().is('.phrase-text')) {
//             elem = $(e.target).find('.phrase-text');
//         }
//         let text = elem.text(),
//             editor = $('.post-editor');
//         editor.html(text).trigger('editor.hasValue');
//         editor.html(text).trigger('focus');
//     });
//
//     // Adding media (photo,video,audio) to posts or comments.
//     // Uses File previewer Class to preview the files and also prepare them
//     // for upload
//     let filePicker = $('[data-action="select-file"]');
// //    let fileInput = filePicker.data('target');
//     let uploadReady = {};
//     $(document).on('change', 'input[type="file"].post-media', function(e) {
//         let $this = $(this);
//         if ($this.data('haspreview') === false) {
//             return false;
//         }
//
//         if ($this.data('preview').length < 1) {
//             throw new Error('No output defined for preview! When using data-haspreview="true", you must define data-preview="#outputId"');
//         }
//
//         let fileProcessor = new FilePreviewer(e.target);
//         fileProcessor.processFiles(function (file) {
//             let thisComposer = $this.parents('.composer'),
//                 composerID = thisComposer.attr('id');
//
//             thisComposer.find('.text-editor')
//                 .attr('aria-hasattachment', 'true')
//                 .attr('data-attachment-type', 'media');
//
//             if (!uploadReady.hasOwnProperty(composerID)) {
//                 uploadReady[composerID] = [];
//             }
//             uploadReady[composerID].push(file.rawData);
//
//             let media = file.processedData,
//                 // The main container
//                 mediaOut = $($this.data('preview'));
//             if (mediaOut.length < 1) {
//                 throw new Error('The output element is missing!');
// //                    uf.appendTo('.composer-content-wrapper');
//             }
//             if (mediaOut.find('.media-list').length < 1) {
//                 mediaOut.html('<div class="_tqGl _5sXN media-list" aria-layout="grid"></div>');
//             }
//
//             let existingMedia = mediaOut.find('.media-group'), // Existing Media
//                 mediaColumn = $('<div class="media-groups _LFwB _2w5s" role="column" aria-layout="stack"></div>'),
//                 // The file wrapper
//                 mediaWrapper = $('<div class="media-box _kx7 _poYC _3PpE border o-hidden"></div>').html(media),
//                 // The file editor
//                 mediaOpts = $('<div class="_kx7 _3oz"></div>'),
//                 // Remove button
//                 mediaRemoveBtn = $('<div class="mr-2 mt-2 pos-a-r pos-a-t remove-media z-9">\n\
//                         <div class="align-items-center bdrs-20 bgcH-grey-700 \n\
//                         btn cH-grey-300 text-muted d-flex justify-content-center p-0 wh_30" role="button" data-action="removeMedia" data-target=".media-group" aria-haspopup="false">\n\
//                         <span class="lh_Ut7" aria-hidden="false" data-toggle="tooltip" title="Remove Media" data-placement="top">\n\
//                         <i class="mdi mdi-24px mdi-close"></i></span></div></div>');
//             $(media).addClass('media');
//             if (file.fileType === 'image') {
//                 $(media).parent().css({backgroundImage: 'url('+media.src+')'}).addClass('_XZA1 _v6nr');
//                 $(media).addClass('_Aqj');
//             }
//
//             let mediaGroup = $('<div class="media-group _pbe pos-r" role="group"></div>');
//             $([mediaRemoveBtn, mediaWrapper, mediaOpts]).each(function() {
//                 $(this).appendTo(mediaGroup);
//             });
//
//             // If there are already two existing media, insert the third one
//             // in the same container as the second, and compress their heights
//             if (existingMedia.length === 2) {
//                 $(existingMedia.eq(1)).addClass('half-height');
//                 mediaGroup.insertAfter(existingMedia.eq(1)).addClass('half-height');
//             }
//                 // Otherwise, if the existing media is upto three (3), move the
//                 // the second to the container of the first one, and insert the
//             // forth in same container as the third
//             else if (existingMedia.length === 3) {
//                 $(existingMedia.eq(0), existingMedia.eq(1)).addClass('half-height');
//                 $(existingMedia.eq(1)).insertAfter(existingMedia.eq(0)); // First move the second one to the container of the first
//                 mediaGroup.insertAfter(existingMedia.eq(2)).addClass('half-height');
//             }
//             else {
//                 mediaColumn.html(mediaGroup);
//                 mediaColumn.appendTo(mediaOut.find('.media-list'));
//             }
//             mediaOut.show();
//
//             existingMedia.each(function () {
//                 $(this).attr('data-index', existingMedia.index($(this)));
//             });
//
//             $this.parents('.composer').trigger('media.added');
//         });
//     });
//
//     $(document).on('media.added', '.composer', function () {
//         if ($(this).is('.post-composer')) {
//             if (!$('.postSubmit').isEnabled()) {
//                 $('.postSubmit').enable();
//             }
//         }
//         if ($(this).is('.comment-composer')) {
//             $(this).find('.commentSubmit').enable();
//         }
//     });
//
//     // Turn on file picker events
//     // This will help fire a click event on any input of type 'file'
//     // when a corresponding button is clicked. It covers posts and comments
//     // media
//     $(document).on('click', '[data-action="select-file"]', function () {
//         $($(this).data('target')).trigger('click');
//     });
//
//     $(document).on('media.removed', function (e, eventData) {
//         // Should disable the buttons, remove
//     });
//
//     // Enable media removal
//     $(document).on('click', '[data-action="removeMedia"]', function () {
//         let t = $(this).data('target');
//         let set = $(this).closest('.media-group').parent();
//         let groupsInSet = $(set).find('.media-group');
//         let allMedia = set.parents('.media-container').find('.media-group');
//
//         if (allMedia.length === 1) {
//             set.parents('.media-container').hide().empty();
//             if ($(composer).text().length < 1) {
//                 $(postSubmit).disable();
//             }
//         }
//         else if (groupsInSet.length === 1) {
//             $(set).remove();
//         } else {
//             $(this).closest(t).remove();
//         }
//         let thisComposer = $(this).parents('.composer');
//         $(thisComposer).trigger('media.removed', [{itemIndex: $(t).data('index')}]);
//     });
//
//     // Submitting the post/comment
//     $(document).on('click', '.submitBtn', function(e) {
//         let $this = $(this),
//             thisComposer = $this.parents('.composer'),
//             thisComposerID = thisComposer.attr('id'),
//             formData = new FormData(),
//             postForm = thisComposer.find('form').eq(0),
//             postData = postForm.serializeArray(),
//             requestHandler = postForm.attr('action') || thisComposer.data('uri'),
//             afterSubmitStatus = 'published',
//             replyTo = thisComposer.data('id');
//
//         if (typeof replyTo === 'undefined') {
//             replyTo = thisComposer.parentsUntil('.i__post').last().data('id');
//         }
//
//         if ($.inArray(type, ['moment','story','location']) >= 1) {
//             afterSubmitStatus = 'Shared';
//         }
//
//         if (
//             uploadReady.hasOwnProperty(thisComposerID) &&
//             uploadReady[thisComposerID].length > 0
//         ) {
//             uploadReady[thisComposerID].forEach(function (item) {
//                 formData.append('attachments[]', item);
//             });
//         }
//
//         let $data = $.merge(postData,postData);
//         $data.forEach(function (item) {
//             formData.append(item.name, item.value);
//         });
//
//         $.ajax({
//             url: requestHandler,
//             type: 'POST',
//             data: formData,
// //            dataType: 'json',
//             headers: {
//                 'X-CSRF-Token': APP.getCsrfToken()
//             },
//             processData: false,
//             contentType: false,
//             success: function (data, status) {
//                 console.log(data);
//                 return false;
//                 let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
//                 if (status === 'success') {
//                     // Emptying the textbox
//                     thisComposer.find('.text-editor').empty().trigger('emptied');
//                     if (data) {
//                         // Display success message
//                         flash.children().first()
//                             .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
//                             .removeClass('alert-danger')
//                             .addClass('alert-success');
//
//                         // Announce the good news
//                         $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
//
//                         // Empty the media container
//                         thisComposer.find('.media-container').hide().empty();
//                         thisComposer.attr({
//                             "data-id": "",
//                             "data-cc": "",
//                             "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
//                         });
//                     } else {
//                         // Display error message
//                         flash.children().first()
//                             .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
//                             .removeClass('alert-succcess')
//                             .addClass('alert-danger');
//
//                         if (window.saveFailedPost) {
//                             postData.attempts = 1;
//                             saveFailedPost(postData);
//                         }
//                     }
//
//                 } else {
//                     flash.children().first()
//                         .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
//                         .removeClass('alert-success')
//                         .addClass('alert-danger');
//                 }
//                 flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
//             }
//         });
//
// //         doAjax(requestHandler, function (data, status) {
// //             let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
// //             if (status === 'success') {
// //                 // Emptying the textbox
// //                 thisComposer.find('.text-editor').empty().trigger('emptied');
// //                 if (data) {
// //                     // Display success message
// //                     flash.children().first()
// //                         .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
// //                         .removeClass('alert-danger')
// //                         .addClass('alert-success');
// //
// //                     // Announce the good news
// //                     $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
// //
// //                     // Empty the media container
// //                     thisComposer.find('.media-container').hide().empty();
// //                     thisComposer.attr({
// //                         "data-id": "",
// //                         "data-cc": "",
// //                         "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
// //                     });
// //                 } else {
// //                     // Display error message
// //                     flash.children().first()
// //                         .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
// //                         .removeClass('alert-succcess')
// //                         .addClass('alert-danger');
// //
// //                     if (window.saveFailedPost) {
// //                         postData.attempts = 1;
// //                         saveFailedPost(postData);
// //                     }
// //                 }
// //
// //             } else {
// //                 flash.children().first()
// //                     .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
// //                     .removeClass('alert-success')
// //                     .addClass('alert-danger');
// //             }
// //             flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
// //         }, {
// //             type: 'POST',
// //             data: formData,
// // //            dataType: 'json',
// //             headers: {
// //                 'X-CSRF-Token': APP.getCsrfToken()
// //             },
// //             processData: false,
// //             contentType: false
// //         });
//     });
//     /*$(document).on('click', '.submitBtn', function(e) {
//         let $this = $(this),
//             thisComposer = $this.parents('.composer'),
//             thisComposerID = thisComposer.attr('id'),
//             thisEditor = thisComposer.find('.text-editor').first(),
//             text = thisEditor.html(),
//             type = thisEditor.data('post-type'),
//             formData = new FormData(),
//             postForm = thisComposer.find('form').eq(0),
//             postFormValues = postForm.serializeArray(),
//             requestHandler = postForm.attr('action') || thisComposer.data('uri'),
//             afterSubmitStatus = 'published',
//             replyTo = thisComposer.data('id');
//
//         if (typeof replyTo === 'undefined') {
//             replyTo = thisComposer.parentsUntil('.i__post').last().data('id');
//         }
//
// //        if ($(this).is('.postSubmit')) {
// //            type = $('input[type="radio"].post-type:checked').val();
// //        }
// //        else if ($(this).is('.commentSubmit')) {
// //            if (typeof replyTo !== 'undefined') {
// //                type = 'reply';
// //            } else {
// //                type = 'comment';
// //            }
// //        } else {
// //            type = 'post';
// //        }
//
//         if ($.inArray(type, ['moment','story','location']) >= 1) {
//             afterSubmitStatus = 'Shared';
//         }
//         let postData = [
//             {
//                 name: "post_text",
//                 value: text
//             },
//             {
//                 name: "post_type",
//                 value: type
//             }
//         ];
//         if (thisEditor.attr('aria-hasattachment') === 'true') {
//             postData.push({
//                 name: 'has_attachment',
//                 value: 1
//             }, {
//                 name: "attachment_type",
//                 value: thisEditor.data('attachment-type')
//             });
//         }
//
//         if (typeof replyTo !== 'undefined') {
//             postData.push({
//                 name: 'reply_to',
//                 value: replyTo
//             });
//         }
//
//         if (
//             uploadReady.hasOwnProperty(thisComposerID) &&
//             uploadReady[thisComposerID].length > 0
//         ) {
//             uploadReady[thisComposerID].forEach(function (item) {
//                 formData.append('attachments[]', item);
//             });
//         }
//
//         let $data = $.merge(postFormValues,postData);
//         $data.forEach(function (item) {
//             formData.append(item.name, item.value);
//         });
//
//         $.ajax({
//             url: requestHandler,
//             type: 'POST',
//             data: formData,
// //            dataType: 'json',
//             headers: {
//                 'X-CSRF-Token': APP.getCsrfToken()
//             },
//             processData: false,
//             contentType: false,
//             success: function (data, status) {
//                 console.log(data);
//                 return false;
//                 let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
//                 if (status === 'success') {
//                     // Emptying the textbox
//                     thisComposer.find('.text-editor').empty().trigger('emptied');
//                     if (data) {
//                         // Display success message
//                         flash.children().first()
//                             .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
//                             .removeClass('alert-danger')
//                             .addClass('alert-success');
//
//                         // Announce the good news
//                         $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
//
//                         // Empty the media container
//                         thisComposer.find('.media-container').hide().empty();
//                         thisComposer.attr({
//                             "data-id": "",
//                             "data-cc": "",
//                             "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
//                         });
//                     } else {
//                         // Display error message
//                         flash.children().first()
//                             .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
//                             .removeClass('alert-succcess')
//                             .addClass('alert-danger');
//
//                         if (window.saveFailedPost) {
//                             postData.attempts = 1;
//                             saveFailedPost(postData);
//                         }
//                     }
//
//                 } else {
//                     flash.children().first()
//                         .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
//                         .removeClass('alert-success')
//                         .addClass('alert-danger');
//                 }
//                 flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
//             }
//         });
//
// //         doAjax(requestHandler, function (data, status) {
// //             let flash = either($('.flash'), $('<div class="flash"><div class="alert text-center"></div></div>'));
// //             if (status === 'success') {
// //                 // Emptying the textbox
// //                 thisComposer.find('.text-editor').empty().trigger('emptied');
// //                 if (data) {
// //                     // Display success message
// //                     flash.children().first()
// //                         .html('Your ' + type + ' was ' + afterSubmitStatus + ' successfully.')
// //                         .removeClass('alert-danger')
// //                         .addClass('alert-success');
// //
// //                     // Announce the good news
// //                     $(document).trigger(type + '.success', [{data: data, replied: replyTo}]);
// //
// //                     // Empty the media container
// //                     thisComposer.find('.media-container').hide().empty();
// //                     thisComposer.attr({
// //                         "data-id": "",
// //                         "data-cc": "",
// //                         "data-uri": thisComposer.parentsUntil('.i__post').last().data('uri') + '/add_comment'
// //                     });
// //                 } else {
// //                     // Display error message
// //                     flash.children().first()
// //                         .html('Oops! Something went wrong there. But not to panic, your ' + type + ' is being processed in the background. We will have error fixed as soon as we can.')
// //                         .removeClass('alert-succcess')
// //                         .addClass('alert-danger');
// //
// //                     if (window.saveFailedPost) {
// //                         postData.attempts = 1;
// //                         saveFailedPost(postData);
// //                     }
// //                 }
// //
// //             } else {
// //                 flash.children().first()
// //                     .html('Oops! Sorry but the ' + type + ' could not be ' + afterSubmitStatus.toLowerCase() + '. Please try refreshing the page.')
// //                     .removeClass('alert-success')
// //                     .addClass('alert-danger');
// //             }
// //             flash.hide().prependTo('main[role="main"]').slideDown(1000).delay(4000).slideUp(1000);
// //         }, {
// //             type: 'POST',
// //             data: formData,
// // //            dataType: 'json',
// //             headers: {
// //                 'X-CSRF-Token': APP.getCsrfToken()
// //             },
// //             processData: false,
// //             contentType: false
// //         });
//     });*/
//
//     $(document).on({
//         'comment.success': renderComment,
//         'reply.success': renderComment,
//         'post.success': renderPost
//     });
//
//
//     function renderComment(event, data)
//     {
//         let replied;
//         if (data.hasOwnProperty('replied')) {
//             if (data.replied !== '') {
//                 replied = data.replied;
//             }
//         }
//         if (typeof replied === 'undefined') {
//             return false;
//         }
//         let target;
//         switch (replied) {
//             case $('[data-commentid="' + replied + '"]').length > 0:
//                 target = $('[data-commentid="' + replied + '"]');
//                 break;
//
//             case $('[data-replyid="' + replied + '"]').length > 0:
//                 target = $('[data-replyid="' + replied + '"]');
//                 break;
//
//             default:
//                 target = $('[data-postid="' + replied + '"]');
//                 break;
//         }
//
//         if (typeof target === 'undefined' || target.length < 1) {
//             return false;
//         }
//
//         if ($(target).has('.thread-container')) {
//
//         }
//
//         // Assuming that the comment definitely exists
//         let container = $(target).find('.thread-container').first() || $(target).find('.comment-body').first(),
//             thread = container.find('[data-role="thread"]');
// //        console.log(container);
//         return false;
//         if (thread.length < 1) {
//             thread = $('<ul data-role="thread" data-thread="comments" data-default-length="3"></ul>');
//             if ($(container).is('.comment-body')) {
//                 $(thread).addClass('replies-thread').attr('data-thread', "replies");
//             } else {
//                 $(thread).addClass('replies-thread');
//             }
//             $(container).append(thread);
//         }
//
//         if ($(thread).find('._TikBHt').length > 0) {
//             $(thread).append(data.data); // The data returned is already preformated
//         } else {
//             $(thread).html(data.data);
//         }
//     }
//
//     function renderPost(event, data)
//     {
//
//     }
//
//     // Enable comments on posts
//     $(document).on('click', '[data-action="comment"], [data-action="reply"]', function (e) {
//         e.preventDefault();
//
//         let thisRoot = $(this).parents('.i__post'),
// //            thisBackTrace = $(this).parentsUntil('._aQtRd7eh').last(),
//             thisData = $(this).find('.data').attr('data'),
//             recipients,
//             thisEditor = $(thisRoot).find('.comment-editor');
//
//         if ($(this).is('[data-action="reply"]')) {
//             thisEditor.attr('data-post-type', 'reply');
//         } else {
//             thisEditor.attr('data-post-type', 'comment');
//         }
//
//
// //        if ($(this).is('._n2Cuoj')) {
// //            thisData = $(thisBackTrace).find('.data').first().text();
// //        } else {
// //            thisData = $(thisBackTrace).find('.data').text();
// //        }
// //
//         if (typeof thisData === 'string' && thisData.length > 0) {
//             thisData = $.parseJSON(thisData);
//         }
//         if (thisData.replyingto !== 'undefined') {
//             recipients = thisData.replyingto;
//         }
//         if (typeof recipients !== 'undefined') {
//             let linkifiedRecipients = recipients.split(',');
//             linkifiedRecipients = $.makeArray(linkifiedRecipients);
//             linkifiedRecipients = $.map(linkifiedRecipients, function (item) {
//                 let username = item;
//                 if (username.charAt(0) === '@') {
//                     username = username.substr(1);
//                 }
//                 if (item.charAt(0) !== '@') {
//                     item = '@' + item;
//                 }
//                 return '<span class="_JF4usO"><a href="/' + username
//                     + '" class="_w5w _zeN4uW" role="link">' + item + '</a></span>';
//             });
//
//             linkifiedRecipients = '<span class="_vVza _wdjO _mo4J3"></span>' + linkifiedRecipients.join("\n");
//             linkifiedRecipients += '&nbsp;';
//             $(thisEditor).html(linkifiedRecipients).trigger('editor.hasValue');
//         }
//         $(thisEditor).parents('.composer').attr({
//             "data-uri": thisData.uri,
//             "data-replyto": thisData.id,
//             "data-cc": thisData.replyingto
//         });
//
//         let commentContainer = $(this).attr('aria-controls');
//         if (typeof commentContainer !== 'undefined') {
//             $(commentContainer).slideToggle('fast');
//         }
//         $(thisEditor).trigger('focus');
//
//         return false;
//     });
//
//     /**
//      * Enable Post View via iframe in modal dialog
//      */
//     // When a post section is clicked without targeting any element on
//     // it, such as media, read more, call-to-action btns
//     $(document).on('click', '.i__post', function (e) {
//         if (!$(this).is('.viewable')) {
//             return false;
//         }
//
//         if (!$(this).children().first().is('[aria-haspopup="true"]')) {
//             return false;
//         }
//         let theElem = e.target,
//             uri;
//
//         if ($(theElem).is('.media, img, video, audio, .btn, a, a *, .btn *, [role="button"],[role="textbox"], .comment-area, .comment-area *, .avatar')) {
//             return;
//         }
//         if ($(theElem).is('.i__post')) {
//             uri = $(theElem).children().last().data('uri');
//         } else if ($(theElem).data('uri')) {
//             uri = $(theElem).data('uri');
//         } else {
//             uri = $(theElem).parentsUntil('.i__post').last().data('uri');
//         }
//         uri += '?ref=container';
//
//         // let prospect = $('<div class="z_24fwo _ycGkU4 _Axdy _3og d-flex .justify-content-center' +
//         //     ' align-items-center"></div>');
//         let loading = spinner('postLoading', {text: 'Loading post. Please wait...', class: 'align-items-center' +
//                 ' content-loading' +
//                 ' d-flex' +
//                 ' justify-content-center pb-5'});
//
//         let prospect = $('<div class="_NGavIJ dhc99t d-flex justify-content-center' +
//             ' align-items-center"></div>');
//         prospect.html(loading);
//         $(prospect).find('.spinner').toggleClass('text-primary text-white');
//         $(prospect).find('.spinner-text').toggleClass('text-muted text-white');
//
//         var basicModal = $('#basicModal');
//         $(basicModal).modal('show');
//
//         let frame = $('<iframe class="_oB post-reader w-100 _a5kW87"></iframe>');
//         $(basicModal).find('.modal-dialog').addClass('w_fMGsRw');
//         $(frame).hide().attr({'id': 'postReader', 'src': uri});
//         $(basicModal).find('.modal-body').html(loading);
//         let viewHeight = $(window).innerHeight();
//         $(frame).css({height: viewHeight});
//         $(basicModal).find('.modal-body').append(frame);
//         $('#postReader').on('load', function () {
//             $('#postLoading').remove();
//             $(frame).show();
//         });
//     });
    // $('.modal').on('hidden.bs.modal', function () {
    //     $(this).removeClass('_px0xiN');
    // });

    $(document).on('click', '.nav-tabs .nav-link', function () {
        let $this = $(this),
            sibs = $this.closest('li').siblings().children('.nav-link');
        sibs.map(function (item) {
            sibs.eq(item).removeClass('active');
        });

        $this.addClass('active');
    });

    /**
     * Containers that should automatically resize with the window
     */
    $(window).on('resize', function (e) {
        $('._a5kW87').css({height: $(window).innerHeight()});
        $('._dcu9P3').css({width: $(window).innerWidth()});
    });

    /**
     * Asynchronous Page loader
     */
    // APP.ajaxLoader.ajaxify('._Hc0qB9');
    // APP.ajaxLoader.ajaxify('.ajaxify');
    const ajaxifiables = $('.ajaxify');
    ajaxifiables.map(function (index, theElem) {
        try {
            APP.ajaxLoader.ajaxify(theElem);
        } catch (e) {
            return false;
        }
    });

    /**
     * Profile page load with ajax
     */
//    $(document).on('click', '._gH7Jzt a', function (e) {
//        e.preventDefault();
//
//        let tabs = $('._gH7Jzt a');
//        tabs.removeClass('active');
//        $(this).addClass('active');
//        let output = '#pageContent',
//            loading = spinner('page-loading'),
//            href = $(this).attr('href'),
//            linkText = $(this).text(),
//            currentTitle = document.title,
//            brand = currentTitle.split('-').pop(),
//            newTitle = linkText + ' - ' + brand;
//        document.title = newTitle;
//        window.history.replaceState(null, null, href);
//
//        if ($(output).find('.backdrop').length < 1) {
//            $(output).prepend('<div class="backdrop d-flex justify-content-center align-items-center"></div>');
//        }
//        if ($(output).find('.page-loading').length < 1) {
//            $('.backdrop').html(loading);
//        }
//
//        doAjax(href, function (result, status) {
//            if (status === 'success') {
//                $('.page-title').html(linkText);
////                result = $('<div class="col-12"></div>').html(result);
//                $(output).html(result);
//                $(document).trigger('page:content:arrival');
//            }
//        }, {type: 'GET', dataType: 'html'});
//    });


    /**
     * This section controls password field input masking/unmasking
     */
    let pToggle = $('[data-toggle="password-visibility"]');
    let $field = $(pToggle.data('target'));
    pToggle.each(function () {
        let $this = $(this);
//        var input = $this.siblings('input[aria-revealable="true"]') || $this.parent().siblings('input[aria-revealable="true"]');
        if ($field.val().length > 0)
            $this.prop('disabled', false);
        else
            $this.prop('disabled', true);

        $field.on('input', function() {
            if ($field.val().length > 0)
                $this.prop('disabled', false);
            else
                $this.prop('disabled', true);
        });

        $this.click(function() {
            var icn = $(this).children('i, span');
            if ($field.attr('type') === 'password') {
                $field.attr('type', 'text');
//                $(icn).removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
            } else {
                $field.attr('type', 'password');
//                $(icn).removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
            }
            $(icn).toggleClass('mdi-eye-off-outline mdi-eye-outline');
        });
    });


    /**
     * Ajax Simulation Script
     * Simulate ajax effect using iframe
     */
    $('.ajaxSimulator').on('load', function () {
        var frame = $(this);
        var r = frame.contents().text();
        var rObj = {};
        if (r.length > 0) {
            rObj = $.parseJSON(r);
        }
        if (rObj.hasOwnProperty('event')) {
            window.triggerEvent('ajaxSimulator.afterload.' + rObj.event + '.complete', document, {
                desc: rObj.eventDesc,
                time: $.now(),
                responseData: rObj
            });
        }
    });

    /**
     * Enable Popover
     */
    $("[data-toggle=popover]").popover();
    enableDisplayToggle();

    /**
     * Aspect Ratio Hack
     */
    let Sq = $.find('.bxSqr');
    let ptr8 = $.find('.bxht2XW');
    let w = $(Sq).outerWidth();
    $(Sq).css({'height': w});
    $(ptr8).css({'height' : ($(ptr8).outerWidth() * 1.1)});

    /**
     *
     *
     */
    $(document).on('click', '.i__p-committer', function (e) {
        let target = $(e.target);
        let $committer;
        if ($(target).parent().hasClass('i__p-committer')) {
            $committer = $($(target).parent());
        } else {
            $committer = $(target);
        }
        let counter = $committer.next(),
            commit = $committer.data('commit'),
            intent = $committer.data('intent'),
            data = 'data=' + $committer.attr('data'),
            url = ([baseUri, COMMIT_HOOK, commit, intent]).join('/'),
            btnTxt = $committer.find('span.btn-text'),
            isDismissable = $committer.attr('aria-dismissable'),
            formData = $('#xhrs-blank-form').serialize();

        data += '&' + formData;

        doAjax(url, function (result, status) {
            if (result.hasOwnProperty('status')) {

                switch (result.intent) {
                    case 'request_cancellation':
                        if (result.status === 'success') {
                            $committer.attr('aria-committed', 'false');
                            $(btnTxt).text($(btnTxt).data('alt-text'));
                        } else if (result.status === 'error') {
                            // Set an error alert as required
                        }
                        break;
                    case 'initialization':
                        if (result.status === 'success') {
                            $committer.attr('aria-committed', 'true');
                            $(btnTxt).text($(btnTxt).data('alt-text'));
                            setTimeout(function () {
                                if (isDismissable === 'true') {
                                    $committer.parents('[aria-dismissable="true"]').remove();
                                }
                            });
                        } else if (result.status === 'error') {
                            // Set an error alert as required
                        }
                        break;
                    case 'reaction':
                        if (result.status === 'success') {
                            console.log(result.count);
                            $committer.attr('aria-state', 'committed');
                            if (counter.length < 1) {
                                counter = $('<span class="counter reaction-counter"></span>');
                                $(counter).insertAfter($committer);
                            }
                            $(counter).text(result.count);
                        } else if (result.status === 'error') {
                            // Set an error alert as required
                        }
                        break;
                    case 'unreaction':
                        if (result.status === 'success') {
                            console.log(result.count);
                            $committer.attr('aria-state', 'uncommitted');
                            // if (counter.length < 1) {
                            //     counter = $('<span class="counter reaction-counter bdrs-r-15 border border-left-0"></span>');
                            //     $(counter).insertAfter($committer);
                            // }
                            if (result.count === 0) {
                                $(counter).remove();
                            } else {
                                $(counter).text(result.count);
                            }

                        } else if (result.status === 'error') {
                            // Set an error alert as required
                        }
                    default:

                        break;
                }
            }
        }, {type: 'POST', dataType: 'json', data: data});
    });

    $(document).on('click', '.i__p-cloner', function (e) {
        let target = $(e.target);
        let $cloner;
        if ($(target).parent().hasClass('i__p-cloner')) {
            $cloner = $(target).parent();
        } else {
            $cloner = $(target);
        }

        let dataID = $cloner.data('id');
        let cloneAs = $cloner.data('clone-as');
        let url = ([baseUri, COMMIT_HOOK, 'cloner']).join('/');
        let fd = $('#xhrs-blank-form').serialize();
        let data = fd + '&id=' + dataID + '&as=' + cloneAs;

        doAjax(url, function (result, status) {
            if (result.hasOwnProperty('status')) {
                switch (result.status) {
                    case 'success':

                        break;
                    case 'error':

                        break;
                    default:

                }
            }
        }, {dataType: 'html', data: data, type: 'POST'});
    });


    /**
     * Notifications Handler
     */
    var edbTabs = $('.edb_tab');
    edbTabs.each(function () {
        var a = $(this).children('a');

        a.on('click', function () {
            var dataSource = $(this).attr('data-source');
            var dType = $(this).attr('data-type');
            var drpdwn = $(this).next('.e-dropmenu');
            var dList = drpdwn.find('.edb_data-list');
            var loader = '<div class="data-preloader py-3 text-center"><span class="d-inline-block lo loader e_notif-loader box-square-2"></span></div>';
            var noDataMsg = '<div class="p-3 text-center">...Nothing to show</div>';
            var failedMsg = '<div class="p-3 text-center">Oops! Could not retrieve ' + dType + '. Please try reloading the page.</div>';
            var noConnectionMsg = '<div class="p-3 text-center alert alert-danger rounded-0">Oops! Connection lost. Please connect to the internet and try again...</div>';
            dList.append(loader);

            // Check if the user is connected to the internet
            if (!navigator.onLine) {
                //                dList.html(noConnectionMsg);
                //                return;
            }

            $.ajax({
                type: "GET",
                url: dataSource,
                success: function (data, status) {
                    if (status === 'success') {
                        if (data.length <= 0) {
                            dList.html(noDataMsg);
                        } else {
                            dList.html(data);
                        }
                    }
                },
                error: function (data, status, xhr) {
                    dList.html(failedMsg);
                }
            });
        });
    });

    /**
     * Events that should be fired when the page scrollable container is scrolled
     */
    // $('#pageContent').on('scroll', function() {
    //     let creatorBtn = document.querySelector('#creatorBtn');
    //     scrollSpy(this, {
    //         onScrollUp: function () {
    //             console.log('Scroll Up...');
    //             $(creatorBtn).animate({right: '-3rem'}, {
    //                 duration: 200,
    //                 easing: 'linear',
    //                 complete: function () {
    //                     $(creatorBtn).css({display: 'none'});
    //                 }
    //             });
    //         },
    //         onScrollDown: function () {
    //             console.log('Scroll Down...');
    //             $(creatorBtn).animate({right: '1rem'}, {
    //                 duration: 100,
    //                 easing: 'linear',
    //                 complete: function () {
    //                     $(creatorBtn).css({display: 'block'});
    //                 }
    //             });
    //         }
    //     });
    // });

    const MAIN = document.querySelector('#pageContent'),
        creatorBtn = document.querySelector('#creatorBtn');

    let pageOffset = 0,
        scrollDir;

    MAIN.addEventListener('scroll', function (e) {
        const APP_HEADER = document.querySelector('.app-header'),
            PAGE_HEADER = this.querySelector('.page-header');
        e.preventDefault();
        let displacement = MAIN.scrollTop;

        if (displacement > pageOffset) {
            scrollDir = 'up';
        } else {
            scrollDir = 'down';
        }
        if (scrollDir === 'up') {
            // $(creatorBtn).animate({right: '-3rem'}, {
            //     duration: 0,
            //     easing: 'linear',
            //     complete: function () {
            //         $(creatorBtn).css({display: 'none'});
            //     }
            // });
            $(creatorBtn).css({right: '-5rem'});
            PAGE_HEADER.classList.remove('toolbar-fixed');
        } else if (scrollDir === 'down') {
            // $(creatorBtn).css({ display: 'block', right: '1rem'});
            $(creatorBtn).css({right: '1rem'});
            // $(creatorBtn).animate({right: '1rem'}, {
            //     duration: 200,
            //     easing: 'linear',
            //     // complete: function () {
            //     //
            //     // }
            // });
            PAGE_HEADER.classList.add('toolbar-fixed');
            if (displacement === 0) {
                PAGE_HEADER.classList.remove('toolbar-fixed');
            }
        }

        pageOffset = displacement;
    });

    $(document).scroll('.page', function (e) {
        console.log(e);
    });

    /**
     *
     */
    // $('.toggler').on('click', function (e) {
    //     let theElem = $(this),
    //         what = theElem.data('toggle');
    //     switch (what) {
    //         case 'class':
    //             let target = theElem.data('target'),
    //                 className = theElem.data('classname');
    //             $(target).toggleClass(className);
    //             break;
    //
    //         default:
    //
    //             break;
    //     }
    // });

    // Selectizer

    //Incremental Coutner
    if ($.isFunction($.fn.incrementalCounter))
        $("#incremental-counter").incrementalCounter();

    //For Trigering CSS3 Animations on Scrolling
    if ($.isFunction($.fn.appear))
        $(".slideDown, .slideUp").appear();

    $(".slideDown, .slideUp").on('appear', function(event, $all_appeared_elements) {
        $($all_appeared_elements).addClass('appear');
    });

    //For Header Appearing in Homepage on Scrolling
    var lazy = $('#header.lazy-load');

    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 200) {
            lazy.addClass('visible');
        } else {
            lazy.removeClass('visible');
        }
    });

    //Initiate Scroll Styling
    if ($.isFunction($.fn.scrollbar))
        $('.scrollbar-wrapper').scrollbar();

    if ($.isFunction($.fn.masonry)) {

        // fix masonry layout for chrome due to video elements were loaded after masonry layout population
        // we are refreshing masonry layout after all video metadata are fetched.
        var vElem = $('.img-wrapper video');
        var videoCount = vElem.length;
        var vLoaded = 0;

        vElem.each(function(index, elem) {

            //console.log(elem, elem.readyState);

            if (elem.readyState) {
                vLoaded++;

                if (count == vLoaded) {
                    $('.js-masonry').masonry('layout');
                }

                return;
            }

            $(elem).on('loadedmetadata', function() {
                vLoaded++;
                //console.log('vLoaded',vLoaded, this);
                if (videoCount == vLoaded) {
                    $('.js-masonry').masonry('layout');
                }
            })
        });


        // fix masonry layout for chrome due to image elements were loaded after masonry layout population
        // we are refreshing masonry layout after all images are fetched.
        var $mElement = $('.img-wrapper img');
        var count = $mElement.length;
        var loaded = 0;

        $mElement.each(function(index, elem) {

            if (elem.complete) {
                loaded++;

                if (count == loaded) {
                    $('.js-masonry').masonry('layout');
                }

                return;
            }

            $(elem).on('load', function() {
                loaded++;
                if (count == loaded) {
                    $('.js-masonry').masonry('layout');
                }
            })
        });

    } // end of `if masonry` checking


    //Fire Scroll and Resize Events
    $(window).trigger('scroll');
    $(window).trigger('resize');



    /** Selectize Form controls **/
    // $('.input-tags').selectize({
    //     delimiter: ',',
    //     persist: false,
    //     create: function (input) {
    //         return {
    //             value: input,
    //             text: input
    //         }
    //     }
    // });

    $('#select-beast').selectize({});

    $('#select-users').selectize({
        render: {
            option: function (data, escape) {
                return '<div>' +
                    '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                    '<span class="title">' + escape(data.text) + '</span>' +
                    '</div>';
            },
            item: function (data, escape) {
                return '<div>' +
                    '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                    escape(data.text) +
                    '</div>';
            }
        }
    });

    $('#select-countries').selectize({
        render: {
            option: function (data, escape) {
                return '<div>' +
                    '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                    '<span class="title">' + escape(data.text) + '</span>' +
                    '</div>';
            },
            item: function (data, escape) {
                return '<div>' +
                    '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                    escape(data.text) +
                    '</div>';
            }
        }
    });

});

// Navigation bootstrap
$(document).on('click', '#cw-app_consumer-interface:not(.off-canvas-collapsed) [vibely-id="v4fU0H5"]', function (e) {
    e.preventDefault();
    let theElem = $(this),
        out = $(theElem.attr('data-target') || '#page-content-wrapper');
    if (window.location.hostname !== 'localhost' && !navigator.onLine) {
        if (out.find('.alert:not(.notice)').length < 1) {
            out.html('<div class="alert alert-danger">Oops! It seems you\'re offline</div>');
        }
        return false;
    }
    if (theElem.data('loading') === true) {
        out.html(spinner());
    }

    let url = theElem.attr('href');
    if (theElem.data('type') !== 'fragment') {
        let currentUrl = document.documentURI,
            currentTitle = document.title;
        window.history.pushState(null, currentTitle, currentUrl);
        document.title = currentTitle;
        window.history.replaceState(null, $(this).text(), url);
    }

    doAjax(url, function (data, status) {
        let result;
        if (status === 'success') {
            result = data;
        } else {
            result = "<p>Oops! We're experiencing troubles loading this page. Please try reloading it.</p>";
            result += '<a href="' + url + '" class="btn btn-primary btn-sm" ' +
                'vibely-id="v4fU0H5" \n' +
                '       data-target=\'' + theElem.data('target') + '\' data-url="' +
                url+ '" data-loading="' + theElem.data('loading')+ '" data-type="' +
                (theElem.data('type') || 'full') + '">Reload</a>';
            result = $(result).wrap('<div class="text-center"></div>');
        }
        let pageTitle = $('.app-container > .page-header .page-title');
        if (pageTitle.length > 0) {
            pageTitle.text(theElem.text());
        }
        const pageBehaviour = theElem.data('behaviour') || 'content';
        $('body').attr('cw-page-behaviour', pageBehaviour);
        out.html(result);
        window.triggerEvent(
            'page:content:arrival',
            document,
            {
                desc: "",
                time: $.now(),
                responseData: result,
                output: out
            }
        );
    })
});

(function ($) {
    $(document).on('click', "[data-processor='vibely']", function (e) {
        e.preventDefault();
        console.log(this);
        return;
        var obj = $(this);
        var data = obj.attr('vibely-data');
        Vibely.process(data, e);
    });

    $(document).on('click', '.backdrop, .drawer-load-failed', function (e) {
        APP.backdrop.hide();
        if ($('body').hasClass('drawer-open')) {
            APP.drawer.closeAll();
        }
    });

    $(document).on('click', '[data-toggle="drawer"],[data-toggle="page"]', function (e) {
        e.preventDefault();
        if ($(this).data('toggle') === 'drawer') {
            APP.drawer.toggleDrawer(this);
        } else {
            APP.drawer.togglePage(this);
        }
    });
    $(document).on('click', '.close-page', function (e) {
        e.preventDefault();
        window.history.back() || window.location.assign(window.getBaseUri());
    });
    $(document).on('click', '[data-action="retry"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            url = $this.attr('href'),
            t = $this.parents().eq(1),
            $clone = $this.parent().clone(),
            loading = spinner();
        if (!(url||t)) {
            return false;
        }
        $(t).html(loading);

        doAjax(url, function (result, status) {
            if (status === 'success' && result.length > 0) {
                $(t).html(result);
            } else {
                $(t).html($clone);
            }
        });
    });
})(jQuery);
$(document).on('page:content:arrival', function (e) {
    if (e.detail.responseData.indexOf('_Hc0qB9') || e.detail.responseData.indexOf('ajaxify')) {
        const ajaxifiables = e.detail.output.find('._Hc0qB9, .ajaxify');
        // console.log(ajaxifiables);
        ajaxifiables.map(function (index, item) {
            APP.ajaxLoader.ajaxify(item);
        });

    }
});

/**
 * Login form asynchronous handler
 */
$(document).on('submit', 'form.login-form', function (e) {
    e.preventDefault();
    APP.form.processing();

    let form = $(this),
        data = form.serializeArray(),
        formAction = form.attr('action'),
        feedback = $('.form-feedback');

    const loginHandler = function (result, status, xhr) {
        let msg, next;
        if (status === 'success' && result.status === 'success') {
            msg = result.message ? result.message : 'Login successful...';
            next = result.redirect ? result.redirect : getBaseUri() + '/feeds';
            if (next.indexOf('http') > 0) {
                next = next.ltrim('/');
            }
            APP.form.successful(msg);
            setTimeout(function () {
                window.location.assign(next);
            }, 1000);
        } else if (status === 'error') {
            msg = result.message ?? 'Login failed!';
            APP.form.failed(msg);
            setTimeout(function () {
                APP.form.hideProcessor();
            }, 1000);
        }
    };

    $.post({
        url: formAction,
        data: data,
        dataType: 'json',
        headers: {
            'X-CSRF-Token': APP.getCsrfToken()
        },
        success: loginHandler,
        error: loginHandler,
    });
});

$(document).on('click', '[data-action="remove-object"]', function (e) {
    const TARGET = $(this).attr('aria-controls');
    let $taget = $(this).closest(TARGET);
    $taget.remove();
    e.preventDefault();
    return false;
});

// $(document).on('drawer:loaded', function (e) {
//     let thisDrawer = document.querySelector(e.detail.drawer),
//         ajaxifiables = thisDrawer.querySelector('._Hc0qB9');
//     if (ajaxifiables) {
//         APP.ajaxLoader.ajaxify(ajaxifiables);
//     }
// });

/**
 *
 * Post Editor
 */
/**
 *
 * @param {string} form
 * @returns {Boolean}
 */
//function postEditor(form)
//{
//    var f = $(form);
//    if (f.length < 1) return false;
//    var manifest = f.find('[data-role="manifest"]').data('manifest');
//    // The result of the above code is an object containing information about
//    // how to control the form. No need for $.parseJSON()
//
//    var editor = f.find('#editor').val();
//    var ta = f.find('#textarea').val();
//    var btn = f.find('button[type="submit"]');
//    var ct = f.find('#content-type');
//    var draftFeedback = f.find('#draftFeedback').val();
//
//    if (btn.length < 1) {
//        btn = manifest.sendBtn;
//    }
//    if (btn.length < 1) {
//        throw new Error('No submit button found for form: ' + form);
//        return false;
//    }
//
//    // Check if there is an unfinished draft data for this form and
//    // restore it
//    var draft = $.cookie('Drafts_' + $(ct).val());
//    if (typeof draft !== 'undefined' && draft.length > 0 && $(editor).text().length < 1) {
//        $(editor).html(draft);
//        $(ta).html(draft);
//    }
//
//    if ($(editor).text().length > 0) {
//        btn.removeAttr('disabled').removeClass('disabled');
//    } else {
//        btn.attr('disabled', 'disabled').addClass('disabled');
//    }
//
//    // Prefill the hidden textarea with the content of the text $(editor)
//    $(ta).html($(editor).html());
//    var lastInputTime;
//    var draftDelay = 3000; // 3 seconds
//
//    $(editor).on({
//        input: function () {
//            $(ta).html($(this).html()); // Update the underlying textarea
//            if ($(editor).text().length > 0) {
//                btn.removeAttr('disabled').removeClass('disabled');
//            } else {
//                btn.attr('disabled', 'disabled').addClass('disabled');
//            }
//
//            lastInputTime = $.now();
//
//            window.setTimeout(function() {
//                window.triggerEvent('Editor.input.stopped', document, {desc: 'Editor input stop event', time: $.now()});
//            }, draftDelay);
//        }
//    });
//
//    // Check whether the use stopped typing and save draft
//    window.addEventListener('Editor.input.stopped', () => {
//        // Each time the user stops typing for at least 3 seconds, this
//        // code should check if the input box has a value, and
//        // automatically saves it as draft, in case the user, for
//        // some reason, is unable to continue at the moment.
//        var now = $.now();
//        if ((now - lastInputTime) < draftDelay) {
//            return false;
//        }
//
//        var text = $(editor).text();
//        var html = $(editor).html();
//        if (text.length < 1)
//            return false;
//
//        if (navigator.onLine) { // Save the draft with cakephp response cookie
//            var draftUrl = f.find('#draft').val();
//            var data = $(editor).html();
//            $.ajax({
//                type: "POST",
//                url: draftUrl,
//                data: data,
//                success: function(data, status) {
//                    if (status === 'success' && data.length > 0) {
//                        $(draftFeedback).fadeIn(1000).html(data).fadeOut(10000);
//                    }
//                },
//                error: function(data, status, xhr) {
//                    var msg = 'Sorry an error occured while trying to save your draft...';
//                    $(draftFeedback).fadeIn(1000).html(msg).fadeOut(10000);
//                },
//                dataType: 'json'
//            });
//        } else { // Store the draft in JavaScript's cookie
//            if ($.cookie('Drafts_' + $(ct).val(), html, {path: '/'})) {
//                $(draftFeedback).fadeIn(1000).html('Draft Saved').fadeOut(10000);
//            }
//        }
//    });
//
//    document.addEventListener('ajaxSimulator.afterload.' + $(ct).val() + '.complete',
//    () => {
//        if ($.cookie('Drafts_' + $(ct).val())) {
//            $.cookie('Drafts_' + $(ct).val(), null, {path: '/'});
//            $(editor).html('');
//            $(ta).html();
//        }
//    });
//}


//var UserActivities = {
//    actor: null,
//    requestHandler: '/xhrs',
//    autoRender: false,
//    getActivities: function (contentTypes = [])
//    {
//        if (typeof contentTypes !== 'object') {
//            throw new TypeError('Parameter 1 passed to EUser.getActivities() is ...');
//            return false;
//        } else {
//            var obj = this;
//            contentTypes.forEach(function (item) {
//                obj.fetchUserContents(item);
//            });
//        }
//    },
//    loadData: function (elem, callback)
//    {
////        let d = $.parseJSON($(elem).attr('data'));
////        let actor = $.parseJSON(unescape($('body').data('intertainer')));
//
////        let winLoc = window.location.href;
////        let uriQs = winLoc.split('?').pop();
////        var srcSplit, path, qs;
////        if (d.source.indexOf('?') > -1) {
////            srcSplit = d.source.split('?');
////            path = srcSplit[0];
////        }
////        if (typeof srcSplit === 'object' && srcSplit.length > 1)
////            qs = '?' + qs + '&';
////        else
////            qs = '?';
////        if (typeof path === 'undefined')
////            path = d.source;
////
////        let url = this.requestHandler + path.slice(1) + qs + 'iuid=' + actor.iuid;
//        let s = $(elem).attr('datasrc');
//        let t = $(elem).data('target');
//        let url = this.requestHandler + s;
////        if (uriQs !== '')
////            url += '&' +  uriQs;
//
//        doAjax(url, function (result, status) {
//           if (result.length > 0)
//               $(t).html(result);
//        }, {type: 'GET', dataType: 'html'});
//    },
//    fetchUserContents: function (ct)
//    {
//        var url = this.requestHandler + ct.hyphenize() + '/?uid=' + actor.id;
//        url += '&cached=false&token=' + $.now();
//        this.requestData(url, function () {
//
//        });
//        return true;
//    },
//
//
//};

//jQuery(document).ready(function () {
//    const ua = UserActivities;
//    const mtd = META_DATA;
//    const CRON_HOOK = 'xhrs';
//    const COMMIT_HOOK = 'commit';
//    let baseUri = mtd ? String(mtd.baseUri) : '/';
//    if (baseUri.endsWith('/'))
//        baseUri = baseUri.substring(0, baseUri.length - 1);
//
//    window.setTimeout(function () {
//        $('.i--c').each(function () {
//            let $this = $(this);
//            let url = baseUri + '/' + CRON_HOOK + $this.attr('datasrc');
//            doAjax(url, function (result, status) {
//                $($this.data('target')).html(result);
//            }, {type: 'GET', dataType: 'html'});
//        });
//
//        let iw = $('i-widgets');
//        let d;
//        try {
//            d = $.parseJSON(iw.attr('data'));
//        } catch (e) {
//            return false;
//        }
//        d.forEach(function (w) {
//            let url = baseUri + '/' + CRON_HOOK + '/' + w;
//            doAjax(url, function (result, status, xhr) {
//                if (status !== 'success') {
//                    return;
//                }
//                let o = iw.parent();
//                if (result.length > 0) {
//                    $(o).prepend(result);
//                }
//            }, {type: 'GET', dataType: 'html'});
//        });
//
//    }, 1000);

//    window.setInterval(function () {
//        $('.i--c[live-task="refresh"]').each(function () {
//            let $this = $(this);
//            let url = mtd.baseUri + CRON_HOOK + $this.attr('datasrc');
//            doAjax(url, function (result, status) {
//                if (result.length > 0)
//                    $($this.data('target')).html(result);
//            }, {type: 'GET', dataType: 'html'});
//        });
//
//
//        $('.i--c[live-task="check_for_updates"]').each(function () {
//            let $this = $(this);
//            doAjax(mtd.baseUri + CRON_HOOK + $this.attr('datasrc'), function (result, status) {
//                if (result.length > 0)
//                    $($this.data('new-items')).html(result);
//            }, {type: 'GET', dataType: 'html'});
//        });
//    }, 10000);


//    $('.layout-toggle').each(function () {
//        let $this = $(this);
//        $this.click(function (e) {
////            e.preventDefault();
//            let href = $this.attr('href');
//            window.history.replaceState('back', null, href);
//
//            let targetId = $this.data('target'); // #id
//            let targetEl = $(targetId);
//
//            if ($(targetEl).find('.e_overlay').length > 0)
//                $('.e_overlay').show();
//            else
//                $(targetEl).append('<div class="align-items-center d-flex e_overlay fit-container justify-content-center"><div class="border-white loading spinner-border"></div></div>');
//            let loader = $(targetEl).find('.e_overlay');
//
//            let url = 'xhrs/fetch/timeline/?' + href.split('?').pop() + '&iuid=' + actor.id;
////            doAjax(url, function (data) {
////                $(targetEl).html(data);
////                $(loader).remove();
////            });
//            doAjax(url, function (result, status) {
//                if (result.length > 0) {
//                    $(targetEl).html(result);
//                    $(loader).remove();
//                }
//
//            }, {type: 'GET', dataType: 'html'});
//        });
//    });


////Preloader
//var preloader = $('#spinner-wrapper');
//$(window).on('load', function() {
//    var preloaderFadeOutTime = 500;
//
//    function hidePreloader() {
//        preloader.fadeOut(preloaderFadeOutTime);
//    }
//    hidePreloader();
//});



// Disable Sticky Feature in Mobile
$(window).on("resize", function() {

    if ($.isFunction($.fn.stick_in_parent)) {
        // Check if Screen wWdth is Less Than or Equal to 992px, Disable Sticky Feature
        if ($(this).width() <= 992) {
            $('#chat-block').trigger('sticky_kit:detach');
            $('#sticky-sidebar').trigger('sticky_kit:detach');

            return;
        } else {

            // Enabling Sticky Feature for Width Greater than 992px
            attachSticky();
        }

        // Firing Sticky Recalculate on Screen Resize
        return function(e) {
            return $(document.body).trigger("sticky_kit:recalc");
        };
    }
});


window.tabler = {
    colors: {
        'blue': '#467fcf',
        'blue-darkest': '#0e1929',
        'blue-darker': '#1c3353',
        'blue-dark': '#3866a6',
        'blue-light': '#7ea5dd',
        'blue-lighter': '#c8d9f1',
        'blue-lightest': '#edf2fa',
        'azure': '#45aaf2',
        'azure-darkest': '#0e2230',
        'azure-darker': '#1c4461',
        'azure-dark': '#3788c2',
        'azure-light': '#7dc4f6',
        'azure-lighter': '#c7e6fb',
        'azure-lightest': '#ecf7fe',
        'indigo': '#6574cd',
        'indigo-darkest': '#141729',
        'indigo-darker': '#282e52',
        'indigo-dark': '#515da4',
        'indigo-light': '#939edc',
        'indigo-lighter': '#d1d5f0',
        'indigo-lightest': '#f0f1fa',
        'purple': '#a55eea',
        'purple-darkest': '#21132f',
        'purple-darker': '#42265e',
        'purple-dark': '#844bbb',
        'purple-light': '#c08ef0',
        'purple-lighter': '#e4cff9',
        'purple-lightest': '#f6effd',
        'pink': '#f66d9b',
        'pink-darkest': '#31161f',
        'pink-darker': '#622c3e',
        'pink-dark': '#c5577c',
        'pink-light': '#f999b9',
        'pink-lighter': '#fcd3e1',
        'pink-lightest': '#fef0f5',
        'red': '#e74c3c',
        'red-darkest': '#2e0f0c',
        'red-darker': '#5c1e18',
        'red-dark': '#b93d30',
        'red-light': '#ee8277',
        'red-lighter': '#f8c9c5',
        'red-lightest': '#fdedec',
        'orange': '#fd9644',
        'orange-darkest': '#331e0e',
        'orange-darker': '#653c1b',
        'orange-dark': '#ca7836',
        'orange-light': '#feb67c',
        'orange-lighter': '#fee0c7',
        'orange-lightest': '#fff5ec',
        'yellow': '#f1c40f',
        'yellow-darkest': '#302703',
        'yellow-darker': '#604e06',
        'yellow-dark': '#c19d0c',
        'yellow-light': '#f5d657',
        'yellow-lighter': '#fbedb7',
        'yellow-lightest': '#fef9e7',
        'lime': '#7bd235',
        'lime-darkest': '#192a0b',
        'lime-darker': '#315415',
        'lime-dark': '#62a82a',
        'lime-light': '#a3e072',
        'lime-lighter': '#d7f2c2',
        'lime-lightest': '#f2fbeb',
        'green': '#5eba00',
        'green-darkest': '#132500',
        'green-darker': '#264a00',
        'green-dark': '#4b9500',
        'green-light': '#8ecf4d',
        'green-lighter': '#cfeab3',
        'green-lightest': '#eff8e6',
        'teal': '#2bcbba',
        'teal-darkest': '#092925',
        'teal-darker': '#11514a',
        'teal-dark': '#22a295',
        'teal-light': '#6bdbcf',
        'teal-lighter': '#bfefea',
        'teal-lightest': '#eafaf8',
        'cyan': '#17a2b8',
        'cyan-darkest': '#052025',
        'cyan-darker': '#09414a',
        'cyan-dark': '#128293',
        'cyan-light': '#5dbecd',
        'cyan-lighter': '#b9e3ea',
        'cyan-lightest': '#e8f6f8',
        'gray': '#868e96',
        'gray-darkest': '#1b1c1e',
        'gray-darker': '#36393c',
        // 'gray-dark': '#6b7278',
        'gray-light': '#aab0b6',
        'gray-lighter': '#dbdde0',
        'gray-lightest': '#f3f4f5',
        'gray-dark': '#343a40',
        'gray-dark-darkest': '#0a0c0d',
        'gray-dark-darker': '#15171a',
        'gray-dark-dark': '#2a2e33',
        'gray-dark-light': '#717579',
        'gray-dark-lighter': '#c2c4c6',
        'gray-dark-lightest': '#ebebec'
    }
};


let hexToRgba = function(hex, opacity) {
    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    let rgb = result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;

    return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + opacity + ')';
};

/**
 *
 */
jQuery(document).ready(function () {
    /** Constant div card */
    const DIV_CARD = 'div.card';

    /** Initialize tooltips */
    $('[data-toggle="tooltip"]').tooltip();

    /** Initialize popovers */
    $('[data-toggle="popover"]').popover({
        html: true
    });

    /** Function for remove card */
    $('[data-toggle="card-remove"]').on('click', function (e) {
        let $card = $(this).closest(DIV_CARD);

        $card.remove();

        e.preventDefault();
        return false;
    });

    /** Function for collapse card */
    $('[data-toggle="card-collapse"]').on('click', function (e) {
        let $card = $(this).closest(DIV_CARD);

        $card.toggleClass('card-collapsed');

        e.preventDefault();
        return false;
    });

    /** Function for fullscreen card */
    $('[data-toggle="card-fullscreen"]').on('click', function (e) {
        let $card = $(this).closest(DIV_CARD);

        $card.toggleClass('card-fullscreen').removeClass('card-collapsed');

        e.preventDefault();
        return false;
    });

    /**  */
    if ($('[data-sparkline]').length) {
        let generateSparkline = function ($elem, data, params) {
            $elem.sparkline(data, {
                type: $elem.attr('data-sparkline-type'),
                height: '100%',
                barColor: params.color,
                lineColor: params.color,
                fillColor: 'transparent',
                spotColor: params.color,
                spotRadius: 0,
                lineWidth: 2,
                highlightColor: hexToRgba(params.color, .6),
                highlightLineColor: '#666',
                defaultPixelsPerValue: 5
            });
        };

        require(['sparkline'], function () {
            $('[data-sparkline]').each(function () {
                let $chart = $(this);

                generateSparkline($chart, JSON.parse($chart.attr('data-sparkline')), {
                    color: $chart.attr('data-sparkline-color')
                });
            });
        });
    }

    /**  */
    if ($('.chart-circle').length) {
        require(['circle-progress'], function () {
            $('.chart-circle').each(function () {
                let $this = $(this);

                $this.circleProgress({
                    fill: {
                        color: tabler.colors[$this.attr('data-color')] || tabler.colors.blue
                    },
                    size: $this.height(),
                    startAngle: -Math.PI / 4 * 2,
                    emptyFill: '#F4F4F4',
                    lineCap: 'round'
                });
            });
        });
    }

});

/**
 * Media Blob Script
 */
(function(c,b,a,d){c.fn.imageBlob=function(e){this.blob=function(){var n=f(this);if(!n){return null}return g(n)};this.formData=function(p){if(typeof p=="object"){var o=new FormData();for(var n in p){o.append(n,p[n])}h=o}return this};this.ajax=function(p,q){var o=this.blob();if(!o){return null}if(typeof p=="object"){q=p;p=d}q=q||{};var r=c.extend({},c.fn.imageBlob.ajaxSettings,q);var n=i(this);if(typeof h=="undefined"){h=new FormData()}h.append(n,o,n);r.data=h;if(typeof p=="string"){return c.ajax(p,r)}return c.ajax(r)};var h;var j=/data:(image\/[^;]+);base64,(.+)/;var k=/.*\.jpe?g/g;function f(n){if(n.length==0||"IMG"!=(n.prop("tagName"))){return null}return n.get(0)}function i(o){var n=o.attr("name");if(typeof n=="undefined"){n=c.fn.imageBlob.defaultImageName}return n}function g(n){var o=m(n);return l(o[1],o[2])}function m(o){var r=c(o).attr("src");r=r.replace(/\s/g,"");var q=r.match(j);if(q==null){if(typeof e!="string"){if(r.match(k)!=null){e="image/jpeg"}else{e="image/png"}}var p=a.createElement("canvas");var n=p.getContext("2d");p.width=o.width;p.height=o.height;n.drawImage(o,0,0);r=p.toDataURL(e);q=r.match(j)}return q}function l(r,n){var o=atob(n);var q=[];for(var p=0;p<o.length;p++){q.push(o.charCodeAt(p))}return new Blob([new Uint8Array(q)],{type:r})}return this};c.fn.imageBlob.ajaxSettings=c.extend({},c.ajaxSettings,{cache:false,processData:false,contentType:false,type:"POST"});c.fn.imageBlob.defaultImageName="IMG_Upload"})(jQuery,window,document);
