<?php

namespace DocumentFilter\Interfaces;

interface DocumentServiceInterface
{
    public function loadDocuments(): array;
    public function filterDocuments(array $documents, string $documentType, int $customerId, float $minSum): array;
    public function printDocuments(array $documents): void;
}
