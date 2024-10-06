<?php

namespace App\Exceptions;
use Illuminate\Http\Request;

use Exception;

class APIException extends Exception
{
    
    public function render(Request $request)
    {
        return response()->json([
            'message' => $this->getMessage(),
            'status' => $this->getCode()< 300
           
        ], $this->getCode());
    }
}
