<?php

require_once __DIR__ . '/Configuration.php';
require_once __DIR__ . '/CsvParser.php';

use DocumentFilter\Configuration;
use DocumentFilter\CsvParser;

if ($argc != 4) {
    echo 'Ambiguous number of parameters!';
    exit(1);
}

$documentType = $argv[1];
$customerId = $argv[2];
$minSum = $argv[3];

$config = new Configuration(__DIR__ . '/../config.php');
$csvParser = new CsvParser($config);
$documents = $csvParser->parse($config->get('csv_path'));
