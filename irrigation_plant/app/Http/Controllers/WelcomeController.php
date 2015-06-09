<?php namespace App\Http\Controllers;

use App\Commands\generateLineChartCommand;
use App\Commands;


class WelcomeController extends Controller
{
    use Commands\ChartTrait;

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

        $this->dispatch(new generateLineChartCommand());
        $reportData = $this->dispatch(new Commands\generateGaugeChartCommand());

//        dd($reportData);

        return view('welcome', ['reports' => $reportData]);
    }

    public function update($format)
    {
        $this->setPresentationFormat($format);

        $updateLineChartData = $this->dispatch(new Commands\updateLineChartCommand());
        $updateGaugeChartData = $this->dispatch(new Commands\updateGaugeChartCommand());
        $updateGaugeChartData['lineChart']['data'] = $updateLineChartData;

        return $updateGaugeChartData;
    }

}
