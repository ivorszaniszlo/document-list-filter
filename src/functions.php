<?php

namespace DocumentFilter;

use Exception;

class InvalidDataTypeException extends Exception {}
class FileNotFoundException extends Exception {}

function parseCsv($filename) {
    $documents = [];
    if (!file_exists($filename)) {
        throw new FileNotFoundException("File not found: $filename");
    }
    if (($handle = fopen($filename, 'r')) !== false) {
        $headers = fgetcsv($handle, null, ';');
        while (($data = fgetcsv($handle, null, ';')) !== false) {
            $document = [];
            foreach ($headers as $index => $header) {
                // Treat 'id' and 'document_type' fields as simple strings/numbers
                if (in_array($header, ['id', 'document_type'])) {
                    $document[$header] = $data[$index];
                } else {
                    $value = json_decode($data[$index]);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        if (!is_array($value) && !is_object($value)) {
                            throw new InvalidDataTypeException("Invalid data type for header $header");
                        }
                        $document[$header] = $value;
                    } else {
                        throw new InvalidDataTypeException("Invalid JSON for header $header");
                    }
                }
            }
            $documents[] = $document;
        }
        fclose($handle);
    } else {
        throw new Exception("Unable to open file: $filename");
    }
    return $documents;
}
