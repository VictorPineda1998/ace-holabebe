<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Paciente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtén todos los IDs de los usuarios existentes
        $userIds = User::where('tipo_usuario', 'Enfermeria consultorios')->pluck('id')->toArray();

        return [
            'nombre' => $this->faker->firstName,
            'apellido_P' => $this->faker->lastName,
            'apellido_M' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
            'fecha_nacimiento' => $this->faker->date,
            // 'edad' => $this->faker->numberBetween(0, 100),
            'lugar_procedencia' => $this->faker->city,
            // Selecciona aleatoriamente uno de los IDs de los usuarios existentes
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
