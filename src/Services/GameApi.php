<?php


namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;

class GameApi
{
    private const ENV_USER_KEY = 'IGDB_USER_KEY';
    private const ENV_URL_REQUEST = 'IGDB_REQUEST_URL';

    public function getGenres()
    {
        $body = $this->buildBody(['name']);
        return $this->get('genres', $body);
    }

    private function buildBody($fields = ['*'], $limit = 500, $where = null)
    {
        $bodyQuery = $this->buildBodyQuery('fields', implode(',', $fields));
        $bodyQuery .= $this->buildBodyQuery('limit', $limit);
        if (null !== $where) {
            $bodyQuery .= $this->buildBodyQuery('where ', $where);
        }

        return $bodyQuery;
    }

    private function buildBodyQuery(string $type, string $value)
    {
        return sprintf('%s %s;', $type, $value);
    }

    private function get(string $endpoint, $body = null)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $this->buildUrl($endpoint), $this->getOptions($body));

        if ($response->getStatusCode()) {
            return json_decode($response->getContent());
        }

        return false;
    }

    private function buildUrl($endpoint)
    {
        return $_ENV[self::ENV_URL_REQUEST] . '/' . $endpoint;
    }

    private function getOptions($body = null)
    {
        $body = $body ?? $this->buildBody(); // default body if null
        return [
            'headers' => [
                "user-key" => $_ENV[self::ENV_USER_KEY],
                'Accept' => 'application/json',
            ],
            'body' => $body
        ];
    }

    public function getGames()
    {
        $body = $this->buildBody(['name', 'summary', 'genres', 'cover']);
        return $this->get('games', $body);
    }

    public function getCover($id)
    {
        $body = $this->buildBody(['url'], 1, "id = {$id}");
        return $this->get('covers', $body);
    }
}