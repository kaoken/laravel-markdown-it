# laravel-markdown-it

[![Build Status](https://img.shields.io/travis/markdown-it/markdown-it/master.svg?style=flat)](https://github.com/kaoken/laravel-markdown-it)
[![composer version](https://img.shields.io/badge/version-1.6.0-blue.svg)](https://github.com/kaoken/laravel-markdown-it)
[![licence](https://img.shields.io/badge/licence-MIT-blue.svg)](https://github.com/kaoken/laravel-markdown-it)
[![Laravel version](https://img.shields.io/badge/Laravel-≧7.3.4-red.svg)](https://github.com/kaoken/laravel-markdown-it)

This target Laravel 6.0 and higher, making  [PHP version markdown-it](https://github.com/kaoken/markdown-it-php) easy to use with Laravel.

__Table of content__

- [Install](#install)
- [Setting](#setting)
- [Syntax extensions](#syntax-extensions)
- [References / Thanks](#references--thanks)
- [License](#license)

## Install

**composer**:

Add to `composer.json` as follows

```composer.json
"require": {
    ...
	"kaoken/laravel-markdown-it":"^1.0"
}
```
Then update!
```bash
composer update
```


## Setting

#### Add to **`config\app.php` as follows：**
``` config\app.php
    'providers' => [
        ...
        Kaoken\LaravelMarkdownIt\MarkdownItServiceProvider::class,
    ],

    'aliases' => [
        ...
        'MarkdownIt' => Kaoken\LaravelMarkdownIt\Facade\MarkdownIt::class,
    ],
```
### artisan command

```bash
php artisan vendor:publish
```
By executing the above command, `markdownit.php` is created in the`config` directory.


### Options and rules configuration file
All options and rules are enabled by default. This is equivalent to `hoge ['options_rules_group'] ['default']` in `config \ markdownit.php` below.  
For a description of the options (`"options "`) and rules (`"enable "`, `"disable "`), see the comments for each parameter of `hoge ['options_rules_group'] ['default']` .  
If you want to add new options and rules, rewrite the contents of `'example'`by removing the comments below`Add options and rules` in the comments below.

```php
<?php


return [
    'set_options_rules' => 'default',

    'options_rules_group' =>[
        'default' => [
            'options'=> [
                'html'=>         true,        // Enable HTML tags in source
                'xhtmlOut'=>     true,        // Use '/' to close single tags (<br />)
                'breaks'=>       true,        // Convert '\n' in paragraphs into <br>
                'langPrefix'=>   'language-',  // CSS language prefix for fenced blocks
                'linkify'=>      true,        // autoconvert URL-like texts to links

                // Enable some language-neutral replacements + quotes beautification
                'typographer'=>  false,

                // Double + single quotes replacement pairs, when typographer enabled,
                // and smartquotes on. Could be either a String or an Array.
                //
                // For example, you can use '«»„“' for Russian, '„“‚‘' for German,
                // and ['«\xA0', '\xA0»', '‹\xA0', '\xA0›'] for French (including nbsp).
                'quotes'=> '“”‘’', /* “”‘’ */

                // Highlighter function. Should return escaped HTML,
                // or '' if the source string is not changed and should be escaped externaly.
                // If result starts with <pre... internal wrapper is skipped.
                //
                // function (/*str, lang*/) { return ''; }
                //
                'highlight'=> null,

                'maxNesting'=>   100            // Internal protection, recursion limit
            ],
            /**
             * Manage rules!
             * `'enable'` adds the rule you want to enable.
             * `'disable'` adds the rule you want to disable.
             * default all rules are enabled.
             * @see https://github.com/markdown-it/markdown-it/tree/master/benchmark/samples
             */
            'enable' => [
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-autolink.md
                 */
                'autolink',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-backticks.md
                 */
                'backticks',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-bq-flat.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-bq-nested.md
                 */
                'blockquote',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-code.md
                 */
                'code',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-em-flat.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-em-nested.md
                 */
                'emphasis',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-entity.md
                 */
                'entity',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-escape.md
                 */
                'escape',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-fences.md
                 */
                'fence',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-heading.md
                 */
                'heading',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-hr.md
                 */
                'hr',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-html.md
                 */
                'html_block',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-html.md
                 */
                'html_inline',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-links-flat.md
                 */
                'image',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-lheading.md
                 */
                'lheading',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-links-flat.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-links-nested.md
                 */
                'link',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-list-flat.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-list-nested.md
                 */
                'list',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/inline-newlines.md
                 */
                'newline',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-ref-flat.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-ref-list.md
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-ref-nested.md
                 */
                'reference',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-tables.md
                 */
                'table'
            ],
            'disable' => [

            ]
        ],
        /**
         * Add options and rules.
         */
        /*
        'example' => [
            'options'=> [
                'html'=>         false,
                'xhtmlOut'=>     false,
                'breaks'=>       false,
                'langPrefix'=>   'language-',
                'linkify'=>      false,
                'typographer'=>  false
            ],
            'enable' => [
                'backticks',
                'blockquote',
                'emphasis',
                'heading',
                'list',
                'newline',
            ],
            'disable' => [
                'autolink',
                'code',
                'entity',
                'escape',
                'fence',
                'hr',
                'html_block',
                'html_inline',
                'image',
                'lheading',
                'link',
                'reference',
                'table'
            ]
        ]
        */
    ]
];
```


### Simpl

```php
use MarkdownIt;

class hoge{
	public function test(){
		// Already a group of `default` options and rules have been set.
		$result1 = MarkdownIt::render('# markdown-it rulezz!');
		// `example`options and groups of rules are set.
		$result2 = MarkdownIt::setOptionsRules("example")
                             ->render('# markdown-it rulezz!');
	}
}
```

Single line rendering, without paragraph wrap:

```php
use MarkdownIt;

class hoge{
	public function test(){
		// Already a group of `default` options and rules have been set.
		$result1 = MarkdownIt::renderInline('__markdown-it__ rulezz!');
		// `example`options and groups of rules are set.
		$result2 = MarkdownIt::setOptionsRules("example")
                             ->renderInline('__markdown-it__ rulezz!');
	}
}
```


### Linkify

`linkify: true` Set [linkify-it](https://github.com/markdown-it/linkify-it) to access the linkify instance.

```php
use MarkdownIt;

class hoge{
	public function test(){
		// disables .py as top level domain
		MarkdownIt::linkify()->tlds('.py', false);
	}
}

```

## References / Thanks

Thanks to the authors of the original implementation in Javascript, [markdown-it](https://github.com/markdown-it/markdown-it):

- Alex Kocharin [github/rlidwka](https://github.com/rlidwka)
- Vitaly Puzrin [github/puzrin](https://github.com/puzrin)

and to [John MacFarlane](https://github.com/jgm) for his work on the
CommonMark spec and reference implementations.

**Related Links:**

- https://github.com/jgm/CommonMark - reference CommonMark implementations in C & JS,
  also contains latest spec & online demo.
- http://talk.commonmark.org - CommonMark forum, good place to collaborate
  developers' efforts.
  
## License

[MIT](https://github.com/markdown-it/markdown-it/blob/master/LICENSE)