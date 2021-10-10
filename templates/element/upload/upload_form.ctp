<?php 
use Cake\Routing\Router;
?>
<div id="media-selector">
    <?= $this->Form->create('file', 
            [
                'url' => [
                    'action' => 'process',
                    $fileType
                ],
                'id' => 'upload-form', 
                'type' => 'file'
            ]); ?>
    <?= $this->Form->unlockField('file') ?>
        <div class="col-sm-6 col-md-6 mx-auto text-center upload-video pt-5 pb-5">
            <section class="card">
                <div class="card-body p-lg-5">
                    <?= $this->Form->input('data-referrer', ['type' => 'hidden', 'value' => $this->getRequest()->getRequestTarget()]) ?>
                    <div class="file-picker input">
                        <label for="file" class="bd-dotted bdc-lte bdrs-10 bdsz-2 bgcH-grey-100 p-4 text-muted">
                            <span class="mdi mdi-cloud-upload mdi-48px text-warning"></span>
                        <h4>Click to select files</h4>
                        <p class="land">or drag and drop files here</p>
                        </label>
                        <?= $this->Form->file('file', [
                            'name' => 'file',
                            'accept' => implode(', ', $acceptedTypes),
                            'label' => false,
                            'id' => 'file',
                            'class' => 'd-none',
                            'onchange' => '$(\'button[disabled="disabled"]\').removeAttr(\'disabled\')',
                            'multiple' => 'multiple'
                        ]) ?>
                        <?php if (isset($classification)): ?>
                        <input type="hidden" name="classification" value="<?= $classification ?>">
                        <?php endif; ?>
                        <div class="mt-4">
                        <div class="clearfix"></div>
                        <div class="file-info mb-3"></div>
                        <?= $this->Form->button(
                                __('Upload'),
                                [
                                    'disabled' => 'disabled',
                                    'class' => 'align-items-center btn btn-secondary d-inline-flex flex-fill justify-content-center px-3 rounded-lg text-uppercase',
                                    'id' => 'uploadBtn'
                                ]
                                ); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?= $this->Form->end(['Upload']); ?>
</div>
<!--<script>-->
<?php //$this->Html->script('ajax-form', ['block' => 'scriptBottom']); ?>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
(function ($) {
    $('#file').on('change', function() {
        let file = this.files[0];
        $('.file-info').html('You selected: ' + file.name);
    });
    
    let fm = $('#upload-form');
    fm.ajaxForm({
//                target: tgt,
                url: fm.attr('action'),
                beforeSubmit: function () {
                    let selectedFile = document.getElementById('file').files[0];
                    let fileMime = selectedFile.type;
                    let fileType = fileMime.split('/')[0];
                    let fc = $('.file-info-form-container');
                    
//                    doAjax('add_file_info/' + fileType, function (data, status, xhr) {
//                        if (status === 'success') {
//                            $(fc).html(data);
//                        }
//                    }, {contentType: 'html', requestMethod: 'get'});
                    
                    $('#media-selector').hide();
                    fc.show();
//                    $(".upload-progress").show();
                    var percentValue = '0%';
                    $('.progress-bar').width(percentValue);
                    $('.sr-only').text(percentValue + ' Complete...');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentValue = percentComplete + '%';
                    $('.progress-bar').width(percentValue);
                    $(".sr-only").text(percentValue + ' Complete...');
//                    $(".progress-bar").animate({},{
//                        easing: "linear",
//                        step: function (x) {
//                            let percentText = Math.round(x * 100 / percentComplete);
//                            console.log(percentText);
//                            $(".upload-level").text(percentText + "%");
//                            if(percentText == "100") {
//                                //tgt.show();
//                            }
//                        }
//                    });
                },
                error: function (response, status, e) {
                    console.log(response);
                },

                complete: function (response, status, xhr) {
                    $('.progress-bar').removeClass('.progress-bar-animated');
                    if (status === 'success') {
                        uploadAfterProcess(response);
                    }
                }
            });
})(jQuery);

/**
 * With the response object, create an id field for the for form
 * 
 * @param {object} response
 * @returns {void}
 */
function uploadAfterProcess(response)
{
    let d = response.responseJSON;
    let $form = $('#file-info-form');
    let idField = $form.find('#fileID');
    if (idField.length > 0) {
        $(idField).attr('value', d.refid);
    } else {
        $form.prepend('<input type="hidden" name="fileID" id="fileID" value="' + d.refid + '">');
    }
    
    // Set the permalink if applicable
    if (d.hasOwnProperty('permalink')) {
        $form.find('#permalink').attr('value', d.permalink).show();
    }
}
//function utf8Decode(utftext) {
//  var string = '';
//  var i = 0;
//  var c = 0, c2 = 0, c3 = 0;
//  while ( i < utftext.length ) {
//    c = utftext.charCodeAt(i);
//    if (c < 128) {
//      string += String.fromCharCode(c);
//      i ++;
//    } else if (c > 191 && c < 224) {
//      c2 = utftext.charCodeAt(i + 1);
//      string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
//      i += 2;
//    } else {
//      c2 = utftext.charCodeAt(i + 1);
//      c3 = utftext.charCodeAt(i + 2);
//      string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
//      i += 3;
//    }
//  }
//  return string;
//}
<?php $this->Html->scriptEnd(); ?>