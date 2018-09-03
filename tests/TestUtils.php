<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 31/07/18
 * Time: 05:25 PM
 */

namespace Tests;

use App\Entities\CfdiUse;
use Doctrine\ORM\EntityManager;
use League\FactoryMuffin\FactoryMuffin;
use Zend\Diactoros\ServerRequestFactory;


class TestUtils
{
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
        $fm->loadFactories(__DIR__ . DIRECTORY_SEPARATOR . 'factories');

        return $fm;
    }
}