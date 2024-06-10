<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DocumentFilter\DocumentService;
use DocumentFilter\CsvParser;
use DocumentFilter\Configuration;

/**
 * This script filters and prints documents based on provided parameters.
 * 
 * Usage: php document_list.php <document_type> <customer_id> <min_sum>
 */

define('EXPECTED_ARGC', 4);

/**
 * Validate and parse command line arguments.
 *
 * @param int $argc The number of arguments.
 * @param array $argv The array of arguments.
 * @return array The validated and parsed arguments.
 * @throws InvalidArgumentException If the arguments are invalid.
 */
function getCommandLineArguments(int $argc, array $argv): array
{
    if ($argc !== EXPECTED_ARGC) {
        throw new InvalidArgumentException('Ambiguous number of parameters!' . PHP_EOL .
            'Usage: php document_list.php <document_type> <customer_id> <min_sum>');
    }

    $documentType = $argv[1];
    $customerId = $argv[2];
    $minSum = $argv[3];

    if (!is_numeric($customerId) || !is_numeric($minSum)) {
        throw new InvalidArgumentException('Customer ID and Minimum Sum must be numeric values.');
    }

    return [$documentType, $customerId, $minSum];
}

try {
    list($documentType, $customerId, $minSum) = getCommandLineArguments($argc, $argv);

    $csvParser = new CsvParser();
    $config = new Configuration(__DIR__ . '/../config.php');
    $service = new DocumentService($csvParser, $config);

    // Load and parse the CSV file
    $documents = $service->loadDocuments();

    // Filter the documents based on the parameters
    $filteredDocuments = $service->filterDocuments($documents, $documentType, $customerId, $minSum);

    // Print the filtered documents
    $service->printDocuments($filteredDocuments);
} catch (InvalidArgumentException $e) {
    echo 'Invalid Argument: ' . $e->getMessage() . PHP_EOL;
    exit(1);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
