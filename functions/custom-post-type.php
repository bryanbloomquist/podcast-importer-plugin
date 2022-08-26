<?php
/**
 * Register a custom post type called "podcast".
 * @see get_post_type_labels() for label keys.
 */
function register_podcast_post_type() {
    $labels = array(
        'name'                  => _x( 'Podcasts', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Podcast', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Podcasts', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Podcast', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Podcast', 'textdomain' ),
        'new_item'              => __( 'New Podcast', 'textdomain' ),
        'edit_item'             => __( 'Edit Podcast', 'textdomain' ),
        'view_item'             => __( 'View Podcast', 'textdomain' ),
        'all_items'             => __( 'All Podcasts', 'textdomain' ),
        'search_items'          => __( 'Search Podcasts', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Podcasts:', 'textdomain' ),
        'not_found'             => __( 'No podcasts found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No podcasts found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Podcast Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Podcast archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into podcast', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this podcast', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter podcasts list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Podcasts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Podcasts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'podcast' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-admin-media',
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
    );

    register_post_type( 'podcast', $args );
}

add_action( 'init', 'register_podcast_post_type' );