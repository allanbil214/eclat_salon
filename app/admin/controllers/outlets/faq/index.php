<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

render_admin('outlets/faq_index', [
    'title'  => 'FAQs — ' . $outlet['name'],
    'active' => 'outlets',
    'outlet' => $outlet,
    'rows'   => get_outlet_faqs($outlet_id),
]);
