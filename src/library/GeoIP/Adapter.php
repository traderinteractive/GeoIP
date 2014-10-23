<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroup\GeoIP;

use \GeoIp2\Database\Reader;

class Adapter
{
    /**
     * @var \GeoIp2\Database\Reader
     */
    private $reader;

    /**
     * @param \GeoIp2\Database\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param string $ip
     * @return array
     * @throws \Exception
     */
    public function findByIp($ip)
    {
        if (!$this->isValidIp($ip)) {
            throw new \Exception('invalid or no ip address given');
        }
        $record = $this->getReader()->city($ip);
        $data = [];
        $data['continentName'] = $record->continent->name;
        $data['countryIsoCode'] = $record->country->isoCode;
        $data['countryName'] = $record->country->name;
        $data['mostSpecificSubdivisionIsoCode'] = $record->mostSpecificSubdivision->isoCode;
        $data['mostSpecificSubdivisionName'] = $record->mostSpecificSubdivision->name;
        $data['cityName'] = $record->city->name;
        $data['postalCode'] = $record->postal->code;
        $data['metroCode'] = $record->location->metroCode;
        $data['lat'] = $record->location->latitude;
        $data['lon'] = $record->location->longitude;
        $data['timeZone'] = $record->location->timeZone;
        $data['query']['ip'] = $ip;
        return $data;
    }

    /**
     * @param $ip
     * @return bool
     */
    public function isValidIp($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE) &&
            filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE));
    }

    /**
     * @return \GeoIp2\Database\Reader
     */
    public function getReader()
    {
        return $this->reader;
    }
}
