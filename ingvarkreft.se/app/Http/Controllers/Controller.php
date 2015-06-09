<?php namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
  private $diagramData;

    public function upload(Request $request)
    {
      $dummy = Input::get();
      $measured_data = Models\Measured::create(array(
        'humidity' => Input::get('humidity'),
        'temperature' => Input::get('temperature'),
        'temperature2' => Input::get('temperature2'),
        'hygrometer' => Input::get('hygrometer'),
	'hygroRaw' => Input::get('hygroRaw'),
      ));

      if ($measured_data->save()) {
        if (Input::get('hygrometer') < 25) {

          return ('C=W_ON');
        }
      }

      return ;
    }

    public function update() {

      $data = Models\Measured::orderBy('created_at', 'desc')->take(1)->get(['temperature','temperature2', 'humidity', 'hygrometer', 'created_at']);

      $labels = $this->getMinutes($data[0]['created_at']);
      $latest[] = $data[0]['temperature'];
      $latest[] = $data[0]['temperature2'];
      $latest[] = $data[0]['humidity'];
      $latest[] = $data[0]['hygrometer'];

      $dataJson = array(
        'values' => $latest,
        'label' => $labels,
        'type' => session('type'),
      );

      return json_encode($dataJson);
    }

    public function changeType($type) {

      session(['type' => $type]);

      $redirect = redirect()->route('home');
      return $redirect;

      //return redirect('home');
    }

    public function show() {

      $this->getDiagramData(session('type'));
      $this->getMinMaxValues(session('type'));

      foreach($this->diagramData->lastHour as $row) {
        $labels[] = $this->getMinutes($row->created_at);
        $temperature[] = $row->temperature;
        $temperature2[] = $row->temperature2;
        $humidity[] = $row->humidity;
        $hygrometer[] = $row->hygrometer;

      }
      $dataJson = array(
        'type' => $this->diagramData->type,
        'labels' => array_reverse($labels),
        'datasets' => array(
          array(
            'label' => 'Temperatur_1',
            'fillColor' => "rgba(220,63,63,0.2)",
            'strokeColor' => "rgba(220,63,63,1)",
            'pointColor' => "rgba(220,63,63,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(220,63,63,1)",
            'data' => array_reverse($temperature),
          ),
          array(
            'label' => 'Temperatur_2',
            'fillColor' => "rgba(110,63,63,0.2)",
            'strokeColor' => "rgba(110,63,63,1)",
            'pointColor' => "rgba(110,63,63,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(110,63,63,1)",
            'data' => array_reverse($temperature2),
          ),
          array(
            'label' => 'Luftfuktighet',
            'fillColor' => "rgba(63,220,63,0.2)",
            'strokeColor' => "rgba(63,220,63,1)",
            'pointColor' => "rgba(63,220,63,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(63,220,63,1)",
            'data' => array_reverse($humidity),
          ),
          array(
            'label' => 'Jordfuktighet',
            'fillColor' => "rgba(63,63,220,0.2)",
            'strokeColor' => "rgba(63,63,220,1)",
            'pointColor' => "rgba(63,63,220,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(63,63,220,1)",
            'data' => array_reverse($hygrometer),
          ),
        ),
      );
      $this->diagramData->json = json_encode($dataJson);

      return view('irrigation', ['measurement_data' => $this->diagramData]);
    }

  public function getDiagramData($type) {

    $this->diagramData = Models\Measured::first();
    $this->diagramData->type = $type;

    if (!isset($type) || $type == '' || $type == 'hour') {
      $this->diagramData->lastHour = Models\Measured::where('created_at',  '>', Carbon::now()->subHour())
        ->orderBy('created_at', 'desc')
        ->take(60)
        ->get(['temperature', 'temperature2', 'humidity', 'hygrometer', 'created_at']);
    }
    elseif ($type == 'day')
    {
      $this->diagramData->lastHour = DB::table('measureds')
        ->select(DB::raw('ROUND(AVG(hygrometer)) AS hygrometer, EXTRACT(HOUR FROM created_at) as created_at'))
        ->addSelect(DB::raw('ROUND(AVG(temperature)) AS temperature, EXTRACT(HOUR FROM created_at)'))
        ->addSelect(DB::raw('ROUND(AVG(temperature2)) AS temperature2, EXTRACT(HOUR FROM created_at)'))
        ->addSelect(DB::raw('ROUND(AVG(humidity)) AS humidity, EXTRACT(HOUR FROM created_at)'))
        ->where('created_at',  '>', Carbon::now()->subDay())
        ->groupBy('EXTRACT(HOUR FROM created_at)')
        ->orderby('created_at', 'desc')
        ->get();
    }
  }

  public function getMinMaxValues($type) {

    if (!isset($type) || $type == '' || $type == 'hour')
    {
      $dateLow = Carbon::now()->subHour();
    }
    elseif ($type == 'day')
    {
      $dateLow = Carbon::now()->subDay();
    }

    $minMaxTemperature = Models\Measured::where('created_at',  '>', $dateLow)->getMinMax('temperature')->get();
    $minMaxTemperature2 = Models\Measured::where('created_at',  '>', $dateLow)->getMinMax('temperature2')->get();
    $minMaxHygrometer = Models\Measured::where('created_at',  '>', $dateLow)->getMinMax('hygrometer')->get('hygrometer');
    $minMaxHumidity = Models\Measured::where('created_at',  '>', $dateLow)->getMinMax('humidity')->get('humidity');

    $this->diagramData->minTemp = $minMaxTemperature[0]->minVal;
    $this->diagramData->maxTemp = $minMaxTemperature[0]->maxVal;
    $this->diagramData->minTemp2 = $minMaxTemperature2[0]->minVal;
    $this->diagramData->maxTemp2 = $minMaxTemperature2[0]->maxVal;
    $this->diagramData->minHygro = $minMaxHygrometer[0]->minVal;
    $this->diagramData->maxHygro = $minMaxHygrometer[0]->maxVal;
    $this->diagramData->minHumi = $minMaxHumidity[0]->minVal;
    $this->diagramData->maxHumi = $minMaxHumidity[0]->maxVal;

    $this->diagramData->actual = Models\Measured::orderBy('created_at', 'desc')->take(1)->get(['temperature', 'temperature2', 'humidity', 'hygrometer']);

  }

  public function getMinutes($time)
  {
    $parts = explode(':', $time);
    return isset($parts[1]) ? $parts[1] : $time;
  }
}
