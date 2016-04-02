<?php namespace App\Commands;

use App\Commands\Command;
use Khill\Lavacharts\Laravel;
use Khill\Lavacharts;
use App\Http\ChartHelpers;

use Illuminate\Contracts\Bus\SelfHandling;

class generateLineChartCommand extends Command implements SelfHandling {

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
        $lineChart = new ChartHelpers('lineChart');
        $lineChart->fillLineChart()->addLineChartTable();
	}

}
