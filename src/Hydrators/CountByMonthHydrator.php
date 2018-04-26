<?php

namespace App\Hydrators;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

/**
 * Hydrates a result of year, month and count to an array, that contains a \DateTime that represents the month, and the
 * count.
 *
 * @package App\Hydrators
 */
class CountByMonthHydrator extends AbstractHydrator
{

    /**
     * Hydrates all rows from the current statement instance at once.
     *
     * @return array
     */
    protected function hydrateAllData()
    {
        $result = [];
        foreach($this->_stmt->fetchAll(\PDO::FETCH_NUM) as $row) {
            $this->hydrateRowData($row, $result);
        }

        return $result;
    }

    /**
     * Hydrates a single row from the current statement instance.
     *
     * Template method.
     *
     * @param array $data   The row data.
     * @param array $result The result to fill.
     */
    protected function hydrateRowData(array $data, array &$result)
    {
        $date = new \DateTime();
        $date->setDate($data[0], $data[1], 1);

        $result[]= ['month' => $date, 'count' => $data[2]];
    }
}