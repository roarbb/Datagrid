<?php namespace Datagrid\Sorter;


class RowSorter
{

    private $rows = array();

    /**
     * @param array $rows
     */
    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    /**
     * @param $cellName
     * @param $direction
     * @return array
     */
    public function sortRowsByCell($cellName, $direction)
    {
        usort($this->rows, function ($a, $b) use ($cellName, $direction) {

            $cellA = $a->getCellByCellName($cellName);
            $cellB = $b->getCellByCellName($cellName);

            $comparison = strcmp($cellA->getCellData(), $cellB->getCellData());

            if ($direction === 'ASC') {
                return $comparison;
            }

            return $comparison * -1;
        });

        return $this->rows;
    }
}