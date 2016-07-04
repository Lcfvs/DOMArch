<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Translations
 *
 * @ORM\Table(name="Translations")
 * @ORM\Entity(repositoryClass="Repositories\Translations")
 */
class Translations extends \Lib\ORM\Entity
{
    /**
     * @var string
     *
     * @ORM\Column(name="format", type="text", length=65535, nullable=false)
     */
    protected $format;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isTranslated", type="boolean", nullable=true)
     */
    protected $isTranslated = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="en", type="text", length=65535, nullable=false)
     */
    protected $en;

    /**
     * @var string
     *
     * @ORM\Column(name="fr", type="text", length=65535, nullable=false)
     */
    protected $fr;

    /**
     * @var string
     *
     * @ORM\Column(name="nl", type="text", length=65535, nullable=false)
     */
    protected $nl;



    /**
     * Set format
     *
     * @param string $format
     *
     * @return Translations
     */
    public function setFormat(
        $format
    )
    {
        $this->format = $format;
    
        return $this;
    }

    /**
     * Init format
     *
     * @param string $format
     *
     * @return Translations
     */
    public function initFormat(
        $format
    )
    {
        if ($this->format !== null) {
            return $this;
        }
    
        if (is_callable($format)) {
            return $this->setFormat($format());
        }
    
        return $this->setFormat($format);
    }

    /**
     * Get format
     *
     * @param $format = null
     *
     * @return string
     */
    public function getFormat(
        $format = null
    )
    {
        if ($this->format !== null) {
            return $this->format;
        }
    
        if (is_callable($format)) {
            return $format();
        }
    
        return $format;
    }

    /**
     * Set isTranslated
     *
     * @param boolean $is_translated
     *
     * @return Translations
     */
    public function setIsTranslated(
        $is_translated
    )
    {
        $this->isTranslated = $is_translated;
    
        return $this;
    }

    /**
     * Init isTranslated
     *
     * @param boolean $is_translated
     *
     * @return Translations
     */
    public function initIsTranslated(
        $is_translated
    )
    {
        if ($this->isTranslated !== null) {
            return $this;
        }
    
        if (is_callable($is_translated)) {
            return $this->setIsTranslated($is_translated());
        }
    
        return $this->setIsTranslated($is_translated);
    }

    /**
     * Get isTranslated
     *
     * @param $is_translated = null
     *
     * @return boolean
     */
    public function getIsTranslated(
        $is_translated = null
    )
    {
        if ($this->isTranslated !== null) {
            return $this->isTranslated;
        }
    
        if (is_callable($is_translated)) {
            return $is_translated();
        }
    
        return $is_translated;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Translations
     */
    public function setEn(
        $en
    )
    {
        $this->en = $en;
    
        return $this;
    }

    /**
     * Init en
     *
     * @param string $en
     *
     * @return Translations
     */
    public function initEn(
        $en
    )
    {
        if ($this->en !== null) {
            return $this;
        }
    
        if (is_callable($en)) {
            return $this->setEn($en());
        }
    
        return $this->setEn($en);
    }

    /**
     * Get en
     *
     * @param $en = null
     *
     * @return string
     */
    public function getEn(
        $en = null
    )
    {
        if ($this->en !== null) {
            return $this->en;
        }
    
        if (is_callable($en)) {
            return $en();
        }
    
        return $en;
    }

    /**
     * Set fr
     *
     * @param string $fr
     *
     * @return Translations
     */
    public function setFr(
        $fr
    )
    {
        $this->fr = $fr;
    
        return $this;
    }

    /**
     * Init fr
     *
     * @param string $fr
     *
     * @return Translations
     */
    public function initFr(
        $fr
    )
    {
        if ($this->fr !== null) {
            return $this;
        }
    
        if (is_callable($fr)) {
            return $this->setFr($fr());
        }
    
        return $this->setFr($fr);
    }

    /**
     * Get fr
     *
     * @param $fr = null
     *
     * @return string
     */
    public function getFr(
        $fr = null
    )
    {
        if ($this->fr !== null) {
            return $this->fr;
        }
    
        if (is_callable($fr)) {
            return $fr();
        }
    
        return $fr;
    }

    /**
     * Set nl
     *
     * @param string $nl
     *
     * @return Translations
     */
    public function setNl(
        $nl
    )
    {
        $this->nl = $nl;
    
        return $this;
    }

    /**
     * Init nl
     *
     * @param string $nl
     *
     * @return Translations
     */
    public function initNl(
        $nl
    )
    {
        if ($this->nl !== null) {
            return $this;
        }
    
        if (is_callable($nl)) {
            return $this->setNl($nl());
        }
    
        return $this->setNl($nl);
    }

    /**
     * Get nl
     *
     * @param $nl = null
     *
     * @return string
     */
    public function getNl(
        $nl = null
    )
    {
        if ($this->nl !== null) {
            return $this->nl;
        }
    
        if (is_callable($nl)) {
            return $nl();
        }
    
        return $nl;
    }
}
