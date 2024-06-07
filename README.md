
# Document List Filter

This project filters documents from a CSV file based on given parameters. The script accepts three parameters: document type, customer ID, and minimum total value.

## Description

This project filters and lists document data from a CSV file based on given parameters.

## Requirements

- PHP 7.4 or higher

- PHPUnit 9.5 or higher

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/ivorszaniszlo/document-list-filter.git
   cd document-list-filter
   ```

2. Ensure the `document_list.csv` file is in the same directory as the script.

3. Run composer install to install dependencies.

## Usage

Run the script with the following parameters:

```sh
php src/document_list.php <document_type> <customer_id> <min_total>
```

### Example

```sh
php src/document_list.php invoice 1 12500
```

This command filters documents of type `invoice`, with customer ID `1`, and a minimum total value of `12500`.

## Running Tests

To run the tests, use the following command:

```sh
php vendor/bin/phpunit --colors=always tests/DocumentFilterTest.php
```

## Directory Structure

/document-list-filter
    /doc
        Task.pdf
    /src
        Configuration.php
        CsvParser.php
        document_list.php
        DocumentService.php
    /tests
        document_test_list.csv
        DocumentServiceTest.php
    .gitignore
    composer.json
    composer.lock
    config.php
    document_list.csv
    LICENSE
    phpunit.xml
    phpunit.xml.bak
    README.md


## Development

### Refactored Code

The script has been refactored to improve readability, maintainability, and performance. The main script reads data from a CSV file, filters it based on given parameters, and outputs the result.

### Unit Testing

Unit tests have been added using PHPUnit. To run the tests, follow these steps:

1. Install PHPUnit:

   ```sh
   composer require --dev phpunit/phpunit
   ```

2. Run the tests:

   ```sh
   vendor/bin/phpunit tests
   ```

## Contributing

If you have suggestions or improvements, feel free to create a pull request.

## Authors

- [Szaniszló Ivor](https://github.com/ivorszaniszlo)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


