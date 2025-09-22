<?php
use PHPUnit\Framework\TestCase;

require 'AuthService.php';

class AuthServiceTest extends TestCase {
    private AuthService $auth;

    // Set simulating database 
    protected function setUp(): void {
        $user1 = new User("bryan123","password123", "bryan123@test.com");
        $user2 = new User("bob12345","password123", "bob12345@test.com");
        $this->auth = new AuthService(users: [$user1, $user2]); // Fill the simulated database
    }

    // Login success
    // Data correspond to one of the user in the database
    public function testLoginSuccess() {
        $this->assertTrue($this->auth->login("bryan123","password123", "bryan123@test.com"));
    }

    // Wrong password trying to login
    public function testLoginWrongPassword() {
        $this->assertFalse($this->auth->login("bryan123","WrongPass", "bryan123@test.com"));
    }

    // Wrong Email trying to login
    public function testLoginUnknownEmail() {
        $this->assertFalse($this->auth->login("bryan123","password123", "wrong@test.com"));
    }

    public function testValidUsernameSucces(){
        $this->assertTrue($this->auth->validUsername(("bryan123")));
    }
    
    public function testValidUsernameFailure(){
        $this->assertFalse($this->auth->validUsername(("brya")));
        $this->assertFalse($this->auth->validUsername(("bryagruniungeirghrrh")));
    }

    // Register success
    // No username OR Email duplicata with the database
    public function testRegisterSuccess(){
        $this->assertTrue($this->auth->register("bryan987","password123", "bryan987@test.com"));
    }

    // Already used password trying to register
    public function testRegisterUsedUsername(){
        $this->assertTrue($this->auth->register("bryan123","password123", "bryan987@test.com"));
    }

    // Already used Email trying to register
    public function testRegisterUsedEmail(){
        $this->assertTrue($this->auth->register("bryan987","password123", "bryan123@test.com"));
    }
}

?>