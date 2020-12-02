<?php

namespace Tests\Feature;

use App\Models\Tuto;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TutoTest extends TestCase
{

	use DatabaseTransactions;

	// /** @test */
	// public function it_shows_propositions(){

	// 	$response = $this->get('/admin/tuto/propositions');

	// 	$response->assertStatus(200);

	// }
   /** @test */
   public function it_should_validate_update_tuto_with_parts(){

      $tuto = factory(\App\Models\Tuto::class)->create();

      $parts = factory(\App\Models\TutoPart::class)->create([
         'tuto_id' => $tuto->id,
         'part_number' => 2,
         'youtube_id' => 'kljatlzerkjt'
      ]);

      $data = $this->getData();

      $validator = Validator::make($data, [
            'tuto.title' => 'required',
            'tuto.youtube_id' => 'required|uniqueInTutoAndTutoPart:'.$tuto->id,
            'parts.*.youtube_id' => 'bail|required|youtube_link|distinct|uniqueInTutoAndTutoPart:'.$tuto->id,
            'parts.*.title' => 'required',
            'parts.*.duration' => 'required'
      ]);

      $this->assertTrue($validator->passes());

   }

   /** @test */
   public function it_should_fails_validation_cuz_youtube_id_already_exists(){

      $tuto = factory(\App\Models\Tuto::class)->create(['youtube_id' => "Moz--Sc-g7o"]);

      $data = $this->getData();

      $validator = Validator::make($data, [
            'tuto.title' => 'required',
            'tuto.youtube_id' => 'required|uniqueInTutoAndTutoPart',
            'parts.*.youtube_id' => 'bail|required|youtube_link|distinct|uniqueInTutoAndTutoPart',
            'parts.*.title' => 'required',
            'parts.*.duration' => 'required'
      ]);

      $this->assertTrue($validator->fails());

   }

   /** @test */
   public function it_should_fails_validation_cuz_parts_id_already_exists(){      

      $tuto = factory(\App\Models\Tuto::class)->create(['youtube_id' => "Moz--Sc-g7o"]);

      $existingPart = factory(\App\Models\TutoPart::class)->create([
         'tuto_id' => $tuto->id,
         'part_number' => 2,
         'youtube_id' => 'BF12mRFeyL4'
      ]);

      $data = $this->getData();

      $validator = Validator::make($data, [
            'tuto.title' => 'required',
            'tuto.youtube_id' => 'required|uniqueInTutoAndTutoPart',
            'parts.*.youtube_id' => 'bail|required|youtube_link|distinct|uniqueInTutoAndTutoPart',
            'parts.*.title' => 'required',
            'parts.*.duration' => 'required'
      ]);

      $this->assertTrue($validator->fails());
   }

   /** @test */
   public function it_should_fails_cuz_parts_have_same_youtube_id(){

      // $data = $this->getData();

      // $validator = Validator::make($data, [
      //       'tuto.title' => 'required',
      //       'tuto.youtube_id' => 'required|uniqueInTutoAndTutoPart',
      //       'parts.*.youtube_id' => 'bail|required|youtube_link|distinct|uniqueInTutoAndTutoPart',
      //       'parts.*.title' => 'required',
      //       'parts.*.duration' => 'required'
      // ]);

      // $this->assertTrue($validator->fails());

   }
   
   private function getData(){
         return [
            "tuto" => [
               "id" => 3,
               "title" => "[Vue.js + Firebase] Slack Clone Tutorial - 1 - Presentation",
               "slug" => "vuejs-firebase-slack-clone-tutorial-1-presentation",
               "youtube_id" => "https://www.youtube.com/watch?v=azeqsdzezea",
               "langue_id" => 1,
               "is_valid" => 0,
               "channel_name" => "Tuto::Code",
               "description" => "Description",
               "duration" => "02:47",
               "categories" => "Vuejs, Javascript, Firebase"
            ],
         "parts" => [
            0 => [
               "title" => "[Vue.js + Firebase] Slack Clone Tutorial - 2 - Preparation",
               "youtube_id" => "https://www.youtube.com/watch?v=BF12ezzyL4a&index=2&list=PLEubh3Rmu4tn8R8rCZi5qeUX1fSLS_VJf",
               "duration" => "08:30"
            ],
            1 => [
               "title" => "machin",
               "youtube_id" => "https://www.youtube.com/watch?v=BF78mRFeyL4&index=2&list=PLEubh3Rmu4tn8R8rCZi5qeUX1fSLS_VJf",
               "duration" => "05:06"
            ]
         ]
      ];
   }

}
