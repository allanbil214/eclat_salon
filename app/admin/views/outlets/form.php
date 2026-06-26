<?php
$x = $o ?? ['id'=>0,'name'=>'','slug'=>'','city'=>'','tagline'=>'','description'=>'','landmark'=>'','hero_label'=>'','google_rating'=>'','has_ladies_room'=>0,'address'=>'','phone'=>'','whatsapp'=>'','gmaps_url'=>'','lat'=>'','lng'=>'','photo_url'=>'','is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head">
    <h1 class="adm-h1"><?= $x['id'] ? 'Edit outlet' : 'New outlet' ?></h1>
    <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">← Back</a>
</div>

<form method="post" action="<?= e(admin_url('outlets/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">

    <label class="adm-field"><span>Name <small>· e.g. ÉCLAT Sudirman</small></span><input type="text" name="name" value="<?= e($x['name']) ?>" required></label>
    <label class="adm-field"><span>Slug <small>· URL-safe, auto-generated if blank · e.g. sudirman</small></span><input type="text" name="slug" value="<?= e($x['slug']) ?>" pattern="[a-z0-9-]+" placeholder="auto"></label>
    <label class="adm-field"><span>City <small>· e.g. Jakarta Pusat</small></span><input type="text" name="city" value="<?= e($x['city']) ?>"></label>
    <label class="adm-field"><span>Tagline <small>· short one-liner shown on the outlet card</small></span><input type="text" name="tagline" value="<?= e($x['tagline']) ?>" placeholder="e.g. Premium salon in the heart of Sudirman"></label>
    <label class="adm-field"><span>Description <small>· longer text shown on the outlet detail page</small></span><textarea name="description" rows="4"><?= e($x['description']) ?></textarea></label>
    <label class="adm-field"><span>Landmark <small>· nearby landmark to help customers find you</small></span><input type="text" name="landmark" value="<?= e($x['landmark']) ?>" placeholder="e.g. Next to Grand Indonesia mall"></label>
    <label class="adm-field"><span>Hero label <small>· badge text on the hero photo · e.g. "Now open"</small></span><input type="text" name="hero_label" value="<?= e($x['hero_label']) ?>" placeholder="e.g. Now open"></label>
    <label class="adm-field adm-field--sm"><span>Google rating <small>· 1.0 – 5.0</small></span><input type="number" name="google_rating" value="<?= e($x['google_rating']) ?>" min="1" max="5" step="0.1" placeholder="e.g. 4.8"></label>
    <label class="adm-field"><span>Full address</span><textarea name="address" rows="3"><?= e($x['address']) ?></textarea></label>
    <label class="adm-field"><span>Phone</span><input type="text" name="phone" value="<?= e($x['phone']) ?>" placeholder="+62 21 1234 5678"></label>
    <label class="adm-field"><span>WhatsApp number <small>· digits only, with country code · e.g. 6221123456780</small></span><input type="text" name="whatsapp" value="<?= e($x['whatsapp']) ?>" placeholder="6221..."></label>

    <label class="adm-field">
        <span>Google Maps URL</span>
        <input type="url" name="gmaps_url" value="<?= e($x['gmaps_url']) ?>" placeholder="https://maps.google.com/…" data-gmaps-input>
    </label>

    <!-- Map picker -->
    <div class="adm-field" data-outlet-map>
        <span>Location pin <small>· paste your Maps URL above then click "Extract", or click the map to place a pin</small></span>

        <div class="adm-map-toolbar">
            <button type="button" class="adm-btn" data-extract-btn>⌖ Extract from Maps URL</button>
            <span class="adm-map-feedback" data-map-feedback></span>
        </div>

        <div class="adm-map-canvas" data-map-canvas></div>

        <div class="adm-map-coords">
            <label class="adm-field adm-field--sm">
                <span>Latitude</span>
                <input type="number" name="lat" step="0.0000001" placeholder="e.g. -6.2088"
                    value="<?= ($x['lat'] !== null && $x['lat'] !== '') ? e($x['lat']) : '' ?>"
                    data-lat-input>
            </label>
            <label class="adm-field adm-field--sm">
                <span>Longitude</span>
                <input type="number" name="lng" step="0.0000001" placeholder="e.g. 106.8456"
                    value="<?= ($x['lng'] !== null && $x['lng'] !== '') ? e($x['lng']) : '' ?>"
                    data-lng-input>
            </label>
        </div>
    </div>

    <div class="adm-field">
        <span>Photo</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview">
                <?php if (!empty($x['photo_url'])): ?><img src="<?= e(image($x['photo_url'])) ?>" alt=""><?php endif; ?>
            </div>
            <input type="hidden" name="photo_url" value="<?= e($x['photo_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions">
                <button type="button" class="adm-btn" data-img-pick>Choose photo</button>
                <button type="button" class="adm-btn" data-img-clear>Remove</button>
            </div>
        </div>
    </div>

    <div class="adm-field adm-field--check">
        <label><input type="checkbox" name="has_ladies_room" value="1"<?= $x['has_ladies_room'] ? ' checked' : '' ?>> Has ladies room</label>
    </div>
    <div class="adm-field adm-field--check">
        <label><input type="checkbox" name="is_active" value="1"<?= $x['is_active'] ? ' checked' : '' ?>> Active (visible on site)</label>
    </div>
    <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save outlet</button>
        <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">Cancel</a>
    </div>
</form>
