<?php
render_admin('dashboard', [
    'title'  => 'Dashboard',
    'active' => 'dashboard',
    'admin'  => current_admin(),
    'd'      => admin_dashboard_data(),
    'chart'  => true,
]);
