<?php

/**
 * Plugin Name: Podcast Importer
 * Description: WordPress plugin to import podcasts from JSON file
 * Author: <a href="https://bryanbloomquist.com">Bryan Bloomquist</a>
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/classes/model/PodcastImporterModel.php';
require_once __DIR__ . '/classes/view/PodcastImporterView.php';
require_once __DIR__ . '/functions/custom-post-type.php';
require_once __DIR__ . '/functions/custom-post-type-support.php';

use Podcast\Classes\Model\PodcastImporterModel as PIModel;
use Podcast\Classes\View\PodcastImporterView as PIView;

/**
 * podcast-importer Podcast Importer. JSON file importer.
 * This file will act as our "controller"
 * @class   BlueQuestPodcastImporter
 * @package BlueQuestPodcastImporter
 */

class PodcastImporter {
    /**
     * Creates the menu item and admin page,
     * along with their functions
     */
    public static function admin() {
        add_menu_page(
            'Podcast Importer',
            'Podcast Importer',
            'manage_options',
            'podcast_importer',
            [self::class, 'display'],
            'dashicons-database-add',
            27
        );
    }

    /**
     * Basic view for the admin importer page
     */
    public static function display() {
        $output  = '<div class="wrap">';
        $output .= PIView::addTitle('Podcast Importer');
        if (isset($_FILES['upload-file']['tmp_name'])) {
            $data = PIModel::parseUploadedFile($_FILES['upload-file']['tmp_name']);
            if($data['type'] === 'success') {
                $output .= PIView::displaySuccess($data['count']);
            } elseif ($data['type'] === 'error') {
                $output .= PIView::displayErrors($data['errors']);
            }
        } else {
            $output .= '<p>Please select a JSON file to upload and add to Podcasts.</p>';
            $output .= PIView::addUploadForm();
        }
        $output .= '</div>';

        echo $output;
    }
}

add_action('admin_menu', ['PodcastImporter', 'admin']);