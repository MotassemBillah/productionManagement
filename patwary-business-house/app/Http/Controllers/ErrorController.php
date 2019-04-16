<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Exception;

class ErrorController extends HomeController {

    public function index(Exception $exception) {
        $trace = $exception->getTraceAsString();
        return view('errors.default', compact('trace'));
    }

}
