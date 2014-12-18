<?php namespace Datagrid\Service;


use Datagrid\Utils\Url;

class HttpService
{
    private $sortByKey = 'sort-by';
    private $sortDirectionKey = 'sort-direction';

    public function getSortUrl($sortByValue)
    {
        $url = new Url();
        $query = $url->getQuery();

        $sortByKey = $this->getSortByKey();
        $sortDirectionKey = $this->getSortDirectionKey();

        $query[$sortDirectionKey] = $this->getSortDirectionValue($sortByKey, $sortByValue, $sortDirectionKey, $query);
        $query[$sortByKey] = $sortByValue;

        $url->setNewQuery($query);

        return $url;
    }

    /**
     * @return string
     */
    public function getSortByKey()
    {
        return $this->sortByKey;
    }

    /**
     * @param string $sortByKey
     */
    public function setSortByKey($sortByKey)
    {
        $this->sortByKey = $sortByKey;
    }

    /**
     * @return string
     */
    public function getSortDirectionKey()
    {
        return $this->sortDirectionKey;
    }

    /**
     * @param string $sortDirectionKey
     */
    public function setSortDirectionKey($sortDirectionKey)
    {
        $this->sortDirectionKey = $sortDirectionKey;
    }

    private function getSortDirectionValue($sortByKey, $sortByValue, $sortDirectionKey, $query)
    {
        if ($this->defaultState($query, $sortByKey, $sortByValue, $sortDirectionKey)) {
            return 'ASC';
        }

        if ($this->ifDirectionIsDESC($query, $sortDirectionKey)) {
            return 'ASC';
        }

        return 'DESC';
    }

    private function defaultState($query, $sortByKey, $sortByValue, $sortDirectionKey)
    {
        return (isset($query[$sortByKey]) && $query[$sortByKey] != $sortByValue) || !isset($query[$sortDirectionKey]);
    }

    private function ifDirectionIsDESC($query, $sortDirectionKey)
    {
        return isset($query[$sortDirectionKey]) && $query[$sortDirectionKey] == 'DESC';
    }

    public function getSortByValue()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (isset($query[$this->sortByKey]) && !empty($query[$this->sortByKey])) {
            return $query[$this->sortByKey];
        }

        return false;
    }

    public function getSortDirection()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (isset($query[$this->sortDirectionKey]) && !empty($query[$this->sortDirectionKey])) {
            return $query[$this->sortDirectionKey];
        }

        return false;
    }
}