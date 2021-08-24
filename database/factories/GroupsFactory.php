<?php

namespace Database\Factories;

use App\Models\Groups;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Groups::class;

    /**
     * @var array
     */
    protected $group_setup = [
        'name' => 'Admin',
        'name' => 'Human Resources',
        'name' => 'Developers',
        'name' => 'SEO',
        'name' => 'Contributors',
        'name' => 'FrontEnd'

    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        foreach($this->group_setup as $group){
            return [
                'name' => $group
            ];
        }
     
    }
}
