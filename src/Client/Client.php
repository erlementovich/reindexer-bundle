<?php

/**
 * @author    Erofeev Artem <artem.erof1@gmail.com>
 * @author    Molchanov Danila <danila.molchanovv@gmail.com>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\Client;

use Reindexer\Client\Api;
use Reindexer\Entities\Index;
use Reindexer\Services\Item;
use Reindexer\Services\Namespaces;
use Reindexer\Services\Query;

final class Client implements ClientInterface
{
    private Namespaces $namespace;

    private string $namespaceName;

    private mixed $result;

    private bool $isAssociative = false;

    public function __construct(
        private Api $api,
        private string $database,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaceName(): string
    {
        return $this->namespaceName;
    }

    /**
     * {@inheritDoc}
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespaceName(string $namespaceName): self
    {
        $this->namespaceName = $namespaceName;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespace(): self
    {
        $namespaceService = new Namespaces($this->api);
        $namespaceService->setDatabase($this->database);
        $this->namespace = $namespaceService;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace(): Namespaces
    {
        return $this->namespace;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteNamespace(): bool
    {
        $namespaceService = $this->getNamespace();
        $namespaces = $namespaceService->getList()->getDecodedResponseBody(true);

        if (empty($namespaces['items'])) {
            return false;
        }

        if (!in_array($this->namespaceName, array_column($namespaces['items'], 'name'))) {
            return false;
        }

        $namespaceService->drop($this->namespaceName);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function createNamespace(string $namespace, array $indexes): void
    {
        $this->getNamespace()->create($namespace, $indexes);
    }

    /**
     * {@inheritDoc}
     */
    public function createIndex(): Index
    {
        return new Index();
    }

    /**
     * {@inheritDoc}
     */
    public function checkItem(int $itemId): bool
    {
        $sql = "SELECT * FROM $this->namespaceName WHERE id = $itemId";

        $response = $this->query()->createByHttpGet($sql);
        $data = $response->getDecodedResponseBody(true);

        return !empty($data['items']);
    }

    /**
     * {@inheritDoc}
     */
    public function updateItem(array $data, string $updateFieldName = 'updatedAt'): bool
    {
        if (empty($data['id'])) {
            return false;
        }

        $item = $this->getById((int) $data['id'])->getItem();

        if (!$item) {
            return false;
        }

        $itemData = $this->arrayMergeRecursiveDistinct((array) $item, $data);

        $itemData[$updateFieldName] = (new \DateTime('now'))->format('Y-m-d H:i:s');

        $this->saveItem($itemData);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function saveItem(array $data): void
    {
        $item = new Item($this->api);
        $item->setDatabase($this->database);
        $item->setNamespace($this->namespaceName);

        $this->checkItem((int) $data['id']) ? $item->update($data) : $item->add($data);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteItem(array $data = []): void
    {
        $item = new Item($this->api);
        $item->setDatabase($this->database);
        $item->setNamespace($this->namespaceName);

        $item->delete($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query(): Query
    {
        $query = new Query($this->api);
        $query->setDatabase($this->database);

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $sql): self
    {
        $response = $this->query()->createByHttpGet($sql);

        if (empty($response)) {
            $this->result = null;

            return $this;
        }

        $data = $response->getDecodedResponseBody($this->isAssociative);
        $this->result = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getItem(): mixed
    {
        return $this->isAssociative ? $this->result['items'][0] ?? null : $this->result->items[0] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems(): mixed
    {
        return $this->isAssociative ? $this->result['items'] ?? null : $this->result->items ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalItems(): int
    {
        return $this->isAssociative ? $this->result['query_total_items'] ?? 0 : $this->result->query_total_items ?? 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id, string $query = ''): self
    {
        $sql = "SELECT * FROM $this->namespaceName WHERE id = $id $query";

        return $this->get($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function getByGuid(string $guid): self
    {
        $sql = "SELECT * FROM $this->namespaceName WHERE guid = $guid";

        return $this->get($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function arrayMergeRecursiveDistinct(array $array1, array $array2): array
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    /**
     * {@inheritDoc}
     */
    public function setIsAssociative(bool $isAssociative): self
    {
        $this->isAssociative = $isAssociative;

        return $this;
    }
}
