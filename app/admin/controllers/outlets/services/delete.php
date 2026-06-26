<?php
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$id        = (int) ($_POST['id'] ?? 0);
if ($id) {
    qexec('DELETE FROM outlet_services WHERE id = :id AND outlet_id = :oid', ['id' => $id, 'oid' => $outlet_id]);
    flash('Service removed.');
}
admin_redirect('/outlets/services?outlet_id=' . $outlet_id);
