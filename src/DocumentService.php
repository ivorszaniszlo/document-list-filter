<?php

namespace DocumentFilter;

class DocumentService
{
    private $csvParser;

    public function __construct(CsvParser $csvParser)
    {
        $this->csvParser = $csvParser;
    }

    public function filterDocuments(array $documents, $documentType, $customerId, $minSum)
    {
        return array_filter($documents, function($item) use ($documentType, $customerId, $minSum) {
            $partner = (array)$item['partner'];
            $isCustomer = !empty($partner['id']) && $partner['id'] == $customerId;
            $isType = $item['document_type'] == $documentType;
            $total = array_reduce($item['items'], function($sum, $currentItem) {
                return $sum + $currentItem->unit_price * $currentItem->quantity;
            }, 0);
            return $isCustomer && $isType && $total >= $minSum;
        });
    }

    public function printDocuments(array $documents)
    {
        $headers = ['document_id', 'document_type', 'partner name', 'total'];
        foreach ($headers as $header) {
            echo str_pad($header, 20);
        }
        echo "\n";
        foreach ($headers as $header) {
            echo str_repeat('=', 20);
        }
        echo "\n";

        foreach ($documents as $item) {
            $total = array_reduce($item['items'], function($sum, $currentItem) {
                return $sum + $currentItem->unit_price * $currentItem->quantity;
            }, 0);

            echo str_pad($item['id'], 20);
            echo str_pad($item['document_type'], 20);
            echo str_pad($item['partner']->name ?? '', 20);
            echo str_pad($total, 20);
            echo "\n";
        }
    }
}
