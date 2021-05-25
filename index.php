<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

$s3Client = new S3Client([
    'endpoint' => 'https://s3.app.zerops.dev',
    'region' => 'us-east-1',
	'version' => 'latest',
    'signature_version' => 'v4',
	'credentials' => [
	    'key' => $_SERVER["accessKeyId"],
	    'secret' => $_SERVER["secretAccessKey"],
	],
]);

// Use multipart upload
$source = 'file.zip';
$uploader = new MultipartUploader($s3Client, $source, [
    'bucket' => 'your-bucket',
    'key' => 'file.zip',
]);

try {
    $result = $uploader->upload();
    echo "Upload complete: {$result['ObjectURL']}\n";
} catch (MultipartUploadException $e) {
    echo $e->getMessage() . "\n";
}

?>