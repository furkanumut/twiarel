<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UserTableSeeder extends Seeder
{

    public function run()
    {
        // Empty all previous records out
        DB::table('users')->delete();

        User::create(array(
            'avatar' => 'public/user-avatar/qJWBuoYlrjilruLspKMMC9T1ZXn1zaPdnePgHDdR.svg',
            'email' => 'foo@bar.com',
            'password' => bcrypt('password'),
            'username' => Str::slug('User One', '-'),
            'name' => 'User One',
            'birth_date' => '2001-08-02',
            'api_token' => hash('sha256', Str::random(60)),

        ));

        User::create(array(
            'avatar' => 'public/user-avatar/qJWBuoYlrjilruLspKMMC9T1ZXn1zaPdnePgHDdR.svg',
            'email' => 'foo2@bar.com',
            'password' => bcrypt('password'),
            'username' => Str::slug('User Two', '-'),
            'name' => 'User Two',
            'birth_date' => '2001-08-02',
            'api_token' => hash('sha256', Str::random(60)),

        ));

        User::create(array(
            'avatar' => 'public/user-avatar/qJWBuoYlrjilruLspKMMC9T1ZXn1zaPdnePgHDdR.svg',
            'email' => 'foo3@bar.com',
            'password' => bcrypt('password'),
            'username' => Str::slug('User Three', '-'),
            'name' => 'User Three',
            'birth_date' => '2001-08-02',
            'api_token' => hash('sha256', Str::random(60)),

        ));

        User::create(array(
            'avatar' => 'public/user-avatar/qJWBuoYlrjilruLspKMMC9T1ZXn1zaPdnePgHDdR.svg',
            'email' => 'foo4@bar.com',
            'password' => bcrypt('password'),
            'username' => Str::slug('User Four', '-'),
            'name' => 'User Four',
            'birth_date' => '2001-08-02',
            'api_token' => hash('sha256', Str::random(60)),

        ));

        User::create(array(
            'avatar' => 'public/user-avatar/qJWBuoYlrjilruLspKMMC9T1ZXn1zaPdnePgHDdR.svg',
            'email' => 'facfur33@gmail.com',
            'password' => bcrypt('asdasdasd'),
            'username' => Str::slug('Furkan Umut', '-'),
            'name' => 'Furkan Umut',
            'birth_date' => '2001-08-02',
            'api_token' => hash('sha256', Str::random(60)),

        ));
    }

}
