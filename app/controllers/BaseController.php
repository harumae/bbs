<?php

use Phalcon\Mvc\Controller as Controller;

class BaseController extends Controller {
    protected function initialize() {
        $this->view->site_title = $this->config->application->siteTitle;
        $this->view->base_uri = $this->config->application->baseUri;
        $this->tag->setTitle($this->view->site_title);
    }
}
