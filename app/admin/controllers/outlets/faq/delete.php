<?php
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$id        = (int) ($_POST['id'] ?? 0);
if ($id) {
    qexec('DELETE FROM outlet_faq WHERE id = :id AND outlet_id = :oid', ['id' => $id, 'oid' => $outlet_id]);
    flash('FAQ removed.');
}
admin_redirect('/outlets/faq?outlet_id=' . $outlet_id);
