<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    /**
     * Test registration endpoint
     */
    public function testRegister()
    {
        $email = "test" . time() . "@sample.com";
        $password = "samplepassword";
        $name = "Test User";

        $response = $this->post('/api/auth/register',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);
        $response->assertStatus(200);

        $response = $this->post('/api/auth/register',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);
        $output = json_decode($response->getContent());
        $this->assertEquals('The email has already been taken.', $output->error->email[0]);
        $response->assertStatus(302);
    }

    /**
     * Test login and logout endpoints
     */
    public function testRegisterAndLogin()
    {
        $email = "testreglogin" . time() . "@sample.com";
        $password = "samplepassword";
        $name = "Test User";

        $response = $this->post('/api/auth/register',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);
        $response->assertStatus(200);

        $response = $this->post('/api/auth/login',
            [
                'email' => $email,
                'password' => $password,
            ]);
        $response->assertStatus(200);
        $output = json_decode($response->getContent());
        $token = $output->token;
        $this->assertNotEmpty($token, 'Token was empty');
        $this->assertIsObject($output->data);
        $this->assertEquals($name, $output->data->name);
        $this->assertEquals($email, $output->data->email);

        $response = $this->post('/api/auth/logout', [], ['Authorization' => "Bearer $token"]);
        $output = json_decode($response->getContent());
        $this->assertEquals("Successfully logged out", $output->message);
    }
}
