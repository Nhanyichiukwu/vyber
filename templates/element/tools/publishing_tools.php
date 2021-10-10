<?php

/**
 *
 */
?>
<div role="button" class="eY tool btn btn-icon" content-type="photo" data-target="#e__composerModal">
    <label for="image-picker" class="n-Hk_Gw">
        <i class="mdi mdi-shape-circle-plus"></i>
    </label>
</div>
<div role="button" class="eY tool btn btn-icon" content-type="video" data-target="#e__composerModal">
    <label for="video-picker" class="n-Hk_Gw">
        <i class="mdi mdi-video"></i>
    </label>
</div>
<div role="button" class="eY tool btn btn-icon" content-type="music" data-target="#e__composerModal">
    <label for="music-picker" class="n-Hk_Gw">
        <i class="mdi mdi-music"></i>
    </label>
</div>
<div role="button" class="eY tool btn btn-icon" content-type="event" data-target="#e__composerModal">
    <span class="n-Hk_Gw">
    <i class="mdi mdi-calendar-today"></i>
    </span>
</div>
<div role="button" class="eY tool btn btn-icon" content-type="location" data-target="#e__composerModal">
    <span class="n-Hk_Gw">
    <i class="mdi mdi-map-marker-radius"></i>
    </span>
</div>
<div role="button" class="eY tool btn btn-icon" content-type="document" data-target="#e__composerModal">
    <label for="file-picker" class="n-Hk_Gw">
        <i class="mdi mdi-file-document"></i>
    </label>
</div>
<?php $this->start('publisherFileControls') ?>
<div class="d-none" aria-hidden="true" style="display: none;">
    <input type="file" class="media-uploader" accept="image/jpg,image/jpeg,image/png,image/gif,video/ogg,video/mpeg4,video/mp4,video/mov,audio/ogg,audio/mpeg3,audio/mp3,audio/wav" tabindex="0" multiple>
<!--    <input type="file" name="photos[]" id="image-picker" accept="image/*" class="file-upload__input" multiple="true">
<input type="file" name="videos[]" id="video-picker" accept="video/*" class="file-upload__input" multiple="true">
    <input type="file" name="music[]" id="music-picker" accept="audio/*" class="file-upload__input">
    <input type="file" name="documents[]" id="document-picker" accept="text/plain,application/docx,application/pdf,application/zip" class="file-upload__input">
    <input type="hidden" name="event" id="event" class="hidden" value="">
    <input type="hidden" name="location" id="location" class="hidden" value="">-->
</div>
<?php $this->end(); ?>
