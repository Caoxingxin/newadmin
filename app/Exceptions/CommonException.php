<?php

namespace App\Exceptions;

use Exception;

class CommonException extends Exception
{
    private $_code = 400;

    private $error_data;

    public function __construct($cause = 'BusinessException.', $data=[])
    {
        parent::__construct($cause);

        $this->error_data = $data;
    }

    public function getResponse()
    {

        $ret = [
            'message' => trans('business.' . $this->getMessage(), $this->error_data),
            'code' => $this->getMessage(),
            'type' => 'business_error',
        ];
        if(!empty($this->error_data)){
            $ret['data'] = $this->error_data;
        }
        return response()->json($ret, $this->_code);
    }

}
