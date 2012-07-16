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
     * @var date $dataDocumento
     *
     * @ORM\Column(name="dataDocumento", type="date")
     */
    private $dataDocumento;

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
     * @var datetime $dataInserimento
     *
     * @ORM\Column(name="dataInserimento", type="datetime")
     */
    private $dataInserimento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile $allegato
     * @Assert\File(maxSize="10000000")
     */
    public $allegato;

    public function __construct() {
        $data = new \DateTime();
        $this->anno = $data->format('Y');
        $this->protocollo = 0;
        $this->dataDocumento = $data;
        $this->dataInserimento = $data;

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
     * Set dataDocumento
     *
     * @param date $DataDocumento
     * @return Protocollo
     */
    public function setDataDocumento($DataDocumento) {
        $this->dataDocumento = $DataDocumento;
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
     * @param datetime $dataInserimento
     * @return Protocollo
     */
    public function setDataInserimento($dataInserimento) {
        $this->dataInserimento = $dataInserimento;
        return $this;
    }

    /**
     * Get data inserimento
     *
     * @return datetime
     */
    public function getDataInserimento() {
        return $this->dataInserimento;
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

    /**
     * Set path
     *
     * @param string $path
     * @return Protocollo
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    public function getUploadRootDir() {
        return __DIR__ . '/../Resources/private/documenti/' . $this->anno . '/';
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->getFileName();
    }

    public function getFileName() {
        return $this->anno . '-' . $this->protocollo . '_' . $this->dataDocumento->format('d-m-Y') . '.' . $this->path;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->allegato) {
            $this->path = $this->allegato->guessExtension();
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

        if (!file_exists($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir());
        }
        // se si verifica un errore mentre il file viene spostato viene
        // lanciata automaticamente un'eccezione da move(). Questo eviterà
        // la memorizzazione dell'entità nella base dati in caso di errore
        $this->allegato->move($this->getUploadRootDir(), $this->getFileName());

        unset($this->file);
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

}