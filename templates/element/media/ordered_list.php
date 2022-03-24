<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Datasource\ResultSetInterface;
use Cake\Routing\Router;

?>
<?php if (isset($media) &&
    $media instanceof ResultSetInterface &&
    $media->count() >= 0
): ?>
    <div class="list-group bg-white list-group-lg no-bg auto">
        <a href="#" class="list-group-item list-group-item-action clearfix">
            <span class="float-end h2 m-0 ms-3 text-gray">1</span>
            <span class="avatar avatar-md float-start me-3 text-center thumb-sm object-fit">
                            <img src="<?=
                        Router::url('/media/face?type=' .
                            'photo&role=album-cover&format=png&size=small&' .
                            '_src=' . $user->refid,
                            true); ?>" alt="...">
                          </span>
            <span class="clear fsz-14">
                <span>Little Town</span>
                <small class="text-muted clear text-ellipsis">by Chris Fox</small>
            </span>
        </a>
        <a href="#" class="list-group-item list-group-item-action clearfix">
            <span class="float-end h2 m-0 ms-3 text-gray">2</span>
            <span class="avatar avatar-md float-start me-3 text-center thumb-sm object-fit">
                            <img src="<?=
                        Router::url('/media/face?type=' .
                            'photo&role=album-cover&format=png&size=small&' .
                            '_src=' . $user->refid,
                            true); ?>" alt="...">
                          </span>
            <span class="clear fsz-14">
                <span>Lementum ligula vitae</span>
                <small class="text-muted clear text-ellipsis">by Amanda Conlan</small>
            </span>
        </a>
        <a href="#" class="list-group-item list-group-item-action clearfix">
            <span class="float-end h2 m-0 ms-3 text-gray">3</span>
            <span class="avatar avatar-md float-start me-3 text-center thumb-sm object-fit">
                            <img src="<?=
                        Router::url('/media/face?type=' .
                            'photo&role=album-cover&format=png&size=small&' .
                            '_src=' . $user->refid,
                            true); ?>" alt="...">
                          </span>
            <span class="clear fsz-14">
                            <span>Aliquam sollicitudin venenatis</span>
                            <small class="text-muted clear text-ellipsis">by Dan Doorack</small>
                          </span>
        </a>
        <a href="#" class="list-group-item list-group-item-action clearfix">
            <span class="float-end h2 m-0 ms-3 text-gray">4</span>
            <span class="avatar avatar-md float-start me-3 text-center thumb-sm object-fit">
                            <img src="<?=
                        Router::url('/media/face?type=' .
                            'photo&role=album-cover&format=png&size=small&' .
                            '_src=' . $user->refid,
                            true); ?>" alt="...">
                          </span>
            <span class="clear fsz-14">
                            <span>Aliquam sollicitudin venenatis ipsum</span>
                            <small class="text-muted clear text-ellipsis">by Lauren Taylor</small>
                          </span>
        </a>
        <a href="#" class="list-group-item list-group-item-action clearfix">
            <span class="float-end h2 m-0 ms-3 text-gray">5</span>
            <span class="avatar avatar-md float-start me-3 text-center thumb-sm object-fit">
                            <img src="<?=
                        Router::url('/media/face?type=' .
                            'photo&role=album-cover&format=png&size=small&' .
                            '_src=' . $user->refid,
                            true); ?>" alt="...">
                          </span>
            <span class="clear fsz-14">
                            <span>Vestibulum ullamcorper</span>
                            <small class="text-muted clear text-ellipsis">by Dan Doorack</small>
                          </span>
        </a>
    </div>
<?php else: ?>
    <?= $this->contentUnavailable('anything to show'); ?>
<?php endif; ?>
