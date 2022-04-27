<?php

namespace App\JsonRpcService;

class Result
{
    /**
     *
     * @var array
     */
    protected $data = null;

    /**
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     *
     * @return string|false
     */
    public function getError()
    {
        return $this->data['error'] ?? false;
    }

    /**
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->data['result'] ?? [];
    }
}
