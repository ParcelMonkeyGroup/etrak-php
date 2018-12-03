<?php

namespace etrak;

abstract class ApiResource
{
    public $uri;
    public $payload = '';
    public $headers = [];

    public function __construct()
    {
        $this->etrak = etrak::instance();
    }

    public static function init()
    {
        $cn = get_called_class();
        $r = new $cn();
        return $r;
    }

    public static function create($payload=[])
    {
        $r = self::init();
        $r->payload = $payload;
        $r->method = 'POST';
        return $r->sendRequest();
    }

    public static function get($id=false)
    {
        $r = self::init();
        $r->method = 'GET';
        if ($id) {
            $r->uri.="/$id";
        }
        return $r->sendRequest();
    }

    public static function update($id=false, $payload)
    {
        $r = self::init();
        $r->payload = $payload;
        $r->method = 'PUT';
        if ($id) {
            $r->uri.="/$id";
        }
        return $r->sendRequest();
    }

    public static function delete($id=false)
    {
        $r = self::init();
        $r->payload = $payload;
        $r->method = 'DELETE';
        if ($id) {
            $r->uri.="/$id";
        }
        return $r->sendRequest();
    }

    public function sendRequest()
    {
        $response = $this->etrak->HttpClient->sendRequest($this->method, $this->etrak->endpoint.$this->uri, $this->payload, $this->headers);
        return $response;
    }
}
