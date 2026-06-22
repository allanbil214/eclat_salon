<?php
$id       = (int) ($_POST['id'] ?? 0);
$question = trim($_POST['question'] ?? '');
$answer   = trim($_POST['answer'] ?? '');
$sort     = (int) ($_POST['sort_order'] ?? 0);
$active   = isset($_POST['is_active']) ? 1 : 0;

if ($question === '' || $answer === '') {
    flash('Question and answer are both required.', 'err');
    admin_redirect($id ? '/faq/edit?id=' . $id : '/faq/new');
}

if ($id) {
    qexec('UPDATE faq SET question=:q, answer=:a, sort_order=:s, is_active=:ia WHERE id=:id',
        ['q' => $question, 'a' => $answer, 's' => $sort, 'ia' => $active, 'id' => $id]);
    flash('FAQ updated.');
} else {
    qexec('INSERT INTO faq (question, answer, sort_order, is_active) VALUES (:q,:a,:s,:ia)',
        ['q' => $question, 'a' => $answer, 's' => $sort, 'ia' => $active]);
    flash('FAQ added.');
}
admin_redirect('/faq');
