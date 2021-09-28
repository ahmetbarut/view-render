<?php

namespace ahmetbarut\View\Traits;

trait Matcher
{
    private array $escapeSemicolon = [
        'else',
    ];

    private array $customKeywords = ["startSection", "endSection", "yield", "extends"];

    /**
     * Süslü parantez içindekileri getirir.
     * @param $content
     *
     * @return array|string|null
     */
    public function brackets($content): array|string|null
    {
        return preg_replace_callback("/{{(.*)}}/", function ($match) {
            return "<?=" . trim($match[1]) . "?>";
        }, $content);
    }

    public function startTagMatch($content): array|string|null
    {
        return preg_replace_callback("/@([a-zA-Z_]+[(].*[)])/", function ($match) {

            if (preg_match("/([a-zA-Z_]+)/", $match[1], $key)) {
                if (in_array($key[0],$this->customKeywords)) {
                    return "<?php \$__view->" . $match[1] . "; ?>";
                }

                if (function_exists($key[0])) {
                    return "<?= " . $match[1] . "; ?>";
                }
            }
            return "<?php " . $match[1] . ": ?>";
        }, $content);
    }

    public function matchAllTags($content): array|string|null
    {
        $content = $this->brackets($content);
        $content = $this->startTagMatch($content);
        $content = $this->endMatch($content);
        return $content;
    }

    public function endMatch($content): array|string|null
    {
        return preg_replace_callback("/@([end]+(.*))/", function ($match) {
            if (in_array($match[1], $this->escapeSemicolon)) {
                return "<?php " . $match[1] . ": ?>";
            }
            return "<?php " . $match[1] . "; ?>";
        }, $content);
    }
}