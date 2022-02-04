<?php

namespace osslibs\Curl;

class CurlFacade extends AbstractCurl
{
    /**
     * @var CurlClient
     */
    private $curl;

    public function __construct(Curl $curl = null)
    {
        $this->curl = $curl ?? new CurlHandler();
    }

    public function method(string $method): self
    {
        $this->curl->setopt(CURLOPT_CUSTOMREQUEST, $method);
        return $this;
    }

    public function uri(string $uri): self
    {
        $this->curl->setopt(CURLOPT_URL, $uri);
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
        $headers && $this->curl->setopt(CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function data(?string $data = null)
    {
        $data && $this->curl->setopt(CURLOPT_POSTFIELDS, $data);
        return $this;
    }

    public function timeout(?int $milliseconds = null)
    {
        $milliseconds && $this->curl->setopt(CURLOPT_TIMEOUT_MS, $milliseconds);
        return $this;
    }

    /**
     * @return CurlResponse
     * @throws CurlException
     */
    public function execute(): CurlResponse
    {
        $headers = [];

        $this->curl->setopt(CURLOPT_RETURNTRANSFER, 1);
        $this->curl->setopt(CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$headers) {
            $length = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) == 2) {
                $key = strtolower(trim($header[0]));
                $value = trim($header[1]);
                $headers[] = [$key, $value];
            }
            return $length;
        });

        $data = $this->curl->exec();
        $status = (int)$this->curl->getinfo(CURLINFO_RESPONSE_CODE);
        $error = $this->curl->errno();

        if ($error !== 0) {
            throw new CurlException($curl->error(), $error);
        }

        $this->curl->close();

        return new CurlResponse($status, $headers, $data);
    }
}
