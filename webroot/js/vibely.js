/**
 * @package Vibely.js
 */

if (!window.jQuery) {
    throw new Error('jQuery not found. This script requires jQuery to junction properly');
}
let $ = window.jQuery;

var Drawer = User = {};



var Vibely = {
    process: function (data, event) {
        var action, vibelyData = $.parseJSON(data);
        let handler = (event.type === 'click' ? event.type : 'hover') + 'Action';
        if (!vibelyData.hasOwnProperty(handler)) {
            return;
        }
        action = vibelyData[handler];
        if (action && typeof this[action] === 'function') {
            return this[action](vibelyData);
        }

        // Convert string such as 'funcName' and 'Object.childObject.method'
        // into a callable function
        action = stringToFunc(action);
        if (typeof action === 'function') {
            return action(vibelyData);
        }
        throw new Error('Action not defined');
    },
    prefetch: function (data) {
        let output = data.output,
            viewport = $(output).find('.view-port').eq(0);
        if (viewport === null) {
            viewport = output;
        }
        let loading = spinner();
        $(viewport).html(loading);
        let url = (
            data.src.startsWith('http') ?
                data.src :
                window.getBaseUri().rtrim('/') + '/' + data.src.ltrim('')
        );
        $.get(url, function (result, status) {
            $(viewport).html(result);
            output.addClass('vibely-loaded');
        });
    },

    /**
     *
     * @param data object
     * @param handler callable
     */
    render: function (data, handler = null) {
        let output = $(data.output);
        this.prefetch(data);

        // Check if there is a defined handler to handle to operation
        // Otherwise, handle it
        handler = handler || (
            data.hasOwnProperty('handler')
                ? data.handler
                : handler // still returning handler since it's null
        );
        if (handler) {
            if (typeof handler === "string") {
                handler = stringToFunc(handler);
            }
            return handler(data);
        }
        output.show();
    }
};
