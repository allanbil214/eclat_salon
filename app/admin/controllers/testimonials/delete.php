<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM testimonials WHERE id = :id', ['id' => $id]); flash('Testimonial deleted.'); }
admin_redirect('/testimonials');
