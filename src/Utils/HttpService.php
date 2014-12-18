<?php namespace Datagrid\Utils;


class HttpService
{
    public function getSortUrl($sortByValue, $sortByKey = 'sort-by', $sortDirectionKey = 'sort-direction')
    {
        $url = new Url();
        $query = $url->getQuery();

        $query[$sortDirectionKey] = $this->getSortDirectionValue($sortByKey, $sortByValue, $sortDirectionKey, $query);
        $query[$sortByKey] = $sortByValue;

        $url->setNewQuery($query);

        return $url;
    }

    private function getSortDirectionValue($sortByKey, $sortByValue, $sortDirectionKey, $query)
    {
        if($this->defaultState($query, $sortByKey, $sortByValue, $sortDirectionKey)) {
            return 'ASC';
        }

        if($this->ifDirectionIsDESC($query, $sortDirectionKey)) {
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
}