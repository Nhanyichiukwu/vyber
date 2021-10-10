<?php

/**
 * 
 */
?>
<ul id="<?= h($chatID) ?>" class="conversation-history">
<?php if (count($chat->messages)): ?>
    <?php foreach ($chat->messages as $message): ?>
    <?php 
    $msgParty = 'secondary';
    if ($message->author->isSameAs($activeUser)) {
        $msgParty = 'primary';
    }
    ?>
    <li class="msg <?= $msgParty ?>">
        <div class="msg-wrapper row">
            <div class="Yqzw col-auto">
                <div class="speech-bubble"><?= h($message->text); ?></div>
            </div>
            <div class="OHd col-auto">
                <span class="avatar avatar-lg"></span>
            </div>
        </div>
        <div class="msg-time"><?= $this->formatTime($message->created); ?></div>
    </li>
    <?php endforeach; ?>
<?php endif; ?>
    <li class="msg primary">
        <div class="msg-wrapper row">
            <div class="Yqzw col-auto">
                <div class="speech-bubble ">
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                    Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                </div>
            </div>
            <div class="OHd col-auto">
                <span class="avatar avatar-lg"></span>
            </div>
        </div>
        <div class="m-datetime"></div>
    </li>
    <li class="msg secondary">
        <div class="msg-wrapper row">
            <div class="Yqzw col-auto">
                <div class="speech-bubble">Hello there</div>
            </div>
            <div class="OHd col-auto">
                <span class="avatar avatar-lg"></span>
            </div>
        </div>
        <div class="m-datetime"></div>
    </li>
    <li class="msg secondary">
        <div class="msg-wrapper row">
            <div class="Yqzw col-auto">
                <div class="speech-bubble">Hello there, it’s an honour having you here Hello there, it’s an honour having you here Hello there, it’s an honour having you here Hello there, it’s an honour having you here Hello there, it’s an honour having you here Hello there, it’s an honour having you here Hello there, it’s an honour having you here</div>
            </div>
            <div class="OHd col-auto">
                <span class="avatar avatar-lg"></span>
            </div>
        </div>
        <div class="m-datetime"></div>
    </li>
</ul>
<!--<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="chatDetailsTitle"><?= __($chatTitle) ?></h4>
        </div>
        <div class="modal-body"></div>
        <footer class="modal-footer"></footer>
    </div>
</div>-->
<!--<div id="chat-details" class="modal">
    
</div>-->
<?php $this->start('messenger_footer'); ?>
    <?= $this->element('messaging/message_composer'); ?>
<?php $this->end(); ?>
<!--<script type="text/javascript">-->
<?php $this->Html->script("node_modules/socket.io-client/dist/socket.io.js", ['block' => 'scriptBottom']); ?>
<?php // $this->Html->script("app", ['block' => 'scriptBottom']); ?>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    $(function () {
        var socket = io();
        var form = $('#message-composer');
        var textBx = form.find('#textbox');
        var sendBtn = form.find('button');
        var sender = $(textBx).data('sender');
        var chatID = $('.conversation-history').attr('id');
        
        $(textBx).on('keydown', function(e) {
            var key = e.keyCode;
//            message = new Message(sender, chatID, this);
            if (key === 13 && $(textBx).text().length > 0) {
                Message.send(socket, sender, chatID, textBx);
            }
            return false;
        });
        sendBtn.on('click', function(e) {
//            message = new Message(sender, chatID, textBx);
            if ($(textBx).text().length > 0)
                Message.send(socket, sender, chatID, textBx);
            return false;
        });
        
        Message.recieve(socket);
        
    });
    
    var MessageOld = function (sender, chat, textInput, fileInput = null)
    {
        this.chat = chat;
        this.textInput = textInput;
        this.files = fileInput;
        
        this.send = function (socket)
        {
            let text = $(this.textInput).text();
            
            $('.conversation-history').append(this.addTemplate(text, 'primary'));
            this.socket.emit('chat message', text);
            $(this.textInput).val('');
        }
        
        this.recieve = function (socket) {
            socket.on('chat message', function(msg){
                $('.conversation-history').append(this.addTemplate(msg, 'secondary'));
            });
        }
        
        this.addTemplate = function(msg, party) 
        {
            let date = new Date();
            let template = '<li class="msg ' + party + '">\n\
                                <div class="msg-wrapper row">\n\
                                    <div class="Yqzw col-auto">\n\
                                        <div class="speech-bubble">' + msg + '</div>\n\
                                    </div>\n\
                                    <div class="OHd col-auto">\n\
                                        <span class="avatar avatar-lg"></span>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="m-datetime">' + date.getDate() + '</div>\n\
                            </li>';
                                            
            return template;
        }
    }
    
    var Message = {
        send: function (socket, sender, chatID, textbox, fileInput = null)
        {
            let text = $(textbox).text();
            
            $('.conversation-history').append(this.addTemplate(text, 'primary'));
            socket.emit('chat message', text);
            $(textbox).text('');
        },
        
        recieve: function (socket) {
            socket.on('chat message', function(msg){
                $('.conversation-history').append(this.addTemplate(msg, 'secondary'));
            });
        },
        
        addTemplate: function(msg, party) 
        {
            let date = new Date();
            let template = '<li class="msg ' + party + '">\n\
                                <div class="msg-wrapper row">\n\
                                    <div class="Yqzw col-auto">\n\
                                        <div class="speech-bubble">' + msg + '</div>\n\
                                    </div>\n\
                                    <div class="OHd col-auto">\n\
                                        <span class="avatar avatar-lg"></span>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="m-datetime">' + date.getDate() + '</div>\n\
                            </li>';
                                            
            return template;
        }
    };
<?php $this->Html->scriptEnd(); ?>