<?php
/**
 * Created by PhpStorm.
 * User: ingvar
 * Date: 2015-06-07
 * Time: 20:16
 */

namespace App\Http;

use Khill\Lavacharts\Formats\DateFormat;
use Lava;

class TimeFormat extends DateFormat
{

    /**
     * Builds the NumberFormat object with specified options
     *
     * @param  array $config
     * @throws InvalidConfigValue
     * @throws InvalidConfigProperty
     * @return TimeFormat
     */
    public function __construct($config = array())
    {
        parent::__construct($this, $config);
    }

}