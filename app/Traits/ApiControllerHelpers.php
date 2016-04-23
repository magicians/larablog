<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait ApiControllerHelpers
{
    
    /**
     * @param $data
     * @return JsonResponse
     */
    protected function respondJson($data)
    {
        if (is_bool($data)) {
            $data = ['success' => !!$data];
        }

        return new JsonResponse($data);
    }
    
        /**
     * @param Request $request
     */
    protected function validateStore(Request $request)
    {
        if(isset($this->rules) || isset($this->storeRules)){
            $rules = isset($this->storeRules) ? $this->storeRules : $this->rules;
            $this->validate($request, $rules);
        }
    }

    /**
     * @param Request $request
     */
    public function validateUpdate(Request $request)
    {
        if(isset($this->rules) || isset($this->updateRules)){
            $rules = isset($this->updateRules) ? $this->updateRules : $this->rules;
            $this->validate($request, $rules);
        }
    }
}