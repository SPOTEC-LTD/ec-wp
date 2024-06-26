<?php
/**
 * Plugin Name: Courses
 * Description: Educational lessons and courses
 * Author: EcMarkets
 * Version: 1.0
 * Plugin URI: https://ecmarkets.sc
 * Author URI: https://ecmarkets.sc
 * Text Domain: courses
 */

if (!function_exists( 'courses_post_type' )) {
    function courses_post_type() {
        register_post_type('courses',
            array(
                'labels' => array(
                    'name' => 'Courses',
                    'singular_name' => 'Course',
                ),
                'public' => true,
                'has_archive' => false,
                'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
                'show_ui'  => true,
                'show_in_rest' => true,
                'capability_type' => 'post',
                'query_var' => true,
                'menu_icon' => 'dashicons-book',
            )
        );

        register_taxonomy('courses_taxonomy', 'courses', array(
            'label' => 'Categories',
            'rewrite' => array('slug' => 'courses-taxonomy'),
            'hierarchical' => true,
            'show_in_rest' => true,
        ));
    }
}
add_action('init', 'courses_post_type');

function courses_enqueue_scripts() {
    $plugin_dir = plugin_dir_url(__FILE__);

    wp_enqueue_script('jquery');
    wp_enqueue_script('courses', $plugin_dir . 'js/courses.js', array('jquery'), SCRIPT_VERSION, true);
    wp_enqueue_style('courses', $plugin_dir . 'css/courses.css', array(), SCRIPT_VERSION);

    wp_localize_script('courses', 'coursesObj', array(
        'rest_url' => rest_url('courses/v1/courses_per_cat'),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}
add_action('wp_enqueue_scripts', 'courses_enqueue_scripts');

add_action( 'rest_api_init', function () {
    register_rest_route( 'courses/v1', '/courses_per_cat', array(
        'methods' => 'POST',
        'callback' => 'courses_per_cat',
        'permission_callback' => '__return_true',
    ) );
} );

function courses_list() {

    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
    );

    $courses_query = new WP_Query($args);
    $numOfPosts = $courses_query->post_count;

    $terms =  get_terms(array(
            'taxonomy' => 'courses_taxonomy',
            'orderby' => 'term_id',
            'hide_empty' => false,
        ));

    if (!empty($courses_query->posts)) {
        ob_start();
        ?>
        <div class="courses-container">
            <div class="categories">
                <button class="categoryBtn selected" data-slug=""><?= esc_html__('All', 'courses'); ?></button>
                <?php foreach ($terms as $term) { ?>
                    <button class="categoryBtn" data-slug="<?= $term->slug; ?>"><?= $term->name; ?></button>
                <?php } ?>
            </div>

            <div>
                <div class="loading-container">
                    <div class="spinner-container">
                        <div class="spinner"></div>
                    </div>
                </div>
                <div class="courses-posts">
                    <?php foreach ($courses_query->posts as $course) {
                        $cat = get_the_terms($course->ID, 'courses_taxonomy');
                        ?>
                        <div class="course-outer">
                            <div class="thumbnail"><?= get_the_post_thumbnail( $course->ID, 'full' ); ?></div>
                            <div class="desc">
                                <div class="title"><?= $course->post_title; ?></div>
                                <div class="cat-name"><?=  $cat[0]->name; ?></div>
                                <div class="excerpt"><?=  $course->post_excerpt; ?></div>
                            </div>
                            <a class="startBtn" href="<?= get_permalink($course->ID)?>"><?= esc_html__('Start Course', 'courses'); ?>
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="arrow-right-icon"><path d="M20.05 11.47l-7-7A.753.753 0 0012 5.55l5.71 5.7H4.48a.75.75 0 000 1.5H17.7l-5.7 5.7a.74.74 0 000 1.06.71.71 0 00.53.22.74.74 0 00.53-.22l7-7a.75.75 0 000-1.06l-.01.02z" fill="currentColor"></path></svg>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}
add_shortcode('courses_list', 'courses_list');

function courses_per_cat($request) {
    if (!empty($request)) {
        $params = $request->get_body_params();
        $category = $params['category'];
    }

    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
    );

    if (!empty($category)) {
        $args = array(
            'post_type' => 'courses',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'courses_taxonomy',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            ),
        );
    }
    $courses_query = new WP_Query($args);
    ob_start();
    foreach ($courses_query->posts as $course) {
        $cat = get_the_terms($course->ID, 'courses_taxonomy');
        ?>
        <div class="course-outer">
            <div class="thumbnail"><?= get_the_post_thumbnail( $course->ID, 'full' ); ?></div>
            <div class="desc">
                <div class="title"><?= $course->post_title; ?></div>
                <div class="cat-name"><?=  $cat[0]->name; ?></div>
                <div class="excerpt"><?=  $course->post_excerpt; ?></div>
            </div>
            <a class="startBtn" href="<?= get_permalink($course->ID)?>"><?= esc_html__('Start Course', 'courses'); ?>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="arrow-right-icon"><path d="M20.05 11.47l-7-7A.753.753 0 0012 5.55l5.71 5.7H4.48a.75.75 0 000 1.5H17.7l-5.7 5.7a.74.74 0 000 1.06.71.71 0 00.53.22.74.74 0 00.53-.22l7-7a.75.75 0 000-1.06l-.01.02z" fill="currentColor"></path></svg>
            </a>
        </div>
    <?php }
    return ob_get_clean();
}

function courses_custom_template($template) {
    if (is_singular('courses')) {
        // Define the path to your custom template file
        $plugin_template = plugin_dir_path(__FILE__) . 'single-course-template.php';

        // Check if the template file exists
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter('template_include', 'courses_custom_template');
