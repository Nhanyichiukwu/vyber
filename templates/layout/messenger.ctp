<?php
use Cake\Utility\Text;
use Cake\Routing\Router;

$this->extend('default');
?>
<div class="PWtMJo">
    <nav class="bg-white border-bottom navbar toolbar">
        <div class="PWtMJo ml-n3 my-n2 px-4 py-1 w_upO1RQ">
            <div class="connection-status py-3" style="display: none;">Connected</div>
            <div class="layer mx-n3 pos-r">
                <input type="text" placeholder="Search contacts..." name="chat_search" class="form-control form-control-lg form-control-plaintext no-focus pl-4 pr-7 rounded-0">
                <span class="input-icon-addon text-muted">
                    <i class="mdi mdi-24px mdi-magnify"></i>
                </span>
            </div>
        </div>
        <div class="col-auto flex-fill">
            <div id="status-bar" class="row justify-content-between">
                <?php if (isset($chatTitle)): ?>
                <div class="col-auto title-block">
                    <a class="chat-title" href="javascript:void(0)" 
                       data-uri="<?= Router::url(['action' => 'lookup','profile','id' => $chatID]); ?>" 
                       data-toggle="pagelet"
                       data-target="#infoCard"><?= Text::truncate($chatTitle, 38, ['ellipsis' => '...']); ?></a>
                </div>
                <?php endif; ?>
                <div class="w_upO1RQ">
                    <div class="messaging-tools">
                        
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="messaging-interface" class="d-flex">
        <div id="online-users" class="D8A PWtMJo afixed bg-white col fixed-bottom fixed-top os_foaU pos-a w_upO1RQ px-4">
            <div class="chat-list h-100 mx-n3 ofx-h ofy-auto user-list"></div>
            <footer class="layer pos-a-b pos-a-r pos-a-l border-top">
                <div class="col bg-white py-3">
                    <div class="input-icon">
                        
                    </div>
                </div>
            </footer>
        </div>
        <div id="chat-window" class="col os_foaU os_push18 fixed-top fixed-bottom w_Osr32Z PWtMJo D8A py-3">
            <content class="Psd0wK">
                <?= $this->fetch('content'); ?>
            </content>
            <footer class="layer pos-a-b pos-a-r pos-a-l border-top">
            <?php if ($this->fetch('messenger_footer')): ?>
                <?= $this->fetch('messenger_footer'); ?>
            <?php else: ?>
                <?= $this->element('messaging/message_composer'); ?>
            <?php endif; ?>
            </footer>
            <div class="pagelet">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="chatDetailsTitle">Modal Title</h4>
                        </div>
                        <div class="modal-body"></div>
                        <footer class="modal-footer"></footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script type="text/javascript">-->
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    (function($) {
        // Populate the user list
        var list = $('.chat-list');
        var loading = $('.content-loading').clone();
        list.html(loading);
        setTimeout(function() {
            doAjax('/messages/chats_list/html', function(data, status, xhrs) {
                if (status === 'success') {
                    list.html(data);
                }
            }, {contentType: 'html'});
        }, 200);
        
        
        // This controls what happens when a user clicks on a chat
        // or on a user, to start a chat.
        $('.chat-list').on('click', '.K1oMs4', function(e) {
            let $chattable = $(this);
            
//            let uri = $chattable.data('uri');
//            let t = $chattable.data('chat-title');
            
            if ($chattable.data('uri') !== window.location.href) {
                var postData = $('#xhrs-blank-form').serialize();
                postData += '&chat_title=' + $chattable.data('chat-title') + '&correspondent=' + $chattable.data('correspondent') + '&chat_type=' + $chattable.data('chat-type') + '&' + ''

                doAjax($chattable.data('uri'), function(data, status, xhrs) {
                    if (status === 'success') {
                        window.history.replaceState(null, $chattable.data('chat-title'), $chattable.data('uri')); // Update the address bar
                        if ($('#status-bar').find('.chat-title')) {
                            $('#status-bar').find('.chat-title').html($chattable.data('chat-title'));
                        } else {
                            $('#status-bar').find('.title-block').prepend('<div class="chat-title"></div>');
                            $('#status-bar').find('.chat-title').html($chattable.data('chat-title'));
                        }
                        $('content.Psd0wK').html(data);
                    }
                }, {requestMethod: 'post', contentType: 'html', data: postData});
            }
        });
        
        
    })(jQuery);
<?php $this->Html->scriptEnd(); ?>
<!--</script>-->