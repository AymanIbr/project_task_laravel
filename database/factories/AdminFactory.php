<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>'ayman',
            'email'=>'ayman@gmail.com',
            'password'=>'$2y$10$XGPkQArY2HHByvmSSLf4BedJlnVERje/eR1x30VtcVG9K7.eRUjHG'  //password
        ];
    }
}
