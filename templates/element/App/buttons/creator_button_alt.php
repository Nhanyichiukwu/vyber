<?php
/**
 * @var \App\View\AppView $this
 */

use App\Utility\RandomString;
use Cake\Routing\Router;

$vibelyData = [
    'drawerID' => mb_strtolower(
        RandomString::generateString(32, 'mixed', 'alpha')
    ),
    'hasCloseBtn' => false,
    'drawerMax' => '100%',
    'dataSrc' => '/posts/create'
];
$vibelyData = json_encode($vibelyData);
?>
<div id="creatorBtn" class="_ycGkU4 gvv3olex jj1wio1k x5jpjwdh z_Gtob">
    <a href="<?= Router::url('/posts/create?data_target=app_view', true) ?>"
       role="link"
       data-toggle="drawer"
       aria-controls="#creator-drawer"
       data-config='<?= $vibelyData ?>'
       class="a3jnltym btn btn-app bzakvszf lzkw2xxp n1ft4jmn qrfe0hvl shadow-lg">
        <span class="_af4H">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor"
                      d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12H20A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4V2M18.78,3C18.61,3 18.43,3.07 18.3,3.2L17.08,4.41L19.58,6.91L20.8,5.7C21.06,5.44 21.06,5 20.8,4.75L19.25,3.2C19.12,3.07 18.95,3 18.78,3M16.37,5.12L9,12.5V15H11.5L18.87,7.62L16.37,5.12Z"/>
            </svg>
            <span class="sr-only">What's Up</span>
        </span>
    </a>
</div>

