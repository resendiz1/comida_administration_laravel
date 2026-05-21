<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Torta de milanesa', 'description' => 'Milanesa de res, lechuga, jitomate, aguacate y crema', 'price' => 55, 'image' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a7?w=400&h=300&fit=crop', 'category' => 'tortas'],
            ['name' => 'Torta de jamón', 'description' => 'Jamón de pierna, queso panela, lechuga y jitomate', 'price' => 45, 'image' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=400&h=300&fit=crop', 'category' => 'tortas'],
            ['name' => 'Torta de pastor', 'description' => 'Pastor, piña, cebolla, cilantro y salsa', 'price' => 60, 'image' => 'https://images.unsplash.com/photo-1552332386-f8dd00dc0f58?w=400&h=300&fit=crop', 'category' => 'tortas'],
            ['name' => 'Torta de pierna', 'description' => 'Pierna de cerdo adobada, guacamole y frijoles', 'price' => 50, 'image' => 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=400&h=300&fit=crop', 'category' => 'tortas'],
            ['name' => 'Huevos al gusto', 'description' => 'Huevos estrellados, revueltos o a la mexicana', 'price' => 45, 'image' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=400&h=300&fit=crop', 'category' => 'desayunos'],
            ['name' => 'Chilaquiles verdes', 'description' => 'Totopos bañados en salsa verde, crema y queso', 'price' => 65, 'image' => 'https://images.unsplash.com/photo-1534352956036-cd81e27dd615?w=400&h=300&fit=crop', 'category' => 'desayunos'],
            ['name' => 'Hot cakes', 'description' => 'Stack de 3 hot cakes con miel y mantequilla', 'price' => 55, 'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=300&fit=crop', 'category' => 'desayunos'],
            ['name' => 'Molletes', 'description' => 'Bolillo con frijoles, queso gratinado y pico de gallo', 'price' => 40, 'image' => 'https://images.unsplash.com/photo-1559742811-822f4580b12e?w=400&h=300&fit=crop', 'category' => 'desayunos'],
            ['name' => 'Comida corrida', 'description' => 'Guisado del día, arroz, frijoles y tortillas', 'price' => 75, 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop', 'category' => 'comida'],
            ['name' => 'Mole con pollo', 'description' => 'Pechuga de pollo bañada en mole poblano con arroz', 'price' => 85, 'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400&h=300&fit=crop', 'category' => 'comida'],
            ['name' => 'Bisteces a la mexicana', 'description' => 'Bisteces en salsa de jitomate, cebolla y chile', 'price' => 80, 'image' => 'https://images.unsplash.com/photo-1553163147-622ab57be1c7?w=400&h=300&fit=crop', 'category' => 'comida'],
            ['name' => 'Pechuga empanizada', 'description' => 'Pechuga empanizada con ensalada y papas', 'price' => 80, 'image' => 'https://images.unsplash.com/photo-1432139555190-58524dae6a55?w=400&h=300&fit=crop', 'category' => 'comida'],
            ['name' => 'Flan napolitano', 'description' => 'Flan cremoso con caramelo', 'price' => 35, 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop', 'category' => 'postres'],
            ['name' => 'Gelatina de mosaico', 'description' => 'Gelatina de leche con cuadros de colores', 'price' => 25, 'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400&h=300&fit=crop', 'category' => 'postres'],
            ['name' => 'Pastel de chocolate', 'description' => 'Rebanada de pastel de chocolate con chantillín', 'price' => 45, 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop', 'category' => 'postres'],
            ['name' => 'Arroz con leche', 'description' => 'Arroz con leche tradicional canela y pasas', 'price' => 30, 'image' => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&h=300&fit=crop', 'category' => 'postres'],
            ['name' => 'Quesadillas', 'description' => 'Quesadillas de harina con queso y tu guisado favorito', 'price' => 25, 'image' => 'https://images.unsplash.com/photo-1618040996337-56904b7850b9?w=400&h=300&fit=crop', 'category' => 'antojitos'],
            ['name' => 'Sopes', 'description' => 'Sopes de masa con frijoles, crema, queso y salsa', 'price' => 20, 'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400&h=300&fit=crop', 'category' => 'antojitos'],
            ['name' => 'Tacos de canasta', 'description' => 'Tacos de canasta surtidos (chicharrón, papa, frijoles)', 'price' => 15, 'image' => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=400&h=300&fit=crop', 'category' => 'antojitos'],
            ['name' => 'Elote preparado', 'description' => 'Elote desgranado con crema, queso, mayonesa y chile', 'price' => 35, 'image' => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=400&h=300&fit=crop', 'category' => 'antojitos'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
