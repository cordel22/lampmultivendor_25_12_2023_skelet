<?php

function includeFileWithFallback($filePaths) {
    foreach ($filePaths as $filePath) {
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        }
    }
    return false;
}

