<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DocumentFilter\DocumentService;
use DocumentFilter\CsvParser;

if ($argc != 4) {
    echo 'Ambiguous number of parameters!';
    exit(1);
}

$documentType = $argv[1];
$customerId = $argv[2];
$minSum = $argv[3];

$csvParser = new CsvParser();
$service = new DocumentService($csvParser);

$documents = $csvParser->parse('document_list.csv');
$filteredDocuments = $service->filterDocuments($documents, $documentType, $customerId, $minSum);
$service->printDocuments($filteredDocuments);