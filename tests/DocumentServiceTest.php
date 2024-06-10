<?php

use PHPUnit\Framework\TestCase;
use DocumentFilter\CsvParser;
use DocumentFilter\DocumentService;
use DocumentFilter\Interfaces\ConfigurationInterface;
use DocumentFilter\InvalidDataTypeException;
use DocumentFilter\Configuration;

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
     * @var ConfigurationInterface The configuration instance.
     */
    private $config;

    /**
     * Sets up the test environment.
     */
    protected function setUp(): void
    {
        // Load configuration
        $this->config = new Configuration(__DIR__ . '/../config.php');
        
        $this->csvParser = new CsvParser();
        $this->documentService = new DocumentService($this->csvParser, $this->config);
    }

    /**
     * Tests the CSV parsing functionality.
     */
    public function testParseCsv()
    {
        $documents = $this->documentService->loadDocuments();
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
        $documents = $this->documentService->loadDocuments();
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

        $mockConfig = $this->createMock(ConfigurationInterface::class);
        $mockConfig->method('get')->willReturn($invalidCsv);
        
        $this->documentService = new DocumentService($this->csvParser, $mockConfig);

        $this->expectException(InvalidDataTypeException::class);
        $this->documentService->loadDocuments();

        unlink($invalidCsv);
    }
}
