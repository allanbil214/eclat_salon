<?php
render_admin('bookings/index', ['title' => 'Booking requests', 'active' => 'bookings', 'rows' => get_booking_requests()]);
