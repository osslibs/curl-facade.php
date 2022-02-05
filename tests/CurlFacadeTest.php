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
        $expect = "alkdsfjldf";
        $curl = Mockery::mock(Curl::class);
        $curl->shouldReceive('setopt')->once()->with(CURLOPT_RETURNTRANSFER, 1);
        $curl->shouldReceive('setopt')->once()->withSomeOfArgs(CURLOPT_HEADERFUNCTION);
        $curl->shouldReceive('getinfo')->once()->with(CURLINFO_RESPONSE_CODE)->andReturn(123);
        $curl->shouldReceive('errno')->once()->with()->andReturn(456);
        $curl->shouldReceive('error')->once()->with()->andReturn("foobar");
        $curl->shouldReceive('exec')->once()->andReturn($expect);
        $curl->shouldReceive('close')->once();
        $facade = new CurlFacade($curl);
        $headers = [];
        $actual = $facade->execute($status, $headers, $errno, $error);
        $this->assertSame(123, $status);
        $this->assertSame(456, $errno);
        $this->assertSame("foobar", $error);
        $this->assertSame($expect, $actual);
    }
}
