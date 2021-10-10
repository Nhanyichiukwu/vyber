(function ($) {
    
    // Ajax Simulation Script
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
    
    // Trigger a focus event on the post input box after the page is loaded
    $('#e__status-text-input.open-by-default').trigger('focus');
    
    $('.modal').modal('handleUpdate');
    // Trigger a focus event on the post input box once the modal is shown
    $('#e__composerModal').on('shown.bs.modal', function () {
        setTimeout(function () {
            $('#e__status-text-input').trigger('focus');
        }, 1000);
    });
    
    customFormControl('#e__pf');

//    var postInput = $('div[contenteditable="true"]');
//    postInput.each(function () {
//        var editor = $(this);
//        var sb = editor.data('submit');
//        var aTF = editor.next().find('textarea');
//        aTF.html(editor.html());
//        editor.on({
//            'input': function () {
//                if (editor.text().length > 0) {
//                    $(sb).removeAttr('disabled').removeClass('disabled');
//                } else {
//                    $(sb).attr('disabled', 'disabled').addClass('disabled');
//                }
//                aTF.html(editor.html());
//            },
//            'keyup': function (e) {
//                // Each time the user stops typing for at least 2 seconds, this 
//                // code should check if the input box has a value, and 
//                // automatically saves it as draft in case the user, for
//                // some reason, is unable to continue at the moment.
//                window.setTimeout(function() {
//                    if (navigator.onLine) {
//                        var draftUrl = $(this).data('tmp-store');
//                    }
//                }, 3000);
//            }
//        });
//    });
})(jQuery);
function customFormControl(form)
{
    var f = $(form);
    if (f.length < 1) return false;
    var manifest = f.find('[data-role="manifest"]').data('manifest'); 
    // The result of the above code is an object containing information about
    // how to control the form. No need for $.parseJSON()
    
    var editor = f.find(manifest.text.editor);
    var ta = f.find(manifest.text.textarea);
    var btn = f.find('button[type="submit"]');
    
    if (btn.length < 1) {
        btn = manifest.sendBtn;
    }
    if (btn.length < 1) {
        throw new Error('No submit button found for form: ' + form);
        return false;
    }
    
    
    
    // Check if there is an unfinished draft data for this form and 
    // restore it
    var cookie = $.cookie('Drafts_' + manifest.dataType);
    if (typeof cookie !== 'undefined' && cookie.length > 0 && editor.text().length < 1) {
        editor.html(cookie);
        ta.html(cookie);
    }
    
    if (editor.text().length > 0) {
        btn.removeAttr('disabled').removeClass('disabled');
    } else {
        btn.attr('disabled', 'disabled').addClass('disabled');
    }
    
    // Prefill the hidden textarea with the content of the text editor
    ta.html(editor.html());
    var lastInputTime;
    var draftDelay = 3000; // 3 seconds
    
    editor.on({
        'input': function (e) 
        {
            ta.html($(this).html()); // Update the underlying textarea
            if (editor.text().length > 0) {
                btn.removeAttr('disabled').removeClass('disabled');
            } else {
                btn.attr('disabled', 'disabled').addClass('disabled');
            }
            
            lastInputTime = $.now();
            
            window.setTimeout(function() {
                window.triggerEvent('Editor.input.stopped', document, {desc: 'Editor input stop event', time: $.now()});
            }, draftDelay);
        }
    });
    
    // Check whether the use stopped typing and save draft
    window.addEventListener('Editor.input.stopped', () => {
        // Each time the user stops typing for at least 3 seconds, this 
        // code should check if the input box has a value, and 
        // automatically saves it as draft, in case the user, for
        // some reason, is unable to continue at the moment.
        var now = $.now();
        if ((now - lastInputTime) < draftDelay) {
            return false;
        }
        
        var v = editor.text();
        if (v.length < 1)
            return false;

        if (navigator.onLine) { // Save the draft with cakephp response cookie
            var draftUrl = manifest.postTmpStore;
            var data = editor.html();
            $.ajax({
                type: "POST",
                url: draftUrl,
                data: data,
                success: function(data, status) {
                    if (status === 'success' && data.length > 0) {
                        $(manifest.feedbackOutput.draftFeedbackOutput)
                        .fadeIn(1000)
                        .html(data)
                        .fadeOut(10000);
                    }
                },
                error: function(data, status, xhr) {
                    var msg = 'Sorry an error occured while trying to save your draft...';
                    $(manifest.feedbackOutput.draftFeedbackOutput)
                        .fadeIn(1000)
                        .html(msg)
                        .fadeOut(10000);
                },
                dataType: 'json'
            });
        } else { // Store the draft in JavaScript's cookie
            if ($.cookie('Drafts_' + manifest.dataType, v, {path: '/'})) {
                $(manifest.feedbackOutput.draftFeedbackOutput)
                        .fadeIn(1000)
                        .html('Draft Saved')
                        .fadeOut(10000);
            }
        }
    });
    
    document.addEventListener('ajaxSimulator.afterload.' + manifest.dataType + '.complete', 
    () => {
        if ($.cookie('Drafts_' + manifest.dataType)) {
            $.cookie('Drafts_' + manifest.dataType, null, {path: '/'});
            editor.html('');
            ta.html();
        }
    });
}
