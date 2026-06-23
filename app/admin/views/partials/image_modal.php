<?php /** Shared image picker modal (upload + URL). Wired by admin-forms.js. */ ?>
<div class="adm-modal" data-img-modal hidden>
    <div class="adm-modal-scrim" data-img-cancel></div>
    <div class="adm-modal-box" role="dialog" aria-label="Set image">
        <div class="adm-modal-head"><span>Set image</span><button type="button" class="adm-modal-x" data-img-cancel aria-label="Close">&times;</button></div>
        <div class="adm-modal-tabs">
            <button type="button" class="on" data-tab="upload">Upload</button>
            <button type="button" data-tab="url">From URL</button>
        </div>
        <div class="adm-modal-body">
            <div data-tabpane="upload">
                <label class="adm-drop" data-drop>
                    <input type="file" accept="image/jpeg,image/png,image/webp" data-file hidden>
                    <span>Click to choose a JPG, PNG or WebP<br><small>maximum 4 MB</small></span>
                </label>
                <div class="adm-upload-status" data-upload-status></div>
            </div>
            <div data-tabpane="url" hidden>
                <label class="adm-field"><span>Image URL</span><input type="url" data-url-input placeholder="https://…"></label>
                <button type="button" class="adm-btn adm-btn--primary" data-url-use>Use this URL</button>
            </div>
        </div>
    </div>
</div>
<template data-gallery-template>
    <div class="adm-gallery-item" data-gallery-item>
        <img src="" alt="">
        <input type="hidden" name="gallery[]" value="">
        <div class="adm-gallery-ctrls">
            <button type="button" data-g-up aria-label="Move up">↑</button>
            <button type="button" data-g-down aria-label="Move down">↓</button>
            <button type="button" data-g-remove aria-label="Remove">✕</button>
        </div>
    </div>
</template>
