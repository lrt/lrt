<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Proxy;

use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;

// Note until PHPUnit_Mock_Objects 1.2 is released you cannot mock abstracts due to
// https://github.com/sebastianbergmann/phpunit-mock-objects/issues/73
class ConcreteProxy extends AbstractProxy
{

}

class ConcreteSessionHandlerInterfaceProxy extends AbstractProxy implements \SessionHandlerInterface
{
   public function open($savePath, $sessionName)
    {
    }

    public function close()
    {
    }

    public function read($id)
    {
    }

    public function write($id, $data)
    {
    }

    public function destroy($id)
    {
    }

    public function gc($maxlifetime)
    {
    }
}

/**
 * Test class for AbstractProxy.
 *
 * @author Drak <drak@zikula.org>
 */
class AbstractProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractProxy
     */
    protected $proxy;

    protected function setUp()
    {
        $this->proxy = new ConcreteProxy();
    }

    protected function tearDown()
    {
        $this->proxy = null;
    }

    public function testGetSaveHandlerName()
    {
        $this->assertNull($this->proxy->getSaveHandlerName());
    }

    public function testIsSessionHandlerInterface()
    {
        $this->assertFalse($this->proxy->isSessionHandlerInterface());
        $sh = new ConcreteSessionHandlerInterfaceProxy();
        $this->assertTrue($sh->isSessionHandlerInterface());
    }

    public function testIsWrapper()
    {
        $this->assertFalse($this->proxy->isWrapper());
    }

    public function testIsActive()
    {
        $this->assertFalse($this->proxy->isActive());
    }

    public function testSetActive()
    {
        $this->proxy->setActive(true);
        $this->assertTrue($this->proxy->isActive());
        $this->proxy->setActive(false);
        $this->assertFalse($this->proxy->isActive());
    }

    /**
     * @runInSeparateProcess
     */
    public function testName()
    {
        $this->assertEquals(session_name(), $this->proxy->getName());
        $this->proxy->setName('foo');
        $this->assertEquals('foo', $this->proxy->getName());
        $this->assertEquals(session_name(), $this->proxy->getName());
    }

    /**
     * @expectedException \LogicException
     */
    public function testNameException()
    {
        $this->proxy->setActive(true);
        $this->proxy->setName('foo');
    }

    /**
     * @runInSeparateProcess
     */
    public function testId()
    {
        $this->assertEquals(session_id(), $this->proxy->getId());
        $this->proxy->setId('foo');
        $this->assertEquals('foo', $this->proxy->getId());
        $this->assertEquals(session_id(), $this->proxy->getId());
    }

    /**
     * @expectedException \LogicException
     */
    public function testIdException()
    {
        $this->proxy->setActive(true);
        $this->proxy->setId('foo');
    }
}
