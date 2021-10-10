"use strict";
$(document).ready(function () {
    var fileInput = $('input[type="file"][data-allow-preview="true"]');
    $(fileInput).on('change', function (e) {
        var file = this.files[0],
                fileType = file.type.split('/')[0],
                fileExt = file.name.split('.').pop(),
                output = $(this).data('preview-output');

        // Ensure that the selected file matches the acceptedTypes (if specified).
        // if (acceptedTypes.length > 0 && !acceptedTypes.includes(fileExt)) {
        //     throw new TypeError('Invalid file type...' + "\n" + 'Only ' +
        //         acceptedTypes.join(', ') + ' are allowed.');
        // }

        var inputClone = $(e.target).clone(), // Make a copy of the file input for later use
                selectionContainer = document.createElement('div'),
                inputWrap = $.clone(selectionContainer);
        $(inputWrap).addClass('selected-file-control d-none :visually-hidden');
        var fileID = $.now() + '_' + file.name.replaceAll(' ', '-').replaceAll('.','_');
        $(inputClone).attr({
            'id': 'selected-' + fileID,
            'name': 'files[' + fileID + '][file]'
        });
        inputClone = $(inputWrap).html(inputClone);

        $(selectionContainer)
                .attr({'id': fileID, 'data-role': 'file-preview-container'})
                .addClass('col-sm-6 col-md-4 mb-3')
                .html('<div class="file-preview card position-relative bdrs-20">' +
                        '<button type="button" ' +
                        'class="btn btn-icon btn-dark btn-sm pos-a-r px-1 py-0 rounded-pill z-9" ' +
                        'role="file-delete-btn">' +
                        '<i class="mdi mdi-close"></i>' +
                        '</button>' +
                        '<div class="i__uploaded-file-sample position-relative">' +
                        '<div class="pos-a-r pos-a-b m-1">' +
                        '<button type="button" class="btn btn-sm rounded-pill btn-light py-0" ' +
                        ' role="file-info-btn" data-toggle="modal" ' +
                        ' data-target="#uploaded-file-info-modal" data-origin="#' +
                        fileID + '" >' +
                        '<i class="mdi mdi-plus"></i> Add Info</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
        var fileGallery = $(output).find('#selected-files');

        if (fileType === 'image') {
            var reader = new FileReader();
            reader.addEventListener("load", function (e) {
                var image = new Image();
                $(image).attr({'title': file.name, 'src': e.target.result})
                        .addClass('img-fluid card-img bdrs-20');
                $(selectionContainer).append(inputClone);
                $(selectionContainer).find('.i__uploaded-file-sample').prepend(image);
                $(selectionContainer).appendTo(fileGallery);
                window.createEvent('file_loaded', document);
            }, false);
            reader.readAsDataURL(file);
        } else if (['audio', 'video'].includes(fileType)) {
            var url = URL.createObjectURL(file);
            var src;
            switch (fileType) {
                case 'audio' :
                    var audio = document.createElement('audio');
                    src = document.createElement('source');
                    src.src = url;
                    src.type = file.mimeType;
                    audio.controls = true;
                    audio.appendChild(src);
                    break;
                case 'video' :
                    var video = document.createElement('video');
                    src = document.createElement('source');
                    video.src = src.src = url;
                    video.type = file.type;
                    src.type = fileType + '/ogg; codecs=\'theora, vorbis\'';
                    video.controls = true;
                    video.appendChild(src);
                    break;
                default :

            }
        }

        $(document).on('file_loaded', function () {
            $(output)
                    .addClass('loaded')
                    .removeClass('d-none hidden d-n :visually-hidden')
                    .show();
        });

    });

    $(document).on('click', '.btn, button', function (e) {
        var btn = e.target;

        /**
         * Allows a user to remove files they had previously selected
         * ---------------------------------------------------------------------
         */
        if ($(btn).attr('role') === 'file-delete-btn' ||
                $(btn).parent().attr('role') === 'file-delete-btn') {
            var response = confirm('Are you sure you want to remove this file?');
            if (response) {
                $(btn).parents('[data-role="file-preview-container"]').remove();
                return true;
            } else {
                return false;
            }
        }

        /**
         * Open the info editor to allow users add/edit file caption, tag users,
         * and add location to files they want to upload
         * --------------------------------------------------------------------
         */
        if ($(btn).attr('role') === 'file-info-btn') 
        {
            let subject = $(btn).data('origin'); // String ID of the container
            let img = $(subject).find('img').first();
            let target = $(btn).data('target');
            let editor = $(target).find('.file-info-editor');
            let inputFields = $(editor).find('.form-control');

            $(target).find('.selected-file').html($(img).clone());
            $(editor).attr('data-target', subject);
            $(inputFields).each(function () {
                $(this)
                    .attr('name', 'files[' + subject.slice(1) +
                    '][' + $(this).attr('field-role') + ']')
                    .val('');
                    
            });
            $(target).find('button').attr('data-target', subject);
        }


        /**
         * This section defines what happens when the user click the 'Done'
         * button after inputting caption, tags, and/or location.
         * --------------------------------------------------------------------
         */
        if ($(btn).attr('role') === 'info-submit')
        {
            let sourceID = $(btn).data('source'); // Refers to the editor
            let data = $(sourceID).clone().html();

            // Create a new container and transfer the form fields from the editor into it
            let dataWrapper = document.createElement('div');
            $(dataWrapper).addClass('file-info d-none').html(data);

            let targetID = $(btn).data('target'); // The file group ID in the list of selected files
            let dataSample = $(btn).data('sample'); // The sample as shown during the input/edit
            dataSample = $(dataSample).clone();
            $(dataSample).addClass('info-sample').removeAttr('id');
            let sampleTarget = $(targetID).find('.file-preview');

            if ($(targetID).find('.file-info').length > 0) {
                $(targetID).find('.file-info').replaceWith(dataWrapper);
            } else {
                $(targetID).append(dataWrapper);
            }
            if ($(targetID).find('.info-sample').length > 0) {
                $(targetID).find('.info-sample').replaceWith(dataSample);
            } else {
                $(dataSample).insertAfter(sampleTarget);
            }
        }
    });

    /**
     * Handle input/edit action
     * ----------------------------------------------------------------
     */
    let fpe = $('.file-info-editor');
    let c = $(fpe).find('.caption-input');
    let t = $(fpe).find('.tags-input');
    let l = $(fpe).find('.location-input');
    let tgt = $(fpe).data('target');
    let inputPreview = $(fpe).data('sample');
    let sample = document.createElement('div');
    $(sample).addClass('input-sample mb-1 small text-truncate');

    $(c).on('input', function () {
        let cTarget = $(this).data('target');
        let cSample = $(inputPreview).find(cTarget + ' span');
        let input = $(this).val();
        if (input.length > 0)
            $(cSample).html(input);
        else
            $(cSample).html($(cSample).data('placeholder'));
    });
    $(t).on('change', function () {
        let tTarget = $(this).data('target');
        let tSample = $(inputPreview).find(tTarget + ' span');
        let input = $(this).val();
        let tagged = input.split(',');
        if (tagged.length === 1)
            $(tSample).html(tagged[0]);
        else if (tagged.length === 2)
            $(tSample).html(tagged[0] + ' and ' + tagged[1]);
        else if (tagged.length > 2)
            $(tSample).html(tagged[0] + ', ' + tagged[1] + ' +' + (tagged.length - 2) + ' others');
        else if (tagged.length === 0)
            $(tSample).html($(tSample).data('placeholder'));
    });
    $(l).on('change', function () {
        let lTarget = $(this).data('target');
        let lSample = $(inputPreview).find(lTarget + ' span');
        let input = $(this).val();
        if (input.length > 0)
            $(lSample).html(input);
        else
            $(lSample).html($(lSample).data('placeholder'));
    });
});
