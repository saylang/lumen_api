<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\BaseController;
use App\Repositories\V1\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Auth\Factory as Auth;

class BlogController extends BaseController {

    /** @var BlogRepository */
    protected $_blogRepository;
    protected $auth;

    public function __construct(BlogRepository $blogRepository, Auth $auth) {
        $this->_blogRepository = $blogRepository;
        $this->auth = $auth;
    }

    public function list(Request $request) {
        try {
            //dd($this->auth->user()->id);
            return Response()->json(['blogs' => $this->_blogRepository->getList()]);
        } catch (QueryException $e) {
            return $this->queryExceptionHandler($e);
        } catch (\Exception $ex) {
            return $this->generalExceptionHandler($ex);
        }
    }
}