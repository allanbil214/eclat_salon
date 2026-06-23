<?php
render_admin('articles/index', ['title' => 'Articles', 'active' => 'articles', 'posts' => get_all_posts()]);
