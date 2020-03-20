<?php

namespace App\Auth;

use Firebase\JWT\JWT;
use Laravel\Socialite\Two\User;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class AdfsSocialiteDriver extends AbstractProvider implements ProviderInterface
{
    protected $scopes = ['openid', 'profile', 'email'];
    protected $scopeSeparator = ' ';

    private function getBaseUrl(): string
    {
        return env('ADFS_BASE_URL', 'https://fs.majava.org/adfs');
    }

    /**
     * @inheritDoc
     */
    protected function getAuthUrl($state)
    {
        $url = $this->getBaseUrl() . '/oauth2/authorize';
        return $this->buildAuthUrlFromBase($url, $state);
    }

    /**
     * @inheritDoc
     */
    protected function getTokenUrl()
    {
        return $this->getBaseUrl() . '/oauth2/token';
    }

    /**
     * @inheritDoc
     */
    protected function getUserByToken($token)
    {
        $key = file_get_contents(base_path('adfs-jwt-signing.cer'));
        $decoded = JWT::decode($token, $key, ['RS256']);
        return (array) $decoded;
    }

    /**
     * @inheritDoc
     */
    protected function mapUserToObject(array $user)
    {
        $map = [
            'email' => $user['upn'],
            'name' => $user['unique_name'],
        ];

        return (new User)->setRaw($map)->map($map);
    }

    protected function getTokenFields($code)
    {
        return array_merge(
            parent::getTokenFields($code),
            ['grant_type' => 'authorization_code']
        );
    }
}
