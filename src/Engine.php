<?php

namespace ahmetbarut\View;

use ahmetbarut\View\Traits\Matcher;

class Engine
{
    use Matcher;

    private array $options;

    protected \ahmetbarut\View\ViewCache $cache;

    public function __construct($options)
    {
        $this->options = $options;

        $this->cache = new ViewCache($this->config('cache'));

    }

    public function load($view, array $data = []){

        extract([
            "__view" => new static($this->options),
        ]);

        extract($data);

        $viewPath = $this->config('view') . "/{$view}.php";
        ob_start();
        require ($viewPath);
        $content = ob_get_clean();

        $content = $this->matchAllTags($content);

        $this->cache->createViewCache($view, $this->config('view'), $content);

        require ($this->cache->getCacheView($view));
        if (null !== error_get_last()) {
            new ViewError($view);
        }

    }

    public function config($key)
    {
        return $this->options[$key];
    }

    public function startSection()
    {
        echo  "artık var !";
    }
}