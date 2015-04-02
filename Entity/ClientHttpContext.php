<?php

namespace Openroot\Bundle\ClientContextBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Openroot\Bundle\ClientContextBundle\Interfaces\ClientContextInterface;

/**
 * @ORM\Entity(repositoryClass="Openroot\Bundle\ClientContextBundle\Entity\Repository\ClientHttpContextRepository")
 * @ORM\Table(name="openroot_clientcontext_httpcontext", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="context_idx", columns={"host", "port"})
 * })
 */
class ClientHttpContext implements ClientContextInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="Openroot\Bundle\ClientContextBundle\Entity\Client", cascade={"all"}, fetch="EAGER", inversedBy="httpContexts")
     */
    private $client;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $host;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $port;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
}
