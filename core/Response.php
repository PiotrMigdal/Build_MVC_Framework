<?php

namespace app\core;

// Returns status code
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

}