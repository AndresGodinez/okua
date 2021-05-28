<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 13/04/18
 * Time: 12:09 PM
 */

namespace App\Site;

use App\Api\AlertEmailResponseApiView;
use App\Api\CfdiApiView;
use App\Api\CfdiEmitterApiView;
use App\Api\EmitterApiView;
use App\Api\FilterEmitterApiView;
use App\Api\FilterReceptorApiView;
use App\Api\ProcessErrorApiView;
use App\Api\ProcessWarningApiView;
use App\Api\SharedConfigApiView;
use App\Api\TestApiView;
use App\Api\UserApiView;
use App\Api\UserAuthApiView;
use App\Site\Middlewares\CorsApiMiddleware;
use App\Site\Middlewares\SecureApiMiddleware;
use App\Site\Middlewares\SecureApiQueryParamMiddleware;
use App\Site\Middlewares\ValidateSessionViewMiddleware;
use App\Utils\SiteRouterUtils;
use App\Views\AdminConfigEmailServiceView;
use App\Views\BillsView;
use App\Views\CatalogsView;
use App\Views\HomeView;
use App\Views\LoginView;
use App\Views\MovementsLogView;
use App\Views\ProcessErrorsView;
use App\Views\ProcessWarningsView;
use App\Views\ProvidersHomeView;
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
        $route->addPatternMatcher('catalogRegId', '[0-9][0-9]*');

        $route->map('GET', '/', function ($request, $response) {
            return new RedirectResponse('/app');
        });
        $route->group('/admin', function (RouteGroup $group) {
            //users
            $group->get('/users', CatalogsView::class . '::usersIndex');
            $group->get('/user/form', CatalogsView::class . '::userForm');
        })
            ->setScheme('http');

        # fixme: mix the groups of admin routes
        # todo: add middleware to secure admin route
        $route->group('/admin', function (RouteGroup $group) {
            //users
            $group->get('/users', CatalogsView::class . '::usersIndex');
            $group->get('/user/activities/{id:catalogRegId}', CatalogsView::class . '::userActivityForm');
            $group->get('/user/form/{id:catalogRegId}', CatalogsView::class . '::userForm');

            //emitters
            $group->get('/emitters', CatalogsView::class . '::emittersIndex');
            $group->get('/emitter/form/{id:catalogRegId}', CatalogsView::class . '::emitterForm');

            //filter-emitters
            $group->get('/filter-emitters', CatalogsView::class . '::filterEmitterIndex');
            $group->get('/filter-emitter/form/{id:catalogRegId}', CatalogsView::class . '::filterEmitterForm');

            //filter-receptors
            $group->get('/filter-receptors', CatalogsView::class . '::filterReceptorsIndex');
            $group->get('/filter-receptor/form/{id:catalogRegId}', CatalogsView::class . '::filterReceptorForm');

            //alert-email-responses
            $group->get('/alert-email-responses', CatalogsView::class . '::alertEmailResponsesIndex');
            $group->get('/alert-email-response/form/{id:catalogRegId}', CatalogsView::class . '::alertEmailResponseForm');
        })
            ->setScheme('http');

        $route->group('/admin', function (RouteGroup $group) {
            $group->get('/config/email-service', AdminConfigEmailServiceView::class . '::index');
        })
            ->middleware(new ValidateSessionViewMiddleware($container->get('config')))
            ->setScheme('http');

        # SECTION: front-end views
        $route->group('/app', function (RouteGroup $group) {
            $group->get('/login', LoginView::class . '::index');
            $group->get('/logout', LoginView::class . '::logout');

            $group->get('/', HomeView::class . '::index');
            $group->get('/home', HomeView::class . '::index');
            $group->get('/dashboard', HomeView::class . '::index');

            $group->get('/bills', BillsView::class . '::index');
            
            $group->get('/process-warnings', ProcessWarningsView::class . '::index');

            $group->get('/process-errors', ProcessErrorsView::class . '::index');

            $group->get('/movements-log', MovementsLogView::class . '::index');

            $group->get('/providers/home', ProvidersHomeView::class . '::index');
        })
            ->setScheme('http');

        # SECTION: back-end views (API)
        $route->group('/api', function (RouteGroup $group) {
            $group->map('GET', '/test', TestApiView::class . '::test');

            $group->map('POST', '/user/authenticate', UserAuthApiView::class . '::userAuth');

            $group->map('GET', '/bill-info', CfdiApiView::class . '::getFilteredCfdiRegisters');
            $group->map('GET', '/bill-info/{cfdiId:regId}/xml', CfdiApiView::class . '::getCfdiXml');
            $group->map('GET', '/bill-info/{cfdiId:regId}/pdf', CfdiApiView::class . '::getCfdiPdf');
            $group->map('GET', '/bill-info/count', CfdiApiView::class . '::getFilteredCfdiRegistersCount');

            $group->map('GET', '/bill-info/total', CfdiApiView::class . '::getCfdiTotal');

            $group->map('GET', '/bill-info/group-by/client', CfdiApiView::class . '::getCfdiGroupByClient');
            $group->map('GET', '/bill-info/group-by/cfdi-use', CfdiApiView::class . '::getCfdiGroupByCfdiUse');
            $group->map('GET', '/bill-info/group-by/email', CfdiApiView::class . '::getCfdiGroupByEmail');

            $group->map('GET', '/bill-info/group-by/client/count', CfdiApiView::class . '::getCfdiGroupByClientCount');

            $group->map('GET', '/bill-info/last-registers', CfdiApiView::class . '::getLastCfdiRegisters');
            $group->map('GET', '/bill-info/email/last-registers', CfdiApiView::class . '::getLastCfdiEmailRegisters');

            $group->map('GET', 'bill-info-client', CfdiEmitterApiView::class. '::getRegistersOrderedByName');

            $group->map('GET', '/bill-info/{cfdiId:regId}/taxes', CfdiApiView::class . '::getCfdiTaxes');

            $group->map('GET', '/bill-info/taxes/transfer/total', CfdiApiView::class . '::getCfdiTransferTotal');
            $group->map('GET', '/bill-info/taxes/withheld/total', CfdiApiView::class . '::getCfdiWithheldTotal');

            // TODO: change to last-registers path
            $group->map('GET', '/process/warning', ProcessWarningApiView::class . '::getLastProcessWarnings');
            $group->map('GET', '/process/warning/all', ProcessWarningApiView::class . '::getEveryRegister');
            $group->map('GET', '/process/error', ProcessErrorApiView::class . '::getLastProcessErrors');

            $group->map('GET', '/process/warning/{processWarningId:regId}', ProcessWarningApiView::class . '::getProcessWarningById');
            $group->map('GET', '/process/error/{processErrorId:regId}', ProcessErrorApiView::class . '::getProcessErrorById');

            $group->map('GET', '/warning', ProcessWarningApiView::class . '::getFilteredProcessWarningsRegisters');
            $group->map('GET', '/warning/count', ProcessWarningApiView::class . '::getFilteredProcessWarningsRegistersCount');

            $group->map('GET', '/error', ProcessErrorApiView::class . '::getFilteredProcessErrorRegisters');
            $group->map('GET', '/error/count', ProcessErrorApiView::class . '::getFilteredProcessErrorRegistersCount');

            // user crud routes
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/user', UserApiView::class, true);

            // alert-email-response crud routes
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/alert-email-response', AlertEmailResponseApiView::class, true);

            // emitter crud routes
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/emitter', EmitterApiView::class, true);

            // filter-emitter crud routes
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/filter-emitter', FilterEmitterApiView::class, true);

            // filter-receptor crud routes
            SiteRouterUtils::appendCrudRoutesToRouteGroup($group, '/filter-receptor', FilterReceptorApiView::class, true);
        })
            ->middleware(new CorsApiMiddleware)
            ->setScheme('http');

        // download files as zip with custom security as a query parameter
        $route->group('/api/cfdi', function (RouteGroup $group) {
            $group->map('GET', '/zip-files', CfdiApiView::class . '::getCfdiZip');
            $group->map('GET', '/xlsx', CfdiApiView::class . '::getCfdiXlsx');
        })
            ->middleware(new SecureApiQueryParamMiddleware)
            ->setScheme('http');

        // email-service-config routes
        $route->group('/api/config/email-service', function (RouteGroup $group) {
            // read config from shared-storage
            $group->map('GET', '/', SharedConfigApiView::class . '::readEmailServiceConfig');

            // update config from shared-storage
            $group->map('PUT', '/', SharedConfigApiView::class . '::updateEmailServiceConfig');
        })
            ->middleware(new SecureApiMiddleware)
            ->middleware(new CorsApiMiddleware)
            ->setScheme('http');

        return $route;
    }
}