<?php

use PHPUnit\Framework\TestCase;
use DocumentFilter\CsvParser;
use DocumentFilter\DocumentService;
use DocumentFilter\InvalidDataTypeException;

/**
 * Class DocumentServiceTest
 * 
 * PHPUnit test case for the DocumentService class.
 */
class DocumentServiceTest extends TestCase
{
    /**
     * @var CsvParser The CSV parser instance.
     */
    private $csvParser;

    /**
     * @var DocumentService The document service instance.
     */
    private $documentService;

    /**
     * @var string The path to the test CSV file.
     */
    private $testCsvFile;

    /**
     * Sets up the test environment.
     */
    protected function setUp(): void
    {
        // Load configuration
        $config = require __DIR__ . '/../config.php';
        
        $this->csvParser = new CsvParser();
        $this->documentService = new DocumentService($this->csvParser);
        $this->testCsvFile = $config['test_csv_path'];
    }

    /**
     * Tests the CSV parsing functionality.
     */
    public function testParseCsv()
    {
        $documents = $this->csvParser->parse($this->testCsvFile);
        $this->assertIsArray($documents);
        $this->assertCount(12, $documents);

        // Additional assertions to check if the parsed data is correct
        $this->assertEquals('invoice', $documents[0]['document_type']);
        $this->assertEquals(1, $documents[0]['partner']->id);
    }

    /**
     * Tests the document filtering functionality.
     */
    public function testFilterDocuments()
    {
        $documents = $this->csvParser->parse($this->testCsvFile);
        $filteredDocuments = $this->documentService->filterDocuments($documents, 'receipt', 354, 1500);

        $this->assertIsArray($filteredDocuments);
        $this->assertCount(2, $filteredDocuments);

        foreach ($filteredDocuments as $document) {
            $this->assertEquals('receipt', $document['document_type']);
            $this->assertEquals(354, $document['partner']->id);
        }
    }

    /**
     * Tests the handling of invalid JSON data in the CSV file.
     */
    public function testInvalidJson()
    {
        $invalidCsv = __DIR__ . '/invalid_document_test_list.csv';
        file_put_contents($invalidCsv, "id;document_type;partner;items\n1;invoice;invalid_json;[{}]");

        $this->expectException(InvalidDataTypeException::class);
        $this->csvParser->parse($invalidCsv);

        unlink($invalidCsv);
    }
}
