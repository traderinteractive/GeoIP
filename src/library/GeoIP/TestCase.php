<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroup\GeoIP;

use \TravelMediaGroup\GeoIP;
use \GeoIp2\Database\Reader;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $server;

    /** @var \TravelMediaGroup\GeoIP\Adapter */
    protected $adapter;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getServer()
    {
        if (!$this->server) {
            $adapter = $this->getAdapter();
            $methods = ['getIp', 'parse', 'getQueryMethod'];
            $this->server = $this->getMockBuilder('\TravelMediaGroup\GeoIP\Server')
                ->setMethods($methods)
                ->setConstructorArgs([$adapter])
                ->getMock();
        }

        return $this->server;
    }

    /**
     * @return Adapter
     */
    protected function getAdapter()
    {
        if (!$this->adapter) {
            $db = 'db/GeoLite2-City.mmdb';
            $this->adapter = new GeoIP\Adapter(new Reader($db));
        }

        return $this->adapter;
    }

    /**
     * @param string $queryMethod
     * @return string
     */
    protected function getFixtureServerResponse($queryMethod = 'default')
    {
        $data = $this->getFixtureData();
        $data['query']['queryMethod'] = $queryMethod;

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    protected function getFixtureData()
    {
        $fixture = 'tests/fixture.json';
        $data = json_decode(file_get_contents($fixture), true);

        return $data;
    }
}
