<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroupTest\GeoIP\Unit;

use \TravelMediaGroup\GeoIP\TestCase;

class TestCaseTest extends TestCase
{
    public function testServerIsMock()
    {
        $this->assertInstanceOf('\PHPUnit_Framework_MockObject_MockObject', $this->getServer());
    }

    public function testAdapterHasData()
    {
        $this->assertInstanceOf('\TravelMediaGroup\GeoIP\Adapter', $this->getAdapter());
    }

    public function testFixtureServerResponse()
    {
        $response = json_decode($this->getFixtureServerResponse('get'));
        
        $this->assertSame($response->query->queryMethod, 'get');
    }
}
