<?php

namespace Database\Factories;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class ApprovalFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Approval::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = [
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
        ];

        return [
            'created_by' => User::where('role','admin')->first()->id,
            'model_type' => 'App\Models\User',
            'data' => serialize($user),
            'action' => 'create',
        ];
    }
}
