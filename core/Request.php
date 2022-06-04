<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        // Get server uri and if this is empty (it is for /) then assign '/'
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // Check position of question mark, in case of GET requests in uri
        $position = strpos($path, '?');
        // if there is no question mark, return just path
        if ($position === false) {
            return $path;
        }
        // if path has question mark, we need substring only path part (from 0 to position of ?)
        return substr($path, 0, $position);


    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}