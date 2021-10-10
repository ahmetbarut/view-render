- [PHP Simple View Engine](#php-simple-view-engine)
- [Installation and Configuration](#installation-and-configuration)
  - [Use](#use)
- [Directives](#directives)
    - [extends and yield](#extends-and-yield)
  - [section and endSection](#section-and-endsection)
  - [](#)
# PHP Simple View Engine
A simple template engine that is lightweight and has no dependencies.

# Installation and Configuration
For installation, `composer` must be installed. There is no stable version of the package yet.
```shell
    composer require ahmetbarut/view-render
```

Add the following configurations after the package is installed. The package needs the `cache` and `template` directories, you need to create it and specify its path.
```php
    $view = new \ahmetbarut\View\Render([
        "view" => __DIR__ . "/view",
        'cache' => __DIR__ . '/cache'
    ]);
```

## Use
After the configuration of the package is finished, let's first use it with a template.

Create a file in the created `template` directory.
```php
    // view/home.php
    {{ $helloWorld }}
```

```php
    // index.php
    require_once  "vendor/autoload.php";

    $view = new \ahmetbarut\View\Render([
        "view" => __DIR__ . "/view",
        'cache' => __DIR__ . '/cache'
    ]);


    $view->load('home', [
        "helloWorld" => "Hello World !"
    ]);
```

The `load` method loads the corresponding template.

# Directives
Directives are uses for this template.

### extends and yield
The `extends` directive can be used to add layouts. Imagine you have a page and constantly copying the entire structure of this page causes us to write code in a very tedious and unnecessary way. In this case, the `extends` directive simplifies our work.
The `yield` directive allows to fetch the sections that will change on each page.

Örnek Kullanım:
```php
//layouts.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
@yield('content')
</body>
</html>  

```
And we included our `home.php` page and included the relevant layout and pushed our page into layout.
```php
// home.php
@extends('layouts')

@section('title')
Hello Template Title
@endSection

@section('content')
hello there, this is content
@endSection
```

## section and endSection
The `section` directive starts the section and the `endSection` directive ends the section and pushes it into order.

## 