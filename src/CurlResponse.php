<?php

namespace osslibs\Curl;

class CurlResponse
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var null|string
     */
    private $data;

    public function __construct(int $status, array $headers, ?string $data = null)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->data = $data;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function headersEntryList()
    {
        return $this->headers;
    }

    public function headersAssoc()
    {
        $headers = [];
        foreach ($this->headers as $entry) {
            list($key, $value) = $entry;
            $headers[$key] = $value;
        }
        return $headers;
    }

    public function stringListHeaders()
    {
        return array_map(function ($entry) {
            list($key, $value) = $entry;
            return "{$key}: {$value}";
        }, $this->headers);
    }

    public function data(): ?string
    {
        return $this->data;
    }
}