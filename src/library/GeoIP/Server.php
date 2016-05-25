<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TravelMediaGroup\GeoIP;

class Server
{
    /** @var \TravelMediaGroup\GeoIP\Adapter */
    private $adapter;

    /** @var string */
    private $ip;

    /** @var array */
    private $response = [];

    /** @var string */
    private $queryMethod = 'default';

    /** @var array */
    private $headers = ['Content-Type: application/json'];

    /**
     * @param \TravelMediaGroup\GeoIP\Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->parse();
    }

    /**
     * Parse the request.
     */
    public function parse()
    {
        $this->ip = isset($_REQUEST['ip']) ? $_REQUEST['ip'] : $_SERVER['REMOTE_ADDR'];

        if (isset($_POST['ip'])) {
            $this->queryMethod = 'post';
        } elseif (isset($_GET['ip'])) {
            $this->queryMethod = 'get';
        }
    }

    /**
     * Processes the input and serves the response.
     */
    public function run()
    {
        try {
            $this->response = $this->getAdapter()->findByIp($this->getIp());
            $this->response['query']['queryMethod'] = $this->getQueryMethod();
        } catch (\Exception $ex) {
            $this->response['error'] = true;
            $this->response['errorDetail'] = $ex->getMessage();
        }

        $this->respond();
    }

    /**
     * Prints the response.
     */
    public function respond()
    {
        ob_start();

        $this->buildHeaders();

        echo json_encode($this->getResponse(), JSON_PRETTY_PRINT);

        $output = ob_get_clean();

        foreach ($this->getHeaders() as $header) {
            header($header);
        }

        echo $output;
    }

    /**
     * Builds the array of response headers.
     */
    public function buildHeaders()
    {
        $response = $this->getResponse();

        if (isset($response['error']) && $response['error']) {
            $this->headers[] = 'HTTP/1.0 400 Bad Request';
        }

        $this->headers = array_unique($this->headers);
    }

    /**
     * @return \TravelMediaGroup\GeoIP\Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getQueryMethod()
    {
        return $this->queryMethod;
    }
}
