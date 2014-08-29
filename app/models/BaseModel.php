<?php

use Phalcon\Mvc\Model as Model;

class BaseModel extends Model {
    protected $config;

    public function initialize() {
        $di = $this->getDI();
        $this->config = $di->get('config');
    }
}
