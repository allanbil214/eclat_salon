<?php
$id     = (int) ($_POST['id'] ?? 0);
$label  = trim($_POST['label'] ?? '');
$value  = (int) ($_POST['value'] ?? 0);
$prefix = trim($_POST['prefix'] ?? '');
$suffix = trim($_POST['suffix'] ?? '');
$active = isset($_POST['is_active']) ? 1 : 0;
$sort   = (int) ($_POST['sort_order'] ?? 0);
if ($label === '') {
    flash('A label is required.', 'err');
    admin_redirect($id ? '/stats/edit?id=' . $id : '/stats/new');
}
if ($id) {
    qexec('UPDATE stats SET label=:l, value=:v, prefix=:p, suffix=:su, is_active=:ia, sort_order=:so WHERE id=:id',
        ['l'=>$label,'v'=>$value,'p'=>$prefix,'su'=>$suffix,'ia'=>$active,'so'=>$sort,'id'=>$id]);
    flash('Stat updated.');
} else {
    qexec('INSERT INTO stats (label,value,prefix,suffix,is_active,sort_order) VALUES (:l,:v,:p,:su,:ia,:so)',
        ['l'=>$label,'v'=>$value,'p'=>$prefix,'su'=>$suffix,'ia'=>$active,'so'=>$sort]);
    flash('Stat added.');
}
admin_redirect('/stats');
