<?php

/**
 * @author: Ankit Tiwari <ankittiwaari@gmail.com>
 * Plugin name: Post Slider
 * Version: 0.1
 * Author: Ankit Tiwari
 * Author uri: http://artofcoding.in
 * Plugin uri: http://artofcoding.in
 * Description: Plugin to meet case study 2 requirements
 */
add_shortcode('post_slider', 'post_slider_callback');

function post_slider_callback()
{
    $my_posts = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);
    $html = '<div class="flexslider carousel"><ul class="slides">';
    if ($my_posts->have_posts()) {
        while ($my_posts->have_posts()) {
            $my_posts->the_post();
            $html .= '<li>'
                    . '<div class="ps-title">' . get_the_title() . '</div>'
                    . '<div class="ps-content">' . get_the_content() . '</div>'
                    . '</li>';
        }
    }
    $html .= '</ul></div>';

    return $html;
}

add_action('wp_enqueue_scripts', 'ps_enqueue_scripts');

function ps_enqueue_scripts()
{
    global $post;
    if (has_shortcode($post->post_content, 'post_slider')) {
        $plugin_dir = plugin_dir_url(__FILE__);
        wp_enqueue_style('fs_slider', $plugin_dir . 'assets/css/flexslider.css');
        wp_enqueue_script('fs_slider_js', $plugin_dir . 'assets/js/jquery.flexslider.js', ['jquery'], 1.0, true);
        wp_enqueue_script('post_slider', $plugin_dir . 'assets/js/post_slider.js', ['jquery', 'fs_slider_js'], 1.0, true);
    }
}
