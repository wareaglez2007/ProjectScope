<?php

namespace Database\Factories;

use App\Models\RolesUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolesUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RolesUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = new User();
       // foreach($users->get() as $user){
            return [
                'roles_id' => 19, //subscribed user
                
            ];
       // }

    }
}
