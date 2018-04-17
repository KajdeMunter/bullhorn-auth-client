<?php

use PHPUnit\Framework\TestCase;
use jonathanraftery\Bullhorn\REST\Authentication\Client as Client;

final class ClientTest extends TestCase
{
    /**
     * @dataProvider validCredentialsProvider
     */
    function testCreatesSessionForValidCredentials(
        $clientId,
        $clientSecret,
        $username,
        $password
    ) {
        $client = new Client(
            $clientId,
            $clientSecret,
            $username,
            $password
        );
        $session = $client->createSession();
        $this->assertTrue(!empty($session->BhRestToken));
    }


    /**
     * @dataProvider invalidClientIdCredentialsProvider
     */
    function testThrowsExceptionOnInvalidClientId(
        $clientId,
        $clientSecret,
        $username,
        $password
    ) {
        $this->expectException(InvalidArgumentException::class);
        $client = new Client(
            $clientId,
            $clientSecret,
            $username,
            $password
        );
        $client->createSession();
    }

    /**
     * @dataProvider invalidUsernameCredentialsProvider
     */
    function testThrowsExceptionOnInvalidUsername(
        $clientId,
        $clientSecret,
        $username,
        $password
    ) {
        $this->expectException(InvalidArgumentException::class);
        $client = new Client(
            $clientId,
            $clientSecret,
            $username,
            $password
        );
        $client->createSession();
    }

    /**
     * @dataProvider invalidPasswordCredentialsProvider
     */
    function testThrowsExceptionOnInvalidPassword(
        $clientId,
        $clientSecret,
        $username,
        $password
    ) {
        $this->expectException(InvalidArgumentException::class);
        $client = new Client(
            $clientId,
            $clientSecret,
            $username,
            $password
        );
        $client->createSession();
    }

    function validCredentialsProvider()
    {
        $credentialsFileName = __DIR__.'/data/client-credentials.json';
        $credentialsFile = fopen($credentialsFileName, 'r');
        $credentialsJson = fread($credentialsFile, filesize($credentialsFileName));
        $credentials = json_decode($credentialsJson);
        return [
            'valid credentials' => [
                $credentials->clientId,
                $credentials->clientSecret,
                $credentials->username,
                $credentials->password
            ]
        ];
    }

    function invalidClientIdCredentialsProvider()
    {
        $credentialsFileName = __DIR__.'/data/client-credentials.json';
        $credentialsFile = fopen($credentialsFileName, 'r');
        $credentialsJson = fread($credentialsFile, filesize($credentialsFileName));
        $credentials = json_decode($credentialsJson);
        return [
            'invalid credentials (client ID)' => [
                'testing_invalid_client_id',
                $credentials->clientSecret,
                $credentials->username,
                $credentials->password
            ]
        ];
    }

    function invalidUsernameCredentialsProvider()
    {
        $credentialsFileName = __DIR__.'/data/client-credentials.json';
        $credentialsFile = fopen($credentialsFileName, 'r');
        $credentialsJson = fread($credentialsFile, filesize($credentialsFileName));
        $credentials = json_decode($credentialsJson);
        return [
            'invalid credentials (username)' => [
                $credentials->clientId,
                $credentials->clientSecret,
                'testing_invalid_username',
                $credentials->password
            ]
        ];
    }

    function invalidPasswordCredentialsProvider()
    {
        $credentialsFileName = __DIR__.'/data/client-credentials.json';
        $credentialsFile = fopen($credentialsFileName, 'r');
        $credentialsJson = fread($credentialsFile, filesize($credentialsFileName));
        $credentials = json_decode($credentialsJson);
        return [
            'invalid credentials (password)' => [
                $credentials->clientId,
                $credentials->clientSecret,
                $credentials->username,
                'testing_invalid_password'
            ]
        ];
    }
}
