<?php

/**
 * Podcast Importer PodcastImporterModel. JSON File Importer
 * @class   PodcastImporterModel
 * @package PocastImporter\Classes
 */

namespace Podcast\Classes\Model;

class PodcastImporterModel {
    /**
     * Attempt to grab data from JSON file
     * @param string $file
     * @return array|string|string[]
     */
    public static function parseUploadedFile($file) {
        try {
            $json = file_get_contents($file);
            $data = json_decode($json);
            return self::createPodcastArray($data);
        } catch(\Exception $e) {
            return "Error processing file.<br>" . print_r($e);
        }
    }

    /**
     * Create an array of podcasts from imported JSON data
     * @param object $data
     * @return array|string|string[]
     */
    public static function createPodcastArray($data) {
        try {
            $podcasts = [];
            $errors = '';
            $numberOfPodcasts = 0;

            if (!empty($data->podcasts)) {
                foreach ($data->podcasts as $podcast) {
                    $podcasts[] = $podcast;
                }
                foreach ($podcasts as $podcast) {
                    if ($return = self::createNewPodcast($podcast)) {
                        $numberOfPodcasts++;
                    } else {
                        $errors .= $return . PHP_EOL;
                    }
                }
            }
            return $errors == '' ? ['type' => 'success', 'count' => $numberOfPodcasts] : ['type' => 'failure', 'errors' => $errors];
        } catch (\Exception $e) {
            return "Error parsing data.<br>" . print_r($e);
        }
    }

    /**
     * Add Podcast data to new Podcast Custom Post Type
     * @param object $podcast
     * @return bool|string
     */
    private static function createNewPodcast($podcast) {
        try {
            $featuredImage = filter_var($podcast->thumbnail ?? '', FILTER_SANITIZE_URL);
            $publisher     = filter_var($podcast->publisher ?? '', FILTER_SANITIZE_STRING);
            $episodeCount  = filter_var($podcast->total_episodes ?? 0, FILTER_SANITIZE_NUMBER_INT);
            $itunesID      = filter_var($podcast->itunes_id ?? '', FILTER_SANITIZE_NUMBER_INT);
            $rss           = filter_var($podcast->rss ?? '', FILTER_SANITIZE_URL);
            $webLink       = filter_var($podcast->listennotes_url ?? '', FILTER_SANITIZE_URL);

            $podcastArray  = array(
                'post_content' => filter_var($podcast->description ?? '', FILTER_SANITIZE_STRING),
                'post_title'   => filter_var($podcast->title ?? '', FILTER_SANITIZE_STRING),
                'post_status'  => 'publish',
                'post_type'    => 'podcast'
            );

            $podcastID     = wp_insert_post($podcastArray);

            add_post_meta($podcastID, 'podcast_publisher', $publisher);
            add_post_meta($podcastID, 'podcast_episode_count', $episodeCount);
            add_post_meta($podcastID, 'podcast_itunes_id', $itunesID);
            add_post_meta($podcastID, 'podcast_rss_feed_link', $rss);
            add_post_meta($podcastID, 'podcast_web_link', $webLink);

            $featuredImageID = self::importFeaturedImage($featuredImage);

            set_post_thumbnail($podcastID, $featuredImageID);

            return true;
        } catch (\Exception $e) {
            return "Error in creating new podcast. <br>" . print_r($e);
        }
    }

    /**
     * Upload image to media gallery from url and return attachment id
     * @param $featuredImage
     * @return int|\WP_Error
     */
    private static function importFeaturedImage($featuredImage) {
        $uploadDirectory   = wp_upload_dir();
        $featuredImageData = file_get_contents($featuredImage);
        $featuredImageName = basename($featuredImage);

        if( wp_mkdir_p($uploadDirectory['path'])) {
            $uploadedFile = $uploadDirectory['path'] . '/' . $featuredImageName;
        } else {
            $uploadedFile = $uploadDirectory['basedir'] . '/' . $featuredImageName;
        }

        file_put_contents($uploadedFile, $featuredImageData);

        $wpFileType = wp_check_filetype($featuredImageName, null);
        $attachment = array(
            'post_mime_type' => $wpFileType['type'],
            'post_title'     => sanitize_file_name($featuredImageName),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        $attachmentID   = wp_insert_attachment($attachment, $uploadedFile);
        $attachmentData = wp_generate_attachment_metadata($attachmentID, $uploadedFile);

        wp_update_attachment_metadata($attachmentID, $attachmentData);

        return $attachmentID;
    }
}