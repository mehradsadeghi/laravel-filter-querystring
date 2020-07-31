# Laravel Filter Query String
#### Filter your queries based on url query string parameters like a breeze.

## Describing the Problem

You have probably faced the situation where you needed to filter your query based on given parameters in url query-string and after developing the logics, You've had such a code:

```php
$users = User::latest();

if(request('username')) {
    $users->where('username', request('username'));
}

if(request('age')) {
    $users->where('age', '>', request('age'));
}

if(request('email')) {
    $users->where('email', request('email'));
}

return $users->get();

```

This works, But it's not a good practice.

When the number of parameters starts to grow, The number of these kind of `if` statements also grows and your code gets huge and hard to maintain.
 
Also it's against the Open/Closed principal of SOLID principles, Because when you have a new parameter, You need to get into your existing code and add a new logic (which may breaks the existing implementations).

So we have to design a way to make our filters logics separated from each other and apply them into the final query, which is the whole idea behind this package.

## Usage
1. First you need to install the package:

`$ composer require mehradsadeghi/laravel-filter-querystring`

2. Then you should `use` the `FilterQueryString` trait in your model, And define `$filters` property which can be consist of [available filters](#Available-Methods) or your [custom filters](#custom-filters).

```php
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class User extends Model
{
    use FilterQueryString;

    protected $filters = [];

    ...
}
```
3. You need to use `filter()` method in your eloquent query. For example:

```php
User::select('name')->filter()->get();
```

### Available Methods
- [Sort](#Sort)
- [Comparisons](#Comparisons)
- [In](#In)
- [Like](#Like)
- [Where clause](#Where-Clause-Default-Filter)

For the purpose of explaining each method, Imagine we have such data in our `users` table:

| id  |   name   |           email            |  username  |  age | created_at 
|:---:|:--------:|:--------------------------:|:----------:|:----:|:----------:|
|  1  | mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
|  2  | reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |
|  3  | hossein  | hossein<i></i>@example.com | hossein123 |  22  | 2020-11-01 |
|  4  | dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

And assume our query is something like this:

```php
User::filter()->get();
```

### Sort
Sort is the equivalent of `order by` sql statement which can be used flexible in `FilterQueryString`:

Conventions:

```
?sort=field
?sort=field,sort_type
?sort[0]=field1&sort[1]=field2
?sort[0]=field1&sort[1]=field2,sort_type
?sort[0]=field1,sort_type&sort[1]=field2,sort_type
```

In User.php
```php
protected $filters = ['sort'];
```
**Single `sort`**:

`https://example.com?sort=created_at`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |
| hossein  | hossein<i></i>@example.com | hossein123 |  22  | 2020-11-01 |
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

- **Note** that when you're not defining `sort_type`, It'll be `asc` by default.

**Multiple `sort`s**:

`https://example.com?sort[0]=age,desc&sort[1]=created_at,desc`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |
| hossein  | hossein<i></i>@example.com | hossein123 |  22  | 2020-11-01 |
| reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |

**Bare in mind** that `sort` parameter with invalid values will be ignored from query and has no effect to the result. 


### Comparisons
Comparisons are consist of 6 filters:
- greater
- greater_or_equal
- less
- less_or_equal
- between
- not_between

Conventions:

```
?greater=field,value
?greater_or_equal=field,value
?less=field,value
?less_or_equal=field,value
?between=field,value1,value2
?not_between=field,value1,value2
```

In User.php
```php
protected $filters = [
    'greater',
    'greater_or_equal',
    'less',
    'less_or_equal',
    'between',
    'not_between'
];
```

**Example of `greater`**:

`https://example.com?greater=age,20`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| hossein  | hossein<i></i>@example.com | hossein123 |  22  | 2020-11-01 |
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

**Example of `not_between`**:

`https://example.com?not_between=age,21,30`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |

**Bare in mind** that comparison parameters with invalid values will be ignored from query and has no effect to the result. 

### In
In clause is the equivalent of `where in` sql statement.

Convention:

```
?in=field,value1,value2
```

In User.php
```php
protected $filters = ['in'];
```
**Example**:

`https://example.com?in=name,mehrad,reza`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |

**Bare in mind** that `in` parameter with invalid values will be ignored from query and has no effect to the result. 

### Like
Like clause is the equivalent of `like '%value%'` sql statement.

Conventions:

```
?like=field,value
?like[0]=field1,value1&like[1]=field2,value2
```

In User.php
```php
protected $filters = ['like'];
```
**Single `like`**:

`https://example.com?like=name,meh`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |


**Multiple `like`s**:

`https://example.com?like[0]=name,meh&like[1]=username,dar`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

**Bare in mind** that `like` parameter with invalid values will be ignored from query and has no effect to the result. 

### Where Clause (default filter)
Generally when your query string parameters are not one of previous available methods, It'll get filtered by the default filter which is the `where` sql statement. It's the proper filter when you need to directly filter one of your table's columns.

Conventions:

```
?field=value
?field1=value&field2=value
?field1[0]=value1&field1[1]=value2
?field1[0]=value1&field1[1]=value2&field2[0]=value1&field2[1]=value2 
```

Assuming we want to filter `name` and `username` database columns, In User.php 
```php
protected $filters = ['name', 'username'];
```
**Example**:

`https://example.com?name=mehrad`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |


**Example**:

`https://example.com?age=22&username=dariush123`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |


**Example**:

`https://example.com?name[0]=mehrad&name[1]=dariush`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

**Example**:

`https://example.com?name[0]=mehrad&name[1]=dariush&username[0]=mehrad123&username[1]=reza1234`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@example.com  | mehrad123  |  20  | 2020-09-01 |

**Bare in mind** that `default` filter parameter with invalid values will be ignored from query and has no effect to the result. 

### Custom Filters
By custom filters you can define your own methods as filters. This helps with the Open/Closed of SOLID principles, Hence each time a new filter is needed, you don't have to edit previous filters and you can just write a separate method for it.

Let's create a custom filter. Assuming you want to create a filter named `all_except` which retrieves all users except the one that is specified:

In User.php
```php
protected $filters = ['all_except'];

public function all_except($query, $value) {
    $query->where('name', '!=', $value);
}
```
To test our newly added filter:

`https://example.com?all_except=mehrad`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| reza     | reza<i></i>@example.com    | reza123    |  20  | 2020-10-01 |
| hossein  | hossein<i></i>@example.com | hossein123 |  22  | 2020-11-01 |
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

**Note** that your custom defined filters have the most priority which means you can even override available filters.

For example lets change `in` filter in a way that only accepts 3 values:

In User.php
```php
protected $filters = ['in'];

public function in($query, $value) {
    
    $exploded = explode(',', $value);

    if(count($exploded) != 4) {
        // throwing an exception or whatever you like to do
    }

    $field = array_shift($exploded);

    $query->whereIn($field, $exploded);
}
```

**Another** good example for custom filters are when you don't want to expose your database table's column name. For example assume we don't want to expose that we have a column named `username` in `users` table:

In User.php
```php
protected $filters = ['by'];

public function by($query, $value) {
    $query->where('username', $value);
}
```

`https://example.com?by=dariush123`

Output:

|   name   |           email            |  username  |  age | created_at 
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@example.com | dariush123 |  22  | 2020-12-01 |

#### Minor Tip
In order to prevent your model to get messy or populated with filter methods, You can create a trait for it and put everything about filters inside the trait.