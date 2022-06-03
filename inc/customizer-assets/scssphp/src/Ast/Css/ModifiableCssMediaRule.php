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
 * A modifiable version of {@see CssDimas_MediaRule} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssDimas_MediaRule extends ModifiableCssParentNode implements CssDimas_MediaRule
{
    /**
     * @var list<CssDimas_MediaQuery>
     */
    private $queries;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param CssDimas_MediaQuery[] $queries
     * @param FileSpan        $span
     */
    public function __construct(array $queries, FileSpan $span)
    {
        parent::__construct();
        $this->queries = $queries;
        $this->span = $span;
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept($visitor)
    {
        return $visitor->visitCssDimas_MediaRule($this);
    }

    public function copyWithoutChildren(): ModifiableCssParentNode
    {
        return new ModifiableCssDimas_MediaRule($this->queries, $this->span);
    }
}
