<?php
$id  = (int) ($_GET['id'] ?? 0);
$faq = $id ? get_faq($id) : null;
if ($id && !$faq) { flash('That FAQ no longer exists.', 'err'); admin_redirect('/faq'); }
render_admin('faq/form', [
    'title'  => $id ? 'Edit FAQ' : 'New FAQ',
    'active' => 'faq',
    'faq'    => $faq,
]);
