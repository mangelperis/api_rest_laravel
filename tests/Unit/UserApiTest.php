<?php

namespace Tests\Unit;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;


class UserApiTest extends TestCase
{
    protected int $userId = 1;

    public function testIndexUsersDataStructure()
    {
        $this->json('get', 'api/user/all')
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]
                ]
            );
    }

    public function testIndexUserDataStructure()
    {
        $this->json('get', sprintf('api/user/%b', $this->userId))
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            );
    }

    public function testCreatesUser()
    {
        $user = [
            'name' => 'UserName',
            'email'    => 'new-user@hotmail.com',
        ];
        $response = $this->call('POST', 'api/user/create', $user);
        $data = $this->parseJson($response);

        $this->assertEquals('User Created', $data[0]);
    }

    public function testCreateUserRequiresNameAndEmail()
    {
        $this->json('POST', 'api/user/create')
            ->assertJson([
                'Request not valid!'
            ]);
    }

    public function testCreatesUserErrorAlreadyExist()
    {
        $user = [
            'name' => 'UserNameFake',
            'email'    => 'fake-name-2@gmail.com',
        ];
        $response = $this->call('POST', 'api/user/create', $user);
        $data = $this->parseJson($response);

        $this->assertEquals('User already exists!', $data[0]);
    }

    public function testDeleteUser()
    {
        $response = $this->call('DELETE', sprintf('api/user/%b', $this->userId));
        $data = $this->parseJson($response);

        $this->assertEquals('User Deleted', $data[0]);
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }

    /**
     * @param $data
     * @return void
     */
    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }
}
