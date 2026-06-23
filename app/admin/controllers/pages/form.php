<?php
$id   = (int) ($_GET['id'] ?? 0);
$page = $id ? get_page_by_id($id) : null;
if ($id && !$page) { flash('That page no longer exists.', 'err'); admin_redirect('/pages'); }
render_admin('pages/form', [
    'title'  => $id ? 'Edit page' : 'New page',
    'active' => 'pages',
    'quill'  => true,
    'page'   => $page,
]);
