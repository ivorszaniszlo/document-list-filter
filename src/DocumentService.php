<?php

namespace DocumentFilter;

/**
 * Class DocumentService
 * 
 * Provides services for filtering and printing documents.
 */
class DocumentService
{
    /**
     * @var CsvParser The CSV parser instance.
     */
    private $csvParser;

    /**
     * DocumentService constructor.
     * 
     * @param CsvParser $csvParser The CSV parser instance.
     */
    public function __construct(CsvParser $csvParser)
    {
        $this->csvParser = $csvParser;
    }

    /**
     * Filters documents based on document type, customer ID, and minimum sum.
     * 
     * @param array $documents The array of documents to filter.
     * @param string $documentType The document type to filter by.
     * @param int $customerId The customer ID to filter by.
     * @param float $minSum The minimum sum to filter by.
     * @return array The filtered array of documents.
     */
    public function filterDocuments(array $documents, string $documentType, int $customerId, float $minSum): array
    {
        return array_filter($documents, function($item) use ($documentType, $customerId, $minSum) {
            $partner = (array)$item['partner'];
            $isCustomer = $this->isCustomer($partner, $customerId);
            $isType = $item['document_type'] == $documentType;
            $total = $this->calculateTotal($item['items']);
            return $isCustomer && $isType && $total >= $minSum;
        });
    }

    /**
     * Checks if the document belongs to the specified customer.
     *
     * @param array $partner The partner data.
     * @param int $customerId The customer ID.
     * @return bool True if the document belongs to the customer, false otherwise.
     */
    private function isCustomer(array $partner, int $customerId): bool
    {
        return !empty($partner['id']) && $partner['id'] == $customerId;
    }

    /**
     * Calculates the total sum of the document items.
     *
     * @param array $items The document items.
     * @return float The total sum.
     */
    private function calculateTotal(array $items): float
    {
        return array_reduce($items, function($sum, $currentItem) {
            return $sum + $currentItem->unit_price * $currentItem->quantity;
        }, 0);
    }

    /**
     * Prints the filtered documents in a table format.
     * 
     * @param array $documents The array of documents to print.
     * @return void
     */
    public function printDocuments(array $documents): void
    {
        $headers = ['document_id', 'document_type', 'partner name', 'total'];
        
        $this->printRow($headers);
        $this->printRow(array_fill(0, count($headers), str_repeat('=', 20)));

        foreach ($documents as $item) {
            $total = $this->calculateTotal($item['items']);
            $row = [
                $item['id'],
                $item['document_type'],
                $item['partner']->name ?? '',
                $total
            ];
            $this->printRow($row);
        }
    }

    /**
     * Prints a single row of data.
     *
     * @param array $row The data to print.
     * @return void
     */
    private function printRow(array $row): void
    {
        foreach ($row as $cell) {
            echo str_pad($cell, 20);
        }
        echo PHP_EOL;
    }
}
