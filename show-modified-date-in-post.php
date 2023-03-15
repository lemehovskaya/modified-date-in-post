<?php
/**
 * Plugin Name: Show modified Date in post
 * Plugin URI: https://github.com/lemehovskaya/modified-date-in-post
 * Description: Shows a modified date in the post. It also shows the username that did the last update.
 * Author: lemehovskaya
 * Author URI: https://github.com/lemehovskaya
 * Text Domain: show-modified-date-in-admin-lists
 */

add_action( 'add_meta_boxes', 'add_custom_meatbox' );
function render_my_meta_box_text($post) {
    $m_orig		= $post->post_modified;
    $m_stamp	= strtotime( $m_orig );
    $modified	= date('F j, Y @ g:i A', $m_stamp );
    $modr_id	= get_post_meta( $post->ID, '_edit_last', true );
    $auth_id	= get_post_field( 'post_author', $post->ID, 'raw' );
    $user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
    $user_info	= get_userdata( $user_id );
    echo '<p class="mod-date">';
    echo '<em>'.$modified.'</em><br />';
    echo 'by <strong>'.$user_info->display_name.'<strong>';
    echo '</p>';
}
function add_custom_meatbox(){
    $post_types = get_post_types( array('public' => true) );
    foreach( $post_types as $post_type) {
        add_meta_box(
            'metabox_id',
            'Last Modified',
            'render_my_meta_box_text',
            $post_type,
            'normal',
            'high'
        );
    }
}