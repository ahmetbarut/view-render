<?php

namespace ahmetbarut\View;

class Component
{
    private array $sections = [];

    private string $activeSection = "";

    private string $page;

    private array $allSections = [];

    private string $includedPage;

    private array $tags = ["{{", "}}"];

    public function regex($str)
    {
        $re = '/([{{]{2}+(.*)[}]{2}+)/';
        preg_match_all($re, $str, $matches, );
        $r = [];
        foreach (end($matches) as $item) {
            $r[] = "<?php return" . $item . "?>";
        }
        foreach ($r as $item) {
            $res[] = eval("?>" . $item . "<?php;?>");
        }
        dd($res);
    }

    public function extends($page): static
    {
        $this->page = $page;
        return $this;
    }

    public function start($section)
    {

        $this->allSections[$section] = "";
        $this->activeSection = $section;
        ob_start();
    }

    public function end(): static
    {
        $this->sections[$this->activeSection] = ob_get_clean();
        $this->allSections[$this->activeSection] = $this->sections[$this->activeSection];

        return $this;
    }

    public function load()
    {
        extract($this->sections, EXTR_OVERWRITE);
        ob_start();
        include VIEW_PATH . "/{$this->page}.php";
        $this->includedPage = ob_get_clean();
        $this->regex($this->includedPage);
    }

    public function getSections($sect)
    {
        return $this->sections[$sect];
    }

    public function __toString(): string
    {
        $this->load();
        return $this->includedPage;
    }

    public function render()
    {
        echo $this;
    }

}