<?php

class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );

        return $uri;
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {
        if (array_key_exists('QUERY_STRING', $_SERVER)) {
            return parse_str($_SERVER['QUERY_STRING'], $query);
        } else {
            $uri = '';
            return [];
        }
    }

    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        error_log(print_r($data, true));

        echo $data;
        exit;
    }
}