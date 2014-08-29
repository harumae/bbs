<?php

class ItemsController extends BaseController {
    public function indexAction($id) {
        $id = $this->filter->sanitize($id, 'int');
        $post = Posts::findFirstById($id);
        $this->tag->prependTitle($post->title . ' | ');
        $this->view->post = $post;
    }
}
