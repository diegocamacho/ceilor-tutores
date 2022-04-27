<?php
/*
 * This file is part of the eclipxe/cfdi library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Carlos C Soto <eclipxe13@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://github.com/eclipxe13/cfdi GitHub
 * @link https://github.com/orlandocharles/cfdi Original project
 */
namespace PhpCfdi\CFDI\Node;

use PhpCfdi\CFDI\Common\Node;

/**
 * This is the cfdi relacionado class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Relacionado extends Node
{
    /**
     * Parent node name.
     *
     * @var string
     */
    protected $parentNodeName = 'cfdi:CfdiRelacionados';

    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'cfdi:CfdiRelacionado';
}