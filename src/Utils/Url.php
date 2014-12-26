<?php namespace Datagrid\Utils;


class Url
{
    private $url;

    /**
     * @param bool $use_forwarded_host
     */
    public function __construct($use_forwarded_host = false)
    {
        $this->url = $this->getActualUrl($use_forwarded_host);
    }

    /**
     * @param $use_forwarded_host
     * @return array
     */
    private function getActualUrl($use_forwarded_host)
    {
        $s = $_SERVER;

        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;

        $sp = strtolower($s['SERVER_PROTOCOL']);

        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');

        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;

        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;

        $parsedUri = $this->parseUrl($s);

        return array(
            'protocol' => $protocol,
            'host' => $host,
            'path' => $parsedUri['path'],
            'query' => $parsedUri['query'],
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url['protocol'] . '://' . $this->url['host'] . $this->url['path'] . ($this->url['query'] ? '?' . $this->url['query'] : '');
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        parse_str($this->url['query'], $query);
        return $query;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function setNewQuery(array $query)
    {
        $this->url['query'] = http_build_query($query);
        return $this;
    }

    /**
     * @param $s
     * @return mixed
     */
    private function parseUrl($s)
    {
        $parsedUrl = parse_url($s['REQUEST_URI']);

        if (!isset($parsedUrl['query'])) {
            $parsedUrl['query'] = "";
        }

        return $parsedUrl;
    }
}