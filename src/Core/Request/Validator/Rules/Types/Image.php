<?php

namespace App\Core\Request\Validator\Rules\Types;

/**
 * Class Image
 *
 * @package App\Core\Request\Validator\Rules\Types
 */
class Image implements TypeInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        foreach ($data['input'] as $item) {
            if ($item['error'] === UPLOAD_ERR_NO_FILE) {
                return 'No file selected!';
            }

            if (!getimagesize($item['tmp_name'])) {
                return "File '{$item['name']}' is not an image!";
            }
        }
    }
}
