<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 3/09/18
 * Time: 02:38 PM
 */

namespace Api;


use App\Api\AbstractBaseCrudApiView;
use App\Site\SiteContainer;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tests\TestUtils;


/**
 * Class ClassAbstractBaseCrudApiViewTest
 * @package Api
 */
class ClassAbstractBaseCrudApiViewTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();
    }

    /**
     * @throws \ReflectionException
     */
    public function testCreateRegisterAbstractMethodMock()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $stub = $this->getMockForAbstractClass(AbstractBaseCrudApiView::class);
        $stub->expects($this->any())
            ->method('createRegister')
            ->with($this->isInstanceOf(ServerRequestInterface::class) , $this->isInstanceOf(ResponseInterface::class))
            ->willReturn(self::$container->get('response'));

        $request = TestUtils::makeServerRequestMock('GET', '/');
        $response = self::$container->get('response');

        $res = $stub->createRegister($request, $response);

        $this->assertNotNull($res);
    }

    /**
     * @throws \ReflectionException
     */
    public function testReadRegistersAbstractMethodMock()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $stub = $this->getMockForAbstractClass(AbstractBaseCrudApiView::class);
        $stub->expects($this->any())
            ->method('readRegisters')
            ->with($this->isInstanceOf(ServerRequestInterface::class) , $this->isInstanceOf(ResponseInterface::class))
            ->willReturn(self::$container->get('response'));

        $request = TestUtils::makeServerRequestMock('GET', '/');
        $response = self::$container->get('response');

        $res = $stub->readRegisters($request, $response);

        $this->assertNotNull($res);
    }

    /**
     * @throws \ReflectionException
     */
    public function testReadRegisterAbstractMethodMock()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $stub = $this->getMockForAbstractClass(AbstractBaseCrudApiView::class);
        $stub->expects($this->any())
            ->method('readRegister')
            ->with($this->isInstanceOf(ServerRequestInterface::class) , $this->isInstanceOf(ResponseInterface::class), $this->isType('array'))
            ->willReturn(self::$container->get('response'));

        $request = TestUtils::makeServerRequestMock('GET', '/');
        $response = self::$container->get('response');

        $res = $stub->readRegister($request, $response, ['regId' => 0]);

        $this->assertNotNull($res);
    }

    /**
     * @throws \ReflectionException
     */
    public function testUpdateRegisterAbstractMethodMock()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $stub = $this->getMockForAbstractClass(AbstractBaseCrudApiView::class);
        $stub->expects($this->any())
            ->method('updateRegister')
            ->with($this->isInstanceOf(ServerRequestInterface::class) , $this->isInstanceOf(ResponseInterface::class), $this->isType('array'))
            ->willReturn(self::$container->get('response'));

        $request = TestUtils::makeServerRequestMock('GET', '/');
        $response = self::$container->get('response');

        $res = $stub->updateRegister($request, $response, ['regId' => 0]);

        $this->assertNotNull($res);
    }

    /**
     * @throws \ReflectionException
     */
    public function testDeleteRegisterAbstractMethodMock()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $stub = $this->getMockForAbstractClass(AbstractBaseCrudApiView::class);
        $stub->expects($this->any())
            ->method('deleteRegister')
            ->with($this->isInstanceOf(ServerRequestInterface::class) , $this->isInstanceOf(ResponseInterface::class), $this->isType('array'))
            ->willReturn(self::$container->get('response'));

        $request = TestUtils::makeServerRequestMock('GET', '/');
        $response = self::$container->get('response');

        $res = $stub->deleteRegister($request, $response, ['regId' => 0]);

        $this->assertNotNull($res);
    }
}