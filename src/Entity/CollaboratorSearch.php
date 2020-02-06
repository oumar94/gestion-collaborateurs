<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

class CollaboratorSearch {

    private $date_dispo;

    private $actualStatus;

    private $operating_mode;

    /**
     * @var ArrayCollection|null
     */
    private  $clients;
    public function __construct()
    {
        $this->clients=new ArrayCollection();
    }


    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->date_dispo;
    }

    /**
     * @param \DateTimeInterface|null $date_dispo
     * @return CollaboratorSearch
     */
    public function setDateDispo(?\DateTimeInterface $date_dispo): CollaboratorSearch
    {
        $this->date_dispo = $date_dispo;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getClients(): ?ArrayCollection
    {
        return $this->clients;
    }

    /**
     * @param ArrayCollection $clients
     * @return CollaboratorSearch
     */
    public function setClients(ArrayCollection $clients): ?CollaboratorSearch
    {
        $this->clients = $clients;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActualStatus():?ActualStatus
    {
        return $this->actualStatus;
    }

    /**
     * @param mixed $actualStatus
     * @return CollaboratorSearch
     */
    public function setActualStatus(?ActualStatus  $actualStatus)
    {
        $this->actualStatus = $actualStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperatingMode():?OperatingMode
    {
        return $this->operating_mode;
    }

    /**
     * @param mixed $operating_mode
     * @return CollaboratorSearch
     */
    public function setOperatingMode(?OperatingMode $operating_mode)
    {
        $this->operating_mode = $operating_mode;
        return $this;
    }







}