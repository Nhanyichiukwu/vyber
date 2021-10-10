$(document).ready(function () {
    // File Upload Handler with progress bar
    
            var fm = $('#upload-form');
            var url = fm.attr('action');
//            var tgt = $('#file-preview');
//            var main = $('#');
            fm.ajaxForm({
                target: tgt,
                url: url,
                beforeSubmit: function () {
//                    l.hide();
                    if($('input[type="file"]').val() === "") {
                        window.alert('You haven\'t selected any file yet. Please select a file and the try again...');
                        return; 
                    }
                    $(".upload-progress").removeClass('d-n');
                    var percentValue = '0%';

                    $('.progress-bar').width(percentValue);
                    $('.upload-level').html(percentValue);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentValue = percentComplete + '%';
                    $('.progress-bar').width(percentValue);
                    $(".upload-level").text(percentValue);
//                    $(".progress-bar").animate({},{
//                        easing: "linear",
////                        step: function (x) {
////                            percentText = Math.round(x * 100 / percentComplete);
////                            $(".upload-level").text(percentText + "%");
////                            if(percentText == "100") {
////                                tgt.show();
////                            }
////                        }
//                    });
                },
                error: function (response, status, e) {
                    console.log('Oops! Something went wrong...');
                },

                complete: function (xhr) {
                    if (xhr.responseText && xhr.responseText != "error")
                    {
                          tgt.html(xhr.responseText);
                    }
                    else{ 
                        console.log(xhr.responseText);
                        tgt.show();
                        tgt.html("<div class='alert alert-danger'>Problem in uploading file.</div>");
                        $("#progressBar").stop();
                    }
                }
            });
    });

