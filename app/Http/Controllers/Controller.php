<?php

namespace App\Http\Controllers;

/**
* @OA\Info(
*      version="1.0.0",
*      title="Bookstore API",
*      description="This is the documentation for the bookstore API. The Postman Url is https://www.getpostman.com/collections/4382c3395a389aa1ebd9",
*      @OA\Contact(
*          email="setty.095@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="Bookstore API"
* )
*/

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
