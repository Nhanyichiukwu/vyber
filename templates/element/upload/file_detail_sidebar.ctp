<?php ?>
<div class="uploaded-file-metadata has-progress-bar">
    <div class="file-sample"></div>
    <div class="file-meta permalink" aria-copiedby="click">
        <div class="form-group">
            <label class="form-label">Permalink</label>
            <div class="input-group align-items-center">
                <input name="permalink" id="permalink" type="text" class="bdrs-20 form-control text-right mr-2" aria-label="Permalink" readonly>
                <button type="button" class="btn btn-outline-secondary bdrs-20 input-group-text mr-2" onclick="copyToClipboard('#permalink')">Copy</button>
                <a href="javascript:void(0)" class="btn btn-outline-secondary bdrs-20 input-group-text" onclick="shareLink()" data-src="#permalink">
                    <i class="mdi mdi-share-variant"></i>
                </a>
                
            </div>
        </div>
    </div>
    <div class="progress upload-progress h-2 my-3">
        <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <span class="sr-only">0% Complete</span>
        </div>
    </div>
</div>
