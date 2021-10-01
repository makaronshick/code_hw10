<?php

require_once '../vendor/autoload.php';
require_once '../config/eloquent.php';

//1. Создать 5 категорий (insert)
$categories = [];
for ($i = 1; $i <= 5; $i++) {
    $categories[] = [
        'title' => 'Category ' . $i,
        'slug' => 'category-' . $i,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
}

\Hillel\Models\Category::insert($categories);

//2. Изменить 1 категорию (update)
$category = \Hillel\Models\Category::inRandomOrder()->first();
$category->title = 'Category Updated';
$category->slug = 'category-updated';
$category->save();

//3. Удалить 1 категорию (delete)
\Hillel\Models\Category::inRandomOrder()->first()->delete();

//4. Создать 10 постов, прикрепив случайную категорию
$categories = \Hillel\Models\Category::all();

$posts = [];
for ($i = 1; $i <= 10; $i++) {
    $posts[] = [
        'title' => 'Post ' . $i,
        'slug' => 'post-' . $i,
        'body' => 'Post Body ' . $i,
        'category_id' => $categories->random()->id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
}

\Hillel\Models\Post::insert($posts);

//5. Обновить 1 пост, заменив поля + категорию
$post = \Hillel\Models\Post::inRandomOrder()->first();

$post->title = 'Post Updated';
$post->slug = 'post-updated';
$post->body = 'Post Body Updated';
$post->category_id = $categories->random()->id;
$post->save();

//6. Удалить пост
\Hillel\Models\Post::inRandomOrder()->first()->delete();

//7. Создать 10 тегов
$tags = [];
for ($i = 1; $i <= 10; $i++) {
    $tags[] = [
        'title' => 'Tag ' . $i,
        'slug' => 'tag-' . $i,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
}

\Hillel\Models\Tag::insert($tags);

//8. Каждому уже сохранённому посту прикрепить по 3 случайных тега
$tags = \Hillel\Models\Tag::all();

$posts = \Hillel\Models\Post::all();
foreach ($posts as $post) {
    $tagsId = $tags->pluck('id')->random(3);
    $post->tags()->sync($tagsId);
}
