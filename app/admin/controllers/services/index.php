<?php
render_admin('services/index', ['title' => 'Services', 'active' => 'services', 'rows' => get_all_services(), 'cats' => get_service_categories()]);
