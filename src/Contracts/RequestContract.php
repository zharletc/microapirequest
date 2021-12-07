<?php

namespace Zharletc\Microapirequest\Contracts;

interface RequestContract {
    public function addHeader($payloads = []): void;
    public function addBody($payloads = []): void;
    public function addQuery($payloads = []): void;
    public function build();
}
