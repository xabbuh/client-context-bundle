<?php

namespace Openroot\Bundle\ClientContextBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Openroot\Bundle\ClientContextBundle\Entity\Repository\ClientRepository")
 * @ORM\Table(name="openroot_clientcontext_client")
 */
class Client
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Openroot\Bundle\ClientContextBundle\Entity\ClientHttpContext", mappedBy="client", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $httpContexts;

    /**
     * Setup
     */
    public function __construct()
    {
        $this->httpContexts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return ArrayCollection
     */
    public function getHttpContexts()
    {
        return $this->httpContexts;
    }

    /**
     * @param ClientHttpContext $clientContext
     *
     * @return bool
     */
    public function hasHttpContext(ClientHttpContext $clientContext)
    {
        return $this->httpContexts->contains($clientContext);
    }

    /**
     * @param ClientHttpContext $clientContext
     *
     * @return $this
     */
    public function addHttpContext(ClientHttpContext $clientContext)
    {
        if (!$this->httpContexts->contains($clientContext)) {
            $this->httpContexts->add($clientContext);
            if ($clientContext->getClient() !== $this) {
                $clientContext->setClient($this);
            }
        }
    }

    /**
     * @param ClientHttpContext $clientContext
     */
    public function removeHttpContext(ClientHttpContext $clientContext)
    {
        if ($this->httpContexts->contains($clientContext)) {
            $this->httpContexts->removeElement($clientContext);
            if ($clientContext->getClient() === $this) {
                $clientContext->setClient(null);
            }
        }
    }

    /**
     * @param ArrayCollection $contexts
     */
    public function setHttpContexts(ArrayCollection $contexts)
    {
        $this->httpContexts = $contexts;
    }
}