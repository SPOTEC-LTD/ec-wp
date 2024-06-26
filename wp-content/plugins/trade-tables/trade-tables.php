<?php
/**
 * Plugin Name: Trade Tables
 * Description: Display dynamic trade tables
 * Author: EcMarkets
 * Version: 1.0
 * Plugin URI: https://ecmarkets.sc
 * Author URI: https://ecmarkets.sc
 * Text Domain: trade-tables
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly.


function register_trade_tables_scripts() {
    $plugin_dir = plugin_dir_url(__FILE__);

    wp_enqueue_script('datatables', $plugin_dir . 'datatables/dataTables.min.js', array('jquery'), SCRIPT_VERSION);
    wp_enqueue_style('datatables', $plugin_dir . 'datatables/dataTables.min.css', array(), SCRIPT_VERSION);

    wp_enqueue_script('trade-tables', $plugin_dir . 'js/trade_tables.js', array('jquery'), SCRIPT_VERSION);
    wp_enqueue_style('trade-tables', $plugin_dir . 'css/trade_tables.css', array(), SCRIPT_VERSION);
}
add_action('wp_enqueue_scripts', 'register_trade_tables_scripts');

function trade_table($shortcodeAtts) {
    if (empty($shortcodeAtts) || empty($shortcodeAtts['account']) || empty($shortcodeAtts['market'])) return;

    $account = $shortcodeAtts['account'];
    $market = $shortcodeAtts['market'];
    $plugin_dir = plugin_dir_path(__FILE__);
    $jsonData = file_get_contents($plugin_dir.'/json/'.$market.'.json');

    if (!empty($jsonData)) {
        $jsonData = json_decode($jsonData, true);
    }
    $jsonDataArr = array();
    if (!empty($jsonData[$account])) {
        $jsonDataArr = $jsonData[$account];
    }
    ob_start();
    ?>
    <div class="tradeTableContainer">
        <table class="dataTable display tradeTable">
            <thead>
                <tr>
                    <th><?= esc_html__('SYMBOL', 'trade-tables'); ?></th>
                    <th><?= esc_html__('DESCRIPTION', 'trade-tables'); ?></th>
                    <th><?= esc_html__('MINIMUM SPREAD', 'trade-tables'); ?></th>
                    <th><?= esc_html__('AVERAGE SPREAD', 'trade-tables'); ?></th>
                    <th><?= esc_html__('PIP VALUE', 'trade-tables'); ?></th>
                    <th><?= esc_html__('MINIMUM PRICE MOVEMENT', 'trade-tables'); ?></th>
                    <th><?= esc_html__('CONTRACT VALUE', 'trade-tables'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($jsonDataArr as $row) { ?>
                <tr>
                    <td><?= $row['symbolName']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['minSpread']; ?></td>
                    <td><?= $row['avgSpread']; ?></td>
                    <td><?= $row['pip']; ?></td>
                    <td><?= $row['point']; ?></td>
                    <td><?= $row['contractSize'] . ' USD'; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'trade_table', 'trade_table' );