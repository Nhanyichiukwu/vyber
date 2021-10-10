
<nav class="bg-transparent toolbar page-nav border-bottom py-3 bg-white mx-n3">
    <div class="has-toggle fl-r px-3">
        <a href="javascript:void()" data-role="toggler" class="">
            <span class="mdi mdi-menu"></span>
        </a>
    </div>
    <div class="align-items-center">
        PartyB Name
    </div>
</nav>
<div class="row">
    <div class="col-md-8 px-0 border-right">
        <div class="conversation Of-Y_a Of-X_h">
            <ul class="thread msgs">
                <li class="msg primary">
                    <div class="msg-wrapper row">
                        <div class="col-auto">
                            <div class="msg-text ">
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            Hello there, it’s an honour having you here, and we do hope you find what you’re looking for.
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="avatar avatar-lg"></span>
                        </div>
                    </div>
                    <div class="m-datetime"></div>
                </li>
                <li class="msg primary">
                    <div class="msg-wrapper row">
                        <div class="col-auto">
                            <div class="msg-text ">Hello there</div>
                        </div>
                        <div class="col-auto">
                            <span class="avatar avatar-lg"></span>
                        </div>
                    </div>
                    <div class="m-datetime"></div>
                </li>
                <li class="msg primary">
                    <div class="msg-wrapper row">
                        <div class="col-auto">
                            <div class="msg-text ">
                            Hello there, it’s an honour having you here
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="avatar avatar-lg"></span>
                        </div>
                    </div>
                    <div class="m-datetime"></div>
                </li>
            </ul>
        </div>
        <footer class="col-md-12 bdT ta-c lh-0 fsz-sm c-grey-600">
                                                <?= $this->Form->create(null, ['class' => 'py-3', 'name' => 'chat-form', 'accept-charset' => 'utf-8', 'type' => 'file', 'url' => ['action' => 'p-2-p-interchange']]) ?>
            <div class="row">
                <div class="d-none">
                    <input type="hidden" class="d-none" id="message" name="message">
                    <input type="hidden" class="d-none" name="chat_refid" value="">
                    <input type="hidden" class="d-none" name="recipients" value="">
<!--                                                            <input type="hidden" class="d-none" name="message">
                    <input type="hidden" class="d-none" name="message">
                    <input type="hidden" class="d-none" name="message">-->
                </div>
                <div class="col-md-9 order-md-2">
                    <button class="msg-send-btn border btn btn-default ml-2 rounded-circle fl-r" name="send">
                        <span class="mdi mdi-24px mdi-send"></span>
                    </button> 
                    <div id="msg-input" class="form-control rounded-pill w-auto mr-7 msg-input" contenteditable="true" placeholder="Say 'Hi'"></div>
                </div>
                <div class="col-md-3">

                </div>
            </div>
                                                <?= $this->Form->end(['Upload']); ?>
        </footer>
    </div>
    <div class="right-sidebar col-md-4" role="infobox">

    </div>
</div>