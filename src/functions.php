<?php

namespace DocumentFilter;

function parseCsv($filename) {
    $documents = [];
    if (($handle = fopen($filename, 'r')) !== false) {
        $headers = fgetcsv($handle, null, ';');
        while (($data = fgetcsv($handle, null, ';')) !== false) {
            $document = [];
            foreach ($headers as $index => $header) {
                $value = json_decode($data[$index]);
                $document[$header] = (json_last_error() == JSON_ERROR_NONE) ? $value : $data[$index];
            }
            $documents[] = $document;
        }
        fclose($handle);
    }
    return $documents;
}
