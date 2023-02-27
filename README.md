# Router PHP package documentation

<p align="center">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=php"/>
  </a>
</p>


The Router PHP package provides an easy-to-use routing system for PHP web applications. It allows developers to define routes for different HTTP methods such as GET, POST, DELETE, and PUT. Additionally, it supports the use of hidden input fields to simulate the DELETE, PUT, and PATCH HTTP methods.

## Requirements

The Router PHP package requires PHP 7.0 or higher.

## features

-   Define routes for GET, POST, DELETE, and PUT HTTP methods
-   Define routes with parameters
-   Define routes with optional parameters
-   Define routes with regular expressions

## Installation

To use the Router PHP package, you need to install it via Composer. Run the following command in your project directory:

```bash 
composer require pierre/router
```

## Usage

To use the Router, you need to create a new instance of the Router class:

```php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Pierre\Router\Router();

// Define routes
// ...

// Run it!
```

## Defining Routes

The Router supports four HTTP methods: GET, POST, DELETE, and PUT. You can define a route for each method using the following methods:

### GET
To define a GET route, use the get() method. The first parameter is the URL path, and the second parameter is a callback function that will be executed when the route is accessed:

```php
$router->get('/', function() {
    return 'Hello World!';
});
```

### POST

To define a POST route, use the post() method.

```php
$router->post('/', function() {
    return $_POST['name'];
});
```

### DELETE

To define a DELETE route, use the delete() method.

```php
$router->delete('/user/:id', function($id) {
    return 'User ' . $id . ' deleted';
});
```

### PUT

To define a PUT route, use the put() method.

```php
$router->put('/user/:id', function($id) {
    return 'User ' . $id . ' updated';
});
```

## Executing the Router

After defining your routes, you need to execute the Router using the run() method:

```php
$router->run();
```

## Simulating DELETE, PUT, and PATCH Methods

To simulate the DELETE, PUT, and PATCH HTTP methods in a form, you need to include a hidden input field with the name _method and the value of the desired method. The Router will detect this input field and use the specified method for the request.

### Delete example

```html
<form action="/user/delete/1" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="id" value="1">
    <input type="submit" value="Delete">
</form>
```

### Put example

```html
<form action="/user/edit/1" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="1">
    <input type="submit" value="Delete">
</form>
```

### Passing Parameters

You can pass parameters to your routes using the following syntax:

```php
$name = "Pierre";
$router->get('/hello', function() use ($name) {
    return "Hello {$name}!}";
});
```

## Set a 404 page not found

To set a 404 page not found, use the page404() method:

```php
$router->page404(function() {
    return '404.php';
});
```


## License

The Router PHP package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).