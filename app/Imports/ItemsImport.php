<?php

namespace App\Imports;

use App\Merchant;
use Maatwebsite\Excel\Concerns\ToModel;


class ItemsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
		
    public function model(array $row)
    {	
		echo 'rkbhai<br><br>';
	$input2 = array(
					'name' =>'SWSRK',
					'slug' =>'swsrk',
					'updated_at' => date('Y-m-d H:i:s'),
				);
	echo Merchant::create($input2)->id;die;
	}	
}
