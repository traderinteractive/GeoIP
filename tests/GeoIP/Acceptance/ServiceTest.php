<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroupTest\GeoIP\Acceptance;

use \TravelMediaGroup\GeoIP\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @dataProvider provideQueryMethods
     * @param string $queryMethod
     */
    public function testRunWithValidIp($queryMethod)
    {
        ob_start();

        $this->getServer()
            ->expects($this->any())
            ->method('getIp')
            ->will($this->returnValue('8.8.8.8'));

        $this->getServer()
            ->expects($this->any())
            ->method('getQueryMethod')
            ->will($this->returnValue($queryMethod));

        $this->getServer()->run();

        $output = ob_get_clean();

        $this->assertSame($this->getFixtureServerResponse($queryMethod), $output);

        $expectedHeaders = ['Content-Type: application/json'];
        $this->assertSame($expectedHeaders, $this->getServer()->getHeaders());
    }

    /**
     * @runInSeparateProcess
     */
    public function testRunWithInvalidIp()
    {
        ob_start();
        
        $this->getServer()
            ->expects($this->any())
            ->method('getIp')
            ->will($this->returnValue('1234567890'));

        $this->getServer()
            ->expects($this->any())
            ->method('getQueryMethod')
            ->will($this->returnValue('get'));

        $this->getServer()->run();

        $output = ob_get_clean();

        $error = [
            'error' => true,
            'errorDetail' => 'invalid or no ip address given'
        ];
        $expectedOutput = json_encode($error, JSON_PRETTY_PRINT);
        $this->assertSame($expectedOutput, $output);

        $expectedHeaders = ['Content-Type: application/json', 'HTTP/1.0 400 Bad Request'];
        $this->assertSame($expectedHeaders, $this->getServer()->getHeaders());
    }

    /**
     * @return array
     */
    public function provideQueryMethods()
    {
        return [
            ['post'], ['get'], ['default']
        ];
    }
}
