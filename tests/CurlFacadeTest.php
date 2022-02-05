<?php

namespace osslibs\Curl;

use PHPUnit\Framework\TestCase;
use Mockery;

class CurlFacadeTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testMethod()
    {
        $value = "foo";
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_CUSTOMREQUEST, $value);
        $facade = new CurlFacade($curl);
        $facade->method($value);
    }

    public function testUri()
    {
        $value = "foo";
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_URL, $value);
        $facade = new CurlFacade($curl);
        $facade->uri($value);
    }

    public function testHeadersEntryList()
    {
        $value = [['a', 'b'], ['c', 'd']];
        $expect = ['a: b', 'c: d'];
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_HTTPHEADER, $expect);
        $facade = new CurlFacade($curl);
        $facade->headersEntryList($value);
    }

    public function testHeadersAssoc()
    {
        $value = ['a' => 'b', 'c' => 'd'];
        $expect = ['a: b', 'c: d'];
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_HTTPHEADER, $expect);
        $facade = new CurlFacade($curl);
        $facade->headersAssoc($value);
    }

    public function testHeadersStringList()
    {
        $value = ['a: b', 'c: d'];
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_HTTPHEADER, $value);
        $facade = new CurlFacade($curl);
        $facade->headersStringList($value);
    }

    public function testData()
    {
        $value = "foobar";
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_POSTFIELDS, $value);
        $facade = new CurlFacade($curl);
        $facade->data($value);
    }

    public function testTimeout()
    {
        $value = 1234;
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_TIMEOUT_MS, $value);
        $facade = new CurlFacade($curl);
        $facade->timeout($value);
    }

    public function testExecute()
    {
//        $curl = Mockery::mock(Curl::class);
//        $curl->shouldReceive('exec')->once();
//        $facade = new CurlFacade($curl);
//        $facade->execute();
    }
}
