<?php namespace App\Commands;

use App\Commands\Command;
use Carbon\Carbon;
use Lava;
use App\reports;

use Illuminate\Contracts\Bus\SelfHandling;

class updateLineChartCommand extends Command implements SelfHandling
{

    private $latestReports;

    /**
     * Execute the command.
     *
     * @return object
     */
    public function handle()
    {
        $this->latestReports = reports::latest()
            ->take(60)
            ->get([
                'temperature_1',
                'temperature_2',
                'humidity',
                'hygrometer',
                'hygro_raw',
                'created_at'])
            ->reverse();

        //$this->latestReports->truncate();

        $temps = Lava::DataTable('Europe/Stockholm');
        $temps->setdateTimeFormat('g:i');

        $temps->addColumn('timeofday', 'Time');
        foreach (Config('gauge.gauges') as $key => $gauge) {
            $temps->addNumberColumn($gauge['Title']);
        }

        foreach ($this->latestReports as $key => $report) {
            $dt = Carbon::parse($report->created_at);
            $temps->addRow(array(
                [$dt->hour, $dt->minute, $dt->second],
                $report->temperature_1,
                $report->temperature_2,
                $report->humidity,
                $report->hygro_raw));
        }

        return $temps->toJson();
    }

}
