<?php

class Images extends BaseModel {
    public $id;
    public $registered_at;
    public $updated_at;
    public $file_name;
    public $mime_type;
    public $raw_data;
    public $raw_size;
    public $raw_width;
    public $raw_height;
    public $thumb_data;
    public $thumb_size;
    public $thumb_width;
    public $thumb_height;

    public $file;

    private $_raw_path;
    private $_thumb_path;
    private $_thumb_size;
    private $_temp_dir;

    public function initialize() {
        parent::initialize();
        $this->_thumb_size = $this->config->application->thumbSize;
        $this->_temp_dir = $this->config->application->tempDir;
    }

    public function beforeValidationOnCreate() {
        try {
            $this->_setRawImageInfo();
            $this->_setThumbImageInfo();
        } catch (Exception $e) {
            return false;
        }

        // Set column values.
        $now = date('Y-m-d H:i:s');
        $this->registered_at = $now;
        $this->updated_at = $now;
    }

    public function afterSave() {
        if (is_readable($this->_raw_path)) {
            unlink($this->_raw_path);
        }

        if (is_readable($this->_thumb_path)) {
            unlink($this->_thumb_path);
        }
    }

    private function _setRawImageInfo() {
        $pathInfo = pathinfo($this->file->getName());
        $basename = $pathInfo['basename'];
        // $extension = $this->_getImageFileExtension($this->file->getName());
        $extension = $pathInfo['extension'];
        $fileName = sha1($basename) . '.' . $extension;

        // Build raw image path.
        $rawPath = sprintf(
            '%s/%s',
            $this->_temp_dir,
            $fileName
        );

        // Move uploaded file to destination path.
        $this->file->moveTo($rawPath);

        // Get raw image size.
        list($rawWidth, $rawHeight) = getimagesize($rawPath);

        // Fills field value according to raw image.
        $this->file_name = $fileName;
        $this->mime_type = $this->file->getType();
        $this->raw_data = file_get_contents($rawPath);
        $this->raw_size = filesize($rawPath);
        $this->raw_width = $rawWidth;
        $this->raw_height = $rawHeight;
        $this->_raw_path = $rawPath;
    }

    private function _setThumbImageInfo() {
        // Get dimensions of thumbnail image.
        list($thumbWidth, $thumbHeight) =
            $this->_getThumbDimensions($this->raw_width, $this->raw_height);

        // Generate thumbnail image.
        $thumbPath = $this->_generateThumbImage(
            $this->raw_width,
            $this->raw_height,
            $thumbWidth,
            $thumbHeight
        );

        // Fills field value according to thumbnail image.
        $this->thumb_data = file_get_contents($thumbPath);
        $this->thumb_size = filesize($thumbPath);
        $this->thumb_width = $thumbWidth;
        $this->thumb_height = $thumbHeight;
        $this->_thumb_path = $thumbPath;
    }

    private function _getImageFileExtension($fileName) {
        switch (exif_imagetype($fileName)) {
        case IMAGETYPE_GIF:
            $ext = 'gif';
            break;
        case IMAGETYPE_JPEG:
            $ext = 'jpeg';
            break;
        case IMAGETYPE_PNG:
            $ext = 'png';
            break;
        default:
            throw new UnexpectedValueException('Unexpected image type.');
            break;
        }

        return $ext;
    }

    private function _getThumbDimensions($width, $height) {
        if ($width >= $height) {
            if ($width > $this->_thumb_size) {
                $thumbWidth = $this->_thumb_size;
            } else {
                $thumbWidth = $width;
            }
            $aspectRatio = $thumbWidth / $width;
            $thumbHeight = $height * $aspectRatio;
        } else {
            if ($height > $this->_thumb_size) {
                $thumbHeight = $this->_thumb_size;
            } else {
                $thumbHeight = $height;
            }
            $thumbHeight = $this->_thumb_size;
            $aspectRatio = $thumbHeight / $height;
            $thumbWidth = $width * $aspectRatio;
        }

        return array($thumbWidth, $thumbHeight);
    }

    private function _generateThumbImage($rawWidth, $rawHeight, $thumbWidth, $thumbHeight) {
        $pathInfo = pathinfo($this->_raw_path);
        $basename = $pathInfo['basename'];
        $extension = $pathInfo['extension'];
        $extension = $this->_getImageFileExtension($this->_raw_path);


        // Build thumbnail image path.
        $thumbPath = sprintf(
            '%s/thumb_%s',
            $this->_temp_dir,
            $basename
        );

        // Generate blank image for thumbnail.
        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

        // Generate blank image for original.
        $imageCreateFunc = 'imagecreatefrom' . $extension;
        $rawImage = $imageCreateFunc($this->_raw_path);

        // Resample image.
        imagecopyresampled(
            $thumbImage,        // Resampled image
            $rawImage,          // Original image
            0,                  // X position of resampled image
            0,                  // Y position of resampled image
            0,                  // X position of original image
            0,                  // Y position of original image
            $thumbWidth,        // Width of resampled image
            $thumbHeight,       // Height of resampled image
            $rawWidth,          // Width of original image
            $rawHeight          // Height of original image
        );

        // Output resampled image.
        $imageFunc = 'image' . $extension;
        $imageFunc($thumbImage, $thumbPath);

        imagedestroy($rawImage);
        imagedestroy($thumbImage);

        return $thumbPath;
    }
}
