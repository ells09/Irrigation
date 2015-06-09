<?php namespace App\Commands;

use App\Commands\Command;
use Carbon\Carbon;
use Lava;
use App\reports;

use Illuminate\Contracts\Bus\SelfHandling;

class updateGaugeChartCommand extends Command implements SelfHandling {

    private $latestReports;
    private $updateFormat;
    private $gauges;

    use ChartTrait;
    /**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        foreach (Config('gauge.gauges') as $key => $gauge) {
            $this->latestReports = $this->readLatestValue($gauge['databaseColumnName']);
            $temps = Lava::DataTable('Europe/Stockholm');

            $temps->addStringColumn('Type')
                ->addNumberColumn('value')
                ->addRow(array(
                        $gauge['unit'],
                        $this->latestReports[0][$gauge['databaseColumnName']],
                    )
                );
            $this->gauges[$key]['data'] = $temps->toJson();
            $this->gauges[$key]['min'] = $this->minVal();
            $this->gauges[$key]['max'] = $this->maxVal();
        }

        return $this->gauges;

    }

}
