<?php

namespace App\Core;

/**
 * Class Storage
 *
 * @package App\Core
 */
class Storage
{
    /**
     * @param string $tmpName
     * @param string $path
     */
    public function storeFile(string $tmpName, string $path)
    {
        move_uploaded_file($tmpName, $path);
    }

    public function deleteFile()
    {
        // to be implemented
    }
}
