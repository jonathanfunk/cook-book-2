<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Include Composer autoload

// Use the Cloudinary namespace
use Cloudinary\Configuration\Configuration;

// Configure Cloudinary with your Cloudinary environment variables
Configuration::instance([
  'cloud' => [
      "cloud_name" => $_ENV['CLOUDINARY_CLOUD_NAME'],
      "api_key" => $_ENV['CLOUDINARY_API_KEY'],
      "api_secret" => $_ENV['CLOUDINARY_API_SECRET'],
      'secure' => true // Ensure HTTPS URLs
  ]
]);

?>