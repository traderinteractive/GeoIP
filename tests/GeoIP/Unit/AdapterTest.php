<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroupTest\GeoIP\Unit;

use \TravelMediaGroup\GeoIP\TestCase;

class AdapterTest extends TestCase
{
    public function testGetReader()
    {
        $this->assertInstanceOf('\GeoIp2\Database\Reader', $this->getAdapter()->getReader());
    }

    public function testIsValidIpWithValidIp()
    {
        $ip = '8.8.8.8';

        $this->assertTrue($this->getAdapter()->isValidIp($ip));
    }

    public function testIsValidIpWithInvalidIp()
    {
        $ip = '1234567890';

        $this->assertFalse($this->getAdapter()->isValidIp($ip));
    }

    public function testFindByIpWithValidIp()
    {
        $ip = '8.8.8.8';
        $expectedValue = $this->getFixtureData();
        $result = $this->getAdapter()->findByIp($ip);

        $this->assertSame($expectedValue, $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testFindByIpWithInvalidIp()
    {
        $ip = '1234567890';
        
        $this->getAdapter()->findByIp($ip);
    }
}
