<?php
$id   = (int) ($_GET['id'] ?? 0);
$item = $id ? get_hero_slide_by_id($id) : null;
if ($id && !$item) { admin_redirect('/hero-slides'); }
render_admin('hero_slides/form', [
    'title'  => $item ? 'Edit slide' : 'New slide',
    'active' => 'hero_slides',
    'item'   => $item,
]);
