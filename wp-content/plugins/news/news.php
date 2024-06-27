<?php
/**
 * Plugin Name: News
 * Description: Articles about economic news
 * Author: EcMarkets
 * Version: 1.0
 * Plugin URI: https://ecmarkets.sc
 * Author URI: https://ecmarkets.sc
 * Text Domain: news
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly.

include 'includes/announcements.php';
include 'includes/news-posts.php';

if (!function_exists( 'news_post_type' )) {
    function news_post_type() {
        register_post_type('news',
            array(
                'labels' => array(
                    'name' => 'News',
                    'singular_name' => 'News',
                ),
                'public' => true,
                'has_archive' => false,
                'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
                'show_ui'  => true,
                'show_in_rest' => true,
                'capability_type' => 'post',
                'query_var' => true,
                'menu_icon' => 'dashicons-text-page',
            )
        );

        register_taxonomy('news_taxonomy', 'news', array(
            'label' => 'Categories',
            'rewrite' => array('slug' => 'news-taxonomy'),
            'hierarchical' => true,
            'show_in_rest' => true,
        ));
    }
}
add_action('init', 'news_post_type');

function news_enqueue_scripts() {
    $plugin_dir = plugin_dir_url(__FILE__);

    wp_enqueue_script('jquery');
    wp_enqueue_script('news', $plugin_dir . 'js/news.js', array('jquery'), SCRIPT_VERSION, true);
    wp_enqueue_style('news', $plugin_dir . 'css/news.css', array(), SCRIPT_VERSION);

    wp_localize_script('news', 'newsObj', array(
        'rest_url' => rest_url('news/v1/fetch_more_news'),
        'rest_url_2' => rest_url('news/v1/fetch_more_announcements'),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}
add_action('wp_enqueue_scripts', 'news_enqueue_scripts');

add_action( 'rest_api_init', function () {
    register_rest_route( 'news/v1', '/fetch_more_news', array(
        'methods' => 'POST',
        'callback' => 'fetch_more_news',
        'permission_callback' => '__return_true',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( 'news/v1', '/fetch_more_announcements', array(
        'methods' => 'POST',
        'callback' => 'fetch_more_announcements',
        'permission_callback' => '__return_true',
    ) );
} );


function news_custom_template($template) {
    global $post;

    if (is_singular('news')) {
        $cat = get_the_terms($post->ID, 'news_taxonomy');
        $category = $cat[0]->slug;

        $plugin_template = plugin_dir_path(__FILE__) . 'single-news-template.php';

        if ($category == 'announcement') {
            $plugin_template = plugin_dir_path(__FILE__) . 'single-announcement-template.php';
        }

        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter('template_include', 'news_custom_template');

function ec_get_post_view($post_id) {
    return get_post_meta($post_id, 'post_views_count', true ) ? : '0';
}
function ec_set_post_view($post_id) {
    $key = 'post_views_count';
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta($post_id, $key, $count);
}
function ec_posts_column_views($columns) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function ec_posts_custom_column_views() {
        $post_id = get_the_ID();
         echo ec_get_post_view($post_id);
}
add_filter( 'manage_posts_columns', 'ec_posts_column_views' );
add_action( 'manage_posts_custom_column', 'ec_posts_custom_column_views' );
