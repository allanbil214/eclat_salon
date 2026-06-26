<?php
$hours = q('SELECT h.id, h.day_order, h.day_name, h.open_time, h.close_time, h.is_closed
            FROM opening_hours h
            WHERE h.outlet_id IS NULL
            ORDER BY h.day_order ASC');
render_admin('hours/index', ['title' => 'Opening Hours — Main Branch', 'active' => 'hours', 'hours' => $hours]);
