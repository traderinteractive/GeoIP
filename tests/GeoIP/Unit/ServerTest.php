<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroupTest\GeoIP\Unit;

use \TravelMediaGroup\GeoIP\Server;
use \TravelMediaGroup\GeoIP\TestCase;

class ServerTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testGetIp()
    {
        $ip = '127.0.0.1';
        $_SERVER['REMOTE_ADDR'] = $ip;
        $server = new Server($this->getAdapter());
        
        $this->assertSame($ip, $server->getIp());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetQueryMethod()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_GET['ip'] = '8.8.8.8';
        $server = new Server($this->getAdapter());
        
        $this->assertSame('get', $server->getQueryMethod());
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testPostQueryMethod()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_POST['ip'] = '8.8.8.8';
        $server = new Server($this->getAdapter());
        
        $this->assertSame('post', $server->getQueryMethod());
    }
}
