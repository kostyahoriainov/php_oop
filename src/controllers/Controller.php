<?php

namespace Controllers;

use Resourse\Request;

abstract class Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    protected function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function checkRequestParamsForEmpty(array $request_params): array
    {
        $errors = [];
        foreach ($request_params as $key => $param) {
            if (empty($param)) {
                $errors[$key] = true;
            }
        }

        return $errors;
    }
}

