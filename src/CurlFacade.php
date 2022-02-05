<?php

namespace osslibs\Curl;

class CurlFacade extends AbstractCurl
{
    public function __construct(Curl $curl = null)
    {
        parent::__construct($curl ?? new CurlHandler());
    }

    public function method(string $method): self
    {
        $this->setopt(CURLOPT_CUSTOMREQUEST, $method);
        return $this;
    }

    public function uri(string $uri): self
    {
        $this->setopt(CURLOPT_URL, $uri);
        return $this;
    }

    public function headersEntryList(array $headers)
    {
        $this->headersStringList(array_map(function ($entry) {
            list($key, $value) = $entry;
            return "{$key}: {$value}";
        }, $headers));
    }

    public function headersAssoc(array $headers)
    {
        $this->headersStringList(array_map(function ($key, $value) {
            return "{$key}: {$value}";
        }, array_keys($headers), array_values($headers)));
    }

    public function headersStringList(?array $headers)
    {
        $headers && $this->setopt(CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function data(?string $data = null)
    {
        $data && $this->setopt(CURLOPT_POSTFIELDS, $data);
        return $this;
    }

    public function timeout(?int $milliseconds = null)
    {
        $this->setopt(CURLOPT_TIMEOUT_MS, $milliseconds);
        return $this;
    }

    public function execute(int &$status=null, array &$headers = [], &$errno=null, &$error=null): string
    {
        $this->setopt(CURLOPT_RETURNTRANSFER, 1);
        $this->setopt(CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
            $length = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) == 2) {
                $key = strtolower(trim($header[0]));
                $value = trim($header[1]);
                $headers[] = [$key, $value];
            }
            return $length;
        });

        $data = $this->exec();
        $status = (int)$this->getinfo(CURLINFO_RESPONSE_CODE);
        $errno = $this->errno();
        $error = $this->error();

        $this->close();

        return $data;
    }
}
