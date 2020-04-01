<?php

namespace App\Core\Request;

/**
 * Class FilesRequest
 *
 * @package App\Core\Request
 */
class FilesRequest
{
    /**
     * @var array
     */
    private $files = [];

    /**
     * FilesRequest constructor.
     *
     * @param array $files
     */
    public function __construct(array $files)
    {
        if (empty($files)) {
            return;
        }

        $this->setFiles($files);
    }

    /**
     * @param $files
     */
    private function setFiles($files)
    {
        $fieldName = array_keys($files)[0];

        if (is_array($files[$fieldName]['name'])) {
            $this->files[$fieldName] = $this->rearrange($files[$fieldName]);
        } else {
            $this->files[$fieldName][0] = $files[$fieldName];
        }

        if ($this->files[$fieldName][0]['error'] === UPLOAD_ERR_NO_FILE) {
            $this->files[$fieldName] = [];
        }
    }

    /**
     * @param array $files
     *
     * @return array
     */
    private function rearrange(array $files)
    {
        $filesRearranged = [];

        for ($i = 0; $i < count($files['name']); $i++) {
            foreach (array_keys($files) as $key) {
                $filesRearranged[$i][$key] = $files[$key][$i];
            }
        }

        return $filesRearranged;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }
}
