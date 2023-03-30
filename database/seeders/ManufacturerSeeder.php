<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->data();
        foreach($data as $item) {
            $m = Manufacturer::create($item);
            $m->save();
        }
    }

    public function data()
    {
        return [
            ['name'=>'Canon','email'=>'','phone'=>'','url1'=>'https://us.medical.canon','url2'=>'','description'=>''],
            ['name'=>'Stryker','email'=>'','phone'=>'','url1'=>'https://www.stryker.com/us','url2'=>'','description'=>''],
            ['name'=>'US Opthomalic','email'=>'','phone'=>'','url1'=>'https://usophthalmic.com','url2'=>'','description'=>''],
        ];
    }
}
