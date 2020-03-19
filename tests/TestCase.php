<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() :void
    {
        parent::setUp();
        $this->createPassportClient();
        $this->withoutMiddleware(\App\Http\Middleware\Cors::class);
    }

    /**
     * Creates test User with the role
     *
     * @param null $role
     * @return mixed
     */
    public function createUser($role = null)
    {
        $user = factory(User::class)->create();

        return $user;
    }

    /**
     * Creates passport client
     *
     * @return ClientRepository
     */
    public function createPassportClient()
    {
        $clients = new ClientRepository();
        $clients->createPasswordGrantClient(
            null, 'test', 'http://localhost'
        );
        return $clients;
    }

    /**
     * Make authorized json
     *
     * @param $method
     * @param $uri
     * @param array $data
     * @param array $headers
     * @param $user
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function authorizedJson($method, $uri, array $data = [], array $headers = [], $user = null)
    {
        if (is_null($user)) {
            $user = $this->createUser();
        }

        Passport::actingAs(
            $user,
            [$uri]
        );

        return $this->json($method, $uri, $data, []);
    }
}
