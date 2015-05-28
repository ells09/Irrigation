<?php namespace App\Http\Controllers;

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
      $reports = reports::all(['temperature_1', 'temperature_2', 'humidity', 'hygrometer', 'created_at'])->take(60);
   //   $temp1 = $reports[0]->temperature_1;

      $temperatures->addDateColumn('Date')
        ->addNumberColumn('Växthus')
        ->addNumberColumn('Tält')
        ->addNumberColumn('Luftfuktighet')
        ->addNumberColumn('Jordfuktighet');
      foreach ($reports as $key => $report) {
          $temperatures->addRow(array($report->created_at, $report->temperature_1, $report->temperature_2, $report->humidity, $report->hygrometer));
      }

      $temp1->addStringColumn('Type')
        ->addNumberColumn('Value')
        ->addRow(array('℃', 24.3));

      $gauge = \Lava::GaugeChart('Temp1')
        ->setOptions(array(
          'datatable' => $temp1,
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
        ));
/*
      ->addRow(array('2014-10-1', 67, 65, 62))
        ->addRow(array('2014-10-2', 68, 65, 61))
        ->addRow(array('2014-10-3', 68, 62, 55))
        ->addRow(array('2014-10-4', 72, 62, 52))
        ->addRow(array('2014-10-5', 61, 54, 47))
        ->addRow(array('2014-10-6', 70, 58, 45))
        ->addRow(array('2014-10-7', 74, 70, 65))
        ->addRow(array('2014-10-8', 75, 69, 62))
        ->addRow(array('2014-10-9', 69, 63, 56))
        ->addRow(array('2014-10-10', 64, 58, 52))
        ->addRow(array('2014-10-11', 59, 55, 50))
        ->addRow(array('2014-10-12', 65, 56, 46))
        ->addRow(array('2014-10-13', 66, 56, 46))
        ->addRow(array('2014-10-14', 75, 70, 64))
        ->addRow(array('2014-10-15', 76, 72, 68))
        ->addRow(array('2014-10-16', 71, 66, 60))
        ->addRow(array('2014-10-17', 72, 66, 60))
        ->addRow(array('2014-10-18', 63, 62, 62));
*/
      $chartArea = \Lava::ChartArea(array(
        'left'   => '5%',
        'top'    => 10,
        'width'  => '80%',
        'height' => 400
      ));
      $linechart = \Lava::LineChart('Temps')
          ->dataTable($temperatures)
          ->title('Den senaste timmen')
          ->setOptions(array(
              'curveType' => 'function',
              'height' => 400,
              'chartArea' => $chartArea,
    ));
      $reportData = new \stdClass();
      $reportData->maxTemp = 25;
      $reportData->minTemp = 22;
      $reportData->temperature = 24;
      $reportData->maxTemp2 = 25;
      $reportData->minTemp2 = 22;
      $reportData->temperature2 = 24;
      $reportData->maxHygro = 25;
      $reportData->minHygro = 22;
      $reportData->hygrometer = 24;
      $reportData->maxHumi = 25;
      $reportData->minHumi = 22;
      $reportData->humidity = 24;


      return view('welcome', ['gauge' => $gauge, 'linechart' => $linechart, 'reports' => $reportData]);
	}

}
