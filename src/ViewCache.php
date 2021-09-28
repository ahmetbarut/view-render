<?php

namespace ahmetbarut\View;

class ViewCache
{
    private string $cachePath;

    public function __construct($cachePath)
    {
        $this->cachePath = $cachePath;
    }

    public function createViewCache(string $view, string $viewPath, $content): bool
    {
        $cacheFile = $this->cachePath . "/" . md5($view) . ".php";
        $viewPath .= "/{$view}.php";

        if (!file_exists($cacheFile)) {
             file_put_contents($cacheFile, $content) !== false;

             chmod($cacheFile, 0644);
        }else {
            if (filemtime($cacheFile) < filemtime($viewPath)) {
                 file_put_contents($cacheFile, $content) !== false;
                 chmod($cacheFile, 0644);
            }
        }
        return false;
    }

    public function getCacheView($viewName): bool|string
    {
        return ($this->cachePath . "/" . md5($viewName) . ".php");
    }
}