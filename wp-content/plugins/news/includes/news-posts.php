<?php

function fetch_more_news($request) {
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
                'terms' => 'news',
            ),
        ),
    );
    $news_query = new WP_Query($args);

    $allPosts = array(
        'post_type' => 'news',
        'posts_per_page' => -1,
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
    $numOfPosts = new WP_Query($allPosts);
    $numOfPosts = $numOfPosts->post_count;
    ob_start();
    foreach ($news_query->posts as $news_post) {
        $post_date = get_the_date('M d, Y g:i A', $news_post->ID);
        $time_diff = human_time_diff(get_the_time('U', $news_post->ID), current_time('timestamp'));
        ?>
        <div class="news-post-box">
            <div class="thumbnail">
                <a href="<?= get_permalink($news_post->ID); ?>"><?= get_the_post_thumbnail( $news_post->ID, 'full' ); ?></a>
            </div>
            <div>
                <a class="title" href="<?= get_permalink($news_post->ID); ?>"><?= $news_post->post_title; ?></a>
                <div class="date-views">
                    <div class="date"><?= $time_diff . ' ago (' . $post_date . ')'; ?></div>
                    <div class="views"><?= ec_get_post_view($news_post->ID) . ' View'; ?></div>
                </div>
                <div class="description"><?= $news_post->post_excerpt; ?></div>
            </div>
        </div>
    <?php }
    if ($numOfPosts > $posts_per_page) { ?>
        <div class="btn-box"><button data-count="<?= $posts_per_page; ?>" id="more-btn"><?= esc_html__('More', 'news'); ?></button></div>
    <?php }
    return ob_get_clean();
}
function news_list() {
    $posts_per_page = 5;

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
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
    $news_query = new WP_Query($args);
    $allPosts = array(
        'post_type' => 'news',
        'posts_per_page' => -1,
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
    $numOfPosts = new WP_Query($allPosts);
    $numOfPosts = $numOfPosts->post_count;

    $args2 = array(
        'post_type' => 'news',
        'posts_per_page' => '5',
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
    $announcements_query = new WP_Query($args2);


    if (!empty($news_query->posts)) {
        ob_start(); ?>
        <div class="news-outer-container">
            <div class="news-container">
                <div class="loading-container">
                    <div class="spinner-container">
                        <div class="spinner"></div>
                    </div>
                </div>
                <div class="show-more-news">
                    <?php foreach ($news_query->posts as $news_post) {
                        $post_date = get_the_date('M d, Y g:i A', $news_post->ID);
                        $time_diff = human_time_diff(get_the_time('U', $news_post->ID), current_time('timestamp'));
                        ?>
                        <div class="news-post-box">
                            <div class="thumbnail">
                                <a href="<?= get_permalink($news_post->ID); ?>"><?= get_the_post_thumbnail( $news_post->ID, 'full' ); ?></a>
                            </div>
                            <div>
                                <a class="title" href="<?= get_permalink($news_post->ID); ?>"><?= $news_post->post_title; ?></a>
                                <div class="date-views">
                                    <div class="date"><?= $time_diff . ' ago (' . $post_date . ')'; ?></div>
                                    <div class="views"><?= ec_get_post_view($news_post->ID) . ' View'; ?></div>
                                </div>
                                <div class="description"><?= $news_post->post_excerpt; ?></div>
                            </div>
                        </div>
                    <?php }
                    if ($numOfPosts > $posts_per_page) { ?>
                        <div class="btn-box"><button data-count="<?= $posts_per_page; ?>" id="more-btn"><?= esc_html__('More', 'news'); ?></button></div>
                    <?php } ?>
                </div>
            </div>
            <div class="announcements-cont">
                <div class="header"><?= esc_html__('Announcements', 'news'); ?></div>
                <?php if (!empty($announcements_query->posts)) {
                    foreach ($announcements_query->posts as $announcement) {
                        $post_date = get_the_date('M d, Y g:i A', $announcement->ID);
                        ?>
                        <div class="post-container">
                            <a href="<?= get_permalink($announcement->ID); ?>">
                                <div class="title-container">
                                    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.906 7.698A8.35 8.35 0 0017.03 4.64c-.121-.077-.229-.129-.361-.129-.334 0-.606.289-.606.643 0 .24.125.45.341.575 2.09 1.297 3.39 3.698 3.39 6.267 0 2.566-1.298 4.966-3.386 6.263-.172.1-.357.307-.357.584 0 .354.272.643.607.643a.667.667 0 00.355-.124 8.348 8.348 0 002.887-3.06A8.922 8.922 0 0021 11.998c0-1.514-.378-3-1.094-4.3zm-2.207 4.299c0-.893-.224-1.77-.648-2.536a4.911 4.911 0 00-1.701-1.8l-.002-.001c-.02-.012-.204-.11-.34-.11-.336 0-.61.288-.61.644a.66.66 0 00.302.563c1.095.661 1.775 1.902 1.775 3.24 0 1.365-.701 2.62-1.83 3.273l-.002.002a.648.648 0 00-.29.55c0 .357.273.647.608.647h.003a.787.787 0 00.309-.087l.002-.002c1.495-.887 2.424-2.566 2.424-4.383zm-5.042-8.92a.7.7 0 00-.773.091l-.003.003c-.105.088-1.055.889-2.09 1.7C7.92 6.334 7.352 6.596 7.24 6.638H4.865a.478.478 0 00-.042.002H3.607c-.335 0-.607.288-.607.642v9.436c0 .354.272.641.607.641l4.076.001c.108.046.642.316 2.3 1.753.566.49 1.22 1.08 1.841 1.66l.032.03a.7.7 0 00.782.128.796.796 0 00.45-.702l.005-3.211-.026-13.249a.77.77 0 00-.41-.693zm-.788 13.838l-.01 2.055c-.309-.278-.608-.541-.89-.784-2.27-1.954-2.838-2.117-3.226-2.117-.008 0-.014 0-.019.002h-.003-.003l-.019-.002H4.635c-.352 0-.429-.086-.429-.482V8.345c0-.278.03-.409.301-.409h2.76c.378 0 .955-.161 3.434-2.092.378-.295.777-.612 1.159-.922l.01 11.993z" fill="#000"></path></svg>
                                    <div class="details-box">
                                        <div class="post-title"><?= $announcement->post_title; ?></div>
                                        <div class="date"><?= $post_date; ?></div>
                                        <div class="description"><?= $announcement->post_excerpt; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php }
                } ?>
                <div class="see-more-container">
                    <a href="<?= home_url('announcements'); ?>"><?= esc_html__('See More','news'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}
add_shortcode('news_list', 'news_list');