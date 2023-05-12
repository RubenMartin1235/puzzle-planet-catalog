<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\RoleSeeder;


class UserControllerTest extends TestCase
{
    //use DatabaseMigrations;
    use RefreshDatabase;

    protected $user;
    protected $useradm;

    public function setUp():void {
        parent::setUp();

        $name = 'PnaTESTER6666';
        $this->user = User::factory()->create([
            'name'=>$name,
            'email'=>'pnath123@puzzplan.com',
            'password'=>Hash::make('666666'),
        ]);

    }
    public function tearDown():void {
        parent::tearDown();
        $this->user->delete();
    }

    /**
     * A basic unit test example.
     */
    public function test_user_login_correct_credentials(): void
    {
        $response = $this->post('/api/login',[
            'email' => $this->user->email,
            'password' => '666666',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['status','msg','access_token']);
    }
    public function test_user_login_incorrect_email(): void
    {
        $response = $this->post('/api/login',[
            'email' => 'llololol@glol.col',
            'password' => '666666',
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            "status" => 0,
            "msg" => "User has not been registered yet.",
        ]);
    }
    public function test_user_login_incorrect_pass(): void
    {
        $response = $this->post('/api/login',[
            'email' => $this->user->email,
            'password' => '331',
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            "status" => 0,
            "msg" => "Incorrect data.",
        ]);
    }
    public function test_user_register_correct_credentials(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'newusertest1',
            'email' => 'nutest1@gfake.com',
            'password' => 'falsofalso123',
            'password_confirmation' => 'falsofalso123',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1,
            'msg' => 'Successfully signed up user!'
        ]);
    }
    public function test_user_register_bad_name(): void
    {
        $response = $this->post('/api/register',[
            'name' => '',
            'email' => 'nutest2@gfake.com',
            'password' => 'falsofalso124',
            'password_confirmation' => 'falsofalso124',
        ]);
        $response->assertStatus(302);
    }
    public function test_user_register_bad_email(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'newusertest3',
            'email' => 'nutest3.com',
            'password' => 'falsofalso124',
            'password_confirmation' => 'falsofalso124',
        ]);
        $response->assertStatus(302);
    }
    public function test_user_register_bad_password(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'newusertest4',
            'email' => 'nutest4.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertStatus(302);
    }
    public function test_user_register_unconfirmed_password(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'newusertest5',
            'email' => 'nutest5.com',
            'password' => 'falsofalso124',
        ]);
        $response->assertStatus(302);
    }

    public function test_user_profile(): void
    {
        $response = $this->actingAs($this->user)->get('/api/profile');
        $response->assertStatus(200);
        $response->assertJsonStructure(['status','msg','data']);
    }
    public function test_user_profile_update_valid_credentials(): void
    {
        $new_name = 'PnaTESTER4444';
        $response = $this->actingAs($this->user)->put('/api/profile/update',[
            'name' => $new_name,
            'password' => 'pna1235'
        ]);
        $this->assertTrue($this->user->name == $new_name);
        $response->assertStatus(200);
        $response->assertJsonStructure(['status','msg']);
    }
    public function test_user_profile_update_bad_name(): void
    {
        $new_name = '';
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $response = $this->actingAs($this->user)->put('/api/profile/update',[
            'name' => $new_name,
        ]);
        $this->assertFalse($this->user->name == $new_name);
        $response->assertJsonStructure(['status','msg']);
    }
    public function test_user_profile_update_bad_email(): void
    {
        $new_email = 'erwer@@@eq';
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $response = $this->actingAs($this->user)->put('/api/profile/update',[
            'email' => $new_email,
        ]);
        $this->assertFalse($this->user->email == $new_email);
        $response->assertJsonStructure(['status','msg']);
    }
    public function test_user_profile_update_bad_password(): void
    {
        $new_password = '';
        $response = $this->actingAs($this->user)->put('/api/profile/update',[
            'password' => $new_password,
        ]);
        $this->assertFalse(Hash::check($new_password, $this->user->password));
        $response->assertJsonStructure(['status','msg']);
    }

    public function test_user_profile_delete_correct(): void
    {
        $pass = '666666';
        $response = $this->actingAs($this->user)->delete('/api/profile/delete',[
            'password' => $pass,
        ]);
        $this->assertNull(User::find($this->user->id));
        $response->assertJsonStructure(['status','msg']);
    }

    public function test_user_show_valid_id(): void
    {
        $id = $this->user->id;
        $response = $this->actingAs($this->user)->get("/api/users/{$id}");
        $response->assertJsonStructure([
            'status','msg','data'
        ]);
    }
    public function test_user_show_invalid_id(): void
    {
        $id = -12;
        $response = $this->actingAs($this->user)->get("/api/users/{$id}");
        $response->assertJsonStructure([
            'status','msg'
        ]);
    }
    public function test_user_update_valid_credentials_as_admin(): void
    {
        $this->seed(RoleSeeder::class);
        $admrole = Role::where('name','admin')->first();
        $this->useradm = User::factory()->create([
            'name'=>'sometestadmin',
            'email'=>'sometest@admin.com',
            'password'=>Hash::make('666666'),
        ]);
        $this->useradm->roles()->attach($admrole);

        $id = $this->user->id;
        $response = $this->actingAs($this->useradm)->put("/api/users/{$id}",[
            'name' => 'NEWNAME',
            'email' => 'gethackedlol@fake.com',
            'password' => 'CANCAN1212',
        ]);
        //dd($response->getContent());
        $response->assertJsonStructure([
            'status','msg'
        ]);
    }



}
