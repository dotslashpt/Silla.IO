<?php
/**
 * Routes Router Module Tests.
 *
 * @package    Silla.IO
 * @subpackage Tests\Modules\Router
 * @copyright  Copyright (c) 2015, Silla.io
 * @license    http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3.0 (GPLv3)
 */

namespace Tests\Modules\Router;

use Core;
use Core\Modules\Router\Routes;

/**
 * @covers \Core\Modules\Router\Routes
 */
class RoutesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Core\Modules\Router\Routes
     */
    protected $routes;

    protected function setUp()
    {
        $this->routes = new Routes(Core\Config()->mode());
    }

    /**
     * @covers \Core\Modules\Router\Routes::add
     */
    public function testAddingRoutesAcceptsArray()
    {
        $route = array('url' => 'url', 'maps_to' => 'maps_to');
        $this->assertTrue($this->routes->add($route));

        return $route;
    }

    /**
     * @covers  \Core\Modules\Router\Routes::add
     * @depends testAddingRoutesAcceptsArray
     */
    public function testAddingRoutesReturnsTrue(array $route)
    {
        $this->assertTrue($this->routes->add($route));
    }

    /**
     * @covers \Core\Modules\Router\Routes::getAll
     */
    public function testGettingAllRoutesReturnsAnArray()
    {
        $this->assertTrue(is_array($this->routes->getAll()));
    }

    /**
     * @covers \Core\Modules\Router\Routes::toRoute
     */
    public function testPreparingUrlSplitsAndTrimsBySlash()
    {
        $this->assertEquals(
            array('controller', 'action', 'id'),
            $this->routes->toRoute('/controller/action/id/')
        );
    }
}
