<?php
/**
 * @author : Lcf.vs
 * @link: https://github.com/Lcfvs
 */
namespace Indoctrinated;

use DateTime;
use stdClass;

use Doctrine\ORM\Mapping as ORM;
use Indoctrinated\Db;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass
 */
abstract class Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="archivedAt", type="datetime", nullable=true)
     */
    protected $archivedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCreatedAt(
        $created_at
    ) : self
    {
        $this->createdAt = $created_at;

        return $this;
    }

    public function initCreatedAt(
        $created_at
    ) : self
    {
        if ($this->createdAt !== null) {
            return $this;
        }

        if (is_callable($created_at)) {
            return $this->setCreatedAt($created_at());
        }

        return $this->setCreatedAt($created_at);
    }

    public function getCreatedAt(
        $created_at = null
    )
    {
        if ($this->createdAt !== null) {
            return $this->createdAt;
        }

        if (is_callable($created_at)) {
            return $created_at();
        }

        return $created_at;
    }

    public function setUpdatedAt(
        $updated_at
    ) : self
    {
        $this->updatedAt = $updated_at;

        return $this;
    }

    public function initUpdatedAt(
        $updated_at
    ) : self
    {
        if ($this->updatedAt !== null) {
            return $this;
        }

        if (is_callable($updated_at)) {
            return $this->setUpdatedAt($updated_at());
        }

        return $this->setUpdatedAt($updated_at);
    }

    public function getUpdatedAt(
        $updated_at = null
    )
    {
        if ($this->updatedAt !== null) {
            return $this->updatedAt;
        }

        if (is_callable($updated_at)) {
            return $updated_at();
        }

        return $updated_at;
    }

    public function setArchivedAt(
        $archived_at
    ) : self
    {
        $this->archivedAt = $archived_at;

        return $this;
    }

    public function initArchivedAt(
        $archived_at
    ) : self
    {
        if ($this->archivedAt !== null) {
            return $this;
        }

        if (is_callable($archived_at)) {
            return $this->setArchivedAt($archived_at());
        }

        return $this->setArchivedAt($archived_at);
    }

    public function getArchivedAt(
        $archived_at = null
    )
    {
        if ($this->archivedAt !== null) {
            return $this->archivedAt;
        }

        if (is_callable($archived_at)) {
            return $archived_at();
        }

        return $archived_at;
    }

    public static function getEntityName() : string
    {
        return Db::getEntityManager()
            ->getClassMetadata(static::class)
            ->getTableName();
    }

    public static function getEntityRepository() : Repository
    {
        return Db::getEntityManager()
            ->getRepository(static::class);
    }

    public static function fromArray(
        array $data
    ) : self
    {
        return static::fromObject((object) $data);
    }

    public static function fromObject(
        stdClass $object
    ) : self
    {
        $instance = static::getEntityRepository()
            ->one();

        foreach ($object as $property => $value) {
            $method_name = 'init' . ucfirst($property);
            $method = [$instance, $method_name];

            if (!is_callable($method, true)) {
                continue;
            }

            $instance->{$method_name}($value);
        }

        return $instance;
    }

    public static function create() : self
    {
        return new static();
    }

    public function save() : self
    {
        $entity_manager = Db::getEntityManager();
        $entity_manager->persist($this);
        $entity_manager->flush();

        return $this;
    }

    public function archive() : self
    {

        $time = Db::getTime() ?? new DateTime();

        return $this->setArchivedAt($time)
            ->save();
    }

    public function toArray() : array
    {
        return (array) $this->toObject();
    }

    public function toObject() : stdClass
    {
        $properties = Db::getEntityManager()
            ->getClassMetadata(static::getEntityName())
            ->getFieldNames();

        sort($properties);

        $std = new stdClass();

        foreach ($properties as $property) {
            $method_name = 'get' . ucfirst($property);
            $method = [$this, $method_name];

            if (!is_callable($method, true)) {
                continue;
            }

            $value = $this->{$method_name}();

            if ($value === null) {
                continue;
            }

            if (is_array($value)) {
                $values = [];

                foreach ($value as $entity) {
                    $values[] = $entity->toObject();
                }

                $std->{$property} = $values;

                continue;
            }

            if (gettype($value) === 'object' && $value instanceof DateTime) {
                $timestamp = $value->getTimestamp();
                $std->{$property} = gmdate('Y-m-d H:i:s', $timestamp);

                continue;
            }

            $std->{$property} = $value;
        }

        return $std;
    }

    public function toJSON(
        int $options = 0,
        int $depth = 512
    ) : string
    {
        return json_encode($this->toObject(), $options, $depth);
    }

    /** @ORM\PrePersist */
    public function onBeforePersist() : self
    {
        $time = Db::getTime() ?? new DateTime();

        return $this->initCreatedAt($time);
    }

    /** @ORM\PreUpdate */
    public function onBeforeUpdate() : self
    {
        if ($this->getArchivedAt()) {
            return $this;
        }

        $time = Db::getTime() ?? new DateTime();

        return $this->setUpdatedAt($time);
    }
}