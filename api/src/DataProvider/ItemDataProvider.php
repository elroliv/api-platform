<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Plant;
use Doctrine\Persistence\ManagerRegistry;

abstract class ItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private iterable $itemExtensions;
    private ManagerRegistry $managerRegistry;
    private string $entityClassName;

    public function __construct(ManagerRegistry $managerRegistry, iterable $itemExtensions, string $entityClassName )
    {
        $this->managerRegistry = $managerRegistry;
        $this->itemExtensions = $itemExtensions;
        $this->entityClassName = $entityClassName;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $this->entityClassName === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?object
    {
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);
        $queryBuilder = $repository->createQueryBuilder(strtolower($this->entityClassName));
        $queryNameGenerator = new QueryNameGenerator();
        $identifiers = ['id' => $id];

        foreach ($this->itemExtensions as $extension) {
            $extension->applyToItem($queryBuilder, $queryNameGenerator, $resourceClass, $identifiers, $operationName, $context);
            if ($extension instanceof QueryResultItemExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context))                 {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
