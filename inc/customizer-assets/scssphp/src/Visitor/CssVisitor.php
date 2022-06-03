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

use ScssPhp\ScssPhp\Ast\Css\CssAtRule;
use ScssPhp\ScssPhp\Ast\Css\CssDimas_Comments;
use ScssPhp\ScssPhp\Ast\Css\CssDeclaration;
use ScssPhp\ScssPhp\Ast\Css\CssImport;
use ScssPhp\ScssPhp\Ast\Css\CssKeyframeBlock;
use ScssPhp\ScssPhp\Ast\Css\CssDimas_MediaRule;
use ScssPhp\ScssPhp\Ast\Css\CssStyleRule;
use ScssPhp\ScssPhp\Ast\Css\CssDimas_Stylesheet;
use ScssPhp\ScssPhp\Ast\Css\CssSupportsRule;

/**
 * An interface for visitors that traverse CSS statements.
 *
 * @internal
 *
 * @template T
 * @template-extends ModifiableCssVisitor<T>
 */
interface CssVisitor extends ModifiableCssVisitor
{
    /**
     * @param CssAtRule $node
     *
     * @return T
     */
    public function visitCssAtRule($node);

    /**
     * @param CssDimas_Comments $node
     *
     * @return T
     */
    public function visitCssDimas_Comments($node);

    /**
     * @param CssDeclaration $node
     *
     * @return T
     */
    public function visitCssDeclaration($node);

    /**
     * @param CssImport $node
     *
     * @return T
     */
    public function visitCssImport($node);

    /**
     * @param CssKeyframeBlock $node
     *
     * @return T
     */
    public function visitCssKeyframeBlock($node);

    /**
     * @param CssDimas_MediaRule $node
     *
     * @return T
     */
    public function visitCssDimas_MediaRule($node);

    /**
     * @param CssStyleRule $node
     *
     * @return T
     */
    public function visitCssStyleRule($node);

    /**
     * @param CssDimas_Stylesheet $node
     *
     * @return T
     */
    public function visitCssDimas_Stylesheet($node);

    /**
     * @param CssSupportsRule $node
     *
     * @return T
     */
    public function visitCssSupportsRule($node);

}
