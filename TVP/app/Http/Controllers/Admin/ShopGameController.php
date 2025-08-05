<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopHist;
use Carbon\Carbon;

class ShopGameController extends Controller
{
    public function index()
    {
        // Obter os dados de `description`, `coin_amount`, e `time`
        $shopGameData = ShopHist::select('description', 'coin_amount', 'time')->get();
    
        // Converter `time` para data e agrupar por mês e ano
        $monthlyData = $shopGameData->groupBy(function($date) {
            return Carbon::parse($date->time)->format('F Y');
        });
    
        // Preparar os dados para a lista
        $listData = [];
        foreach ($monthlyData as $month => $data) {
            $monthTotal = 0;
            $monthItems = [];
            foreach ($data as $item) {
                if ($item->coin_amount < 0) {
                    $monthTotal += -$item->coin_amount;
                    $monthItems[] = [
                        'description' => $item->description,
                        'coin_amount' => -$item->coin_amount // Invertendo o sinal do coin_amount
                    ];
                }
            }
            $listData[] = [
                'month' => $month,
                'total' => $monthTotal,
                'items' => $monthItems
            ];
        }

        // Obter os anos disponíveis para o campo de seleção
        $availableYears = $shopGameData->groupBy(function($date) {
            return Carbon::parse($date->time)->format('Y');
        })->keys()->toArray();

        // Calcular o total de cada mês para o gráfico
        $monthlyTotals = $shopGameData->groupBy(function($date) {
            return Carbon::parse($date->time)->format('Y-m');
        })->map(function($group) {
            return $group->sum('coin_amount');
        });

        return view('admin.shop.index', compact('listData', 'availableYears', 'monthlyTotals'));
    }
}
