<?php
render_admin('gallery/cats_index', ['title' => 'Gallery categories', 'active' => 'gallery', 'cats' => get_all_gallery_categories()]);
