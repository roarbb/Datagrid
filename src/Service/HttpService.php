<?php namespace Datagrid\Service;


use Datagrid\Utils\Url;

class HttpService
{
    private $sortByKey = 'sort-by';
    private $sortDirectionKey = 'sort-direction';
    private $paginatorKey = 'paginator-page';

    /**
     * Returns sorting Url object for specific column
     *
     * @param $sortByValue
     * @return Url
     */
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

    /**
     * @param $sortByKey
     * @param $sortByValue
     * @param $sortDirectionKey
     * @param $query
     * @return string
     */
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

    /**
     * @param $query
     * @param $sortByKey
     * @param $sortByValue
     * @param $sortDirectionKey
     * @return bool
     */
    private function defaultState($query, $sortByKey, $sortByValue, $sortDirectionKey)
    {
        return (isset($query[$sortByKey]) && $query[$sortByKey] != $sortByValue) || !isset($query[$sortDirectionKey]);
    }

    /**
     * @param $query
     * @param $sortDirectionKey
     * @return bool
     */
    private function ifDirectionIsDESC($query, $sortDirectionKey)
    {
        return isset($query[$sortDirectionKey]) && $query[$sortDirectionKey] == 'DESC';
    }

    /**
     * Returns name of active sorting column
     *
     * @return bool
     */
    public function getSortByValue()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (isset($query[$this->sortByKey]) && !empty($query[$this->sortByKey])) {
            return $query[$this->sortByKey];
        }

        return false;
    }

    /**
     * Returns sorting direction (ASC / DESC / false)
     *
     * @return bool
     */
    public function getSortDirection()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (isset($query[$this->sortDirectionKey]) && !empty($query[$this->sortDirectionKey])) {
            return $query[$this->sortDirectionKey];
        }

        return false;
    }

    /**
     * Tells if sorting is active
     *
     * @return bool
     */
    public function sortingGetParamsAreSet()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (isset($query[$this->sortByKey]) && isset($query[$this->sortDirectionKey])) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getPaginatorKey()
    {
        return $this->paginatorKey;
    }

    /**
     * @param string $paginatorKey
     */
    public function setPaginatorKey($paginatorKey)
    {
        $this->paginatorKey = $paginatorKey;
    }

    /**
     * Returns Paginator Page from $_GET
     *
     * @return int
     */
    public function getPaginatorPage()
    {
        $url = new Url();
        $query = $url->getQuery();

        if (!isset($query[$this->getPaginatorKey()]) || $query[$this->getPaginatorKey()] < 1) {
            return 1;
        }

        return intval($query[$this->getPaginatorKey()]);
    }

    /**
     * Returns Url with paginator set to specific page
     *
     * @param $page
     * @return Url
     */
    public function getUrlWithPaginator($page)
    {
        $url = new Url();
        $query = $url->getQuery();

        $query[$this->paginatorKey] = $page;

        $url->setNewQuery($query);

        return $url;
    }

    public function getBaseUrl()
    {
        $url = new Url();
        $url->setNewQuery(array());

        return $url;
    }
}