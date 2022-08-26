<?php

/**
 * add Meta data to custom post type 'podcast'
 */
class PodcastMetaData {
    /**
     * Add custom meta box for Podcast custom post type
     * @return void
     */
    public static function add() {
        $screens = ['podcast'];
        foreach($screens as $screen) {
            add_meta_box(
                'podcast_meta_data',
                'Podcast Meta Data',
                [self::class, 'html'],
                $screen
            );
        }
    }

    /**
     * Display Podcast custom meta data
     * @param $post
     * @return void
     */
    public static function html($post) {
        $publisher    = get_post_meta( $post->ID, 'podcast_publisher', true );
        $episodeCount = get_post_meta( $post->ID, 'podcast_episode_count', true );
        $itunesId     = get_post_meta( $post->ID, 'podcast_itunes_id', true );
        $rssFeedLink  = get_post_meta( $post->ID, 'podcast_rss_feed_link', true );
        $webLink      = get_post_meta( $post->ID, 'podcast_web_link', true );
?>
        <label for="podcast_publisher">Podcast Publisher:</label>
        <br>
        <input type="text" name="podcast_publisher" id="podcast_publisher" class="postbox" value="<?php echo $publisher; ?>" />
        <br>
        <label for="podcast_episode_count">Episode Count:</label>
        <br>
        <input type="number" name="podcast_episode_count" id="podcast_episode_count" class="postbox" value="<?php echo $episodeCount; ?>"/>
        <br>
        <label for="podcast_itunes_id">iTunes Id:</label>
        <br>
        <input type="url" name="podcast_itunes_id" id="podcast_itunes_id" class="postbox"  value="<?php echo $itunesId; ?>"/>
        <br>
        <label for="podcast_rss_feed_link">RSS Feed Link:</label>
        <br>
        <input type="url" name="podcast_rss_feed_link" id="podcast_rss_feed_link" class="postbox"  value="<?php echo $rssFeedLink; ?>"/>
        <br>
        <label for="podcast_web_link">Web Link:</label>
        <br>
        <input type="url" name="podcast_web_link" id="podcast_web_link" class="postbox"  value="<?php echo $webLink; ?>"/>
<?php
    }

    /**
     * Save custom post meta if any of it is touched
     * @param $post_id
     * @return void
     */
    public static function save( $post_id ) {
        if ( array_key_exists( 'podcast_publisher', $_POST ) ) {
            update_post_meta($post_id, 'podcast_publisher', $_POST['podcast_publisher']);
        }
        if ( array_key_exists( 'podcast_episode_count', $_POST ) ) {
            update_post_meta($post_id, 'podcast_episode_count', filter_var($_POST['podcast_episode_count'], FILTER_SANITIZE_NUMBER_INT));
        }
        if ( array_key_exists( 'podcast_itunes_id', $_POST ) ) {
            update_post_meta($post_id, 'podcast_itunes_id', filter_var($_POST['podcast_itunes_id'], FILTER_SANITIZE_URL));
        }
        if ( array_key_exists( 'podcast_rss_feed_link', $_POST ) ) {
            update_post_meta($post_id, 'podcast_rss_feed_link', filter_var($_POST['podcast_rss_feed_link'], FILTER_SANITIZE_URL));
        }
        if ( array_key_exists( 'podcast_web_link', $_POST ) ) {
            update_post_meta($post_id, 'podcast_web_link', filter_var($_POST['podcast_web_link'], FILTER_SANITIZE_URL));
        }
    }
}

add_action('add_meta_boxes', ['PodcastMetaData', 'add']);
add_action('save_post', ['PodcastMetaData', 'save']);