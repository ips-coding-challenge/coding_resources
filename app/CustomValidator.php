<?php

namespace App;

use App\Models\Conference;
use App\Models\Tuto;
use App\Models\TutoPart;
use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    public function validateYoutubeLink($attribute, $value, $parameters){


        if(convertYoutubeLinkToId($value) === null){
            return false;
        }

        return true;
    }

    /**
     * Validate that youtube_id not already in table tuto_parts
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateUniqueInTutoAndTutoPart($attribute, $value, $parameters){

    	$youtubeId = convertYoutubeLinkToId($value);

    	if($youtubeId === null) return true;

       	//Get the tuto id to verify unicity against it
        if(isset($parameters[0])){
          $tutoId = $parameters[0];
          $tuto = Tuto::where('youtube_id', $youtubeId)->where('id', '<>', $tutoId)->first();
          $tutoPart = TutoPart::where("youtube_id", $youtubeId)->where('tuto_id', '<>', $tutoId)->first();
      }else{
          $tuto = Tuto::where('youtube_id', $youtubeId)->first();
          $tutoPart = TutoPart::where("youtube_id", $youtubeId)->first();
      }

      if($tuto || $tutoPart){
          return false;
      }

      return true;

  }

    /**
     * Check unicity of conferences with converted youtube_id
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateUniqueInConferences($attribute, $value, $parameters){

        $youtubeId = convertYoutubeLinkToId($value);

        // if($youtubeId === null) throw new \Exception('Fail to convert youtube url to youtube id');
        if($youtubeId === null) return true; // Do not throw exception ... Normally, it's not needed...

        if(isset($parameters[0])){
            $confId = $parameters[0];
            $conf = Conference::where('youtube_id', $youtubeId)->where('id', '<>', $confId)->first();
        }else{
            $conf = Conference::where('youtube_id', $youtubeId)->first();
        }

        if($conf) return false;

        return true;
    }


}