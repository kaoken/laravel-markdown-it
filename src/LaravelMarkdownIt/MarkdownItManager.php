<?php
namespace Kaoken\LaravelMarkdownIt;

use Kaoken\MarkdownIt\MarkdownIt;

/**
 * It is close to MarkdownIt wrapper class.
 * @package kaoken\MarkdownIt\Laravel
 */
class MarkdownItManager
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var MarkdownIt
     */
    protected $markdown;
    /**
     * The group name of the current options and rules.
     * @var string
     */
    protected $optionsRulesGroup = 'default';

    /**
     * The group data of the current options and rules.
     * @var array
     */
    protected $optionsRulesData = [];

    /**
     * MarkdownItManager constructor.
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(&$app)
    {
        $this->app = $app;
        $this->markdown = new MarkdownIt();
        $this->optionsRulesGroup = $this->app->config->get('markdownit.set_options_rules');

        $this->setOptionGroup($this->optionsRulesGroup);
    }


    /** chainable
     * Enable list or rules. It will automatically find appropriate components,
     * containing rules with given names. If rule not found, and `ignoreInvalid`
     * not set - throws exception.
     *
     * ##### Example
     *
     * ```PHP
     * $md = MarkdownIt::enable(['sub', 'sup'])
     *                 ->disable('smartquotes');
     * ```
     * @param string|array $list          rule name or list of rule names to enable
     * @param boolean      $ignoreInvalid set `true` to ignore errors when rule not found.
     * @return $this
     */
    public function enable($list, bool $ignoreInvalid=false)
    {
        $this->markdown->enable($list, $ignoreInvalid);
        return $this;
    }


    /** chainable
     * The same as [[$this->enable]], but turn specified rules off.
     *
     * @param string|array $list          rule name or list of rule names to enable
     * @param boolean      $ignoreInvalid set `true` to ignore errors when rule not found.
     * @return $this
     */
    public function disable($list, $ignoreInvalid=false)
    {
        $this->markdown->disable($list, $ignoreInvalid);
        return $this;
    }

    /** chainable
     * $this->options($options)
     *
     * Set parser options (in the same format as in constructor). Probably, you
     * will never need it, but you can change options after constructor call.
     *
     * ##### Example
     *
     * ```PHP
     * MarkdownIt::options([ "html" => true, "breaks" => true ])
     *    ->options([ "typographer", "true" ]);
     * ```
     *
     * __Note:__ To achieve the best possible performance, don't modify a
     * `markdown-it` instance options on the fly. If you need multiple configurations
     * it's best to create multiple instances and initialize each with separate
     * config.
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        $this->markdown->set($options);
        return $this;
    }
    
    /**
     * Get LinkifyIt instance.
     * @see \Kaoken\LinkifyIt\LinkifyIt
     * @return \Kaoken\LinkifyIt\LinkifyIt
     */
    public function linkify()
    {
        return $this->markdown->linkify;
    }


    /** chainable
     * Load specified plugin with given params into current parser instance.
     * It's just a sugar to call `plugin($md, $params)` with curring.
     *
     * ##### Example
     *
     * ```PHP
     * class Test{
     *   public function plugin($md, $ruleName, $tokenType, $iteartor){
     *     $scan = function($state) use($md, $ruleName, $tokenType, $iteartor) {
     *         for ($blkIdx = count($state->tokens) - 1; $blkIdx >= 0; $blkIdx--) {
     *             if ($state->tokens[$blkIdx]->type !== 'inline') {
     *                 continue;
     *             }
     *
     *             $inlineTokens = $state->tokens[$blkIdx]->children;
     *
     *             for ($i = count($inlineTokens) - 1; $i >= 0; $i--) {
     *                 if ($inlineTokens[$i]->type !== $tokenType) {
     *                     continue;
     *                 }
     *
     *                 ($iteartor)($inlineTokens, $i);
     *             }
     *         }
     *     };
     *
     *     $md->core->ruler->push($ruleName, $scan);
     *   }
     * }
     * MarkdownIt::plugin(new Test(),'foo_replace', 'text', function ($tokens, $idx) {
     *   $tokens[$idx]->content = preg_replace("/foo/", 'bar', $tokens[$idx]->content);
     * });
     * ```
     *
     * @param callable|object $plugin
     * @param array ...     $args
     * @return $this
     * @throws \Exception
     */
    public function plugin($plugin, ...$args)
    {
        $this->markdown->plugin($plugin, ...$args);
        return $this;
    }

    /**
     * Set group name of the options and rules.
     * `config\markdownit.php`内の
     * @see config\markdownit.php
     * @param string $name Group name of the options and rules.
     * @return $this
     */
    public function setOptionsRules(string $name)
    {
        $this->optionsRulesGroup = $name;

        $this->optionsRulesData = $this->app->config->get('markdownit.options_rules_group.'.$this->optionsRulesGroup);

        $this->markdown->set($this->optionsRulesData['options']);
        $this->markdown->enable($this->optionsRulesData['enable']);
        $this->markdown->disable($this->optionsRulesData['disable']);
        return $this;
    }

    /**
     * Takes token stream and generates HTML.
     * @param string $src source string
     * @return string
     */
    public function render(string $src):string
    {
        return $this->markdown->render($src);
    }

    /**
     * Similar to [[$this->render]] but for single paragraph content.
     * Result will NOT be wrapped into `<p>` tags.
     *
     * @param string $src source string
     * @return string
     */
    public function renderInline(string $src):string
    {
        return $this->markdown->renderInline($src);
    }
}