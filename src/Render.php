<?php

namespace ahmetbarut\View;

class Render extends Component
{

    /**
     * Bütün şablonlara paylaşılan değişkenler.
     *
     * @var array
     */
    public static array $shared;

    /**
     * Denetleyici tarafından gönderilen değişkenleri depolar.
     *
     * @var array
     */
    public array $data;

    /**
     * Yüklenmesi istenen görünümü ve değişkenleri hazırlar.
     *
     * @param  string  $view
     * @param  array|null  $data
     *
     * @throws \ahmetbarut\PhpRouter\Exception\NotRouteFound
     * @return static
     */
    public function render(string $view, array $data = null): static
    {
        if (null !== $data) {
            $this->data = $data;
        }
        
        return $this->load($view, $data);
    }

    /**
     * Görünümleri yüklemek için dizini alması gerekir.
     *
     * @throws \ahmetbarut\PhpRouter\Exception\NotRouteFound
     * @return string
     */
    public function getConfigPath(): string 
    {
        return VIEW_PATH;
    }

    /**
     * İlgili görünümü yükler ve parametreleri değişkene döndürür.
     *
     * @param  string  $view
     * @param  array|null  $data
     *
     * @throws \ahmetbarut\PhpRouter\Exception\NotRouteFound
     * @return static
     */
    public function load(string $view, array $data = null): static
    {
        if (!is_null($data)) {
            extract($data, EXTR_OVERWRITE);
        }
        

        require_once $this->getConfigPath() . '/' . $view . ".php";
        return $this;
    }

    public function __toString()
    {
        return $this->render($this->layout, $this->vars);
    }
}
