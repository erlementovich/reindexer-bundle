<?php

/**
 * @author    Erofeev Artem <artem.erof1@gmail.com>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\Client;

use Reindexer\Entities\Index;
use Reindexer\Services\Namespaces;
use Reindexer\Services\Query;

interface ClientInterface
{
    public function getNamespaceName(): string;

    public function setNamespaceName(string $namespaceName): self;

    public function setNamespace(): self;

    public function getNamespace(): Namespaces;

    public function deleteNamespace(): bool;

    public function createNamespace(string $namespace, array $indexes): void;

    public function createIndex(): Index;

    public function checkItem(int $itemId): bool;

    public function updateItem(array $data, string $updateFieldName = 'updatedAt'): bool;

    public function saveItem(array $data): void;

    public function deleteItem(array $data = []): void;

    public function query(): Query;

    public function get(string $sql): self;

    public function getItem(): mixed;

    public function getItems(): mixed;

    public function getTotalItems(): int;

    public function getById(int $id, string $query = ''): self;

    public function getByGuid(string $guid): self;

    public function arrayMergeRecursiveDistinct(array $array1, array $array2): array;

    public function setIsAssociative(bool $isAssociative): self;
}
