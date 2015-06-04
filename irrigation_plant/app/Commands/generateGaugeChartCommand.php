<?php namespace App\Commands;

use App\Commands\Command;
use Carbon\Carbon;
use Khill\Lavacharts\Laravel;
use App\reports;
use Khill\Lavacharts;
use App\Http\ChartHelpers;

use Illuminate\Contracts\Bus\SelfHandling;

class generateGaugeChartCommand extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $reportData = new \stdClass();

        foreach (Config('gauge.gauges') as $key => $gauge) {
            $name = "gauge" . $key;
            //$max = "max" . $key;
            //$min = "min" . $key;
            $$name = new ChartHelpers($key, $gauge['unit']);
            $$name->generateGaugeChart()->addGaugeChartTemplate($gauge);
            $reportData->$key = new \stdClass();
            $reportData->$key->max = $$name->maxVal();
            $reportData->$key->min = $$name->minVal();
            $reportData->$key->title = $gauge['Title'];
            $reportData->$key->name = $key;
            $reportData->$key->unit = $gauge['unit'];

        }

        return $reportData;
    }
}
