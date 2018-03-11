<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;

$wpdb->query(
    $wpdb->prepare(
        "delete from {$wpdb->options} where option_name like %s",
        ['fawpami_icon_%']
    )
);
