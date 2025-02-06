<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $service = new Service();
        $service->name = 'Vista a la playa';
        $service->type_id = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Vista al mar';
        $service->type_id = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Vista a la montaña';
        $service->type_id = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Vista a la ciudad';
        $service->type_id = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Vista al jardin';
        $service->type_id = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Vista al patio';
        $service->type_id = 1;
        $service->save();

        
        $service = new Service();
        $service->name = 'Acondicionador';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Agua caliente';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Bañera';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Bidé';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Gel para baño';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Jabón corporal';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Productos de limpieza';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Regadera Exterior';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Secadora de pelo';
        $service->type_id = 2;
        $service->save();

        $service = new Service();
        $service->name = 'Shampoo';
        $service->type_id = 2;
        $service->save();



        $service = new Service();
        $service->name = 'Almohadas y cobijas adicionales';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Caja fuerte';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Elementos básicos';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Espacio para guardar ropa';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Ganchos';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Lavadora';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Mosquitero';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Persianas o cortinas opacas';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Plancha';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Ropa de cama';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Secadora';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Tendedero para ropa';
        $service->type_id = 3;

        $service = new Service();
        $service->name = 'Boliche';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Cine';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Conexion ethernet';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Consola de juegos';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Equipo para hacer ejercicio';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Jaula de bateo';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Juegos Arcade';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Juegos de tamaño real';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Libros y material de lectura';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Mesa de billar';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Mesa de ping pong';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'Libros y juguetes para niños';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Sistema de sonido';
        $service->type_id = 4;
        $service->save();

        $service = new Service();
        $service->name = 'TV';
        $service->type_id = 4;
        $service->save();


        $service = new Service();
        $service->name = 'Barrera de seguridad para bebes';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Bañera para bebes';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Bicicleta para niños';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Cuarto de juegos para niños';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Cuna';
        $service->type_id = 5;
        $service->save();

        $service = new Service();
        $service->name = 'Aire acondicionado';
        $service->type_id = 6;
        $service->save();

        $service = new Service();
        $service->name = 'Calefacción';
        $service->type_id = 6;
        $service->save();

        $service = new Service();
        $service->name = 'Chimenea interiór';
        $service->type_id = 6;
        $service->save();

        $service = new Service();
        $service->name = 'Ventilador de techo';
        $service->type_id = 6;
        $service->save();

        $service = new Service();
        $service->name = 'Ventiladores portables';
        $service->type_id = 6;
        $service->save();



        $service = new Service();
        $service->name = 'Botiquín';
        $service->type_id = 7;
        $service->save();

        $service = new Service();
        $service->name = 'Detector de humo';
        $service->type_id = 7;
        $service->save();

        $service = new Service();
        $service->name = 'Detector de monóxido de carbono';
        $service->type_id = 7;
        $service->save();

        $service = new Service();
        $service->name = 'Extintor de incendios';
        $service->type_id = 7;
        $service->save();


        $service = new Service();
        $service->name = 'Wifi';
        $service->type_id = 8;
        $service->save();

        $service = new Service();
        $service->name = 'Wifi móvil';
        $service->type_id = 8;
        $service->save();

        $service = new Service();
        $service->name = 'Area para trabajar';
        $service->type_id = 8;
        $service->save();

        $service = new Service();
        $service->name = 'Arrocera';
        $service->type_id = 9;
        $service->save();
        
        $service = new Service();
        $service->name = 'Articulos básicos de cocina';
        $service->type_id = 9;
        $service->save();
        
        $service = new Service();
        $service->name = 'Cafetera';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Café';
        $service->type_id = 9;
        $service->save();


        $service = new Service();
        $service->name = 'Cocina';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Cocineta';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Compactador de basura';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Congelador';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Copas de vino';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Estufa';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Horno';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Jarra electrica para agua caliente';
        $service->type_id = 9;
        $service->save();
        
        $service = new Service();
        $service->name = 'Lavavajillas';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Licuadora';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Mesa de comedor';
        $service->type_id = 9;
        $service->save();
        
        $service = new Service();
        $service->name = 'Microondas';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Mini refrigerador';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Panificadora';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Platos y cubiertos';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Refrigerador';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Sábana para hornear';
        $service->type_id = 9;
        $service->save();
        
        $service = new Service();
        $service->name = 'Tostadora';
        $service->type_id = 9;
        $service->save();


        $service = new Service();
        $service->name = 'Utensilios para hacer parrillada';
        $service->type_id = 9;
        $service->save();

        $service = new Service();
        $service->name = 'Acceso a la playa';
        $service->type_id = 10;
        $service->save();

        $service = new Service();
        $service->name = 'Acceso a complejo turistico';
        $service->type_id = 10;
        $service->save();

        $service = new Service();
        $service->name = 'Acceso a lago';
        $service->type_id = 10;
        $service->save();

        $service = new Service();
        $service->name = 'Acceso de entrada y salida a pistas';
        $service->type_id = 10;
        $service->save();

        $service = new Service();
        $service->name = 'Costa';
        $service->type_id = 10;
        $service->save();


        $service = new Service();
        $service->name = 'Artículos básicos para la playa';
        $service->type_id = 11;
        $service->save();

        $service = new Service();
        $service->name = 'Asador';
        $service->type_id = 11;
        $service->save();

        $service = new Service();
        $service->name = 'Atracadero para barcos';
        $service->type_id = 11;
        $service->save();

        $service = new Service();
        $service->name = 'Bicicletas';
        $service->type_id = 11;
        $service->save();

        $service = new Service();
        $service->name = 'Camastros';
        $service->type_id = 11;
        $service->save();

        $service = new Service();
        $service->name = 'Cocina exteriór';
        $service->type_id = 11;
        $service->save();
        
        $service = new Service();
        $service->name = 'Comedor al aire libre';
        $service->type_id = 11;
        $service->save();
        
        $service = new Service();
        $service->name = 'Alberca';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Alojamiento de un solo piso';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Ascensor';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Cargador para autos eléctricos';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Estacionamiento de pago en las instalaciones';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Estacionamiento de pago en la calle';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Estacionamiento gratuito en las instalaciones';
        $service->type_id = 12;
        $service->save();

        $service = new Service();
        $service->name = 'Estacionamiento gratuito en la calle';
        $service->type_id = 12;
        $service->save();


        $service = new Service();
        $service->name = 'Desayuno';
        $service->type_id = 13;
        $service->save();

        $service = new Service();
        $service->name = 'Se admiten mascotas';
        $service->type_id = 13;
        $service->save();

        $service = new Service();
        $service->name = 'Disponible para estancias largas';
        $service->type_id = 13;
        $service->save();

        $service = new Service();
        $service->name = 'Limpieza disponible durante la estancia';
        $service->type_id = 13;
        $service->save();

        $service = new Service();
        $service->name = 'Se permite dejar equipaje';
        $service->type_id = 13;
        $service->save();

        $service = new Service();
        $service->name = 'Cerradura inteligente';
        $service->type_id = 13;
        $service->save();
    }
}
