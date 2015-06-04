<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-06-01
 * Time: 15:59
 */

namespace App\Http;


use App\reports;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class ChartHelpers
{

    private $name;
    private $chartName;
    private $gaugeLabel;
    private $latestReports;
    private $minMaxTemperature;
    private $column;

    public function __construct($name, $label = null)
    {
        $this->chartName = $name;
        $this->name = \Lava::DataTable();
        if ($label) {
            $this->gaugeLabel = $label;
        }
        switch ($this->chartName) {
            case 'Temp1':
                $this->column = 'temperature_1';
                $this->readGaugeValues('temperature_1');
                break;
            case 'Temp2':
                $this->column = 'temperature_2';
                $this->readGaugeValues('temperature_2');
                break;
            case 'Humidity':
                $this->column = 'humidity';
                $this->readGaugeValues('humidity');
                break;
            case 'Hygrometer':
                $this->column = 'hygrometer';
                $this->readGaugeValues('hygrometer');
                break;
            default:
                $this->latestReports = reports::latest()->take(60)->get(['temperature_1', 'temperature_2', 'humidity', 'hygrometer', 'created_at'])->reverse();
                break;
        }

    }

    public function maxVal()
    {
        return $this->minMaxTemperature[0]['maxVal'];
    }

    public function minVal()
    {
        return $this->minMaxTemperature[0]['minVal'];
    }

    private function readGaugeValues($column)
    {
        $this->latestReports = reports::latest()->take(1)->get([$column, 'created_at']);
        $time = $this->latestReports[0]['created_at'];
        $dateLow = $time->subHour();
        $this->minMaxTemperature = reports::getInterval($dateLow)->getMinMax($column)->get();
    }

    public function fillLineChart()
    {
        $this->name->addStringColumn('Time')
            ->addNumberColumn('Givare 1')
            ->addNumberColumn('Givare 2')
            ->addNumberColumn('Luftfuktighet')
            ->addNumberColumn('Jordfuktighet');
        foreach ($this->latestReports as $key => $report) {
            Carbon::setToStringFormat('g:i');
            $dt = Carbon::parse($report->created_at);
            $time = $dt->hour . ':' . $dt->minute;
            $this->name->addRow(array($time, $report->temperature_1, $report->temperature_2, $report->humidity, $report->hygrometer));
        }

        return $this;
    }

    public function generateGaugeChart()
    {
        $this->name->addStringColumn('Type')
            ->addNumberColumn('Value')
            ->addRow(array(
                    $this->gaugeLabel,
                    $this->latestReports[0][$this->column])
            );

        return $this;
    }

    public function addGaugeChartTemplate($values)
    {
        $values['options']['datatable'] = $this->name;

        \Lava::GaugeChart($this->chartName)
            ->setOptions(
                $values['options']
            );

        return $this;
    }

    public function addLineChartTable()
    {
        $chartArea = \Lava::ChartArea(array(
            'left' => '5%',
            'top' => 10,
            'width' => '80%',
            'height' => '90%',
        ));
        $config = array(
            'hAxis' => \Lava::HorizontalAxis(array(
                'format' => 'YY/MM/DD'
            ))
        );
        $hAxis = \Lava::HorizontalAxis(array(
            'format' => 'H:mm',
        ));

        $vAxis = \Lava::VerticalAxis(array(
            'format' => 'H:mm',
        ));

        $linechart = \Lava::LineChart($this->chartName)
            ->dataTable($this->name)
            ->title('Den senaste timmen')
            ->setOptions(array(
                'curveType' => 'function',
                'height' => 500,
                'chartArea' => $chartArea,
                'hAxis' => $hAxis,

            ));

        return $this;
    }
}