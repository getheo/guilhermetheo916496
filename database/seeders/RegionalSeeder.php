<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Regional;
use Illuminate\Support\Facades\Log;

class RegionalSeeder extends Seeder
{
    public function run()
    {
        // URL da API externa
        $url = 'https://integrador-argus-api.geia.vip/v1/regionais';

        // Chamada HTTP GET usando Http Client do Laravel
        $response = Http::get($url);

        // Verifica se a requisição foi bem sucedida
        if ($response->successful()) {
            // Converte JSON para array
            $regionais = $response->json();

            // Caso a API retorne um array direto ou esteja no campo data, adapte conforme necessário
            foreach ($regionais as $item) {
                Regional::updateOrCreate(
                    ['id_externo' => $item['id']], // campo de chave única opcional
                    [
                        'nome' => $item['nome'] ?? null,
                        'codigo' => $item['codigo'] ?? null,
                        // adicione aqui os campos que você quer salvar
                    ]
                );
            }
        } else {
            Log::error("Erro ao buscar regionais: HTTP {$response->status()}");
        }
    }
}
