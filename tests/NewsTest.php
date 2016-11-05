<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

class NewsTest extends TestCase
{
    protected $testUserEmail = 'rajesh@test.com';
    
    protected $testUserName = 'rajesh';
    
    protected $testUserPwd = 'Test@1234';
    
    protected $testNewsArr =   ['title'=>'unitTest Title',
                                'slug' =>'unittest-title',
                                'description'  =>  'unit test desc'
                                ];
    
     /**
     * User Register page test
     *
     * @return void
     */
    public function testVisitUserRegister()
    {
        printf("User Registration\n");
        $this->visit(route('login'))
             ->see('frmSignUp');
        //do some more test
        $this->see('firstname');
        $this->see('lastname');
        $this->see('email');
        $this->see('Register');
    }
    
    /* Test register form
     * @return void
     */
    public function testRegisterFormFields() {
        printf("Register form fields and submit \n");
        $this->visit(route('login'))
         ->type($this->testUserEmail, 'email')
         ->type($this->testUserName, 'firstname')
         ->type($this->testUserName, 'lastname')
         ->press('Register')
         ->seeInDatabase('users', ['email' => $this->testUserEmail]);

        $this->assertResponseOk(); 
    }
    
    /**
     * User Actiation page test
     *
     * @return void
     */
    public function testVisitUserActivation()
    {
        printf("User Activation and change password\n");
        
        $verificationCode = User::where('email', $this->testUserEmail)->first()->userEmailVerify->verification_code;
        
        $this->visit(route('activateuser', $verificationCode))
                ->see('frmPwd')
                ->type($this->testUserPwd, 'password')
                ->type($this->testUserPwd, 'cpassword')
                ->press('Change password');
    }
    
    /* Test Login form
     * @return void
     */
    public function testLoginFormSubmit() {
        printf("Login form fields and submit \n");
        $this->visit(route('login'))
            ->see('frmSignIn')
            ->type($this->testUserEmail, 'username')
            ->type($this->testUserPwd, 'password')
            ->press('Sign In')
            ->seePageIs(route("dashboard"));
        $this->assertResponseOk(); 
    }
    
    /* remove test user data from database
     */
    public function testCleanUser() {
        printf("\nRemove user by test\n");
        User::where('email', $this->testUserEmail)->delete();
    }  
     
}

