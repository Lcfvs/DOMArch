<?php
namespace DOMArch;

abstract class Constants
{
    const
        DOWNLOAD_DIR = 'DOWNLOAD_DIR',
        DOWNLOAD_SPEED = 'DOWNLOAD_SPEED',
        UPLOAD_DIR = 'UPLOAD_DIR',
        CACHE_DIR = 'CACHE_DIR',
        MIME_TYPES_URL = 'MIME_TYPES_URL',
        ENCRYPTION_KEY = 'ENCRYPTION_KEY',
        SERVICE_URL = 'SERVICE_URL',
        SERVICE_TOKEN = 'X-Service-Token',
        REQUEST_TIME = 'X-Request-Time';

    final private function __construct()
    {}
}