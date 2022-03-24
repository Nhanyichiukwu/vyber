<?php

use Cake\Routing\Router;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<nav id="filter-tools" class="toolbar mb-3" role="toolbar">
    <div class="vV">
        <div class="Dh">
            <div class="row gutters-sm justify-content-between align-items-center tl_layout-toggle">
                <div class="col-auto">
                    <div class="row gutters-sm justify-content-between align-items-center">
                        <div class="col-auto"><span class="labels">Layout:</span></div>
                        <div class="col">
                            <div class=":btn-group">
                                <?= $this->Html->link(
                                    __('<i class="mdi mdi-view-grid"></i> Grid'),
                                    [
                                        'controller' => 'xhrs',
                                        'action' => 'aKJm'
//                                        '?' => ['referer' => urlencode($this->getRequest()->getAttribute('here'))]
                                    ],
                                    [
                                        'data' => json_encode(['option' => 'timeline_layout_preference','mode' => 'grid']),
                                        'escapeTitle' => false,
                                        'class' => 'btn btn-icon lh-1 layout-toggle btn-sm text-dark',
                                        'data-toggle' => 'layout',
                                        'aria-layout' => 'grid',
                                        'data-target' => '#stream',
                                        'fullBase' => true
                                    ]) ?>
                                <?= $this->Html->link(
                                    __('<i class="mdi mdi-view-agenda"></i> Stack'),
                                    [
                                        'controller' => 'xhrs',
                                        'action' => 'aKJm'
//                                        '?' => ['referer' => urlencode($this->getRequest()->getAttribute('here'))]
                                    ],
                                    [
                                        'data' => json_encode(['option' => 'timeline_layout_preference','mode' =>
                                'stack']),
                                        'escapeTitle' => false,
                                        'class' => 'btn btn-icon lh-1 layout-toggle btn-sm text-dark',
                                        'data-toggle' => 'layout',
                                        'aria-layout' => 'stack',
                                        'data-target' => '#stream',
                                        'fullBase' => true
                                    ])  ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($enableAuthorFiltering) && true === $enableAuthorFiltering): ?>
                <div class="col-auto">
                    <div class="row gutters-sm justify-content-between align-items-center">
                        <div class="col-auto"><span class="labels">Posted By:</span></div>
                        <div class="col">
                            <div class="btn-group-justified">
                                <?= $this->Form->create(null, ['type' => 'get', 'url' => ['filter' => 'by_author']]); ?>
                                <span class="d-n">
                                    <input type="hidden" name="data" value="timeline">
                                        <?php if ($this->getRequest()->getQuery('mode')): ?>
                                    <input type="hidden" name="mode" value="<?= $this->getRequest()->getQuery('mode'); ?>">
                                        <?php endif; ?>
                                </span>
                                <div class="input-group">
                                    <select name="postedby" class="custom-select custom-select-sm py-0">
                                        <?php if (isset($activeUser, $actor) && $activeUser->isSameAs($actor)): ?>
                                        <option value="me" data-author="<?= $actor->getUsername(); ?>">Me</option>
                                        <?php elseif (isset($actor)): ?>
                                        <option
                                            value="<?= $actor->getUsername(); ?>"
                                            data-author="<?= $actor->getUsername(); ?>">
                                            @<?= $actor->getUsername(); ?>
                                        </option>
                                        <?php endif; ?>
                                        <option value="others">Others</option>
                                        <option value="anyone">Anyone</option>
                                    </select>
                                    <span class="input-group-append">
                                        <button class="btn btn-primary btn-sm" type="submit">Go!</button>
                                    </span>
                                </div>
                                <?= $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<!--<script>-->
<?php $this->Html->scriptStart(['block' => 'scriptBottom', 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
(function($) {
    $('.tl_layout-toggle .btn').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        let url = $this.attr('href');
        let data = $.parseJSON($this.attr('data'));
        data = $(data).serializeObject();
        // let formData = $('#xhrs-blank-form').serialize();
        // data = formData + '&' + data;
        let csfr = $('#xhrs-blank-form [name="_csrfToken"]').val();
        doAjax(url, function (data, status) {
            if (status === 'success') {
                window.location.assign(window.location.href);
            } else {
                alert('Unable to change layout at the moment.');
            }
        }, {
            type: 'POST',
            data: data,
            headers: {
            'X-CSRF-Token': csfr
            },
            contentType: false
        });
    });
})(jQuery);
<?= $this->Html->scriptEnd(); ?>
