<?php

/**
 * Phpunit bootstrap file.
 * 
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @link https://github.com/avninc/authorize
 * @author Vincent Gabriel <vincent.gabriel@avn.com>
 */

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Test\\', 'tests/');
