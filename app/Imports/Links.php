<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class Links implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row){
            $email=User::where(["email"=>$row[2]])->first();
        
            Links::create([
                'link'=>'1',
                'offer'=>'1',
                'user_id'=>'1'
            ]);
        }
    }
}
