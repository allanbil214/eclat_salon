<?php
$id  = (int) ($_GET['id'] ?? 0);
$svc = $id ? get_service_by_id($id) : null;
if ($id && !$svc) { flash('That service no longer exists.', 'err'); admin_redirect('/services'); }
$cats = get_service_categories();
if (!$cats) { flash('Create a service category first.', 'err'); admin_redirect('/services/categories'); }
render_admin('services/form', ['title' => $id ? 'Edit service' : 'New service', 'active' => 'services', 'svc' => $svc, 'cats' => $cats]);
