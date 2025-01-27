# Amazon MWS Library

A PHP library to connect to Amazon Marketplace Web Services (Amazon MWS).

## Installation

You can install this package via Composer:

```bash
composer require mislam/amazon-mws
```

## Requirements

- PHP >= 5.4
- PHP cURL extension

## Usage

```php
<?php
use AmazonMWS\AmazonProductList;

$config = [
  'MWS_SELLER_ID' => env('MWS_SELLER_ID'),
  'MWS_AUTH_TOKEN' => env('MWS_AUTH_TOKEN'),
  'MWS_ACCESS_KEY' => env('MWS_ACCESS_KEY'),
  'MWS_SECRET_KEY' => env('MWS_SECRET_KEY'),
  'MWS_SERVICE_URL' => env('MWS_SERVICE_URL'),
];

// Initialize the AmazonProductList class
$productList = new AmazonProductList($config);

// Set the product ASIN
$productList->setIdType('ASIN');
$productList->setProductIds(['B0786VMVXW', 'B089FPC2HX']);

// Fetch the product list
$productList->fetchProductList();
```

## Features

- Connect to Amazon MWS API
- Handle authentication and request signing
- Support for major MWS API sections:
  - Orders
  - Products
  - Inventory
  - Reports
  - And more...

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

[Mohammad Islam](https://mislam.dev)

## Support

If you discover any security-related issues, please email hi@mislam.dev instead of using the issue tracker.