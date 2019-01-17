<?php

/**
 * Plugin Name: Custom Loop with WP_Query class
 * Description: Demonstrate how to customize the WordPress Loop WP_Query class
 * Plugin URL: https://wpninja.pp.ua
 * Author: Vladimir Kamuz
 * Version: 1.0
 */

/**
 * Custom Loop shortcode [wp_query_example cat="3, 4"]
 */
function custom_loop_pre_shortcode_wp_query($atts){

    // define shortcode variable
    extract(shortcode_atts(array(
        'posts_per_page' => 5,
        'orderby' => 'date',
        'cat' => array(3, 4, 5, 8)
    ), $atts));

    // define get_posts parameters
    $args = array(
        'posts_per_page' => $posts_per_page,
        'orderby' => $orderby,
        'cat' => $cat
    );

    // query the posts
    $posts = new WP_Query($args);

    // begin output variable
    $output = '<h3>' . esc_html__('Custom Loop Example: WP_Query', 'myplugin') . '</h3>';

    if($posts->have_posts()){
        while($posts->have_posts()): $posts->the_post(); 
            $output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            $output .= '<p>' . wp_trim_words(get_the_content(), 70, '...') . '</p>';
            $output .= '<a class="btn btn-primary" href="' . get_permalink() . '">Read more...</a>';
            $output .= '<hr>';
        endwhile;
    }
    else{
        $output .= '<div class="alert alert-danger">' . esc_html__('Sorry, no posts matched your criteria.', 'myplugin') . '</div>';
    }

    // reset post data
    wp_reset_postdata();

    // return output
    return $output;

}

// register shortcode function
add_shortcode('wp_query_example', 'custom_loop_pre_shortcode_wp_query');