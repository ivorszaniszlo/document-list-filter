<?php

namespace DocumentFilter;

use Exception;

/**
 * Class InvalidDataTypeException
 * 
 * Custom exception for invalid data types in CSV parsing.
 */
class InvalidDataTypeException extends Exception {}

/**
 * Class CsvParser
 * 
 * Parses CSV files and returns an array of documents.
 */
class CsvParser
{
    /**
     * Parses a CSV file and returns an array of documents.
     *
     * @param string $filename The path to the CSV file.
     * @return array The array of parsed documents.
     * @throws Exception If the file is not found or cannot be opened.
     * @throws InvalidDataTypeException If an invalid data type is encountered.
     */
    public function parse(string $filename): array
    {
        if (!file_exists($filename)) {
            throw new Exception("File not found: $filename");
        }

        if (($handle = fopen($filename, 'r')) === false) {
            throw new Exception("Unable to open file: $filename");
        }

        $documents = [];
        $headers = fgetcsv($handle, null, ';');

        while (($data = fgetcsv($handle, null, ';')) !== false) {
            $documents[] = $this->parseRow($headers, $data);
        }

        fclose($handle);
        return $documents;
    }

    /**
     * Parses a row of CSV data and returns an associative array.
     *
     * @param array $headers The headers of the CSV file.
     * @param array $data The data row from the CSV file.
     * @return array The parsed document.
     * @throws InvalidDataTypeException If an invalid data type is encountered.
     */
    private function parseRow(array $headers, array $data): array
    {
        $document = [];

        foreach ($headers as $index => $header) {
            if (in_array($header, ['id', 'document_type'])) {
                $document[$header] = $data[$index];
            } else {
                $document[$header] = $this->decodeJson($header, $data[$index]);
            }
        }

        return $document;
    }

    /**
     * Decodes a JSON string and returns the value.
     *
     * @param string $header The header name.
     * @param string $json The JSON string.
     * @return mixed The decoded JSON value.
     * @throws InvalidDataTypeException If the JSON is invalid or the data type is incorrect.
     */
    private function decodeJson(string $header, string $json)
    {
        $value = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidDataTypeException("Invalid JSON for header $header");
        }

        if (!is_array($value) && !is_object($value)) {
            throw new InvalidDataTypeException("Invalid data type for header $header");
        }

        return $value;
    }
}
