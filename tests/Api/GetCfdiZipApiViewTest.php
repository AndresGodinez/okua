<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 6/09/18
 * Time: 11:29 AM
 */

namespace Tests\Api;


use App\Entities\Cfdi;
use App\Exceptions\ViewSecurityException;
use App\Repositories\CfdiRepository;
use App\Site\SiteContainer;
use App\Utils\EntityUtils;
use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\FactoryMuffin;
use League\Route\RouteCollection;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Filesystem;
use Tests\TestUtils;


/**
 * Class GetCfdiZipApiViewTest
 * @package Api
 */
class GetCfdiZipApiViewTest extends TestCase
{
    /** @var Container */
    protected static $container = null;

    /** @var EntityManager */
    protected static $em = null;

    /** @var null|RouteCollection */
    public static $router = null;

    /** @var null|FactoryMuffin */
    protected static $fm = null;

    /** @var null|array */
    protected static $config = null;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \League\FactoryMuffin\Exceptions\DirectoryNotFoundException
     */
    public static function setUpBeforeClass()
    {
        self::$container = SiteContainer::make();

        TestUtils::initConsts();

        self::$fm = TestUtils::initFactories();

        /** @var Filesystem $sharedFs */
        $sharedFs = self::$container->get('shared-filesystem');

        self::$config = self::$container->get('config');

        $filesDoneDir = self::$config['FILES_DONE_DIR'];

        $basePath = $filesDoneDir . '/2018-09-04/IIM651101EVA';
        if (!\file_exists($basePath))
            mkdir($basePath, 0755, true);

        \file_put_contents($basePath . '/90FB2D49-50A1-4FD0-A077-4C1A6EAAC124.xml', 'aaa');
        \file_put_contents($basePath . '/90FB2D49-50A1-4FD0-A077-4C1A6EAAC124.pdf', 'aaa');

        $basePath = $filesDoneDir . '/2018-09-05/IIM651101EVA';
        if (!\file_exists($basePath))
            mkdir($basePath, 0755, true);

        \file_put_contents($basePath . '/1C7E1DC5-3C01-43F9-8535-CED5ABBA0FF4.xml', 'aaa');
        \file_put_contents($basePath . '/1C7E1DC5-3C01-43F9-8535-CED5ABBA0FF4.pdf', 'aaa');

        $basePath = $filesDoneDir . '/2018-09-06/IIM651101EVA';
        if (!\file_exists($basePath))
            mkdir($basePath, 0755, true);

        \file_put_contents($basePath . '/B1A13571-BCD1-41B7-94FE-C84113FB3450.xml', 'aaa');
    }

    public static function tearDownAfterClass()
    {
        $filesDoneDir = self::$config['FILES_DONE_DIR'];

        unlink($filesDoneDir . '/2018-09-04/IIM651101EVA/90FB2D49-50A1-4FD0-A077-4C1A6EAAC124.xml');
        unlink($filesDoneDir . '/2018-09-04/IIM651101EVA/90FB2D49-50A1-4FD0-A077-4C1A6EAAC124.pdf');

        unlink($filesDoneDir . '/2018-09-05/IIM651101EVA/1C7E1DC5-3C01-43F9-8535-CED5ABBA0FF4.xml');
        unlink($filesDoneDir . '/2018-09-05/IIM651101EVA/1C7E1DC5-3C01-43F9-8535-CED5ABBA0FF4.pdf');

        unlink($filesDoneDir . '/2018-09-06/IIM651101EVA/B1A13571-BCD1-41B7-94FE-C84113FB3450.xml');
    }

    protected function setUp()
    {
        self::$router = self::$container->get('router');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function tearDown()
    {
        self::$router = null;
    }

    public function testUpAndRunning()
    {
        $this->expectException(ViewSecurityException::class);

        $request = TestUtils::makeServerRequestMock('GET', '/api/cfdi/zip-files');
        self::$router->dispatch($request, self::$container->get('response'));
    }

    public function testGetCfdiZipSuccessfully()
    {
        $now = new \DateTime();
        $dummyData = [
            'id' => 0,
            'email' => 'israel.torres@connectit.com.mx',
            'emitterRfc' => 'IIM651101EVA',
            'uuid' => '',
            'type' => 'I',
            'documentDatetime' => $now,
            'emailDatetime' => $now,
            'stampDatetime' => $now,
            'regDatetime' => $now,
            'filesPath' => '',
            'hasPdf' => 1,
        ];

        $mockedRegisters = [];

        $dummyData['id'] = 1;
        $dummyData['uuid'] = '90FB2D49-50A1-4FD0-A077-4C1A6EAAC124';
        $dummyData['filesPath'] = '/2018-09-04/IIM651101EVA';
        \array_push($mockedRegisters, [self::$fm->instance(Cfdi::class, $dummyData), 'cfdiUseName' => 'a']);

        $dummyData['id'] = 2;
        $dummyData['uuid'] = '1C7E1DC5-3C01-43F9-8535-CED5ABBA0FF4';
        $dummyData['filesPath'] = '/2018-09-05/IIM651101EVA';
        \array_push($mockedRegisters, [self::$fm->instance(Cfdi::class, $dummyData), 'cfdiUseName' => 'a']);

        $dummyData['id'] = 3;
        $dummyData['uuid'] = 'B1A13571-BCD1-41B7-94FE-C84113FB3450';
        $dummyData['filesPath'] = '/2018-09-06/IIM651101EVA';
        $dummyData['hasPdf'] = 0;
        \array_push($mockedRegisters, [self::$fm->instance(Cfdi::class, $dummyData), 'cfdiUseName' => 'a']);

        EntityUtils::$mockedEm = $this->createMock(EntityManager::class);

        $mockedRepo = $this->createMock(CfdiRepository::class);

        $mockedRepo->expects($this->once())
            ->method('getFilteredReportRegisters')
            ->with(
                $this->isInstanceOf(\DateTime::class),
                $this->isInstanceOf(\DateTime::class),
                $this->isType('string'),
                $this->isType('float'),
                $this->isType('float'),
                $this->isType('int')
            )
            ->willReturn($mockedRegisters);

        EntityUtils::$mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(Cfdi::class)
            ->willReturn($mockedRepo);

        $encToken = TestUtils::API_TOKEN;

        $request = TestUtils::makeServerRequestMock('GET', '/api/cfdi/zip-files', [
            'a' => $encToken,
            'startDatetime' => '2018-09-06 00:00',
            'endDatetime' => '2018-09-06 00:00',
            'clientRfc' => '',
            'initialAmount' => '0.00',
            'finalAmount' => '0.00',
            'filterDateType' => '1',
        ]);

        $response = self::$router->dispatch($request, self::$container->get('response'));
        
        $this->assertNotNull($response);
        $this->assertTrue($response->hasHeader(TestUtils::HEADER_CONTENT_TYPE), 'The response does not have the CONTENT_TYPE header');

        $contentType = $response->getHeaderLine(TestUtils::HEADER_CONTENT_TYPE);
        $this->assertEquals($contentType, TestUtils::CONTENT_TYPE_APPLICATION_ZIP, 'The response CONTENT_TYPE header is not JSON');

        $this->assertGreaterThan(0, $response->getBody()->getSize());
    }
}