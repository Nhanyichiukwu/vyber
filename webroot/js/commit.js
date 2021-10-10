(function ($) {
//    if (typeof $ !== 'function') {
//        throw new TypeError("jQuery not found. Please include jQuery in order to use 'commit.js'");
//    }

    /**
     * Script for connection and disconnection
     */
   $(document).on('click', '[data-commit="connection"]',function (e) {
       e.preventDefault();
       let obj = $(this),
           form = obj.parent();

       $.post({
           url: form.attr('action'),
           type: 'POST',
           dataType: 'json',
           data: form.serializeArray(),
           success: connectionCommitted,
           error: connectionCommitted
       });

       function connectionCommitted(result, status, xhrs) {
            if (status === 'success' && result.status === 'success') {
                replaceButton(result.intent);
            }
       }

       function replaceButton(intent) {
           switch (intent) {
               case 'invite_connection':

                   break;
               case 'cancel_invitation':

                   break;
               case 'confirm_invitation':

                   break;
               case 'reject_invitation':

                   break;
               case 'disconnect':

                   break;
               default:

           }
       }

       return true;


//            var data = {
//                intent: ai,
//                user: userScreenName,
//                account: targetAccount,
//                origin: requestOrigin
//            };
//        $.ajax({
//            type: "GET",
//            url: url,
//            success: function(data, status) {
//                if (status === 'success') {
//                    if (data.status === 'success') {
//                        obj.parents('.user').remove();
//                    }
//                }
//            },
//            error: function(data, status, xhr) {
// //                    if (data.status === 'success') {
// //                        obj.parents('.user').remove();
// //                    }
//                console.log('Unable to send request!');
//            },
//            dataType: 'json'
//        });
   });

    // Ajax Simulation Script
    $('.ajaxSimulator').on('load', function () {
        var frame = $(this);
        var r = frame.contents().text();
        var rObj = {};
        if (r.length > 0) {
            rObj = $.parseJSON(r);
        }
        if (rObj.hasOwnProperty('event')) {
            if (window.CustomEvent) {
                var event = new CustomEvent('ajaxSimulator.afterload.' + rObj.event + '.complete', {
                    detail: {
                        desc: rObj.eventDesc,
                        time: new Date(),
                        responseData: rObj
                    },
                    bubbles: true,
                    cancelable: true
                });
                document.dispatchEvent(event);
            }
        }
//        var msg = '';
//        if (rObj.status === 'success') {
//            // Remove the call to action buttons and them know they are now
//            // connected or disconnected, depending on what action the user
//            // took. But if the user deletes the request or blocks the sender,
//            // navigate away from this page, or simply remove the request from
//            // list as the case may be
//            if (rObj.ua === 'accept') {
//                msg = 'You are now connected to ' + rObj.sender.fullname;
//            } else if (rObj.ua === 'decline') {
//                msg = 'You are now disconnected from ' + rObj.sender.fullname;
//            }
//
//            frame.parent().prev().replaceWith(msg);
////            frame
//        }
//        e.preventDefault();
//        var form = $(this);
//        var data = form.serializeArray();
//        var url = form.attr('action');
//
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: data,
//            success: function (data, status)
//            {
//                console.log(data);
//            },
//            error: function (data, status)
//            {
//                console.log(data);
//            },
//            dataType: 'json'
//        });
    });
})(jQuery);

