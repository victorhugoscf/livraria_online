<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book; // Importe o Model Book
use Faker\Factory as Faker; // Importe a classe Faker

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ####
        # Cria registros fakes da entidade books
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 100; $i++) {
            $totalCopies = $faker->numberBetween(1, 20);
            $availableCopies = $faker->numberBetween(0, $totalCopies);

            Book::create([
                'isbn'             => $faker->unique()->isbn13(),
                'title'            => $faker->sentence(rand(3, 8)), 
                'author'           => $faker->name(), 
                'publisher'        => $faker->company(),
                'publication_year' => $faker->numberBetween(1900, 2024), 
                'edition'          => $faker->optional(0.5, '1ª Edição')->word() . ' Edição', 
                'genre'            => $faker->randomElement([ 
                    'Ficção Científica', 'Fantasia', 'Romance', 'Terror', 'Suspense',
                    'Aventura', 'Mistério', 'História', 'Biografia', 'Autoajuda',
                    'Programação', 'Educação', 'Culinária', 'Saúde', 'Viagem'
                ]),
                'language'         => $faker->randomElement(['Português', 'Inglês', 'Espanhol', 'Francês']),
                'pages'            => $faker->numberBetween(100, 1200), 
                'total_copies'     => $totalCopies, 
                'available_copies' => $availableCopies, 
                'is_active'        => $faker->boolean(90), 
                'created_at'       => $faker->dateTimeBetween('-2 years', 'now'), 
                'updated_at'       => $faker->dateTimeBetween('-1 year', 'now'), 
            ]);
        }
    }
}

