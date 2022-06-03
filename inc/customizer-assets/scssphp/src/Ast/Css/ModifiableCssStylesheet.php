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

class ModifiableCssDimas_Stylesheet extends ModifiableCssParentNode implements CssDimas_Stylesheet
{
    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param FileSpan $span
     */
    public function __construct(FileSpan $span)
    {
        parent::__construct();
        $this->span = $span;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssDimas_Stylesheet($this);
    }

    /**
     * @phpstan-return ModifiableCssDimas_Stylesheet
     */
    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssDimas_Stylesheet($this->span);
    }
}
