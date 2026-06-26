<?php
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$id       = (int) ($_POST['id'] ?? 0);
$question = trim($_POST['question'] ?? '');
$answer   = trim($_POST['answer'] ?? '');
$sort     = (int) ($_POST['sort_order'] ?? 0);
$active   = isset($_POST['is_active']) ? 1 : 0;

if ($question === '' || $answer === '') {
    flash('Question and answer are both required.', 'err');
    $back = '/outlets/faq/' . ($id ? 'edit?outlet_id=' . $outlet_id . '&id=' . $id : 'new?outlet_id=' . $outlet_id);
    admin_redirect($back);
}

if ($id) {
    qexec(
        'UPDATE outlet_faq SET question=:q, answer=:a, sort_order=:s, is_active=:ia WHERE id=:id AND outlet_id=:oid',
        ['q'=>$question,'a'=>$answer,'s'=>$sort,'ia'=>$active,'id'=>$id,'oid'=>$outlet_id]
    );
    flash('FAQ updated.');
} else {
    qexec(
        'INSERT INTO outlet_faq (outlet_id, question, answer, sort_order, is_active) VALUES (:oid,:q,:a,:s,:ia)',
        ['oid'=>$outlet_id,'q'=>$question,'a'=>$answer,'s'=>$sort,'ia'=>$active]
    );
    flash('FAQ added.');
}
admin_redirect('/outlets/faq?outlet_id=' . $outlet_id);
