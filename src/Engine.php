<?php

namespace ahmetbarut\View;

use ahmetbarut\View\Traits\Matcher;

class Engine
{
    use Matcher;

    /**
     * Stored options.
     * @var array $options
     */
    private array $options;

    /**
     * View cache object.
     * @var ViewCache $cache
     */
    protected \ahmetbarut\View\ViewCache $cache;

    protected static array $share = [];

    /**
     * Engine constructor.
     * @param $options
     */
    public function __construct($options, array $allowedFunction = [])
    {
        $this->options = $options;

        $this->cache = new ViewCache($this->config('cache'));

        if (!is_dir($this->config('view'))) {
            throw new \Error("Can't find view directory.");
        }

        $this->allowFunctions = array_merge($this->allowFunctions, $allowedFunction);
    }

    /**
     * This is where it works for mapping, caching and loading views.
     *
     * Variables to include in the view are given as an array, pass through the "extract" function,
     * then the view is loaded, thrown into the buffer, then it does the matching and replaces it,
     * then it does the cache operations then the view is loaded.
     *
     * @param string $view
     * @param  array  $data
     */
    public function load(string $view, array $data = [])
    {
        $data = array_merge(static::$share, $data);

        extract($data, EXTR_OVERWRITE);

        $viewPath = $this->config('view') . "/{$view}.php";
        ob_start();
        require($viewPath);
        $content = ob_get_clean();

        $content = $this->matchAllTags($content);

        $this->cache->createViewCache($view, $this->config('view'), $content);

        require($this->cache->getCacheView($view));

        if (null !== error_get_last()) {
            new ViewError($view);
        }
    }

    public function share($key, $value = null): void
    {
        $share = [];

        if (!is_array($key)) {
            $share[$key] = $value;
        } else {
            $share = $key;
        }

        static::$share = $share;
    }

    /**
     * Get options with key.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function config(string $key): mixed
    {
        return $this->options[$key];
    }

    /**
     * added locale function in php library.
     *
     * @param array ...$function
     * @return void
     */
    public function setAllowLocaleFunction(...$functions)
    {
        foreach ($functions as $function) {
            array_push($this->allowFunctions, $function);
        }
    }
}
