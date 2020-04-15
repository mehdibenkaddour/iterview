<?php
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 6; $i++) { 
	    	Topic::create([
	            'label' => str_random(8),
	            'image' => 'default_image.png',
	        ]);
    	}
    }
}
