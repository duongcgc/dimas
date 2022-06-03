<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Ast\Css;

use ScssPhp\ScssPhp\SourceSpan\FileSpan;

/**
 * A modifiable version of {@see CssDimas_Comments} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssDimas_Comments extends ModifiableCssNode implements CssDimas_Comments
{
    /**
     * @var string
     * @readonly
     */
    private $text;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    public function __construct(string $text, FileSpan $span)
    {
        $this->text = $text;
        $this->span = $span;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function isPreserved(): bool
    {
        return $this->text[2] === '!';
    }

    public function accept($visitor)
    {
        return $visitor->visitCssDimas_Comments($this);
    }
}
