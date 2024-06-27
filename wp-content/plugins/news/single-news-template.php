<?php
get_header();

global $post;
ec_set_post_view($post->ID);

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

if (!empty($post->post_content)) {
    $post_date = get_the_date('M d, Y g:i A', $post->ID);
    ?>
    <div class="single-news-container">
        <div class="single-news">
            <div class="title"><?= $post->post_title; ?></div>
            <div class="content"><?= $post->post_content; ?></div>
            <div class="date-views">
                <div class="date"><?= $post_date; ?></div>
                <div class="views"><?='View ' . ec_get_post_view($post->ID); ?></div>
            </div>
        </div>
        <div class="recent-news-container">
            <?php foreach ($recent_news_query->posts as $news_post) { ?>
                <a href="<?= get_permalink($news_post->ID) ?>" class="news-permalink">
                    <div class="recent-news">
                        <div class="thumbnail"><?=  get_the_post_thumbnail( $news_post->ID, 'medium' ); ?></div>
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

get_footer();
