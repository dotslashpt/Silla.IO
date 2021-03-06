<?php
/**
 * Smarty plugin.
 *
 * @package    Smarty
 * @subpackage Vendor\Athlon\SmartyPlugins
 * @author     Kalin Stefanov <kalin@athlonsofia.com>
 * @copyright  Copyright (c) 2015, Silla.io
 * @license    http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3.0 (GPLv3)
 */

/**
 * Formats String with format.
 *
 * @param string $string Input string.
 * @param string $format Format string.
 *
 * @return string
 */
function smarty_modifier_string_format($string, $format)
{
    return sprintf($format, $string);
}
