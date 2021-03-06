<?php

namespace etrak;

abstract class ApiResource
{
    public $uri;
    public $payload = '';
    public $headers = [];
    public $etrak;

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

    public static function paginate(array $options = [])
    {
        $r = self::init();
        $r->method = 'GET';
        $options = array_intersect_key($options, array_flip(['page', 'show', 'q', 'include']));
        if (!empty($options)) {
            $r->uri.= '?'.http_build_query($options);
        }
        return $r->sendRequest();
    }

    public static function update($id, $payload)
    {
        $r = self::init();
        $r->payload = $payload;
        $r->method = 'PUT';
        $r->uri.="/$id";
        return $r->sendRequest();
    }

    public static function partialUpdate($id, array $payload)
    {
        $r = self::init();
        $r->payload = $payload;
        $r->method = 'PATCH';
        $r->uri.="/$id";
        return $r->sendRequest();
    }

    public static function delete($id=false)
    {
        $r = self::init();
        $r->method = 'DELETE';
        if ($id) {
            $r->uri.="/$id";
        }
        return $r->sendRequest();
    }

    public function sendRequest()
    {
        $response = $this->etrak->getHttpClient()->sendRequest($this->method, $this->etrak->getEndpoint().$this->uri, $this->payload, $this->headers);
        return $response;
    }
}
