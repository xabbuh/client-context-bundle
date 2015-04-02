<?php

namespace Openroot\Bundle\ClientContextBundle\Profiler;

use Openroot\Bundle\ClientContextBundle\Exceptions\ClientContextException;
use Openroot\Bundle\ClientContextBundle\Service\ClientContextService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Class ClientContextDataCollector
 *
 * @package Openroot\Bundle\ClientContextBundle\Profiler
 */
class ClientContextDataCollector extends DataCollector
{
    /**
     * @var ClientContextService
     */
    private $clientContextService;

    /**
     * @param ClientContextService $clientContextService
     */
    public function setClientContextService(ClientContextService $clientContextService)
    {
        $this->clientContextService = $clientContextService;
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     */
    function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $contextClientShort = null;
        $contextClientLong = null;
        try {
            $contextClientShort = $this->clientContextService->getClient()->getTitle();
            $contextClientLong = $contextClientShort;
        } catch (ClientContextException $e) {
            $contextClientShort = '###ERR###';
            $contextClientLong = $e->getMessage();
        }

        $this->data = array(
            'clientContextShort' => $contextClientShort,
            'clientContextLong' => $contextClientLong
        );
    }

    /**
     * @return string
     */
    public function getClientContextShort()
    {
        return $this->data['clientContextShort'];
    }

    /**
     * @return string
     */
    public function getClientContextLong()
    {
        return $this->data['clientContextLong'];
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    function getName()
    {
        return 'clientContext';
    }
}
