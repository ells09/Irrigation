<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-06-01
 * Time: 15:59
 */

namespace App\Http;


use App\Commands\ChartTrait;
use App\reports;
use Carbon\Carbon;
use Lava;

class ChartHelpers
{

    private $name;
    private $chartName;
    private $gaugeLabel;
    private $latestReports;
    private $column;

    use ChartTrait;

    public function __construct($name, $label = null)
    {
        $this->chartName = $name;
        $this->name = Lava::DataTable();
        if ($label) {
            $this->gaugeLabel = $label;
        }
        switch ($this->chartName) {
            case 'Temp1':
                $this->column = 'temperature_1';
                $this->latestReports = $this->readLatestValue($this->column);
                break;
            case 'Temp2':
                $this->column = 'temperature_2';
                $this->latestReports = $this->readLatestValue($this->column);
                break;
            case 'Humidity':
                $this->column = 'humidity';
                $this->latestReports = $this->readLatestValue($this->column);
                break;
            case 'Hygrometer':
                $this->column = 'hygrometer';
                $this->latestReports = $this->readLatestValue($this->column);
                break;
            default:
                $this->latestReports = reports::latest()->take(60)->get([
                    'temperature_1',
                    'temperature_2',
                    'humidity',
                    'hygrometer',
                    'hygro_raw',
                    'created_at'
                ])->reverse();
                break;
        }

    }

    public function fillLineChart()
    {
        $this->name->addColumn('timeofday', 'Time');
        foreach (Config('gauge.gauges') as $key => $gauge) {
            $this->name->addNumberColumn($gauge['Title']);
        }
        //$d = $this->latestReports->avg('humidity');
        foreach ($this->latestReports as $key => $report) {
            $dt = Carbon::parse($report->created_at);
            $this->name->addRow(array(
                [$dt->hour, $dt->minute],
                $report->temperature_1,
                $report->temperature_2,
                $report->humidity,
                $report->hygro_raw,
            ));
        }

        return $this;
    }

    public function generateGaugeChart()
    {
        $this->name->addStringColumn('Type')
            ->addNumberColumn('Value')
            ->addRow(array(
                    $this->gaugeLabel,
                    $this->latestReports[0][$this->column]
                )
            );

        return $this;
    }

    public function addGaugeChartTemplate($values)
    {
        $values['options']['datatable'] = $this->name;

        Lava::GaugeChart($this->chartName)
            ->setOptions(
                $values['options']
            );

        return $this;
    }

    public function addLineChartTable()
    {
        Carbon::setLocale('sv');
        $dt = Carbon::now('Europe/Stockholm');
        $from = Carbon::now('Europe/Stockholm')->subHour();
        //Either Chain functions together and assign to variables
        $legendStyle = Lava::TextStyle()->color('#F3BB00')
            ->fontName('Arial')
            ->fontSize(20);

        $legend = Lava::Legend()->position('bottom')
            ->alignment('start')
            ->textStyle($legendStyle);


//Or pass in arrays with set options into the function's constructor
        $tooltip = Lava::Tooltip(array(
            'showColorCode' => true,
            'textStyle' => Lava::TextStyle(array(
                'color' => '#C0C0B0',
                'fontName' => 'Courier New',
                'fontSize' => 10
            ))
        ));

        $config = array(
            'backgroundColor' => Lava::BackgroundColor(array(
                'stroke' => '#eee',
                'strokeWidth' => 4,
                'fill' => '#fff'
            )),
            'chartArea' => Lava::ChartArea(array(
                'left' => 100,
                'top' => 75,
                'width' => '85%',
                'height' => '55%'
            )),
            'titleTextStyle' => Lava::TextStyle(array(
                'color' => '#FF0A04',
                'fontName' => 'Georgia',
                'fontSize' => 18
            )),
            'legend' => $legend,
            'tooltip' => $tooltip,
            'title' => 'Senaste timmen',
            'titlePosition' => 'out',
            'curveType' => 'function',
            //'width' => '100%',
            'height' => 450,
            'pointSize' => 2,
            'lineWidth' => 1,
            'colors' => array('#0066FF', '#00CCFF', '#CCFF33', '#669933'),
            'hAxis' => Lava::HorizontalAxis(array(
                'baselineColor' => '#fc32b0',
                'format' => 'H:mm',
                'gridlines' => [
                    'count' => 20,
                    'color' => '#aaa',
                ],
                'minorGridlines' => array(
                    'color' => '#eee',
                    'count' => 5,
                ),
                'textPosition' => 'out',
                'textStyle' => Lava::TextStyle(array(
                    'color' => '#C42B5F',
                    'fontName' => 'Arial',
                    'fontSize' => 10
                )),
                //'slantedText' => FALSE,
                //'slantedTextAngle' => 30,
                'title' => $from->format('y-m-d H:i') . ' - ' . $dt->format('Y-m-d H:i'),
                'titleTextStyle' => Lava::TextStyle(array(
                    'color' => '#BB33CC',
                    'fontName' => 'Arial',
                    'fontSize' => 14
                )),
                'maxAlternation' => 1,
                'maxTextLines' => 1
            )),
            'vAxis' => Lava::VerticalAxis(array(
                'gridlines' => [
                    'count' => -1,
                    'color' => '#ddd',
                ],
                'baseline' => 0,
                'baselineColor' => '#CF3BBB',
                //'format' => '## U.',
                'textPosition' => 'out',
                'textStyle' => Lava::TextStyle(array(
                    'color' => '#111',
                    'fontName' => 'Arial Bold',
                    'fontSize' => 10
                )),
                'title' => '0 - 100',
                'titleTextStyle' => Lava::TextStyle(array(
                    'color' => '#5C6DAB',
                    'fontName' => 'Verdana',
                    'fontSize' => 14
                )),
            ))
        );

        $this->name->setdateTimeFormat('H:mm');

        $linechart = Lava::LineChart($this->chartName)
            ->dataTable($this->name)
            ->setOptions($config);

        return $this;
    }
}
