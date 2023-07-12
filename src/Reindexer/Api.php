<?php

/**
 * @author    Molchanov Danila <danila.molchanovv@gmail.com>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\Reindexer;

use GuzzleHttp\Exception\GuzzleException;
use Reindexer\Client\Api as BaseApi;
use Reindexer\Response;

final class Api extends BaseApi
{
    /**
     * @throws \Exception
     */
    public function request(string $method, string $uri, string $body = null, array $headers = []): Response
    {
        try {
            $response = $this->client->request($method, $this->host . $uri, [
                'json' => $body ? json_decode($body, true) : [],
                'headers' => $headers,
            ]);

            $apiResponse = (new Response())
                ->setResponse($response)
                ->setError($this->error);

            $this->logger?->logResponse($apiResponse);
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }

        return $apiResponse;
    }
}
