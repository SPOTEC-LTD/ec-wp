<?php
/**
 * Plugin Name: Live Prices
 * Description: Displays real-time prices in a table
 * Author: EcMarkets
 * Version: 1.0
 * Plugin URI: https://ecmarkets.sc
 * Author URI: https://ecmarkets.sc
 * Text Domain: live-prices
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly.

function live_prices_enqueue_scripts() {
//    global $post;
//    if (is_a($post, 'WP_Post') &&
//        (has_shortcode($post->post_content, 'live_prices_tabs') || has_shortcode($post->post_content, 'default_symbols')))
//    {
        $plugin_dir = plugin_dir_url(__FILE__);

        wp_enqueue_script('jquery');
        wp_enqueue_script('live-prices', $plugin_dir . 'js/live-prices.js', array('jquery'), SCRIPT_VERSION, true);
        wp_enqueue_style('live-prices', $plugin_dir . 'css/live-prices.css', array(), SCRIPT_VERSION);

        //Bootstrap
        wp_enqueue_script('bootstrap-bundle', $plugin_dir . 'bootstrap/bootstrap.bundle.min.js', array(), SCRIPT_VERSION, true);
        wp_enqueue_script('bootstrap', $plugin_dir . 'bootstrap/bootstrap.min.js', array(), SCRIPT_VERSION, true);
        wp_enqueue_style('bootstrap', $plugin_dir . 'bootstrap/bootstrap.min.css', array(), SCRIPT_VERSION);

        wp_localize_script('live-prices', 'livePricesObj', array(
            'rest_url' => rest_url('live-prices/v1/create_table'),
            'nonce' => wp_create_nonce('wp_rest'),
        ));
//    }
}
add_action('wp_enqueue_scripts', 'live_prices_enqueue_scripts');

add_action( 'rest_api_init', function () {
    register_rest_route( 'live-prices/v1', '/create_table', array(
        'methods' => 'POST',
        'callback' => 'create_table',
        'permission_callback' => '__return_true',
    ) );
} );

function create_table($request) {
    $market = 'popular';
    if (!empty($request)) {
        $params = $request->get_body_params();
        $market = $params['market'];
    }
    $plugin_dir = plugin_dir_path(__FILE__);
    $jsonData = file_get_contents($plugin_dir.'/json/'.$market.'.json');
    $jsonDataArr = array();

    if (!empty($jsonData)) {
        $jsonDataArr = json_decode($jsonData, true);
    }

    ob_start();
    ?>
    <table class="live-prices-table">
        <thead>
            <tr>
                <th><?= esc_html__('INSTRUMENT','live-prices'); ?></th>
                <th><?= esc_html__('DESCRIPTION','live-prices'); ?></th>
                <th><?= esc_html__('BID','live-prices'); ?></th>
                <th><?= esc_html__('ASK','live-prices'); ?></th>
                <th><?= esc_html__('CHANGE','live-prices'); ?></th>
                <th><?= esc_html__('SPREAD','live-prices'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jsonDataArr as $row) { ?>
                <tr>
                    <td>
                        <div class="symbol-icon">
                            <p class="symbol"><?= $row['symbolName']; ?></p>
                            <?php if (!empty($row['icon'])) {
                                echo '<img src="'.$row['icon'].'">';
                            } ?>
                        </div>
                    </td>
                    <td><?= $row['description']; ?></td>
                    <td class="bid">-</td>
                    <td class="ask">-</td>
                    <td class="change" data-closing_price="<?= $row['yesterdayClosePrice']; ?>">-</td>
                    <td class="spread" data-point="<?= $row['point']; ?>">-</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

function live_prices_tabs($shortcodeAtts) {
    ob_start();
    ?>
    <div class="live-prices-card">
        <ul class="nav nav-tabs" id="live-prices-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-id="popular" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular" type="button" role="tab" aria-controls="popular" aria-selected="true"><?= esc_html__('Popular','live-prices'); ?></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-id="forex" id="forex-tab" data-bs-toggle="tab" data-bs-target="#forex" type="button" role="tab" aria-controls="forex" aria-selected="false"><?= esc_html__('FOREX','live-prices'); ?></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-id="metals" id="metals-tab" data-bs-toggle="tab" data-bs-target="#metals" type="button" role="tab" aria-controls="metals" aria-selected="false"><?= esc_html__('METALS','live-prices'); ?></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-id="energy" id="energy-tab" data-bs-toggle="tab" data-bs-target="#energy" type="button" role="tab" aria-controls="metals" aria-selected="false"><?= esc_html__('ENERGY','live-prices'); ?></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-id="indices" id="indices-tab" data-bs-toggle="tab" data-bs-target="#indices" type="button" role="tab" aria-controls="indices" aria-selected="false"><?= esc_html__('INDICES','live-prices'); ?></button>
            </li>
            <?php if (empty($shortcodeAtts['crypto']) || $shortcodeAtts['crypto'] !== 'hide') { ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-id="cryptos" id="cryptos-tab" data-bs-toggle="tab" data-bs-target="#cryptos" type="button" role="tab" aria-controls="metals" aria-selected="false">
                        <?= esc_html__('CRYPTO', 'live-prices'); ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content" id="live-prices-tabs-content">
            <div class="loading-container">
                <div class="spinner-container">
                    <div class="spinner"></div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                <div class="table-container"><?= create_table(''); ?></div>
                <div class="more-details">
                    <a href="<?= home_url('trade/markets/forexpair'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="tab-pane fade" id="forex" role="tabpanel" aria-labelledby="forex-tab">
                <div class="table-container"></div>
                <div class="more-details">
                    <a href="<?= home_url('trade/markets/forexpair'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="tab-pane fade" id="metals" role="tabpanel" aria-labelledby="metals-tab">
                <div class="table-container"></div>
                <div class="more-details">
                    <a href="<?= home_url('trade/markets/precious'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="tab-pane fade" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                <div class="table-container"></div>
                <div class="more-details">
                    <a href="<?= home_url('trade/markets/crude'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="tab-pane fade" id="indices" role="tabpanel" aria-labelledby="indices-tab">
                <div class="table-container"></div>
                <div class="more-details">
                    <a href="<?= home_url('trade/markets/cfds'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                        </svg>
                    </a>
                </div>
            </div>
            <?php if (empty($shortcodeAtts['crypto']) || $shortcodeAtts['crypto'] !== 'hide') { ?>
                <div class="tab-pane fade" id="cryptos" role="tabpanel" aria-labelledby="cryptos-tab">
                    <div class="table-container"></div>
                    <div class="more-details">
                        <a href="<?= home_url('trade/markets/cryptocurrency'); ?>"><?= esc_html__('More Details','live-prices'); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </a>
                    </div>
                </div>
        <?php } ?>
        </div>
    </div>
    <?php return ob_get_clean();
}
add_shortcode('live_prices_tabs', 'live_prices_tabs');

function default_symbols() {
    ob_start();
    ?>
    <div class="default-symbols-container">
        <div class="inner">
            <div class="symbol">EURUSD</div>
            <div class="prices">
                <div style="text-align: left;">
                    <div class="title">BID</div>
                    <div class="bid">-</div>
                </div>
                <div style="text-align: right;">
                    <div class="title">ASK</div>
                    <div class="ask">-</div>
                </div>
            </div>
        </div>
        <div class="inner">
            <div class="symbol">XAUUSD</div>
            <div class="prices">
                <div style="text-align: left;">
                    <div class="title">BID</div>
                    <div class="bid">-</div>
                </div>
                <div style="text-align: right;">
                    <div class="title">ASK</div>
                    <div class="ask">-</div>
                </div>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}
add_shortcode('default_symbols', 'default_symbols');


