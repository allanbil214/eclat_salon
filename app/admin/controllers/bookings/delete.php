<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM booking_requests WHERE id = :id', ['id' => $id]); flash('Booking request deleted.'); }
admin_redirect('/bookings');
