<?php
render_admin('hours/index', ['title' => 'Opening hours', 'active' => 'hours', 'hours' => get_all_opening_hours()]);
