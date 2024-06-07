<?php

use PHPUnit\Framework\TestCase;
use DocumentFilter\InvalidDataTypeException;
use DocumentFilter\Configuration;
use DocumentFilter\CsvParser;

require_once __DIR__ . '/../src/Configuration.php';
require_once __DIR__ . '/../src/CsvParser.php';

class DocumentFilterTest extends TestCase
{
    public function testParseCsv()
    {
        $config = new Configuration(__DIR__ . '/../config.php');
        $csvParser = new CsvParser($config);
        $expected = [
            [
                'id' => "1",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 1, 'name' => 'Kovács József'],
                'items' => [
                    (object)['name' => 'alma', 'unit_price' => 5000, 'quantity' => 5]
                ]
            ],
            [
                'id' => "2",
                'document_type' => 'proforma',
                'partner' => (object)['id' => 23, 'name' => 'Kiss János'],
                'items' => [
                    (object)['name' => 'körte', 'unit_price' => 3000, 'quantity' => 2],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "3",
                'document_type' => 'receipt',
                'partner' => (object)['id' => 354, 'name' => 'Nagy Béla'],
                'items' => [
                    (object)['name' => 'alma', 'unit_price' => 5000, 'quantity' => 5],
                    (object)['name' => 'körte', 'unit_price' => 3000, 'quantity' => 2],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "4",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 354, 'name' => 'Nagy Béla'],
                'items' => [
                    (object)['name' => 'alma', 'unit_price' => 5000, 'quantity' => 5],
                    (object)['name' => 'körte', 'unit_price' => 3000, 'quantity' => 2],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "5",
                'document_type' => 'receipt',
                'partner' => (object)['id' => 354, 'name' => 'Nagy Béla'],
                'items' => [
                    (object)['name' => 'dinnye', 'unit_price' => 10000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "6",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 1, 'name' => 'Kovács József'],
                'items' => [
                    (object)['name' => 'alma', 'unit_price' => 5000, 'quantity' => 5]
                ]
            ],
            [
                'id' => "7",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 23, 'name' => 'Kiss János'],
                'items' => [
                    (object)['name' => 'körte', 'unit_price' => 3000, 'quantity' => 2],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "8",
                'document_type' => 'receipt',
                'partner' => (object)[],
                'items' => [
                    (object)['name' => 'licsi', 'unit_price' => 7500, 'quantity' => 3]
                ]
            ],
            [
                'id' => "9",
                'document_type' => 'proforma',
                'partner' => (object)['id' => 1, 'name' => 'Kovács József'],
                'items' => [
                    (object)['name' => 'dinnye', 'unit_price' => 10000, 'quantity' => 3],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "10",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 1, 'name' => 'Kovács József'],
                'items' => [
                    (object)['name' => 'dinnye', 'unit_price' => 10000, 'quantity' => 3],
                    (object)['name' => 'szilva', 'unit_price' => 4000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "11",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 354, 'name' => 'Nagy Béla'],
                'items' => [
                    (object)['name' => 'körte', 'unit_price' => 15000, 'quantity' => 3]
                ]
            ],
            [
                'id' => "12",
                'document_type' => 'invoice',
                'partner' => (object)['id' => 354, 'name' => 'Nagy Béla'],
                'items' => [
                    (object)['name' => 'alma', 'unit_price' => 5000, 'quantity' => 5],
                    (object)['name' => 'körte', 'unit_price' => 15000, 'quantity' => 1]
                ]
            ]
        ];

        $documents = $csvParser->parse($config->get('test_csv_path'));
        $this->assertEquals($expected, $documents);
    }

    public function testParseCsvWithInvalidData()
    {
        $this->expectException(InvalidDataTypeException::class);

        $invalidCsvContent = 'id;document_type;partner;items
1;invoice;invalid_json;[{"name":"alma","unit_price":5000,"quantity":5}]';

        $tempFile = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($tempFile, $invalidCsvContent);

        $config = new Configuration(__DIR__ . '/../config.php');
        $csvParser = new CsvParser($config);
        $csvParser->parse($tempFile);

        unlink($tempFile);
    }
}
