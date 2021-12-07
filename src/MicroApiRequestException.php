<?php

namespace Zharletc\Microapirequest;

use Exception;
use Throwable;

class MicroApiRequestException extends Exception implements MicroApiRequestThrowable {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
        return response()->json([
            'code' => 0,
            'message' => $this->message
        ]);
    }
}
