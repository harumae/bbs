<?php

class BaseListener {
    protected $logger;

    public function __construct($logger) {
        $this->logger = $logger;
    }
}
