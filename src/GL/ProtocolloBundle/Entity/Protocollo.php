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
     * @var integer $azienda
     *
     * @ORM\Column(name="azienda_id", type="integer")
     */
    private $azienda;

    /**
     * @var integer $anno
     *
     * @ORM\Column(name="anno", type="integer")
     */
    private $anno;

    /**
     * @var integer $protocollo
     *
     * @ORM\Column(name="protocollo", type="integer", nullable=true)
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
     * @var datetime $dataInserimento
     *
     * @ORM\Column(name="dataInserimento", type="datetime")
     */
    private $dataInserimento;

    /**
     * @var string $formato
     *
     * @ORM\Column(name="formato", type="string", length=25, nullable=true)
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
     * @var string $categora
     *
     * @ORM\Column(name="categoria", type="string", length=25, nullable=true)
     */
    private $categoria;

    /**
     * @var string $classificazione
     *
     * @ORM\Column(name="classificazione", type="string", length=25, nullable=true)
     */
    private $classificazione;

    /**
     * @var string $fascicolo
     *
     * @ORM\Column(name="fascicolo", type="string", length=25, nullable=true)
     */
    private $fascicolo;

    /**
     * @var integer $user_id
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(name="documentiFileName", type="string", length=255, nullable=true)
     */
    public $documentoFileName;

    /**
     * @ORM\Column(name="documentiCheckSum", type="string", length=255, nullable=true)
     */
    public $documentoCheckSum;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile $allegato
     * @Assert\File(maxSize="10000000")
     */
    public $allegato;

    public function __construct() {
        $data = new \DateTime();
        $this->azienda = 0;
        $this->anno = $data->format('Y');
        $this->protocollo = 0;
        $this->dataInserimento = $data;

        return $this;
    }

    public function __toString() {
        return sprintf('%s-%04s', $this->anno, $this->protocollo);
        ;
    }

    public function getUploadRootDir() {
        return sprintf('%s/../Resources/private/documenti/%s/$s/', __DIR__, $this->azienda, $this->anno);
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->documentoFileName;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->allegato) {
            $this->documentoCheckSum = md5_file($this->allegato->getRealPath());
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

        $this->documentoFileName = $this->__toString() . '.' . $this->allegato->getExtension();

        $this->allegato->move($this->getUploadRootDir(), $this->documentoFileName);

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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set azienda
     *
     * @param integer $azienda
     * @return Protocollo
     */
    public function setAzienda($azienda) {
        $this->azienda = $azienda;
        return $this;
    }

    /**
     * Get azienda
     *
     * @return integer
     */
    public function getAzienda() {
        return $this->azienda;
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
     * Set dataInserimento
     *
     * @param datetime $dataInserimento
     * @return Protocollo
     */
    public function setDataInserimento($dataInserimento) {
        $this->dataInserimento = $dataInserimento;
        return $this;
    }

    /**
     * Get dataInserimento
     *
     * @return datetime
     */
    public function getDataInserimento() {
        return $this->dataInserimento;
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
     * Set categoria
     *
     * @param string $categoria
     * @return Protocollo
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * Set classificazione
     *
     * @param string $classificazione
     * @return Protocollo
     */
    public function setClassificazione($classificazione) {
        $this->classificazione = $classificazione;
        return $this;
    }

    /**
     * Get classificazione
     *
     * @return string
     */
    public function getClassificazione() {
        return $this->classificazione;
    }

    /**
     * Set fascicolo
     *
     * @param string $fascicolo
     * @return Protocollo
     */
    public function setFascicolo($fascicolo) {
        $this->fascicolo = $fascicolo;
        return $this;
    }

    /**
     * Get fascicolo
     *
     * @return string
     */
    public function getFascicolo() {
        return $this->fascicolo;
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
     * Set documentoFileName
     *
     * @param string $documentoFileName
     * @return Protocollo
     */
    public function setDocumentoFileName($documentoFileName) {
        $this->documentoFileName = $documentoFileName;
        return $this;
    }

    /**
     * Get documentoFileName
     *
     * @return string
     */
    public function getDocumentoFileName() {
        return $this->documentoFileName;
    }

    /**
     * Set documentoCheckSum
     *
     * @param string $documentoCheckSum
     * @return Protocollo
     */
    public function setDocumentoCheckSum($documentoCheckSum) {
        $this->documentoCheckSum = $documentoCheckSum;
        return $this;
    }

    /**
     * Get documentoCheckSum
     *
     * @return string
     */
    public function getDocumentoCheckSum() {
        return $this->documentoCheckSum;
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
    public function setProtocolloSuccessivo(\GL\ProtocolloBundle\Entity\Protocollo $protocolloSuccessivo = null)
    {
        $this->protocolloSuccessivo = $protocolloSuccessivo;
        return $this;
    }

    /**
     * Get protocolloSuccessivo
     *
     * @return GL\ProtocolloBundle\Entity\Protocollo 
     */
    public function getProtocolloSuccessivo()
    {
        return $this->protocolloSuccessivo;
    }
}