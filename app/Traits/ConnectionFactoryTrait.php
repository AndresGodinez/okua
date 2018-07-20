<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 21/05/18
 * Time: 12:42 PM
 */

namespace App\Traits;


use App\Factories\ConnectionFactory;

trait ConnectionFactoryTrait
{
    /** @var ConnectionFactory */
    protected $connectionFactory;

    /**
     * @return ConnectionFactory
     */
    public function getConnectionFactory(): ConnectionFactory
    {
        return $this->connectionFactory;
    }

    /**
     * @param ConnectionFactory $connectionFactory
     */
    public function setConnectionFactory(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }


}
