<?php

namespace GL\ProtocolloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GL\ProtocolloBundle\Entity\Protocollo
 *
 * @ORM\Table()
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
     * @var integer $protocolloNumero
     *
     * @ORM\Column(name="protocolloNumero", type="integer", nullable=true)
     */
    private $protocolloNumero;

    /**
     * @var Protocollo $protocolloPrecedente
     *
     * @ORM\OneToOne(targetEntity="Protocollo", inversedBy="protocolloSuccessivo")
     * @ORM\JoinColumn(name="protocolloPrecedente_id", referencedColumnName="id", nullable=true, unique=true)
     */
    private $protocolloPrecedente;

    /**
     * @var Protocollo $protocolloSuccessivo
     *
     * @ORM\OneToOne(targetEntity="Protocollo", mappedBy="protocolloPrecedente")
     */
    private $protocolloSuccessivo;

    /**
     * @var datetime $dataRegistrazione
     *
     * @ORM\Column(name="dataRegistrazione", type="datetime")
     */
    private $dataRegistrazione;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=1)
     * @Assert\Choice(choices = {"U", "I"}, message = "Scegliere U per uscita o I per ingresso.")
     *
     */
    private $tipo;

    /**
     * @var Formato $categoria
     *
     * @ORM\ManyToOne(targetEntity="Formato", inversedBy="protocolli")
     * @ORM\JoinColumn(name="formato_id", referencedColumnName="id")
     */
    private $formato;

    /**
     * @var string $intestazione
     *
     * @ORM\Column(name="intestazione", type="string", length=255, nullable=true)
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
     * @var date $dataDocumento
     *
     * @ORM\Column(name="dataDocumento", type="date", nullable=true)
     */
    private $dataDocumento;

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
     * @ORM\Column(name="documento", type="string", length=255, nullable=true)
     */
    public $documento;

    /**
     * @var string $categora
     *
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="protocolli")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @var string $classificazione
     *
     * @ORM\ManyToOne(targetEntity="Classificazione", inversedBy="protocolli")
     * @ORM\JoinColumn(name="classificiazione_id", referencedColumnName="id")
     */
    private $classificazione;

    /**
     * @var string $fascicolo
     *
     * @ORM\ManyToOne(targetEntity="Fascicolo", inversedBy="protocolli")
     * @ORM\JoinColumn(name="fascicolo_id", referencedColumnName="id")
     */
    private $fascicolo;

    /**
     * @var integer $user_id
     *
     * @ORM\Column(name="utente", type="integer", nullable=true)
     */
    private $utente;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile $allegato
     * @Assert\File(maxSize="10000000")
     */
    public $allegato;

    public function __construct() {
        $data = new \DateTime();
        $this->anno = $data->format('Y');
        $this->protocolloNumero = 0;
        $this->dataRegistrazione = $data;

        return $this;
    }

    public function __toString() {
        return $this->getAnnoProtocollo();
    }

    public function getAnnoProtocollo() {
        return sprintf('%s-%04s', $this->anno, $this->protocolloNumero);
    }

    public function getUploadRootDir() {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'documenti' . DIRECTORY_SEPARATOR . $this->anno . DIRECTORY_SEPARATOR;
    }

    public function getAbsolutePath() {
        return null === $this->documento ? null : $this->getUploadRootDir() . $this->documento;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->allegato) {
            $estensione = pathinfo($this->allegato->getClientOriginalName(), PATHINFO_EXTENSION);
            $this->documento = $this->getAnnoProtocollo() . '.' . $estensione;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postUpload() {
        if (null === $this->allegato) {
            return;
        }

        $this->allegato->move($this->getUploadRootDir(), $this->documento);

        unset($this->allegato);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
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
     * Set protocolloNumero
     *
     * @param integer $protocolloNumero
     * @return Protocollo
     */
    public function setProtocolloNumero($protocolloNumero) {
        $this->protocolloNumero = $protocolloNumero;
        return $this;
    }

    /**
     * Get protocolloNumero
     *
     * @return integer
     */
    public function getProtocolloNumero() {
        return $this->protocolloNumero;
    }

    /**
     * Set dataRegistrazione
     *
     * @param datetime $dataRegistrazione
     * @return Protocollo
     */
    public function setDataRegistrazione($dataRegistrazione) {
        $this->dataRegistrazione = $dataRegistrazione;
        return $this;
    }

    /**
     * Get dataRegistrazione
     *
     * @return datetime
     */
    public function getDataRegistrazione() {
        return $this->dataRegistrazione;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Protocollo
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;
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
     * Set dataDocumento
     *
     * @param date $dataDocumento
     * @return Protocollo
     */
    public function setDataDocumento($dataDocumento) {
        $this->dataDocumento = $dataDocumento;
        return $this;
    }

    /**
     * Get dataDocumento
     *
     * @return date
     */
    public function getDataDocumento() {
        return $this->dataDocumento;
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

    /**
     * Set documento
     *
     * @param string $documento
     * @return Protocollo
     */
    public function setDocumento($documento) {
        $this->documento = $documento;
        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento() {
        return $this->documento;
    }

    /**
     * Set utente
     *
     * @param integer $utente
     * @return Protocollo
     */
    public function setUtente($utente) {
        $this->utente = $utente;
        return $this;
    }

    /**
     * Get utente
     *
     * @return integer
     */
    public function getUtente() {
        return $this->utente;
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
     * Set formato
     *
     * @param GL\ProtocolloBundle\Entity\Formato $formato
     * @return Protocollo
     */
    public function setFormato(\GL\ProtocolloBundle\Entity\Formato $formato = null) {
        $this->formato = $formato;
        return $this;
    }

    /**
     * Get formato
     *
     * @return GL\ProtocolloBundle\Entity\Formato
     */
    public function getFormato() {
        return $this->formato;
    }

    /**
     * Set categoria
     *
     * @param GL\ProtocolloBundle\Entity\Categoria $categoria
     * @return Protocollo
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

    /**
     * Set classificazione
     *
     * @param GL\ProtocolloBundle\Entity\Classificazione $classificazione
     * @return Protocollo
     */
    public function setClassificazione(\GL\ProtocolloBundle\Entity\Classificazione $classificazione = null) {
        $this->classificazione = $classificazione;
        return $this;
    }

    /**
     * Get classificazione
     *
     * @return GL\ProtocolloBundle\Entity\Classificazione
     */
    public function getClassificazione() {
        return $this->classificazione;
    }

    /**
     * Set fascicolo
     *
     * @param GL\ProtocolloBundle\Entity\Fascicolo $fascicolo
     * @return Protocollo
     */
    public function setFascicolo(\GL\ProtocolloBundle\Entity\Fascicolo $fascicolo = null) {
        $this->fascicolo = $fascicolo;
        return $this;
    }

    /**
     * Get fascicolo
     *
     * @return GL\ProtocolloBundle\Entity\Fascicolo
     */
    public function getFascicolo() {
        return $this->fascicolo;
    }

}