# php-filters

## Filter with Query String

This URL:

```text
/users?name=test&age=15
```

automatically knew to filter the DB query by responding with users that have their

- name containing `test`
- age as `15`

and order the records by age in descending order, all without you having to write boilerplate code 😱.

## Setup

- Run `composer require josueeek/laravel-filters` in your terminal to pull the package in.

## Usage

- In the Model class you wish to make filterable, use the `FilterableTrait` like:

```php
<?php

use Josueeek\Filters\Traits\FilterableTrait;

class User {
  use FilterableTrait;
  ...
}
```

- Create a filter class for that model e.g. `UserFilter`

```php
<?php
namespace App\Filters;

use App\User;
use Josueeek\Filters\BaseFilters;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserFilters extends BaseFilters
{
    public function name($term) {
        return $this->builder->where('users.name', 'LIKE', "%$term%");
    }

    public function company($term) {
        return $this->builder->whereHas('company', function ($query) use ($term) {
            return $query->where('name', 'LIKE', "%$term%");
        });
    }

    public function age($term) {
        $year = Carbon::now()->subYear($age)->format('Y');
        return $this->builder->where('dob', '>=', "$year-01-01")->where('dob', '<=', "$year-12-31");
    }

    public function sort_age($type = null) {
        return $this->builder->orderBy('dob', (!$type || $type == 'asc') ? 'desc' : 'asc');
    }
}
```

> Note how the name of each method maps to the key of each query string in `/users?name=test&age=15`, and the parameters of the methods map to the values.

- Inject `UserFilters` in your controller 😍, like:

```php
<?php

namespace App\Http\Controllers;

use App\User;
use App\Filters\UserFilters;

class UserController extends Controller {

  public function index(Request $request, UserFilters $filters)
  {
      return User::filter($filters)->get();
  }
}
```

That's all! 💃

Now, you can execute your app, and use variations of the query strings that your filters allow for. 🔥🔥🔥
