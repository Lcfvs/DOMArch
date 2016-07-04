<?php
namespace Indoctrinated;

use Doctrine\ORM\EntityRepository;

class Repository
    extends EntityRepository
{

    public function selectAll() : array
    {
        return $this->findBy([
            'archivedAt' => null
        ]);
    }

    public function selectBy(
        array $parameters
    )
    {
        $parameters['archivedAt'] = $parameters['archivedAt'] ?? null;

        return $this->findOneBy($parameters);
    }

    public function selectAllBy(
        array $parameters,
        array $order_by = null,
        int $limit = null,
        int $offset = null
    ) : array
    {
        $parameters['archivedAt'] = $parameters['archivedAt'] ?? null;

        return $this->findBy($parameters, $order_by, $limit, $offset);
    }

    public function count(
        array $parameters = []
    ) : int
    {
        $parameters['archivedAt'] = $parameters['archivedAt'] ?? null;

        return $this
            ->createQueryBuilder('counter')
            ->select('COUNT(counter)')
            ->from(static::getEntityName(), 'c')
            ->setParameters($parameters)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function one(
        int $id = null
    ) : Entity
    {
        if ($id) {
            $instance = $this->select([
                'id' => $id
            ]);
        }
        
        $entity_name = $this->getEntityName();

        return $instance ?? new $entity_name;
    }

    public function select(
        array $parameters
    )
    {
        $parameters['archivedAt'] = $parameters['archivedAt'] ?? null;

        return $this->findOneBy($parameters);
    }
}