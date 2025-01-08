<?php

namespace App\Imports;

use App\Models\Links;
use Maatwebsite\Excel\Concerns\ToModel;

class LinksImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }


    public function model(array $row)
    {
        try {
            return new Links([
                'link' => $row['link'],
                'offer' => $row['offer'],
                'user_id' => $this->userId
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al insertar registro en Links:', [
                'error' => $e->getMessage(),
                'row' => $row,
            ]);
            throw $e;
        }
    }
}
