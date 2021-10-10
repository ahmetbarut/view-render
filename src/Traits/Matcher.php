<?php

namespace ahmetbarut\View\Traits;

use ReflectionFunction;

trait Matcher
{
    /**
     * Allowed other functions
     *
     * @var array
     */
    protected array $allowFunctions = [
        'dd', 'print_r', 'var_dump'
    ];

    /**
     * While matching, it may be necessary to call some keywords,
     * namely our methods, from a class (Template engine).
     * The keywords here are specified to be called on the engine.
     * @var array|string[] $templateTags
     */
    private array $templateTags = ["section", "endSection", "yield", "extends"];


    protected array $aliasMethod = [
        'section' => 'startSection',
        'yield' => 'yieldSection',
        'endSection' => 'endSection',
        'extends' => 'extendSection'
    ];

    private $content;

    /**
     * Runs all mappings.
     *
     * @param $content
     *
     * @return array|string|null
     */
    public function matchAllTags($content): array|string|null
    {
        $this->content = $content;
        $this->extendMatch();
        $this->sectionMatch();
        $this->yieldMatch();
        $this->conditionIfMatch();
        $this->conditionElseIfMatch();
        $this->conditionElseMatch();
        $this->conditionEndIfMatch();
        $this->phpMatch();
        $this->brackets();
        $this->endMatch();
        $this->allowFunctionMatch();
        return $this->content;
    }

    /**
     * Retrieves the codes between the curly brackets.
     * @param $content
     *
     * @return array|string|null
     */
    public function brackets(): array|string|null
    {
        return $this->content = preg_replace_callback("/{{(.*)}}/isU", function ($match) {
            return "<?=htmlspecialchars(trim(" . $match[1] . "))?>";
        }, $this->content);
    }

    /**
     * The partition matches the description.
     *
     * @return void
     */
    public function sectionMatch()
    {
        $this->content = preg_replace_callback("/@(section)\((.*?)\)/", function ($match) {
            return "<?php \$this->" . $this->aliasMethod[$match[1]] . "({$match[2]}); ?>";
        }, $this->content);
    }

    /**
     * Extend a layout
     *
     * @return void
     */
    public function extendMatch()
    {
        $this->content = preg_replace_callback("/@(extends)\((.*?)\)/", function ($match) {

            return "<?php \$this->" . $this->aliasMethod[$match[1]] . "({$match[2]}); ?>";
        }, $this->content);
    }

    /**
     * Prints the defined section.
     *
     * @return void
     */
    public function yieldMatch()
    {
        $this->content = preg_replace_callback("/@(yield)\((.*?)\)/", function ($match) {

            return "<?php \$this->" . $this->aliasMethod[$match[1]] . "({$match[2]}); ?>";
        }, $this->content);
    }

    /**
     * Attempts to match and replace all keywords ending in (end).
     * @param $content
     *
     * @return array|string|null
     */
    public function endMatch(): array|string|null
    {
        return $this->content = preg_replace_callback("/@(end[a-zA-Z_]+)/", function ($match) {
            if (in_array($match[1], $this->templateTags)) {
                return "<?php \$this->" . $this->aliasMethod[$match[1]] . "() ?>";
            }
        }, $this->content);
    }

    /**
     * Matches PHP tags.
     *
     * @return void
     */
    public function phpMatch(): void
    {
        $this->content = preg_replace_callback("/@php(.*?)@endphp/s", function ($match) {
            return "<?php " . $match[1] . "; ?>";
        }, $this->content);
    }


    /**
     * Matches the if condition.
     *
     * @return void
     */
    public function conditionIfMatch()
    {
        $this->content = preg_replace_callback("/@if\((.*)\)/", function ($match) {
            return "<?php if({$match[1]}) {?>";
        }, $this->content);
    }

    /**
     * Matches the Elseif condition.
     *
     * @return void
     */
    public function conditionElseIfMatch()
    {
        $this->content = preg_replace_callback("/@elseif\((.*)\)/", function ($match) {
            return "<?php } elseif({$match[1]}) {?>";
        }, $this->content);
    }

    /**
     * Matches the else condition.
     *
     * @return void
     */
    public function conditionElseMatch()
    {
        $this->content = preg_replace_callback("/@else/is", function ($match) {
            return "<?php } else {?>";
        }, $this->content);
    }

    /**
     * Matches the endif condition.
     *
     * @return void
     */
    public function conditionEndIfMatch()
    {
        $this->content = preg_replace_callback("/@endif/is", function ($match) {
            return "<?php }?>";
        }, $this->content);
    }

    /**
     * Matches the functions desired to be used on the template side.
     *
     * @return void
     */
    public function allowFunctionMatch()
    {
       $this->content = preg_replace_callback('/@(.*)\((.*)\)/', function($match){
            if (in_array($match[1], $this->allowFunctions)) {
                return "<?php " . $match[1] . "(" . $match[2] . "); ?>";
            }
        }, $this->content);
    }
}
