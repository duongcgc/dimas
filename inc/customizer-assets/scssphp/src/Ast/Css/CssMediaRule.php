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

/**
 * A plain CSS `@media` rule.
 *
 * @internal
 */
interface CssDimas_MediaRule extends CssParentNode
{
    /**
     * The queries for this rule.
     *
     * This is never empty.
     *
     * @return list<CssDimas_MediaQuery>
     */
    public function getQueries(): array;
}
