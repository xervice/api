Api
=====================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xervice/api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xervice/api/?branch=master)
[![Build Status](https://travis-ci.org/xervice/api).svg?branch=master)](https://travis-ci.org/xervice/api)
[![Code Coverage](https://scrutinizer-ci.com/g/xervice/api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xervice/api/?branch=master)

Installation
-----------------
```
composer require xervice/api
```

Configuration
-----------------
If you want to use secured api controller, you have to add the kernel service and the authenticator to the security module:
* You must add the "ApiAuthService" service to the kernel stack.
* Also you must define your authoration types and add their authenticator to the security dependency provider.

Using
-----------------

To use an api controller without authentification, you can extend from AbstractApiController.

```php
<?php


namespace App\MyModule\Communication\Controller;

use \DataProvider\MyDataDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Xervice\Api\Business\Controller\AbstractApiController;

class MyApiController extends AbstractApiController
{
    /**
     * @param \DataProvider\MyDataDataProvider $dataProvider
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Xervice\Api\Exception\ApiException
     */
    public function myRequestAction(MyDataDataProvider $dataProvider, string $name): Response
    {
        $dataProvider = $this->getFacade()->doAnythingWithData($dataProvider);

        return $this->apiResponse($dataProvider);
    }
}
```

If you want to have authentication, you can extend from AbstractSecureApiController.
Every call to an SecureController check an authorization before running the action.
The authentication data comes from the header HTTP_Authorization.

***Example***
```
HTTP_Authorization: Token Zm9vOmJhcg==
```

In that example it will look for an security authenticator "Token" and run the authentification. On failure, it will throw an AuthorizationException.