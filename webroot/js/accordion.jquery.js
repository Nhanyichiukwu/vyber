/**
 * JQuery Based Accordion Panels
 * @author Nhanyichiukwu Hopeson Otuosorochiukwu
 */
Accordion = {
    engine: jQuery,
    panels: null,
    init: function (engine) {
        if (typeof engine !== 'function')
            throw new TypeError('engine must be a function such as jQuery');
        
        this.engine = engine;
        this.start();
    },
    start: function () {
        if (typeof this.engine !== 'function')
            throw new TypeError('Engine not defined!');
        
        this.panels = this.engine('.accordion .accordion-item');
        this.core();
    },
    core: function () {
        if (typeof this.engine !== 'function' || typeof this.panels !== 'object')
            return;
        let $ = this.engine;
        let panels = this.panels;
        panels.each(function () {
            let panel = $(this);
            let pane = panel.find('.accordion-pane');
            let content = panel.find('.accordion-content');
            let icon = pane.find('.icon').children();
            $(pane).on('click', function () {
//                content.slideToggle(200, function () {
//                    let dataState = panel.attr('data-state');
//                    if (dataState === 'open')
//                        panel.attr('data-state','close');
//                    else
//                        panel.attr('data-state','open');
//
//                    icon.toggleClass('mdi-plus mdi-minus');
//                });
//                content.slideToggle(200, function () {
                    let dataState = panel.attr('data-state');
                    if (dataState === 'open') {
                        content.slideUp(200, function () {
                            panel.attr('data-state','close');
                            icon.removeClass('mdi-chevron-up').addClass('mdi-chevron-down');
                        });
                    } else if (dataState === 'close') {
                        content.slideDown(200, function () {
                            panel.attr('data-state','open');
                            icon.removeClass('mdi-chevron-down').addClass('mdi-chevron-up');
                        });
                    }
                    
//                });
            });
        });
    }
};
