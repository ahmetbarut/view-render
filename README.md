- [PHP Simple View Engine](#php-simple-view-engine)
- [Installation and Configuration](#installation-and-configuration)
  - [Use](#use)
- [Directives](#directives)
    - [extends and yield](#extends-and-yield)
  - [section and endSection](#section-and-endsection)
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
Direktifler, bu template için kullanımlardır. 

### extends and yield
`extends` direktifi, düzen eklemek için kullanılabilir. Bir sayfanızın olduğunu düşünün ve bu sayfanın bütün yapısını sürekli kopyalamak çok uğraştırıcı gereksiz bir şekilde kod yazmamıza sebep olur. Bu durumda `extends` direktifi işimizi basitleştiriyor.
`yield` direktifi'de her sayfada değişecek bölümleri getirmeyi sağlar. 

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
Ve biz `home.php` sayfamızı dahil ederek ilgili düzeni dahil edip sayfamızı düzene ittik.

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
`section` direktifi, bölümü başlatır ve `endSection` direktifi de bölümü bitirir ve düzene iter.

