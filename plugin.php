<?php
/**
* Plugin Name: JS Image Compressor
* Description: This plugin compresses the uploaded image file on the fly and convert it into JPG format. The original uploaded file is replaced with new compressed one so be sure before using this plugin.
* Version: 1.1.0
* Author: JahaSoft
* Author URI: https://www.jahasoft.pk
**/

/* 
 * Wordpress media upload file we are 
 * using it to alter the file i-e compressing
 */ 

add_filter('wp_handle_upload_prefilter', 'js_ic_custom_upload_filter' );
function js_ic_custom_upload_filter( $file ) {
    $source = $destination = $file["tmp_name"];

    // Convert image to jpg and reduce image quality
    js_ic_compress_image($source, $destination, 75); 
    return $file;
}


/* 
 * Custom function to compress image size and 
 * upload to the server using PHP 
 */ 
function js_ic_compress_image($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $destination; 
} 