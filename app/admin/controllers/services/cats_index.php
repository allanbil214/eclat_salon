<?php
render_admin('services/cats_index', ['title' => 'Service categories', 'active' => 'services', 'cats' => get_all_service_categories()]);
