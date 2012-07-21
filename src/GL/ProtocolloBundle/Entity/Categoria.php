<?php

namespace GL\ProtocolloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GL\ProtocolloBundle\Entity\Categoria
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Categoria {

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
     * @var $classificazioni
     *
     * @ORM\OneToMany(targetEntity="Classificazione", mappedBy="categoria")
     */
    private $classificazioni;

    /**
     * @var $fascicoli
     *
     * @ORM\OneToMany(targetEntity="Fascicolo", mappedBy="categoria")
     */
    private $fascicoli;

    /**
     * @var $protocolli
     *
     * @ORM\OneToMany(targetEntity="Protocollo", mappedBy="categoria")
     */
    private $protocolli;

    public function __construct() {
        $this->classificazioni = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fascicoli = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Categoria
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
     * Add classificazioni
     *
     * @param GL\ProtocolloBundle\Entity\Classificazione $classificazioni
     * @return Categoria
     */
    public function addClassificazioni(\GL\ProtocolloBundle\Entity\Classificazione $classificazioni) {
        $this->classificazioni[] = $classificazioni;
        return $this;
    }

    /**
     * Remove classificazioni
     *
     * @param <variableType$classificazioni
     */
    public function removeClassificazioni(\GL\ProtocolloBundle\Entity\Classificazione $classificazioni) {
        $this->classificazioni->removeElement($classificazioni);
    }

    /**
     * Get classificazioni
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getClassificazioni() {
        return $this->classificazioni;
    }

    /**
     * Add fascicoli
     *
     * @param GL\ProtocolloBundle\Entity\Fascicolo $fascicoli
     * @return Categoria
     */
    public function addFascicoli(\GL\ProtocolloBundle\Entity\Fascicolo $fascicoli) {
        $this->fascicoli[] = $fascicoli;
        return $this;
    }

    /**
     * Remove fascicoli
     *
     * @param <variableType$fascicoli
     */
    public function removeFascicoli(\GL\ProtocolloBundle\Entity\Fascicolo $fascicoli) {
        $this->fascicoli->removeElement($fascicoli);
    }

    /**
     * Get fascicoli
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFascicoli() {
        return $this->fascicoli;
    }


    /**
     * Add protocolli
     *
     * @param GL\ProtocolloBundle\Entity\Protocollo $protocolli
     * @return Categoria
     */
    public function addProtocolli(\GL\ProtocolloBundle\Entity\Protocollo $protocolli)
    {
        $this->protocolli[] = $protocolli;
        return $this;
    }

    /**
     * Remove protocolli
     *
     * @param <variableType$protocolli
     */
    public function removeProtocolli(\GL\ProtocolloBundle\Entity\Protocollo $protocolli)
    {
        $this->protocolli->removeElement($protocolli);
    }

    /**
     * Get protocolli
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProtocolli()
    {
        return $this->protocolli;
    }
}