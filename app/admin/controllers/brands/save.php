<?php
$id      = (int) ($_POST['id'] ?? 0);
$name    = trim($_POST['name'] ?? '');
$logo    = trim($_POST['logo_url'] ?? '');
$website = trim($_POST['website_url'] ?? '');
$sort    = (int) ($_POST['sort_order'] ?? 0);

if ($name === '') {
    flash('A brand name is required.', 'err');
    admin_redirect($id ? '/brands/edit?id=' . $id : '/brands/new');
}
if ($id) {
    qexec('UPDATE brands SET name=:n, logo_url=:l, website_url=:w, sort_order=:s WHERE id=:id',
        ['n'=>$name,'l'=>$logo,'w'=>$website,'s'=>$sort,'id'=>$id]);
    flash('Brand updated.');
} else {
    qexec('INSERT INTO brands (name,logo_url,website_url,sort_order) VALUES (:n,:l,:w,:s)',
        ['n'=>$name,'l'=>$logo,'w'=>$website,'s'=>$sort]);
    flash('Brand added.');
}
admin_redirect('/brands');
