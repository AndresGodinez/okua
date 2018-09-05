<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 31/07/18
 * Time: 05:25 PM
 */

namespace Tests;

use App\Entities\CfdiUse;
use App\Models\EmailServiceConfig;
use App\Utils\ResponseUtils;
use Doctrine\ORM\EntityManager;
use League\FactoryMuffin\FactoryMuffin;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;


class TestUtils
{
    const API_TOKEN = 'a';

    const HEADER_CONTENT_TYPE = 'Content-Type';
    const CONTENT_TYPE_APPLICATION_JSON_UTF8 = 'application/json; charset=utf-8';

    const CFDI_USES = [
        ['satCode' => 'G01', 'name' => 'Adquisición de mercancias'],
        ['satCode' => 'G02', 'name' => 'Devoluciones, descuentos o bonificaciones'],
        ['satCode' => 'G03', 'name' => 'Gastos en general'],
        ['satCode' => 'I01', 'name' => 'Construcciones'],
        ['satCode' => 'I02', 'name' => 'Mobilario y equipo de oficina por inversiones'],
        ['satCode' => 'I03', 'name' => 'Equipo de transporte'],
        ['satCode' => 'I04', 'name' => 'Equipo de computo y accesorios'],
        ['satCode' => 'I05', 'name' => 'Dados, troqueles, moldes, matrices y herramental'],
        ['satCode' => 'I06', 'name' => 'Comunicaciones telefónicas'],
        ['satCode' => 'I07', 'name' => 'Comunicaciones satelitales'],
        ['satCode' => 'I08', 'name' => 'Otra maquinaria y equipo'],
        ['satCode' => 'D01', 'name' => 'Honorarios médicos, dentales y gastos hospitalarios.'],
        ['satCode' => 'D02', 'name' => 'Gastos médicos por incapacidad o discapacidad'],
        ['satCode' => 'D03', 'name' => 'Gastos funerales.'],
        ['satCode' => 'D04', 'name' => 'Donativos.'],
        ['satCode' => 'D05', 'name' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).'],
        ['satCode' => 'D06', 'name' => 'Aportaciones voluntarias al SAR.'],
        ['satCode' => 'D07', 'name' => 'Primas por seguros de gastos médicos.'],
        ['satCode' => 'D08', 'name' => 'Gastos de transportación escolar obligatoria.'],
        ['satCode' => 'D09', 'name' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.'],
        ['satCode' => 'D10', 'name' => 'Pagos por servicios educativos (colegiaturas)'],
        ['satCode' => 'P01', 'name' => 'Por definir'],
    ];

    const TEST_EMAIL_SERVICE_CONFIG_FILEPATH = '/test/config/email-serv.data';

    /**
     * @param $method
     * @param $uri
     * @param array $query
     * @param array $body
     * @return \Zend\Diactoros\ServerRequest
     */
    public static function makeServerRequestMock($method, $uri, $query = [], $body = [])
    {
        $server = (require __DIR__ . DIRECTORY_SEPARATOR . "server-mock.php");

        $server['REQUEST_METHOD'] = $method;
        $server['REQUEST_URI'] = $uri;

        return ServerRequestFactory::fromGlobals($server, $query, $body);
    }

    /**
     * @param EntityManager $em
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    public static function insertInitialCfdiUses($em)
    {
        foreach (self::CFDI_USES as $cfdiUseData) {
            $cfdiUse = new CfdiUse();
            $cfdiUse->setName($cfdiUseData['name']);
            $cfdiUse->setSatCode($cfdiUseData['satCode']);

            $em->persist($cfdiUse);
        }
        $em->flush();
        $em->clear();

        return true;
    }

    public static function initConstBaseDir()
    {
        if (!defined("BASE_DIR")) {
            define("BASE_DIR", \realpath(__DIR__ . "/../"));
        }
    }

    public static function initConstTesting()
    {
        if (!defined("TESTING")) {
            define("TESTING", true);
        }
    }

    public static function initConsts()
    {
        self::initConstBaseDir();
        self::initConstTesting();
    }

    /**
     * @return FactoryMuffin
     * @throws \League\FactoryMuffin\Exceptions\DirectoryNotFoundException
     */
    public static function initFactories()
    {
        $fm = new FactoryMuffin();
        $fm->loadFactories(__DIR__ . DIRECTORY_SEPARATOR . 'models-factories');

        return $fm;
    }

    /**
     * @return string
     */
    public static function mockCreateRegisterResponse()
    {
        return \json_encode(['id' => 1, 'msg' => 'Register successfully created']);
    }

    /**
     * @return string
     */
    public static function mockReadRegisterResponse()
    {
        return \json_encode(['id' => 1, 'name' => '', 'regStatus' => 1]);
    }

    /**
     * @return string
     */
    public static function mockReadRegistersResponse()
    {
        return \json_encode(['data' => [
            ['id' => 1, 'name' => '', 'regStatus' => 1],
            ['id' => 2, 'name' => '', 'regStatus' => 1],
            ['id' => 3, 'name' => '', 'regStatus' => 1],
            ['id' => 4, 'name' => '', 'regStatus' => 1],
            ['id' => 5, 'name' => '', 'regStatus' => 1],
            ['id' => 6, 'name' => '', 'regStatus' => 1],
            ['id' => 7, 'name' => '', 'regStatus' => 1],
            ['id' => 8, 'name' => '', 'regStatus' => 1],
            ['id' => 9, 'name' => '', 'regStatus' => 1],
            ['id' => 10, 'name' => '', 'regStatus' => 1],
        ]]);
    }

    /**
     * @return string
     */
    public static function mockUpdateRegisterResponse()
    {
        return \json_encode(['id' => 1, 'msg' => 'Register successfully updated']);
    }

    /**
     * @return string
     */
    public static function mockDeleteRegisterResponse()
    {
        return \json_encode(['id' => 1, 'msg' => 'Register successfully deleted']);
    }

    /**
     * @param TestCase $testInst
     * @param ResponseInterface $response
     */
    public static function runDefaultTestsJsonApiResponse(TestCase $testInst, ResponseInterface $response)
    {
        $testInst->assertNotNull($response);
        $testInst->assertTrue($response->hasHeader(ResponseUtils::HEADER_CORS), 'The response does not have the CORS header');
        $testInst->assertTrue($response->hasHeader(self::HEADER_CONTENT_TYPE), 'The response does not have the CONTENT_TYPE header');

        $contentType = $response->getHeaderLine(self::HEADER_CONTENT_TYPE);
        $testInst->assertEquals($contentType, self::CONTENT_TYPE_APPLICATION_JSON_UTF8, 'The response CONTENT_TYPE header is not JSON');
    }

    public static function mockEmailServiceConfig()
    {
        $hostname = 'test';
        $inboxName = 'INBOX';
        $username = 'test';
        $pswd = 'blablabla';
        $tagOk = 'OK';
        $tagIssue = 'ISSUE';

        $serviceConfig = new EmailServiceConfig();
        $serviceConfig->setHostname($hostname);
        $serviceConfig->setInboxName($inboxName);
        $serviceConfig->setUsername($username);
        $serviceConfig->setPswd($pswd);
        $serviceConfig->setTagOk($tagOk);
        $serviceConfig->setTagIssue($tagIssue);

        return $serviceConfig;
    }
}