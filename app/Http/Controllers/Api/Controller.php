<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller as BaseController;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use Helpers;

    protected function throwValidationException(Request $request, $validator)
    {
        throw new ResourceException('Validation failed', $validator->getMessageBag());
    }
}
