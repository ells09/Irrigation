<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-05-07
 * Time: 08:50
 */

namespace Irrigation;

use Laravel\Lumen\Application;

class IrrigationApplication extends Application{

  public function publicPath()
  {
    return $this->basePath . '/public_html';
  }

}