<?php

class DbListener extends BaseListener {
    public function beforeQuery($event, $connection) {
        $this->logger->log($connection->getSQLStatement(), Phalcon\Logger::INFO);
    }
}
