<?php /** Vars: $settings */
$s = $settings;
$groups = [
    'Brand' => [['site_name','Site name','text'],['site_name_full','Full name','text'],['tagline','Tagline','text'],['currency_symbol','Currency symbol','text'],['founded_year','Founded year','text']],
    'Contact' => [['phone','Phone','text'],['whatsapp','WhatsApp number','text'],['email','Email','text'],['address','Address','textarea'],['map_url','Google Maps link','url']],
    'Social' => [['instagram','Instagram','text'],['facebook','Facebook','text'],['tiktok','TikTok','text'],['youtube','YouTube','text']],
    'Hero (home top)' => [['hero_eyebrow','Eyebrow','text'],['hero_title','Title','text'],['hero_lead','Lead paragraph','textarea']],
    'About & booking' => [['about_eyebrow','About eyebrow','text'],['about_title','About title','text'],['booking_note','Booking note','textarea']],
];
?>
<div class="adm-head"><h1 class="adm-h1">Settings</h1></div>
<form method="post" action="<?= e(admin_url('settings/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <?php foreach ($groups as $group => $fields): ?>
        <div class="adm-panel adm-settings-group">
            <div class="adm-panel-h"><?= e($group) ?></div>
            <?php foreach ($fields as [$key, $label, $type]): $val = $s[$key] ?? ''; ?>
                <label class="adm-field">
                    <span><?= e($label) ?></span>
                    <?php if ($type === 'textarea'): ?>
                        <textarea name="<?= e($key) ?>" rows="3"><?= e($val) ?></textarea>
                    <?php else: ?>
                        <input type="<?= $type === 'url' ? 'url' : 'text' ?>" name="<?= e($key) ?>" value="<?= e($val) ?>">
                    <?php endif; ?>
                </label>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save settings</button></div>
</form>
