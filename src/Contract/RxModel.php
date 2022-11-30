<?php

/**
 * Created by PhpStorm.
 * @author Erofeev Artem <erofeevas@pik.ru>
 * @date 30.11.2022
 * @time 18:57
 */

declare(strict_types=1);

namespace Pik\Reindexer\Contract;

interface RxModel
{
    /**
     * Получение названия индекса
     *
     * @return string
     */
    public function getSource(): string;

    /**
     * Удаление записи по идентификатору
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Соединение с клиентом Rx
     *
     * @return RxClient
     */
    public function getConnection(): RxClient;

    /**
     * Обновление одного поля в документе
     *
     * @param int $id
     * @param string $field название поля
     * @param mixed $value значение
     *
     * @return RxClient
     */
    public function updateField(int $id, string $field, mixed $value): RxClient;

    /**
     * Переиднексация данных в rx
     *
     * @param array $data
     * @param bool $update
     *
     * @return void
     */
    public function reindex(array $data, bool $update = false): void;

    /**
     * Маппинг данных в поля Rx
     * формат массива $_mapping = [
     *      'индекс в массиве data' => [
     *          0 => функция приведения типа,
     *          1 => новый индекс для Rx,
     *          2 => значение по умолчанию
     *        ]
     *      ,...
     * ]
     *
     * @param array $data
     *
     * @return array
     */
    public function mapping(array $data): array;

    /**
     * Получение записи по уникальному идентификатору
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById(int $id): mixed;

    /**
     * Получение записей по уникальным идентификаторам
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function getByIds(array $ids): mixed;
}