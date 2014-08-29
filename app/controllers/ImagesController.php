<?php

class ImagesController extends BaseController {
    public function indexAction($size, $id) {
        $id = $this->filter->sanitize($id, 'int');
        $image = Images::findFirstById($id);

        if ($size === 'thumb') {
            $data = $image->thumb_data;
        } else {
            $data = $image->raw_data;
        }

        $this->response->setContentType($image->mime_type);
        $this->response->setHeader(
            'Content-Disposition',
            'inline; filename=' . $image->file_name
        );
        $this->response->setContent($data);

        return $this->response;
    }

}
