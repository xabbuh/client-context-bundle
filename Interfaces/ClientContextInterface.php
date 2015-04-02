<?php

namespace Openroot\Bundle\ClientContextBundle\Interfaces;

use Openroot\Bundle\ClientContextBundle\Entity\Client;

/**
 * Interface ClientContextInterface
 *
 * @package Openroot\Bundle\ClientContextBundle\Interfaces
 */
interface ClientContextInterface
{
    /**
     * @param null|Client $client
     */
    public function setClient(Client $client = null);

    /**
     * @return null|Client
     */
    public function getClient();
}
