<?php

namespace DocumentFilter\Interfaces;

interface CsvParserInterface
{
    public function parse(string $filename): array;
}
