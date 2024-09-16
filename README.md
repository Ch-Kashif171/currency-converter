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
## Step 3. Publish Assets
To publish the assets run the below command.
```
 php artisan vendor:publish --tag=amkas-currency-converter
```
This command will copy three files as below:

 ```php
 Copying file [amkas\currency-converter\src\Models\CurrencyRate.php] to [app\Models\CurrencyRate.php]  DONE
 Copying file [amkas\currency-converter\src\config\currency_converter.php] to [config\currency_converter.php]  DONE
 Copying directory [amkas\currency-converter\src\database\migrations] to [database\migrations]  DONE
  ```
So there are three files
1. Currency rates migration
2. Currency Rate model
3. config/currency-converter.php

After that, you need to run the migration command to migrate the currency rates table into database as below:

```
 php artisan migrate
```

Then you can set the default currency in config file as below:

```
'default_currency' => 'USD',
```

and other config settings.

After that, you can create a CRUD to save the currency rates into database

# Usage:
  In Controller include and call Currency class and pass the amount and desire currency notation in convertAmount method as below:
  ```php
    use Amkas\CurrencyConverter\Currency;
    
    $convertedAmount = Currency::convertAmount(10, 'EUR');
  ```
  If you want to use a helper's function use below.
  ```php
    $convertedAmount = convertRate(10, 'EUR');
  ```

If you want to convert amount from one currency to another, call chain functions as below:

```php
    $convertedAmount = Currency::amount(10)
        ->from('EUR')
        ->to("USD")
        ->convert();
  ```
with helper functions you can call as below:

```php
    $convertedAmount = amount(10)
        ->from("EUR")
        ->to("USD")
        ->convert();
  ```
#### Note: Since this currency converter has cache implemented to avoid database query everytime when currency conversion function will call, so every time when new currency rate will add via CurrencyRate model, the cahce will automatically reset.
However you can reset that specific cache by runing the below command:

````php
php artisan converter:reset-cache
````
