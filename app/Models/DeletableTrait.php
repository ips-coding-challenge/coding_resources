<?php


namespace App\Models;


use Illuminate\Support\Facades\DB;

trait DeletableTrait
{

    public function delete(){
        DB::beginTransaction();

        try{

            $this->categories()->detach();
            parent::delete();

        }catch(\Exception $e){
            DB::rollback();
        }

        DB::commit();
    }

}