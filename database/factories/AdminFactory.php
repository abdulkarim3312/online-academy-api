<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_id' => 'admin123456',
            'name' => 'Super admin',
            'password' => bcrypt('admin123456#'),
            'email' => 'admin@academy.com',
            'situation' => 'approval',
            'rating' => 'system',
            'remember_token' => null,
        ];
    }
}
