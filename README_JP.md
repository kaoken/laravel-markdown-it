# laravel-markdown-it

[![Build Status](https://img.shields.io/travis/markdown-it/markdown-it/master.svg?style=flat)](https://github.com/kaoken/laravel-markdown-it)
[![composer version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/kaoken/laravel-markdown-it)
[![licence](https://img.shields.io/badge/licence-MIT-blue.svg)](https://github.com/kaoken/laravel-markdown-it)
[![php version](https://img.shields.io/badge/Laravel-≧5.4.0-red.svg)](https://github.com/kaoken/laravel-markdown-it)
[![php version](https://img.shields.io/badge/php%20version-≧5.6.4-red.svg)](https://github.com/kaoken/laravel-markdown-it)

Laravel 5.4 以上を対象とした  [PHP 版 markdown-it](https://github.com/kaoken/markdown-it-php)をLaravelで簡単に使用できるようにした。  


__コンテンツ一覧__

- [インストール](#インストール)
- [初期設定](#初期設定)
- [構文拡張](#構文拡張)
- [参照 / 謝辞](#参照--謝辞)
- [ライセンス](#ライセンス)

## インストール

**composer**:

`composer.json`に以下のように追加する
```composer.json
"require": {
    ...
	"kaoken/laravel-markdown-it":"1.0.*"
}
```
その後更新
```bash
composer update
```

## 初期設定

#### **`config\app.php`**へ以下を追加：
``` config\app.php
    'providers' => [
        ...
        Kaoken\LaravelMarkdownIt\MarkdownItServiceProvider::class,
    ],

    'aliases' => [
        ...
        'MarkdownIt' => Kaoken\LaravelMarkdownIt\Facades\MarkdownIt::class,
    ],
```
### コマンド

```bash
php artisan vender:publish
```
上記コマンドを実行することによって、`config`ディレクトリに`markdownit.php`が作られる。


### オプションとルールのコンフィグファイル
デフォルトで全てのオプションとルールが使用可能になっている。下記の`config\markdownit.php`の`hoge['options_rules_group']['default']`がそれにあたる。  
オプション（`"options"`）とルール(`"enable"`,`"disable"`)の説明は、`hoge['options_rules_group']['default']`の各パラメーターごとのコメントを見てほしい。
もし、新たなオプションとルールを追加したい場合、下記コメントの`オプションと管理ルールを追加`の下にあるコメントをはずし`"example"`の内容を書き換える。
```php
<?php


return [
    'set_options_rules' => 'default',

    'options_rules_group' =>[
        'default' => [
            'options'=> [
                'html'=>         true,        // ソースでHTMLタグを有効にする
                'xhtmlOut'=>     true,        // 単一のタグを閉じるには、「/」を使用する（<br />）
                'breaks'=>       true,        // 段落内の ' \n ' を <br> に変換する
                'langPrefix'=>   'language-', // フェンスブロックのCSS言語接頭辞
                'linkify'=>      true,        // url のようなテキストをリンクに自動変換する
 
                // いくつかの言語中立的な置換+引用符の美化を有効にする。
                'typographer'=>  false,

                // 二重引用符または一重引用符の置換ペアをタイポグラファーを有効にし、
                // スマートクォートがオンのときStringまたはArrayのいずれかになる。
                //
				// たとえば、ロシア語では '«»„“' 、ドイツ語では '„“‚‘' 、フランス語では（nbspを含む）
				// ['«\xA0', '\xA0»', '‹\xA0', '\xA0›']を使用できる。
                'quotes'=> '“”‘’', /* “”‘’ */

                // ハイライト機能。 エスケープされたHTMLを返す必要がある。
                // ソース文字列が変更されておらず、外部からエスケープされなければならない場合は '' を返す。
                // 結果が<pre ...で始まる場合、内部ラッパーはスキップされる。
                //
                // function (/*str, lang*/) { return ''; }
                //
                'highlight'=> null,

                'maxNesting'=>   100            // 内部保護、再帰制限
            ],
            /**
             * ルール管理！
             * `'enable'`が、有効にしたいルールを追加する。
             * `'disable'`が、無効にしたいルールを追加する。
             * デフォルトではすべてのルールが有効。
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
                'strikethrough',
                /**
                 * @see https://github.com/markdown-it/markdown-it/blob/master/benchmark/samples/block-tables.md
                 */
                'table'
            ],
            'disable' => [

            ]
        ],
        /**
         * オプションとルールを追加
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


### 簡単な使い方

```php
use MarkdownIt;

class hoge{
	public function test(){
		// `default`のオプションとルールのグループがセットされている。
		$result1 = MarkdownIt::render('# markdown-it rulezz!');
		// `example`のオプションとルールのグループがセットされる。
		$result2 = MarkdownIt::setOptionsRules("example")
                             ->render('# markdown-it rulezz!');
	}
}
```

単一行レンダリング、段落の折り返しなし:

```php
use MarkdownIt;

class hoge{
	public function test(){
		// `default`のオプションとルールのグループがセットされている。
		$result1 = MarkdownIt::renderInline('__markdown-it__ rulezz!');
		// `example`のオプションとルールのグループがセットされる。
		$result2 = MarkdownIt::setOptionsRules("example")
                             ->renderInline('__markdown-it__ rulezz!');
	}
}
```

### Linkify

`linkify: true` [linkify-it](https://github.com/markdown-it/linkify-it)を設定は、linkifyインスタンスにアクセスする。 

```php
use MarkdownIt;

class hoge{
	public function test(){
		// .pyをトップレベルドメインとして無効にする
		MarkdownIt::linkify()->tlds('.py', false);
	}
}

```

## 参照 / 謝辞
Javascriptで作られた、[markdown-it](https://github.com/markdown-it/markdown-it)に感謝:

- Alex Kocharin [github/rlidwka](https://github.com/rlidwka)
- Vitaly Puzrin [github/puzrin](https://github.com/puzrin)

それと、CommonMarkの仕様とリファレンスの実装については、[John MacFarlane](https://github.com/jgm)を参照。


**関連リンク:**

- https://github.com/jgm/CommonMark
- http://talk.commonmark.org

  
## ライセンス

[MIT](https://ja.osdn.net/projects/opensource/wiki/licenses%2FMIT_license)