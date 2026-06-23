<?php
$id = (int) ($_GET['id'] ?? 0);
$st = $id ? get_stat_by_id($id) : null;
if ($id && !$st) { flash('That stat no longer exists.', 'err'); admin_redirect('/stats'); }
render_admin('stats/form', ['title' => $id ? 'Edit stat' : 'New stat', 'active' => 'stats', 'st' => $st]);
