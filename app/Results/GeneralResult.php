<?php

namespace App\Results;

class GeneralResult
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var array|object
     */
    private $data;

    /**
     * @var ErrorCollection[]
     */
    private $errors;

    /**
     * @var string
     */
    private $message;

    public function __construct()
    {
        $this->code = 0;
        $this->data = null;
        $this->errors = [];
        $this->message = '';
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
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|object $data
     *
     * @return self
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return ErrorCollection[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ErrorCollection $error
     * @param bool $toArray
     *
     * @return self
     */
    public function addError(ErrorCollection $error, $toArray = false): self
    {
        $this->errors[] = $toArray ? $error->toArray() : $error;
        return $this;
    }

    /**
     * @param ErrorCollection[] $errors
     *
     * @return self
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return \App\Results\ErrorCollection
     */
    public function getFirstError()
    {
        if (count($this->errors) > 0) {
            return $this->errors[0];
        }

        return new ErrorCollection();
    }

    /**
     * @return array
     */
    public function getErrorsArray(): array
    {
        $data = [];
        foreach ($this->errors as $error) {
            $data[] = [
                // 'code' => $error->getCode(),
                'message' => $error->getMessage(),
                'property' => $error->getProperty(),
            ];
        }

        return $data;
    }
}
