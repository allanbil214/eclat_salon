<?php
$id = (int) ($_GET['id'] ?? 0);
$b  = $id ? get_booking_request_by_id($id) : null;
if (!$b) { flash('That booking request no longer exists.', 'err'); admin_redirect('/bookings'); }
render_admin('bookings/view', ['title' => 'Booking from ' . $b['name'], 'active' => 'bookings', 'b' => $b]);
