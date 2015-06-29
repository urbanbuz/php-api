# UrbanBuz PHP API Client
## Installation
Using composer:
```
composer require urbanbuz/api
```

## Usage
```
require('vendor/autoload.php');
$ub = new UrbanBuz\API\UrbanBuz(API_KEY, API_SECRET);
$ub->login('email@example.com', 'password');
```
