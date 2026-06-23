<?php
$keys = ['site_name','site_name_full','tagline','currency_symbol','founded_year',
         'phone','whatsapp','email','address','map_url',
         'instagram','facebook','tiktok','youtube',
         'hero_eyebrow','hero_title','hero_lead','about_eyebrow','about_title','booking_note'];
foreach ($keys as $k) {
    if (array_key_exists($k, $_POST)) put_setting($k, trim((string) $_POST[$k]));
}
flash('Settings saved.');
admin_redirect('/settings');
