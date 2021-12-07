<?php

namespace Zharletc\Microapirequest\Builders;

use Illuminate\Http\Client\Response;
use Zharletc\Microapirequest\Contracts\ResponseContract;

class ResponseBuilder implements ResponseContract
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    public function getBody()
    {
        return json_decode($this->response->body());
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getAll(){
        return $this->response;
    }
}
