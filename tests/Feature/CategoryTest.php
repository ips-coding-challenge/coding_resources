<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Conference;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    
    use DatabaseTransactions;
    
    /** @test */
    public function it_insert_categories_to_conference(){

        $conf = factory(\App\Models\Conference::class)->create();

        $categories = "truc, machin";

        $conf->saveCategories($categories);

        $this->assertEquals(2, $conf->categories()->count());

    }


    /** @test */
    public function it_cant_insert_twice_the_same_tag_for_the_conference(){

        $conf = factory(\App\Models\Conference::class)->create();

        $categories = "Laravel, Android, Php";

        $conf->saveCategories($categories);

        $this->assertEquals(3, $conf->categories()->count());

    }

    /** @test */
    public function it_cant_delete_a_category_if_its_the_only_category_of_a_data(){

        //Not finished

        $category = factory(\App\Models\Category::class)->create();

        $conf = factory(\App\Models\Conference::class)->create();

        $conf->saveCategories($category->name);

        $this->assertEquals(1, $conf->categories()->count());


    }
}
