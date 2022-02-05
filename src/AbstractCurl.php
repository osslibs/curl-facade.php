<?php

namespace osslibs\Curl;

abstract class AbstractCurl implements Curl
{
    /**
     * @var Curl
     */
    private $client;

    public function __construct(Curl $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function resource()
    {
        return $this->client->resource();
    }

    /**
     * @inheritDoc
     */
    public function setopt($option, $value)
    {
        return $this->client->setopt($option, $value);
    }

    /**
     * @inheritDoc
     */
    public function setopt_array(array $options)
    {
        return $this->client->setopt_array($options);
    }

    /**
     * @inheritDoc
     */
    public function exec()
    {
        return $this->client->exec();
    }

    /**
     * @inheritDoc
     */
    public function getinfo($opt = null)
    {
        return $this->client->getinfo($opt);
    }

    /**
     * @inheritDoc
     */
    public function error()
    {
        return $this->client->error();
    }

    /**
     * @inheritDoc
     */
    public function errno()
    {
        return $this->client->errno();
    }

    /**
     * @inheritDoc
     */
    public function escape($str)
    {
        return $this->client->escape($str);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        return $this->client->close();
    }

    /**
     * @inheritDoc
     */
    public function pause($bitmask)
    {
        return $this->client->pause($bitmask);
    }

    /**
     * @inheritDoc
     */
    public function reset()
    {
        return $this->client->reset();
    }
}
