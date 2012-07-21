<?php

namespace GL\ProtocolloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GL\ProtocolloBundle\Entity\Fascicolo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GL\ProtocolloBundle\Repository\FascicoloRepository")
 */
class Fascicolo {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Categoria $categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="fascicoli")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=50)
     */
    private $nome;

    /**
     * @var $protocolli
     *
     * @ORM\OneToMany(targetEntity="Protocollo", mappedBy="fascicoli")
     */
    private $protocolli;

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
     * @return Fascicolo
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
     * Set categoria
     *
     * @param GL\ProtocolloBundle\Entity\Categoria $categoria
     * @return Fascicolo
     */
    public function setCategoria(\GL\ProtocolloBundle\Entity\Categoria $categoria = null) {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return GL\ProtocolloBundle\Entity\Categoria
     */
    public function getCategoria() {
        return $this->categoria;
    }

    public function __construct()
    {
        $this->protocolli = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add protocolli
     *
     * @param GL\ProtocolloBundle\Entity\Protocollo $protocolli
     * @return Fascicolo
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