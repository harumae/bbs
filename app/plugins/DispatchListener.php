<?php

class DispatchListener extends BaseListener {
    public function beforeExecuteRoute($event, $dispatcher) {
        $message = sprintf(
            '%s::%s() started.',
            $dispatcher->getHandlerClass(),
            $dispatcher->getActiveMethod()
        );
        $this->logger->info($message);
    }

    public function afterExecuteRoute($event, $dispatcher) {
        $message = sprintf(
            '%s::%s() finished.',
            $dispatcher->getHandlerClass(),
            $dispatcher->getActiveMethod()
        );
        $this->logger->info($message);
    }
}
