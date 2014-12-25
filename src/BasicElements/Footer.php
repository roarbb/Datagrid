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
    }

    public function render()
    {
        $footerDiv = Html::el('div')->addAttributes(array('class' => 'row datagrid-footer'));

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
        $leftPart = Html::el('div')->addAttributes(array('class' => 'col-xs-6'));

        $leftPartContent = Html::el('div')->addAttributes(array('class' => 'datagrid-info'));
        $leftPartContent->setText(sprintf('Total items: %s', $this->paginator->itemCount));

        $leftPart->add($leftPartContent);

        return $leftPart;
    }

    private function getRightPart()
    {
        $rightPart = Html::el('div')->addAttributes(array('class' => 'col-xs-6 text-right'));
        $rightPartContent = $this->getPaginatorGUI();

        $rightPart->setHtml($rightPartContent);
        return $rightPart;
    }

    private function getPaginatorGUI()
    {
        if ($this->paginator->pageCount <= 1) {
            return false;
        }

        $nav = Html::el('nav');
        $ul = Html::el('ul')->addAttributes(array('class' => 'pagination'));

        $ul->add($this->getFirstPaginationListItem());
        $this->buildPaginatorPages($ul);
        $ul->add($this->getLastPaginationListItem());

        $nav->add($ul);

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
        $li = Html::el('li');
        $a = Html::el('a')->addAttributes(array('aria-label' => $label));
        $span = Html::el('span')->addAttributes(array('aria-hidden' => 'true'))->setHtml($buttonText);

        if ($shouldBeDisabled) {
            $li->addAttributes(array('class' => 'disabled'));
        } else {
            $httpService = new HttpService();
            $href = $httpService->getUrlWithPaginator($this->paginator->page + $pageNumber);
            $a->addAttributes(array('href' => $href));
        }

        $li->add($a);
        $a->add($span);

        return $li;
    }

    private function buildPaginatorPages(Html $ul)
    {
        $actualPage = $this->paginator->page;

        for ($i = 1; $i <= $this->paginator->pageCount; $i++) {

            if ($this->shouldSkipThisPaginationPage($i)) continue;

            $httpService = new HttpService();
            $paginationUrl = $httpService->getUrlWithPaginator($i);

            $li = Html::el('li');
            $a = Html::el('a')->addAttributes(array('href' => $paginationUrl))->setText($i);

            if ($actualPage == $i) {
                $li->addAttributes(array('class' => 'active'));
            }

            $li->add($a);
            $ul->add($li);
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
        $actualPageLastPageAndFirstPage = 3;

        return $leftPaginationRange + $rightPaginationRange + $actualPageLastPageAndFirstPage;
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