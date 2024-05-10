<?php

namespace App\Services;

use App\Results\ErrorCollection;
use App\Results\GeneralResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ValidatorService
{
    /**
     * @param Request $request
     * @param array $rules
     *
     * @return \App\Results\GeneralResult
     */
    public static function validate(Request $request, array $rules): GeneralResult
    {
        $result = new GeneralResult();

        $cleanRequest = self::sanitize($request->all());

        $validator = Validator::make($cleanRequest, $rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $key => $value) {
                if (count($value) > 0) {
                    foreach ($value as $k => $v) {
                        $result->addError(new ErrorCollection(400, $v, $key));
                    }
                } else {
                    $result->addError(new ErrorCollection(400, $value[0], $key));
                }
            }
        }

        $result->setData($validator->getData());

        return $result;
    }

    /**
     * @param array $datas
     */
    public static function sanitize($datas)
    {
        foreach ($datas as $key => $data) {
            $datas[$key] = Str::of($data)->replace([';', ',', '=', '(', ')', '[', ']', '{', '}'], '');
            $datas[$key] = e($data);
        }

        return $datas;
    }
}
