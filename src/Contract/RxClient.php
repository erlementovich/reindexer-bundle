<?php

/**
 * Created by PhpStorm.
 * @author Erofeev Artem <erofeevas@pik.ru>
 * @date 30.11.2022
 * @time 12:48
 */

declare(strict_types=1);

namespace Pik\Reindexer\Contract;

use Reindexer\Entities\Index;
use Reindexer\Services\Namespaces;
use Reindexer\Services\Query;

interface RxClient
{
    /**
     * @return string
     */
    public function getNamespaceName(): string;

    /**
     * @param string $namespaceName
     *
     * @return RxClient
     */
    public function setNamespaceName(string $namespaceName): self;

    /**
     * @return RxClient
     */
    public function setNamespace(): self;

    /**
     * @return Namespaces
     */
    public function getNamespace(): Namespaces;

    /**
     * @return bool
     */
    public function deleteNamespace(): bool;

    /**
     * @param string $namespace
     * @param array $indexes
     *
     * @return void
     */
    public function createNamespace(string $namespace, array $indexes): void;

    /**
     * @return Index
     */
    public function createIndex(): Index;

    /**
     * @param int $itemId
     *
     * @return bool
     */
    public function checkItem(int $itemId): bool;

    /**
     * @param array $data
     * @param string $updateFieldName
     *
     * @return bool
     */
    public function updateItem(array $data, string $updateFieldName = 'updatedAt'): bool;

    /**
     * @param array $data
     *
     * @return void
     */
    public function saveItem(array $data): void;

    /**
     * @param array $data
     *
     * @return void
     */
    public function deleteItem(array $data = []): void;

    /**
     * @return Query
     */
    public function query(): Query;

    /**
     * @param $sql
     *
     * @return RxClient
     */
    public function get($sql): self;

    /**
     * @return mixed
     */
    public function getItem(): mixed;

    /**
     * @return mixed
     */
    public function getItems(): mixed;

    /**
     * @return int
     */
    public function getTotalItems(): int;

    /**
     * @param int $id
     * @param string $query
     *
     * @return RxClient
     */
    public function getById(int $id, string $query = ''): self;

    /**
     * @param string $guid
     *
     * @return RxClient
     */
    public function getByGuid(string $guid): self;

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    public function arrayMergeRecursiveDistinct(array $array1, array $array2): array;
}