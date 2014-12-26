<?php namespace Datagrid\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ParseException;

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
     * @return array|MessageService|mixed
     */
    public function getData()
    {
        $client = new Client();
        $response = $client->get($this->downloadUrl);

        if ($this->format == 'json') {
            try {
                return $response->json();
            } catch (ParseException $e) {
                return new MessageService($e->getMessage(), 'danger');
            }
        }

        return array();
    }
}