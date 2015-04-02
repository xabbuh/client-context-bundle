<?php

namespace Openroot\Bundle\ClientContextBundle\Service;

use Openroot\Bundle\ClientContextBundle\Entity\Client;
use Openroot\Bundle\ClientContextBundle\Entity\Repository\ClientHttpContextRepository;
use Openroot\Bundle\ClientContextBundle\Exceptions\ClientContextException;
use Openroot\Bundle\ClientContextBundle\Interfaces\ClientContextInterface;
use Openroot\Bundle\HttpContextBundle\Entity\Context as HttpContext;
use Openroot\Bundle\HttpContextBundle\Service\HttpContextService;

/**
 * Class ClientContextService
 *
 * @package Openroot\Bundle\ClientContextBundle\Service
 */
class ClientContextService
{
    /**
     * @var HttpContextService
     */
    private $httpContextService;

    /**
     * @var ClientHttpContextRepository
     */
    private $clientHttpContextRepository;

    /**
     * @var null|Client
     */
    private $resolvedClient;

    /**
     * @var null|ClientContextInterface
     */
    private $resolvedContext;

    /**
     * @param HttpContextService          $httpContextService
     * @param ClientHttpContextRepository $clientHttpContextRepository
     */
    public function __construct(HttpContextService $httpContextService, ClientHttpContextRepository $clientHttpContextRepository)
    {
        $this->httpContextService = $httpContextService;
        $this->clientHttpContextRepository = $clientHttpContextRepository;
    }

    /**
     * @return Client
     * @throws ClientContextException
     */
    public function getClient()
    {
        if (!$this->resolvedClient) {
            if (!$this->httpContextService->hasContext()) {
                throw ClientContextException::noContext();
            }

            $httpContext = $this->httpContextService->getContext();
            $client = $this->resolveClientByHttpContext($httpContext);

            if (!$client) {
                throw ClientContextException::noClient();
            }

            $this->resolvedClient = $client;
        }

        return $this->resolvedClient;
    }

    /**
     * @param HttpContext $context
     *
     * @return null|Client
     */
    private function resolveClientByHttpContext(HttpContext $context)
    {
        $this->resolvedContext = $this->clientHttpContextRepository->findOneBy(
            [
                'host' => $context->getHost(),
                'port' => $context->getPort()
            ]
        );
        if ($this->resolvedContext) {
            return $this->resolvedContext->getClient();
        }
        return null;
    }
}
