<?php

use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Routing\Router;
use App\Utility\RandomString;

/* 
 * Photos
 */

?>
<?php if (isset($photos) && count($photos)): ?>
<div class="col-12">
        <?php foreach ($photos as $album => $items): ?>
    <div class="album-title">
        <div class="section-header">
            <h3 class="section-title album-<?= $album; ?>"><?= $album; ?></h3>
        </div>
    </div>
    <div class="gallery gallery-grid has-caption gap-0 row">
            <?php foreach ($items as $photo): ?>
                <?php if ('private' !== $photo->get('privacy')): ?>
        <div class="col-6 col-sm-3 px-1">
            <div class="image-box">
                <figure class="figure image-figure">
                    <a href="<?= Router::url(['contoller' => 'photo','action' => $photo->get('refid'), '']) ?>">
                        <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="">
                            <?php if (!empty($photo->get('caption'))): ?>
                        <figcaption class="mt-3 pr-4">
                            <h4 class="caption"><?= Text::truncate(h($photo->get('caption')), 60, ['ellipsis' => '...']); ?></h4>
                        </figcaption>
                            <?php endif; ?>
                    </a>
                </figure>
            </div>
        </div>
                <?php endif; ?>
            <?php endforeach; ?>
    </div>
        <?php endforeach; ?>
</div>
    <?php endif; ?>