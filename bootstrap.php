<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 12:46 PM
 */

$container = \App\Site\SiteContainer::make();

$router = $container->get('router');

try {
    $response = $router->dispatch($container->get('request'), $container->get('response'));
} catch (\App\Exceptions\ValidationException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareValidationExceptionResponse($container->get('response'), $ex);
} catch (\App\Exceptions\ApiSecurityException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareApiSecurityExceptionResponse($container->get('response'), $ex);
} catch (\App\Exceptions\RemoteApiException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareRemoteApiExceptionResponse($container->get('response'), $ex);
} catch (\App\Exceptions\ViewInvalidSessionException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareViewError($container->get('templates'), $container->get('response'), $ex);
} catch (\App\Exceptions\ViewValidationException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareViewError($container->get('templates'), $container->get('response'), $ex);
} catch (\App\Exceptions\ViewSecurityException $ex) {
    $response = \App\Utils\ExceptionUtils::prepareViewError($container->get('templates'), $container->get('response'), $ex);
}

$container->get('emitter')->emit($response);
exit();
