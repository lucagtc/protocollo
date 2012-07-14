<?php

namespace GL\ProtocolloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GL\ProtocolloBundle\Entity\Protocollo
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="main_idx", columns={"anno", "protocollo"})})
 * @ORM\Entity(repositoryClass="GL\ProtocolloBundle\Repository\ProtocolloRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Protocollo {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $anno
     *
     * @ORM\Column(name="anno", type="integer")
     */
    private $anno;

    /**
     * @var integer $protocollo
     *
     * @ORM\Column(name="protocollo", type="integer")
     */
    private $protocollo;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=1)
     * @Assert\Choice(choices = {"U", "I"}, message = "Scegliere U per uscita o I per ingresso.")
     *
     */
    private $tipo;

    /**
     * @var date $data
     *
     * @ORM\Column(name="data", type="date")
     */
    private $data;

    /**
     * @var string $formato
     *
     * @ORM\Column(name="formato", type="string", length=25)
     */
    private $formato;

    /**
     * @var string $intestazione
     *
     * @ORM\Column(name="intestazione", type="string", length=255)
     */
    private $intestazione;

    /**
     * @var string $indirizzo
     *
     * @ORM\Column(name="indirizzo", type="string", length=255, nullable=true)
     */
    private $indirizzo;

    /**
     * @var string $localita
     *
     * @ORM\Column(name="localita", type="string", length=255, nullable=true)
     */
    private $localita;

    /**
     * @var string $oggetto
     *
     * @ORM\Column(name="oggetto", type="string", length=255, nullable=true)
     */
    private $oggetto;

    /**
     * @var string $protocolloDocumento
     *
     * @ORM\Column(name="protocolloDocumento", type="string", length=255, nullable=true)
     */
    private $protocolloDocumento;

    /**
     * @var string $posizione
     *
     * @ORM\Column(name="posizione", type="string", length=25, nullable=true)
     */
    private $posizione;

    /**
     * @var Protocollo $protocolloSuccessivo
     *
     * @ORM\OneToOne(targetEntity="Protocollo", mappedBy="protocolloPrecedente")
     */
    private $protocolloSuccessivo;

    /**
     * @var Protocollo $protocolloPrecedente
     *
     * @ORM\OneToOne(targetEntity="Protocollo", inversedBy="protocolloSuccessivo")
     * @ORM\JoinColumn(name="protocolloPrecedente_id", referencedColumnName="id", nullable=true, unique=true)
     */
    private $protocolloPrecedente;

    /**
     * @var integer $user_id
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var string $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct() {
        $data = new \DateTime();
        $this->anno = $data->format('Y');
        $this->protocollo = 0;
        $this->data = $data;
        $this->created_at = $data;

        return $this;
    }

    public function __toString() {
        return $this->anno . '/' . $this->protocollo;
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
     * Set anno
     *
     * @param integer $anno
     * @return Protocollo
     */
    public function setAnno($anno) {
        $this->anno = $anno;
        return $this;
    }

    /**
     * Get anno
     *
     * @return integer
     */
    public function getAnno() {
        return $this->anno;
    }

    /**
     * Set protocollo
     *
     * @param integer $protocollo
     * @return Protocollo
     */
    public function setProtocollo($protocollo) {
        $this->protocollo = $protocollo;
        return $this;
    }

    /**
     * Get protocollo
     *
     * @return integer
     */
    public function getProtocollo() {
        return $this->protocollo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Protocollo
     */
    public function setTipo($tipo) {
        $this->tipo = strtoupper($tipo);
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Set data
     *
     * @param date $data
     * @return Protocollo
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return date
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set formato
     *
     * @param string $formato
     * @return Protocollo
     */
    public function setFormato($formato) {
        $this->formato = $formato;
        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato() {
        return $this->formato;
    }

    /**
     * Set intestazione
     *
     * @param string $intestazione
     * @return Protocollo
     */
    public function setIntestazione($intestazione) {
        $this->intestazione = $intestazione;
        return $this;
    }

    /**
     * Get intestazione
     *
     * @return string
     */
    public function getIntestazione() {
        return $this->intestazione;
    }

    /**
     * Set indirizzo
     *
     * @param string $indirizzo
     * @return Protocollo
     */
    public function setIndirizzo($indirizzo) {
        $this->indirizzo = $indirizzo;
        return $this;
    }

    /**
     * Get indirizzo
     *
     * @return string
     */
    public function getIndirizzo() {
        return $this->indirizzo;
    }

    /**
     * Set localita
     *
     * @param string $localita
     * @return Protocollo
     */
    public function setLocalita($localita) {
        $this->localita = $localita;
        return $this;
    }

    /**
     * Get localita
     *
     * @return string
     */
    public function getLocalita() {
        return $this->localita;
    }

    /**
     * Set oggetto
     *
     * @param string $oggetto
     * @return Protocollo
     */
    public function setOggetto($oggetto) {
        $this->oggetto = $oggetto;
        return $this;
    }

    /**
     * Get oggetto
     *
     * @return string
     */
    public function getOggetto() {
        return $this->oggetto;
    }

    /**
     * Set posizione
     *
     * @param string $posizione
     * @return Protocollo
     */
    public function setPosizione($posizione) {
        $this->posizione = $posizione;
        return $this;
    }

    /**
     * Get posizione
     *
     * @return string
     */
    public function getPosizione() {
        return $this->posizione;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Protocollo
     */
    public function setUserId($userId) {
        $this->user_id = $userId;
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Protocollo
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * PreUpdate entity
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->updated_at = new \DateTime();
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     * @return Protocollo
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Set protocolloSuccessivo
     *
     * @param GL\ProtocolloBundle\Entity\Protocollo $protocolloSuccessivo
     * @return Protocollo
     */
    public function setProtocolloSuccessivo(\GL\ProtocolloBundle\Entity\Protocollo $protocolloSuccessivo = null) {
        $this->protocolloSuccessivo = $protocolloSuccessivo;
        return $this;
    }

    /**
     * Get protocolloSuccessivo
     *
     * @return GL\ProtocolloBundle\Entity\Protocollo
     */
    public function getProtocolloSuccessivo() {
        return $this->protocolloSuccessivo;
    }

    /**
     * Set protocolloPrecedente
     *
     * @param GL\ProtocolloBundle\Entity\Protocollo $protocolloPrecedente
     * @return Protocollo
     */
    public function setProtocolloPrecedente(\GL\ProtocolloBundle\Entity\Protocollo $protocolloPrecedente = null) {
        $this->protocolloPrecedente = $protocolloPrecedente;
        return $this;
    }

    /**
     * Get protocolloPrecedente
     *
     * @return GL\ProtocolloBundle\Entity\Protocollo
     */
    public function getProtocolloPrecedente() {
        return $this->protocolloPrecedente;
    }

    /**
     * Set protocolloDocumento
     *
     * @param string $protocolloDocumento
     * @return Protocollo
     */
    public function setProtocolloDocumento($protocolloDocumento) {
        $this->protocolloDocumento = $protocolloDocumento;
        return $this;
    }

    /**
     * Get protocolloDocumento
     *
     * @return string
     */
    public function getProtocolloDocumento() {
        return $this->protocolloDocumento;
    }

}