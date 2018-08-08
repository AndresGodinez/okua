<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Site;

use App\Api\BillInfoApiView;
use App\Api\BillInfoClientApiView;
use App\Api\TestApiView;
use App\Api\UserAuthApiView;
use App\Views\BillsView;
use App\Views\HomeView;
use App\Views\LoginView;
use App\Views\MovementsLogView;
use League\Container\Container;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use Zend\Diactoros\Response\RedirectResponse;

class SiteRouter
{
    public function __invoke(Container $container)
    {
        $route = new RouteCollection($container);

        $route->addPatternMatcher('regId', '[1-9][0-9]*');

        $route->map('GET', '/', function ($request, $response) {
            return new RedirectResponse('/app');
        });

        # SECTION: front-end views
        $route->group('/app', function (RouteGroup $group) {
            $group->get('/login', LoginView::class . '::index');

            $group->get('/', HomeView::class . '::index');
            $group->get('/home', HomeView::class . '::index');
            $group->get('/dashboard', HomeView::class . '::index');

            $group->get('/bills', BillsView::class . '::index');

            $group->get('/movements-log', MovementsLogView::class . '::index');
        })
            ->setScheme('http');


        # SECTION: back-end views (API)
        $route->group('/api', function (RouteGroup $group) {
            $group->map('GET', '/test', TestApiView::class . '::test');

            $group->map('POST', '/user/authenticate', UserAuthApiView::class . '::userAuth');

            $group->map('GET', '/bill-info', BillInfoApiView::class . '::getFilteredBillInfoRegisters');
            $group->map('GET', '/bill-info/{billInfoId:regId}/xml', BillInfoApiView::class . '::getBillInfoXml');
            $group->map('GET', '/bill-info/{billInfoId:regId}/pdf', BillInfoApiView::class . '::getBillInfoPdf');
            $group->map('GET', '/bill-info/count', BillInfoApiView::class . '::getFilteredBillInfoRegistersCount');

            $group->map('GET', '/bill-info/total', BillInfoApiView::class . '::getBillsTotal');

            $group->map('GET', '/bill-info/group-by/client', BillInfoApiView::class . '::getBillsInfoGroupByClient');
            $group->map('GET', '/bill-info/group-by/cfdi-use', BillInfoApiView::class . '::getBillsInfoGroupByCfdiUse');
            $group->map('GET', '/bill-info/group-by/email', BillInfoApiView::class . '::getBillsInfoGroupByEmail');

            $group->map('GET', '/bill-info/last-registers', BillInfoApiView::class . '::getLastBillInfoRegisters');
            $group->map('GET', '/bill-info/email/last-registers', BillInfoApiView::class . '::getLastBillInfoEmailRegisters');

            $group->map('GET', 'bill-info-client', BillInfoClientApiView::class. '::getRegistersOrderedByName');
        })
            ->setScheme('http');

        return $route;
    }
}
