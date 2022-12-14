<?php

/**
 * Created by PhpStorm.
 * @author Erofeev Artem <erofeevas@pik.ru>
 * @date 30.11.2022
 * @time 14:26
 */

declare(strict_types=1);

namespace Pik\Reindexer\Model;

use Pik\Reindexer\Client\ClientInterface;

abstract class Model implements ModelInterface
{
    protected string $source;

    public function __construct(private ClientInterface $connection)
    {
        $this->connection->setNamespaceName($this->source)->setNamespace();
    }

    /**
     * @inheritDoc
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->connection->deleteItem(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getConnection(): ClientInterface
    {
        return $this->connection;
    }

    /**
     * @inheritDoc
     */
    public function updateField(int $id, string $field, mixed $value): ClientInterface
    {
        $sql = "UPDATE $this->source SET $field = $value WHERE id = $id";

        return $this->connection->get($sql);
    }

    /**
     * @inheritDoc
     */
    public function reindex(array $data, bool $update = false): void
    {
        $data = $this->mapping($data);
        if (!$update) {
            $this->connection->saveItem($data);
        } else {
            $this->connection->updateItem($data);
        }
    }

    /**
     * @inheritDoc
     */
    public function mapping(array $data): array
    {
        if (empty($this->_mapping)) {
            return $data;
        }

        foreach ($data as $key => $value) {
            // если не задан мэппинг, то удаляем данные с таким ключем
            if (!isset($this->_mapping[$key])) {
                unset($data[$key]);
                continue;
            }

            // приводим тип данных, если задан тип (и значение это не значение по умолчанию)
            if (!empty($this->_mapping[$key][0]) && (!array_key_exists(
                        2,
                        $this->_mapping[$key]
                    ) || $value !== $this->_mapping[$key][2])) {
                $value = call_user_func($this->_mapping[$key][0], $value);
            }

            // преобразуем индекс, если задано преобразование
            if (isset($this->_mapping[$key][1])) {
                unset($data[$key]);
                $data[$this->_mapping[$key][1]] = $value;
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): mixed
    {
        return $this->connection->getById($id)->getItem();
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): mixed
    {
        $strIds = implode(',', $ids);
        $sql = "SELECT * FROM $this->source WHERE id IN ($strIds)";

        return $this->connection->get($sql)->getItems();
    }
}