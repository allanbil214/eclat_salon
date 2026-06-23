<?php
$id     = (int) ($_POST['id'] ?? 0);
$author = trim($_POST['author'] ?? '');
$quote  = trim($_POST['quote'] ?? '');
$rating = (int) ($_POST['rating'] ?? 5);
$rating = max(1, min(5, $rating));
$service = trim($_POST['service'] ?? '');
$source  = trim($_POST['source'] ?? 'Google');
$active  = isset($_POST['is_active']) ? 1 : 0;
$sort    = (int) ($_POST['sort_order'] ?? 0);

if ($author === '' || $quote === '') {
    flash('Author and quote are both required.', 'err');
    admin_redirect($id ? '/testimonials/edit?id=' . $id : '/testimonials/new');
}
if ($id) {
    qexec('UPDATE testimonials SET author=:a, rating=:r, quote=:q, service=:sv, source=:so, is_active=:ia, sort_order=:srt WHERE id=:id',
        ['a'=>$author,'r'=>$rating,'q'=>$quote,'sv'=>$service,'so'=>$source,'ia'=>$active,'srt'=>$sort,'id'=>$id]);
    flash('Testimonial updated.');
} else {
    qexec('INSERT INTO testimonials (author,rating,quote,service,source,is_active,sort_order) VALUES (:a,:r,:q,:sv,:so,:ia,:srt)',
        ['a'=>$author,'r'=>$rating,'q'=>$quote,'sv'=>$service,'so'=>$source,'ia'=>$active,'srt'=>$sort]);
    flash('Testimonial added.');
}
admin_redirect('/testimonials');
