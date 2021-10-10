<?php
use App\Utility\FileManager;
?>
<div class="table-responsive">
    <table class="card-table table table-striped table-bordered border-top table-hover table-vcenter bg-white">
        <thead>
            <tr>
                <th colspan="2" class="w-30 text-nowrap">File</th>
                <th class="text-nowrap">Type</th>
                <th class="text-nowrap">Size</th>
                <th class="text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pendingUpload as $file): ?>
            <tr>
                <td class="w-1 text-nowrap">
                    <?php
                    $b64 = 'data:' . $file->getClientMediaType() . ';base64,' . base64_encode($file->getStream());
                    ?>
                    <span class="avatar avatar-lg" style="background-image: url(<?= $b64 ?>)"></span>
                </td>
                <td class="text-nowrap"><?= $file->getClientFilename(); ?></td>
                <td class="w-25 text-nowrap"><?= FileManager::getFileClientType($file->getClientMediaType()); ?></td>
                <td class="text-nowrap"><?= $file->getSize(); ?></td>
                <td class="text-nowrap">
                    <div class="btn-group btn-group-sm">
                        
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
