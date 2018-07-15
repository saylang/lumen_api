<?php
namespace App\Http\Controllers;

class BaseController extends Controller
{
    public function generalExceptionHandler($e = null) {
        return Response()->json([
            'Error' => 'Invalid Request',
            'DevError' => $e ? $e->getMessage() : "",
            'Code'  => isset($e) && $e ? $e->getCode() : 0
        ], 400);
    }

    public function queryExceptionHandler($ex) {
        return Response()->json([
            'Error' => "Data error",
            'DevError' => isset($ex) && $ex ? $ex->getMessage() : "",
            'Code'  => 4096
        ], 400);
    }
}