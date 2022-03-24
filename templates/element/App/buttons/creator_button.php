<?php
/**
 * @var \App\View\AppView $this
 */

use App\Utility\RandomString;
use Cake\Routing\Router;


$drawerID = mb_strtolower(
    RandomString::generateString(32, 'mixed', 'alpha')
);
$drawerData = json_encode([
    'drawerID' => $drawerID,
    'hasCloseBtn' => false,
    'drawerMax' => '100%',
    'alwaysReload' => true,
]);


//data-toggle="drawer"
/*aria-controls="#creatorDialog"*/
/*data-config='<?= $drawerData ?>'*/

$creatorTools = mb_strtolower(
    RandomString::generateString(32, 'mixed', 'alpha')
)
?>
<div id="creatorBtn" class="_ycGkU4 gvv3olex jj1wio1k x5jpjwdh z_Gtob d-none d-md-block">
    <div class="_oFb7Hd">
        <a href="javascript:void()"
           data-bs-toggle="modal"
           data-bs-target="#creatorTools"
            class="a3jnltym btn btn-app btn-icon bzakvszf lh_wxx lzkw2xxp qrfe0hvl shadow-lg">
            <i class="icon mdi mdi-shape-square-plus"></i>
            <span class="btn-label sr-only">Share</span>
        </a>
    </div>
</div>
<div id="creatorTools" class="modal" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="creatorToolsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down fHQbDJMO">
        <div class="modal-content yQx6NY6F">
            <div class="modal-header">
                <h5 class="modal-title" id="creatorToolsLabel">What would you like to do?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-app-body">
                <div class="_vYaq align-items-start d-flex flex-wrap gutters-xs row row-cols-2 row-cols-md-3">
                    <div class="col">
                        <?php
                        //                        $thoughtDrawer = mb_strtolower(
                        //                            RandomString::generateString(32, 'mixed', 'alpha')
                        //                        );
                        //                        $thought = json_encode([
                        //                            'drawerID' => $thoughtDrawer,
                        //                            'hasCloseBtn' => false,
                        //                            'drawerMax' => '100%',
                        //                        ]);
                        ?>
                        <a href="<?= Router::url('/posts/create?what=thought', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-uri="<?= Router::url('/posts/create?what=thought', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon mdi mdi-head-lightbulb"></i>
                            <span class="btn-label">Share a Thought</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$momentDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $moment = json_encode([
                            'drawerID' => $momentDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?what=moment', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?what=moment', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon icofont-expressionless"></i>
                            <span class="btn-label">Share my Moment</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$shoutoutDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $shoutout = json_encode([
                            'drawerID' => $shoutoutDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?what=shout_out', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?what=shoutout', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon mdi mdi-account-voice"></i>
                            <span class="btn-label">Send a Shout Out</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$goLiveDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $goLive = json_encode([
                            'drawerID' => $goLiveDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?intent=go_live&what=video', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?intent=go_live&what=video', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="fe fe-video icon"></i>
                            <span class="btn-label">Go Live</span>
                        </a>
                    </div>

                    <div class="col">
                        <?php
                        /*$goLiveDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $goLive = json_encode([
                            'drawerID' => $goLiveDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?intent=go_live&what=audio', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?intent=go_live&what=audio', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icofont-record icon"></i>
                            <span class="btn-label">Sing Live</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$videoDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $video = json_encode([
                            'drawerID' => $videoDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?what=video', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?what=video', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon icofont-ui-video-play"></i>
                            <span class="btn-label">Post a Video</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$songDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $song = json_encode([
                            'drawerID' => $songDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?what=audio', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?what=audio', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon icofont-music"></i>
                            <span class="btn-label">Post a Song</span>
                        </a>
                    </div>
                    <div class="col">
                        <?php
                        /*$photoDrawer = mb_strtolower(
                            RandomString::generateString(32, 'mixed', 'alpha')
                        );
                        $photo = json_encode([
                            'drawerID' => $photoDrawer,
                            'hasCloseBtn' => false,
                            'drawerMax' => '100%',
                        ]);*/
                        ?>
                        <a href="<?= Router::url('/posts/create?what=photo', true) ?>"
                           role="button"
                           data-ov-toggle="modal"
                           data-ov-target="#creatorDialog"
                           data-title='Create Post'
                           data-uri="<?= Router::url('/posts/create?what=photo', true) ?>"
                           data-modal-control='{"class":"d-flex flex-column flex-column-reverse"}'
                           data-dialog-control='{"css":{"maxHeight":"100%","maxWidth":"35rem"},
                   "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}'
                           data-window="frame"
                           data-always-reload="true"
                           aria-controls="#creatorDialog"
                           data-config='<?= $drawerData ?>'
                           class="btn btn-icon bzakvszf lh_wxx qrfe0hvl">
                            <i class="icon icofont-image"></i>
                            <span class="btn-label">Post a Photo</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function postData(url = '', data = {}) {
        const response = await fetch(url, {
            method: 'GET',
            mode: 'same-origin',
            cache: 'default',
            credentials: 'same-origin',
            // headers: {
            //     'Content-Type': 'application/json'
            // },
            redirect: 'follow',
            // body: JSON.stringify(data)
        });
        return response.text();
    }
    // postData('settings/profile').then(data => {console.log(data)});
</script>
