<?php
/**
 * This file is part of the GeoIP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// change directories to the project root
chdir(dirname(__DIR__));

// pull in dependencies
require 'vendor/autoload.php';

// set the default date if necessary
if (date_default_timezone_get() == 'UTC') {
    date_default_timezone_set('America/New_York');
}
