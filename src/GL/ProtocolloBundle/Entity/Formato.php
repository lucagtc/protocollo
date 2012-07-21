<?php

namespace GL\ProtocolloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GL\ProtocolloBundle\Entity\Formato
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Formato {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=50)
     */
    private $nome;

    /**
     * @var $protocollo
     *
     * @ORM\OneToMany(targetEntity="Protocollo", mappedBy="formato")
     */
    private $protocolli;

    public function __construct() {
        $this->protocolli = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->nome;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Formato
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Add protocolli
     *
     * @param GL\ProtocolloBundle\Entity\Protocollo $protocolli
     * @return Formato
     */
    public function addProtocolli(\GL\ProtocolloBundle\Entity\Protocollo $protocolli) {
        $this->protocolli[] = $protocolli;
        return $this;
    }

    /**
     * Remove protocolli
     *
     * @param <variableType$protocolli
     */
    public function removeProtocolli(\GL\ProtocolloBundle\Entity\Protocollo $protocolli) {
        $this->protocolli->removeElement($protocolli);
    }

    /**
     * Get protocolli
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProtocolli() {
        return $this->protocolli;
    }

}