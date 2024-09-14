# Currency Converter

Currency Converter is a simple easy to use package for Laravel for currency conversion.

# Getting Started
  Install Currency Converter via composer.
Note: If you do not have composer yet, you can install it by following the instructions on https://getcomposer.org

# Step 1. Install package
  
    composer require amkas/currency-converter

# Step 2. Register the Currency Converter service provider
  in bootstrap/providers.php
  add following line
   ```php
    \Amkas\CurrencyConverter\ConversionServiceProvider::class,
   ```
#### Publish Assets
To publish the assets run the below command.
```
 php artisan vendor:publish --tag=amkas-currency-converter
```
This command will copy three files as below:

 ```php
File [app\Models\CurrencyRate.php] already exists ............................................................... SKIPPED
File [config\currency_converter.php] already exists ............................................................. SKIPPED
Copying directory [vendor\amkas\currency-converter\src\database\migrations] to [C:\laragon\www\converter\database\migrations]  DONE
  ```

# Usage:
  In Controller include and call Currency class and pass the amount and desire currency notation in convert method as below:
  ```php
    use Amkas\CurrencyConverter\Currency;
    
    $convertedAmount = Currency::convert(10, 'EUR');
  ```
  If you want to use a helper's function use below.
  ```php
    $convertedAmount = convertRate(10, 'EUR');
  ```
