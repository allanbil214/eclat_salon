<?php
render_admin('settings/index', ['title' => 'Settings', 'active' => 'settings', 'settings' => get_all_settings(), 'leaflet' => true]);
