<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 7/08/18
 * Time: 03:34 PM
 */

namespace App\Models;


use App\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LoginRequestData
 * @package App\Models
 */
class LoginRequestData
{
    /**
     * @param ServerRequestInterface $request
     * @return LoginRequestData
     */
    public static function makeFromRequest(ServerRequestInterface $request)
    {
        $body = $request->getParsedBody();
        $username = $body['username'] ?? '';
        $password = $body['password'] ?? '';

        return new LoginRequestData($username, $password);
    }

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /**
     * LoginRequestData constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \json_encode(["username" => $this->username, "password" => $this->password]);
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->username || !$this->password)
            throw new ValidationException("Los parámetros de la petición son inválidos.");
    }
}