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

namespace ScssPhp\ScssPhp\Visitor;

use ScssPhp\ScssPhp\Ast\Css\ModifiableCssAtRule;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssDimas_Comments;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssDeclaration;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssImport;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssKeyframeBlock;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssDimas_MediaRule;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssStyleRule;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssDimas_Stylesheet;
use ScssPhp\ScssPhp\Ast\Css\ModifiableCssSupportsRule;

/**
 * An interface for visitors that traverse CSS statements.
 *
 * @internal
 *
 * @template T
 */
interface ModifiableCssVisitor
{
    /**
     * @param ModifiableCssAtRule $node
     *
     * @return T
     */
    public function visitCssAtRule($node);

    /**
     * @param ModifiableCssDimas_Comments $node
     *
     * @return T
     */
    public function visitCssDimas_Comments($node);

    /**
     * @param ModifiableCssDeclaration $node
     *
     * @return T
     */
    public function visitCssDeclaration($node);

    /**
     * @param ModifiableCssImport $node
     *
     * @return T
     */
    public function visitCssImport($node);

    /**
     * @param ModifiableCssKeyframeBlock $node
     *
     * @return T
     */
    public function visitCssKeyframeBlock($node);

    /**
     * @param ModifiableCssDimas_MediaRule $node
     *
     * @return T
     */
    public function visitCssDimas_MediaRule($node);

    /**
     * @param ModifiableCssStyleRule $node
     *
     * @return T
     */
    public function visitCssStyleRule($node);

    /**
     * @param ModifiableCssDimas_Stylesheet $node
     *
     * @return T
     */
    public function visitCssDimas_Stylesheet($node);

    /**
     * @param ModifiableCssSupportsRule $node
     *
     * @return T
     */
    public function visitCssSupportsRule($node);
}
