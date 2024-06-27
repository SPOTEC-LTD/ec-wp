<?php

function announcements_list($request) {
    $posts_per_page = 5;

    if (!empty($request)) {
        $params = $request->get_body_params();
        $posts_per_page = $params['count'] + 5;
    }

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news_taxonomy',
                'field' => 'slug',
                'terms' => 'announcement',
            ),
        ),
    );
    $announcements_query = new WP_Query($args);

    $allPosts = array(
        'post_type' => 'news',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news_taxonomy',
                'field' => 'slug',
                'terms' => 'announcement',
            ),
        ),
    );
    $numOfPosts = new WP_Query($allPosts);
    $numOfPosts = $numOfPosts->post_count;

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news_taxonomy',
                'field' => 'slug',
                'terms' => 'news',
            ),
        ),
    );
    $recent_news_query = new WP_Query($args);

    if (!empty($announcements_query->posts)) {
        ob_start(); ?>
        <div class="ann-outer-container">
            <div class="announcements-list">
                <div class="loading-container">
                    <div class="spinner-container">
                        <div class="spinner"></div>
                    </div>
                </div>
                <div class="show-more-announcements">
                    <?php foreach ($announcements_query->posts as $announcement) {
                        $post_date = get_the_date('M d, Y g:i A', $announcement->ID);
                        //  $post_date = get_the_date('Y-m-d H:i', $announcement->ID);
                        ?>
                        <div class="post-container">
                            <a href="<?= get_permalink($announcement->ID); ?>">
                                <div class="title"><?= $announcement->post_title; ?></div>
                                <div class="date-views-cont">
                                    <div class="date">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                        </svg>
                                        <?= $post_date; ?>
                                    </div>
                                    <div class="views">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                        </svg>
                                        <?= ec_get_post_view($announcement->ID); ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } if ($numOfPosts > $posts_per_page) { ?>
                        <div class="btn-box"><button data-count="<?= $posts_per_page; ?>" id="more-ann-btn"><?= esc_html__('More', 'news'); ?></button></div>
                    <?php } ?>
                </div>
            </div>
            <div class="recent-news-container">
                <div class="header"><?= esc_html__('News', 'news'); ?></div>
                <?php foreach ($recent_news_query->posts as $news_post) { ?>
                    <a href="<?= get_permalink($news_post->ID) ?>" class="news-permalink">
                        <div class="recent-news">
                            <div class="thumbnail"><?= get_the_post_thumbnail( $news_post->ID, 'medium' ); ?></div>
                            <div class="info">
                                <div class="title"><?= $news_post->post_title; ?></div>
                                <div class="date"><?= $post_date; ?></div>
                                <div class="description"><?= $news_post->post_excerpt; ?></div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
                <div class="more-details">
                    <a href="<?= home_url('news'); ?>"><?= esc_html__('See more','news'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    <?php }
    return ob_get_clean();
}
add_shortcode('announcements_list', 'announcements_list');

function fetch_more_announcements($request) {
    if (empty($request)) return;

    $params = $request->get_body_params();
    $posts_per_page = $params['count'] + 5;

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news_taxonomy',
                'field' => 'slug',
                'terms' => 'announcement',
            ),
        ),
    );
    $announcements_query = new WP_Query($args);

    $allPosts = array(
        'post_type' => 'news',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'news_taxonomy',
                'field' => 'slug',
                'terms' => 'announcement',
            ),
        ),
    );
    $numOfPosts = new WP_Query($allPosts);
    $numOfPosts = $numOfPosts->post_count;
    ob_start();

    foreach ($announcements_query->posts as $announcement) {
        $post_date = get_the_date('M d, Y g:i A', $announcement->ID);
        //  $post_date = get_the_date('Y-m-d H:i', $announcement->ID);
        ?>
        <div class="post-container">
            <a href="<?= get_permalink($announcement->ID); ?>">
                <div class="title"><?= $announcement->post_title; ?></div>
                <div class="date-views-cont">
                    <div class="date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        </svg>
                        <?= $post_date; ?>
                    </div>
                    <div class="views">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                        </svg>
                        <?= ec_get_post_view($announcement->ID); ?>
                    </div>
                </div>
            </a>
        </div>
    <?php } if ($numOfPosts > $posts_per_page) { ?>
        <div class="btn-box"><button data-count="<?= $posts_per_page; ?>" id="more-ann-btn"><?= esc_html__('More', 'news'); ?></button></div>
    <?php }
    return ob_get_clean();
}