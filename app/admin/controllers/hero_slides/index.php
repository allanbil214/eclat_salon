<?php
render_admin('hero_slides/index', [
    'title'  => 'Hero Slides',
    'active' => 'hero_slides',
    'items'  => get_all_hero_slides(),
]);
