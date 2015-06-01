<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Khill\Lavacharts\Laravel;
use App\reports;
use Khill\Lavacharts;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

      $temperatures = \Lava::DataTable();
      $temp1 = \Lava::DataTable();
      $temp2 = \Lava::DataTable();
      $humi = \Lava::DataTable();
      $hygro = \Lava::DataTable();
      $reports = reports::all(['temperature_1', 'temperature_2', 'humidity', 'hygrometer', 'created_at'])->take(60);
   //   $temp1 = $reports[0]->temperature_1;

      $temperatures->addDateColumn('Date')
        ->addNumberColumn('Givare 1')
        ->addNumberColumn('Givare 2')
        ->addNumberColumn('Luftfuktighet')
        ->addNumberColumn('Jordfuktighet');
      foreach ($reports as $key => $report) {
          $dt = Carbon::parse($report->created_at);
          $temperatures->addRow(array($report->created_at, $report->temperature_1, $report->temperature_2, $report->humidity, $report->hygrometer));
      }

      $temp1->addStringColumn('Type')
        ->addNumberColumn('Value')
        ->addRow(array('℃', $report->temperature_1));
      $temp2->addStringColumn('Type')
        ->addNumberColumn('Value')
        ->addRow(array('℃', $report->temperature_2));
      $humi->addStringColumn('Type')
        ->addNumberColumn('Value')
        ->addRow(array('%', $report->humidity));
      $hygro->addStringColumn('Type')
        ->addNumberColumn('Value')
        ->addRow(array('%', $report->hygrometer));

      $gaugeTemp1 = $this->addDataTableTemp('Temp1', $temp1);
      $gaugeTemp2 = $this->addDataTableTemp('Temp2', $temp2);
      $gaugeHumi = $this->addDataTable('Humi', $humi);
      $gaugeHygro = $this->addDataTable('Hygro', $hygro);

      $chartArea = \Lava::ChartArea(array(
        'left'   => '5%',
        'top'    => 10,
        'width'  => '80%',
        'height' => 400
      ));
      $hAxis = \Lava::HorizontalAxis(array(
        'format' => 'h:m',
      ));

      $linechart = \Lava::LineChart('Temps')
          ->dataTable($temperatures)
          ->title('Den senaste timmen')
          ->setOptions(array(
              'curveType' => 'function',
              'height' => 400,
              'chartArea' => $chartArea,
              'hAxis' => $hAxis,
    ));
      $reportData = new \stdClass();
      $reportData->maxTemp = 25.65;
      $reportData->minTemp = 22.25;
      $reportData->temperature = 24.5;
      $reportData->maxTemp2 = 23.25;
      $reportData->minTemp2 = 22.35;
      $reportData->temperature2 = 24.45;
      $reportData->maxHygro = 25;
      $reportData->minHygro = 22;
      $reportData->hygrometer = 24;
      $reportData->maxHumi = 25;
      $reportData->minHumi = 22;
      $reportData->humidity = 24;


      return view('welcome', ['gaugeTemp1' => $gaugeTemp1, 'linechart' => $linechart, 'reports' => $reportData]);
	}

    private function addDataTableTemp ($name, $table) {
        return \Lava::GaugeChart($name)
            ->setOptions(array(
                'datatable' => $table,
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 10,
                'greenFrom' => 10,
                'greenTo' => 30,
                'redFrom' => 30,
                'redTo' => 40,
                'max' => 40,
                'majorTicks' => array(
                    'Kall',
                    'Normal',
                    'Het'
                ),
            )
        );
    }

    private function addDataTable ($name, $table) {
        return \Lava::GaugeChart($name)
            ->setOptions(array(
                'datatable' => $table,
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 30,
                'greenFrom' => 30,
                'greenTo' => 70,
                'redFrom' => 70,
                'redTo' => 100,
                'max' => 100,
                'majorTicks' => array(
                    'Torr',
                    'Normal',
                    'Blöt'
                ),
            )
        );
    }

}
