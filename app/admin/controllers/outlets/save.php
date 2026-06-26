<?php
$id          = (int) ($_POST['id'] ?? 0);
$name        = trim($_POST['name'] ?? '');
$slug        = trim($_POST['slug'] ?? '');
$city        = trim($_POST['city'] ?? '');
$tagline     = trim($_POST['tagline'] ?? '');
$description = trim($_POST['description'] ?? '');
$landmark    = trim($_POST['landmark'] ?? '');
$hero_label  = trim($_POST['hero_label'] ?? '');
$google_rating   = $_POST['google_rating'] !== '' ? (float) $_POST['google_rating'] : null;
$has_ladies_room = isset($_POST['has_ladies_room']) ? 1 : 0;
$address     = trim($_POST['address'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$whatsapp    = trim($_POST['whatsapp'] ?? '');
$gmaps       = trim($_POST['gmaps_url'] ?? '');
$lat         = $_POST['lat'] !== '' ? (float) $_POST['lat'] : null;
$lng         = $_POST['lng'] !== '' ? (float) $_POST['lng'] : null;
$photo       = trim($_POST['photo_url'] ?? '');
$active      = isset($_POST['is_active']) ? 1 : 0;
$sort        = (int) ($_POST['sort_order'] ?? 0);

// Auto-slug if blank
if ($slug === '' && $name !== '') {
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    $slug = trim($slug, '-');
}

if ($name === '') {
    flash('A name is required.', 'err');
    admin_redirect($id ? '/outlets/edit?id=' . $id : '/outlets/new');
}

if ($id) {
    qexec('UPDATE outlets SET name=:nm, slug=:sl, city=:ct, tagline=:tg, description=:dc, landmark=:lm, hero_label=:hl, google_rating=:gr, has_ladies_room=:hlr, address=:ad, phone=:ph, whatsapp=:wa, gmaps_url=:gm, lat=:lat, lng=:lng, photo_url=:pu, is_active=:ia, sort_order=:so WHERE id=:id',
        ['nm'=>$name,'sl'=>$slug,'ct'=>$city,'tg'=>$tagline,'dc'=>$description,'lm'=>$landmark,'hl'=>$hero_label,'gr'=>$google_rating,'hlr'=>$has_ladies_room,'ad'=>$address,'ph'=>$phone,'wa'=>$whatsapp,'gm'=>$gmaps,'lat'=>$lat,'lng'=>$lng,'pu'=>$photo,'ia'=>$active,'so'=>$sort,'id'=>$id]);
    flash('Outlet updated.');
} else {
    qexec('INSERT INTO outlets (name,slug,city,tagline,description,landmark,hero_label,google_rating,has_ladies_room,address,phone,whatsapp,gmaps_url,lat,lng,photo_url,is_active,sort_order) VALUES (:nm,:sl,:ct,:tg,:dc,:lm,:hl,:gr,:hlr,:ad,:ph,:wa,:gm,:lat,:lng,:pu,:ia,:so)',
        ['nm'=>$name,'sl'=>$slug,'ct'=>$city,'tg'=>$tagline,'dc'=>$description,'lm'=>$landmark,'hl'=>$hero_label,'gr'=>$google_rating,'hlr'=>$has_ladies_room,'ad'=>$address,'ph'=>$phone,'wa'=>$whatsapp,'gm'=>$gmaps,'lat'=>$lat,'lng'=>$lng,'pu'=>$photo,'ia'=>$active,'so'=>$sort]);
    flash('Outlet added.');
}
admin_redirect('/outlets');
