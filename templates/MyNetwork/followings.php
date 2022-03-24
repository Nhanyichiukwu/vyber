<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
?>
<?php
$this->set('page_title', 'Connections');

$this->element('App/page_header');
?>

<div class="content">
    <?php if ($followings->count() > 0): ?>
    <div class="_M22YBE flex-wrap gutters-xs row">
        <?php foreach ($followings as $following): ?>
            <div class="col-6 col-md-2 col-sm-3">
                <div class="_oFb7Hd nYJsFM nYJsFM-lg nYJsFM-md card xoj5za5y">
                    <div class="card-header yhbirx ebhwdzhs" style="background-image: url
                (demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
                    <div class="ybzbve p-2 text-center">
                        <img class="nYJsFM-img" src="<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                        ?>">
                        <h6 class="profile-name">
                            <a href="<?= Router::url('/'. h($following->getUsername())) ?>">
                        <span class="d-block">
                            <?= Text::truncate(
                                h($following->getFullName()),
                                20
                            ); ?>
                        </span>
                            </a>
                        </h6>
                        <div class="fsz-12 lh_f5 mb-3">
                            <?= Text::truncate(
                                h($following->profile->about),
                                30
                            ); ?>
                        </div>
                        <?= $this->element('App/buttons/connection_btn', ['account' => $following]); ?>
                        <?= $this->Form->postButton(__('<i class="mdi mdi-check"></i> <span
                        data-alt="Disconnect">Connected</span>'), [
                            'controller' => 'commits',
                            'action' => 'connection',
                            '?' => [
                                'intent' => "disconnect",
                                ]
                        ], [
                            'data' => [
                                'actor' => h($appUser->getUsername()),
                                'account' => h($following->getUsername()),
                            ],
                            'data-commit' => "connection",
                            'escapeTitle' => false,
                            'data-referer' => $this->getRequest()->getRequestTarget(),
                            'class' => 'btn btn-control-small btn-sm btn-primary btn-rounded px-2 btn-block btn-pill',
                        ]); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <h3 class="font-weight-light text-center text-muted">You aren't following any user, group or event.</h3>
    <?php endif; ?>
</div>
