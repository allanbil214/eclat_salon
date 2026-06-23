<?php
render_admin('gallery/index', ['title' => 'Gallery', 'active' => 'gallery', 'items' => get_all_gallery_items(), 'cats' => get_gallery_categories()]);
