<?php

require_once __DIR__ . '/functions.php';

use function DocumentFilter\parseCsv;

if ($argc != 4) {
    echo 'Ambiguous number of parameters!';
    exit(1);
}

$documentType = $argv[1];
$customerId = $argv[2];
$minSum = $argv[3];

$documents = parseCsv('document_list.csv');
