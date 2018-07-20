<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 12:44 PM
 */

namespace App\Factories;


class ConnectionFactory
{
    /** @var array */
    protected $config;

    /** @var null */
    protected $connection;

    /**
     * ConnectionFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->initConnection($config);
    }

    private function initConnection(array $config)
    {
        $this->connection = null;
    }

    /**
     * @return null
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
