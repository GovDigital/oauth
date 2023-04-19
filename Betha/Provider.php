<?php

namespace GovDigital\OAuth\Betha;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'BETHA';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['contas-usuarios.suite', 'sistema_interno', 'user-accounts.suite', 'licenses.suite'];

    /**
     * {@inheritdoc}
     */
    protected $usesPKCE = true;

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://plataforma-oauth.betha.cloud/auth/oauth2/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://plataforma-oauth.betha.cloud/auth/oauth2/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://plataforma-usuarios.betha.cloud/usuarios/v0.1/api/usuarios/@me', [
            'query' => [
                'access_token' => $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'cpf' => $user['cpf'],
            'cellphone' => $user['cellPhone'],
            'birthday' => $user['birthDay'],
            'sex' => $user['sex'],
            'email' => $user['email'],
            'secondary_email' => $user['secondaryEmail'],
            'photo' => $user['photo'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}
