<?php namespace Datagrid\BasicElements;


use Datagrid\Service\HttpService;
use Nette\Utils\Html;
use Nette\Utils\Paginator;

class Footer implements IBasicElement
{
    /**
     * @var Paginator
     */
    private $paginator;
    private $visiblePaginationRange = 2;

    public function __construct($paginator)
    {
        $this->paginator = $paginator;
        $this->html = new Html();
    }

    public function render()
    {
        $footerDiv = $this->html->el('div')->addAttributes(array('class' => 'row datagrid-footer'));

        if (!$this->paginator) {
            return $footerDiv;
        }

        $leftPart = $this->getLeftPart();
        $rightPart = $this->getRightPart();

        $footerDiv->add($leftPart);
        $footerDiv->add($rightPart);

        return $footerDiv;
    }

    private function getLeftPart()
    {
        $leftPart = $this->html->el('div')->addAttributes(array('class' => 'col-xs-6'));

        $leftPartContent = $this->html->el('div')->addAttributes(array('class' => 'datagrid-info'));
        $leftPartContent->setText(sprintf('Total items: %s', $this->paginator->itemCount));

        $leftPart->add($leftPartContent);

        return $leftPart;
    }

    private function getRightPart()
    {
        $rightPart = $this->html->el('div')->addAttributes(array('class' => 'col-xs-6 text-right'));
        $rightPartContent = $this->getPaginatorGUI();

        $rightPart->setHtml($rightPartContent);
        return $rightPart;
    }

    private function getPaginatorGUI()
    {
        if ($this->paginator->pageCount <= 1) {
            return false;
        }

        $nav = $this->html->el('nav');
        $unorderedList = $this->html->el('ul')->addAttributes(array('class' => 'pagination'));

        $unorderedList->add($this->getFirstPaginationListItem());
        $this->buildPaginatorPages($unorderedList);
        $unorderedList->add($this->getLastPaginationListItem());

        $nav->add($unorderedList);

        return $nav;
    }

    private function getFirstPaginationListItem()
    {
        return $this->getNextOrPreviousPaginationButton(
            'Previous',
            '&laquo;',
            $this->paginator->isFirst(),
            -1
        );
    }

    private function getLastPaginationListItem()
    {
        return $this->getNextOrPreviousPaginationButton(
            'Next',
            '&raquo;',
            $this->paginator->isLast(),
            1
        );
    }

    private function getNextOrPreviousPaginationButton($label, $buttonText, $shouldBeDisabled, $pageNumber)
    {
        $listItem = $this->html->el('li');
        $anchor = $this->html->el('a')->addAttributes(array('aria-label' => $label));
        $span = $this->html->el('span')->addAttributes(array('aria-hidden' => 'true'))->setHtml($buttonText);

        if ($shouldBeDisabled) {
            $listItem->addAttributes(array('class' => 'disabled'));
        }

        if(!$shouldBeDisabled) {
            $httpService = new HttpService();
            $href = $httpService->getUrlWithPaginator($this->paginator->page + $pageNumber);
            $anchor->addAttributes(array('href' => $href));
        }

        $listItem->add($anchor);
        $anchor->add($span);

        return $listItem;
    }

    private function buildPaginatorPages(Html $unorderedList)
    {
        $actualPage = $this->paginator->page;

        for ($i = 1; $i <= $this->paginator->pageCount; $i++) {

            if ($this->shouldSkipThisPaginationPage($i)) continue;

            $httpService = new HttpService();
            $paginationUrl = $httpService->getUrlWithPaginator($i);

            $listItem = $this->html->el('li');
            $anchor = $this->html->el('a')->addAttributes(array('href' => $paginationUrl))->setText($i);

            if ($actualPage == $i) {
                $listItem->addAttributes(array('class' => 'active'));
            }

            $listItem->add($anchor);
            $unorderedList->add($listItem);
        }
    }

    private function shouldSkipThisPaginationPage($pageIndex)
    {
        return $this->paginator->pageCount > $this->maximumVisiblePaginationPages()
            && $this->pageIsNotInPaginationVisibleRange($pageIndex)
            && $this->isNotfirstOrLastPage($pageIndex);
    }

    private function maximumVisiblePaginationPages()
    {
        $leftPaginationRange = $this->visiblePaginationRange;
        $rightPaginationRange = $this->visiblePaginationRange;
        $activeGuiElements = 3;

        return $leftPaginationRange + $rightPaginationRange + $activeGuiElements;
    }

    private function pageIsNotInPaginationVisibleRange($pageIndex)
    {
        $actualPage = $this->paginator->page;
        return $pageIndex < $actualPage - $this->visiblePaginationRange || $pageIndex > $actualPage + $this->visiblePaginationRange;
    }

    private function isNotfirstOrLastPage($pageIndex)
    {
        return $pageIndex != $this->paginator->pageCount && $pageIndex != 1;
    }
}