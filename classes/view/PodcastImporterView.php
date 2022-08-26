<?php

/**
 * Podcast Importer PodcastImporterView. JSON File Importer
 * @class   PodcastImporterView
 * @package PocastImporter\Classes
 */

namespace Podcast\Classes\View;

class PodcastImporterView {
    /**
     * Adds title in h1 tags based on passed string
     * @param $title string the title to be added
     * @return string
     */
    public static function addTitle(string $title): string {
        return "<h1>$title</h1>";
    }

    /**
     * Adds form for uploading JSON file
     * @return string
     */
    public static function addUploadForm(): string {
        $output  = '<form action="?page=podcast_importer" method="post" enctype="multipart/form-data">';
        $output .= '<input type="file" id="uploadFile" name="upload-file" value="" accept=".json" />';
        $output .= '<input type="submit" id="submitFIle" name="submit" value="Upload File" class="button button-primary" />';
        $output .= '</form>';

        return $output;
    }

    /**
     * Display success message after uploading podcasts from JSON file
     * @param $numberOfPodcasts int
     * @return string
     */
    public static function displaySuccess(int $numberOfPodcasts): string {
        return '<p>You have successfully uploaded ' . $numberOfPodcasts . ' podcasts.</p>';
    }

    /**
     * Display error message after uploading podcasts from JSON file doesn't work.
     * @param $errors string
     * @return string
     */
    public static function displayErrors(string $errors): string {
        $output  = '<p>There were errors while processing your file</p>';
        $output .= '<pre>';
        $output .= $errors;
        $output .= '</pre>';
        return $output;
    }
}