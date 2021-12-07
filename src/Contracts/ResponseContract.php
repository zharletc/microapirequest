<?php

namespace Zharletc\Microapirequest\Contracts;

interface ResponseContract {
    public function getHeaders();
    public function getBody();
    public function getStatusCode();
    public function getAll();
}
