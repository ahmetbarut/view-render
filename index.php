<?php

require './vendor/autoload.php';
$tokens = PhpToken::tokenize('<?php echo; ?>');

const VIEW_PATH = "/srv/http/packages/viewRender/view";
\ahmetbarut\View\Container::setResolved(new \ahmetbarut\View\Component());
$view = \ahmetbarut\View\Container::$resolved['view'];
$view->extends('home');
$view->start('title');?>
BAŞLIKK!!
{{ strtoupper("lorem") }}
{{ strtoupper("lorem2") }}
{{ strtoupper("lorem2") }}
<?php
$view->end();
$view->start('content');?>
<h1>Helllo</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium corporis cupiditate dicta distinctio eos hic iusto non quis quos rerum? A, assumenda explicabo facere minus molestiae quod veritatis. A, autem.</p>
{{ strtoupper("lorem2") }}


<?php $view->end()->render();
?>
