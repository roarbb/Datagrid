<?php namespace Datagrid\Service;

use GuzzleHttp\Client;

class DownloadService
{
    private $downloadUrl;
    private $format;

    /**
     * @param $downloadUrl
     * @param $format
     */
    public function __construct($downloadUrl, $format)
    {
        $this->downloadUrl = $downloadUrl;
        $this->format = $format;
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        $client = new Client();
        $response = $client->get($this->downloadUrl);

        if ($this->format == 'json') {
            return $response->json();
        }

        return array();
    }
}
