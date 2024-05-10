<?php

namespace App\Results;
use Illuminate\Support\Collection;

class ErrorCollection extends Collection
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $property;

    public function __construct($code = null, $message = null, $property = null)
    {
        $this->code = $code ?? 0;
        $this->message = $message ?? '';
        $this->property = $property ?? '';
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return self
     */
    public function setCode(int $code): int
    {
        return $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $data
     *
     * @return self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param string $data
     *
     * @return self
     */
    public function setProperty(string $property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'property' => $this->property,
        ];
    }
}
