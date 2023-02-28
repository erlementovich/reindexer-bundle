<?php

/**
 * @author    Erofeev Artem <erofeevas@pik.ru>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\Model;

use Pik\Bundle\ReindexerBundle\Client\ClientInterface;

interface ModelInterface
{
    /**
     * Получение названия индекса.
     */
    public function getSource(): string;

    /**
     * Удаление записи по идентификатору.
     */
    public function delete(int $id): void;

    /**
     * Соединение с клиентом Rx.
     */
    public function getConnection(): ClientInterface;

    /**
     * Обновление одного поля в документе.
     *
     * @param string $field название поля
     * @param mixed $value значение
     */
    public function updateField(int $id, string $field, mixed $value): ClientInterface;

    /**
     * Переиднексация данных в rx.
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
     * ].
     */
    public function mapping(array $data): array;

    /**
     * Получение записи по уникальному идентификатору.
     */
    public function getById(int $id): mixed;

    /**
     * Получение записей по уникальным идентификаторам
     */
    public function getByIds(array $ids): mixed;
}
