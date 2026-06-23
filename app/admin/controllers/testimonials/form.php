<?php
$id = (int) ($_GET['id'] ?? 0);
$t  = $id ? get_testimonial_by_id($id) : null;
if ($id && !$t) { flash('That testimonial no longer exists.', 'err'); admin_redirect('/testimonials'); }
render_admin('testimonials/form', ['title' => $id ? 'Edit testimonial' : 'New testimonial', 'active' => 'testimonials', 't' => $t]);
