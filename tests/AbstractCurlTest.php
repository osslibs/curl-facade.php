<?php

namespace osslibs\Curl;

use PHPUnit\Framework\TestCase;
use Mockery;

class AbstractCurlTest extends TestCase
{
    /**
     * @var Mockery\LegacyMockInterface|Mockery\MockInterface|Curl
     */
    private $curl;

    /**
     * @var AbstractCurl
     */
    private $abstract;

    protected function setUp()
    {
        parent::setUp();
        $this->curl = Mockery::mock(Curl::class);
        $this->abstract = new class($this->curl) extends AbstractCurl {
            public function __construct(Curl $client)
            {
                parent::__construct($client);
            }
        };
    }

    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();;
    }

    public function testResource()
    {
        $expect = (object)[];
        $this->curl->shouldReceive('resource')->once()->andReturn($expect);
        $actual = $this->abstract->resource();
        $this->assertSame($expect, $actual);
    }

    public function testSetOpt()
    {
        $key = 'a';
        $value = 'b';
        $this->curl->shouldReceive('setopt')->once()->with($key, $value);
        $this->abstract->setopt($key, $value);
    }

    public function testSetOptArray()
    {
        $array = ['a' => 'b', 'c' => 'd'];
        $this->curl->shouldReceive('setopt_array')->once()->with($array);
        $this->abstract->setopt_array($array);
    }

    public function testExec()
    {
        $this->curl->shouldReceive('exec')->once();
        $actual = $this->abstract->exec();
    }

    public function testGetinfo()
    {
        $key = 'foo';
        $expect = 'bar';
        $this->curl->shouldReceive('getinfo')->once()->with($key)->andReturn($expect);
        $actual = $this->abstract->getinfo($key);
        $this->assertSame($expect, $actual);
    }

    public function testError()
    {
        $expect = 'b';
        $this->curl->shouldReceive('error')->once()->andReturn($expect);
        $actual = $this->abstract->error();
        $this->assertSame($expect, $actual);
    }

    public function testErrno()
    {
        $expect = 567;
        $this->curl->shouldReceive('errno')->once()->andReturn($expect);
        $actual = $this->abstract->errno();
        $this->assertSame($expect, $actual);
    }

    public function testEscape()
    {
        $value = "a";
        $expect = 'b';
        $this->curl->shouldReceive('escape')->once()->with($value)->andReturn($expect);
        $actual = $this->abstract->escape($value);
        $this->assertSame($expect, $actual);
    }

    public function testClose()
    {
        $this->curl->shouldReceive('close')->once();
        $this->abstract->close();
    }

    public function testPause()
    {
        $bitmask = 0x1;
        $this->curl->shouldReceive('pause')->once()->with($bitmask);
        $this->abstract->pause($bitmask);
    }

    public function testReset()
    {
        $this->curl->shouldReceive('reset')->once();
        $this->abstract->reset();
    }
}
