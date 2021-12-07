<?php

namespace Zharletc\Microapirequest\Builders;

use Zharletc\Microapirequest\Contracts\RequestContract;

class RequestBuilder implements RequestContract
{
    private $request;

    public function __construct()
    {
        $this->request = [
            'query' => [],
            'header' => [],
            'body' => []
        ];
    }
    public function addBody($payloads = []): void
    {
        $this->request['body'] = $payloads;
    }

    public function addHeader($payloads = []): void
    {
        $this->request['header'] = $payloads;
    }

    public function addQuery($payloads = []): void
    {
        $this->request['query'] = $payloads;
    }

    public function build()
    {
        return $this->request;
    }
}
