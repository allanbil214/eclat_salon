<?php
$id = (int) ($_GET['id'] ?? 0);
$m  = $id ? get_team_member_by_id($id) : null;
if ($id && !$m) { flash('That team member no longer exists.', 'err'); admin_redirect('/team'); }
render_admin('team/form', ['title' => $id ? 'Edit team member' : 'New team member', 'active' => 'team', 'm' => $m]);
