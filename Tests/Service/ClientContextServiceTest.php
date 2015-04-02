<?php

namespace Openroot\Bundle\ClientContextBundle\Tests\Service;

use Openroot\Bundle\ClientContextBundle\Service\ClientContextService;

require_once __DIR__ . '/../../Service/ClientContextService.php';
require_once __DIR__ . '/../../Exceptions/ClientContextException.php';

class ClientContextServiceTest extends \PHPUnit_Framework_TestCase
{
    private function getClientMock()
    {
        static $context;
        if (!$context) {
            $context = $this->getMock('Openroot\Bundle\HttpContextBundle\Entity\Client');
        }

        return $context;
    }

    private function getHttpContextMock()
    {
        $context = $this->getMock('Openroot\Bundle\HttpContextBundle\Entity\Context', ['getHost', 'getPort']);
        $context
            ->expects($this->once())
            ->method('getHost')
            ->willReturn('www.example.com');
        $context
            ->expects($this->once())
            ->method('getPort')
            ->willReturn(0);

        return $context;
    }

    private function getContextMock()
    {
        $context = $this->getMock('Openroot\Bundle\HttpContextBundle\Entity\Context', ['getClient']);
        $context
            ->expects($this->once())
            ->method('getClient')
            ->willReturn($this->getClientMock());

        return $context;
    }

    private function getHttpContextServiceMock($hasContext)
    {
        $service = $this->getMock('Openroot\Bundle\HttpContextBundle\Service\HttpContextService', ['hasContext', 'getContext']);
        if ($hasContext) {
            $service
                ->expects($this->once())
                ->method('getContext')
                ->willReturn($this->getHttpContextMock());
        }

        return $service;
    }

    private function getClientHttpContextRepositoryMock($hasContext)
    {
        $repository = $this->getMock('Openroot\Bundle\ClientContextBundle\Entity\Repository\ClientHttpContextRepository', ['findOneBy']);
        if ($hasContext) {
            $repository
                ->expects($this->once())
                ->method('findOneBy')
                ->willReturn($this->getContextMock());

        }

        return $repository;
    }

    public function testClientResolvingException()
    {
        $service = new ClientContextService($this->getHttpContextServiceMock(false), $this->getClientHttpContextRepositoryMock(false));
        $this->setExpectedException('Openroot\Bundle\ClientContextBundle\Exceptions\ClientContextException');
        $service->getClient();
    }

    public function testClientResolving()
    {
        $service = new ClientContextService($this->getHttpContextServiceMock(true), $this->getClientHttpContextRepositoryMock(true));
        $this->assertEquals($service->getClient(), $this->getClientMock());
    }
}
