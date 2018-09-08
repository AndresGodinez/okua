<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 5/09/18
 * Time: 03:47 PM
 */

namespace App\Site\Middlewares;


use App\Exceptions\ViewInvalidSessionException;
use App\Traits\ConfigurableViewTrait;
use App\Utils\SessionUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class ValidateSessionViewMiddleware
 * @package App\Site\Middlewares
 */
class ValidateSessionViewMiddleware
{
    /** @var array */
    private $config = [];

    /**
     * ValidateSessionViewMiddleware constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     * @throws ViewInvalidSessionException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        SessionUtils::initSessionFromConfig($this->config);

        // $sessionId = $_SESSION['id'] ?? null;
        // if (!$sessionId)
        //    throw new ViewInvalidSessionException('Invalid session', 400);

        return $next($request, $response);
    }
}