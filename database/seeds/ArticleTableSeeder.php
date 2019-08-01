<?php
use App\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleTableSeeder extends Seeder
{

    public function run()
    {

        Article::create(array(
            'user_id' => 1,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid1 in kedisi',
            'slug' => Str::slug('Bu uid1 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 1,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid1 in kedisi2',
            'slug' => Str::slug('Bu uid1 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 2,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid2 in kedisi',
            'slug' => Str::slug('Bu uid2 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 2,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid2 in kedisi2',
            'slug' => Str::slug('Bu uid2 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 3,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid3 in kedisi',
            'slug' => Str::slug('Bu uid3 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 3,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid3 in kedisi2',
            'slug' => Str::slug('Bu uid3 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 4,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid4 in kedisi',
            'slug' => Str::slug('Bu uid4 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 4,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid4 in kedisi2',
            'slug' => Str::slug('Bu uid4 in kedisi', '-'),
        ));

        Article::create(array(
            'user_id' => 5,
            'image' => 'public/article-image/ZPMFj5HYDMqsZNoJs7Iknh6GZexWVMZrywMvPq19.jpeg',
            'content' => 'asdas dasfsdfad',
            'title' => 'Bu uid5 in kedisi',
            'slug' => Str::slug('Bu uid5 in kedisi', '-'),
        ));

    }

}
