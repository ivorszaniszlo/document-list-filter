
# Document List Filter

This project filters documents from a CSV file based on given parameters. The script accepts three parameters: document type, customer ID, and minimum total value.

## Requirements

- PHP 7.4 or higher

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/ivorszaniszlo/document-list-filter.git
   cd document-list-filter
   ```

2. Ensure the `document_list.csv` file is in the same directory as the script.

## Usage

Run the script with the following parameters:

```sh
php document_list.php <document_type> <customer_id> <min_total>
```

### Example

```sh
php document_list.php invoice 1 12500
```

This command filters documents of type `invoice`, with customer ID `1`, and a minimum total value of `12500`.

## Directory Structure

- `document_list.php` - The main script for filtering documents.
- `document_list.csv` - The CSV file containing the document data.
- `tests/` - Directory containing unit tests.
- `README.md` - This file.

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
