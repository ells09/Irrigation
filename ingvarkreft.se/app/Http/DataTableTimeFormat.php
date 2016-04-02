<?php
/**
 * Created by PhpStorm.
 * User: ingvar
 * Date: 2015-06-07
 * Time: 21:00
 */

namespace App\Http;

use Khill\Lavacharts\Configs\DataTable;
use Lava;

class DataTableTimeFormat extends DataTable
{

    /**
     * Supplemental function to add a date column with less params.
     *
     * @access public
     * @param  string                A label for the column.
     * @param  Format                A column formatter object. (Optional)
     * @throws InvalidConfigValue
     * @throws InvalidConfigProperty
     * @return DataTable
     */
    public function addTimeColumn($optLabel, Format $formatter = null)
    {
        return $this->addColumn('time', $optLabel, 'col_' . count($this->cols) + 1, $formatter);
    }


}