<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccountExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function getAllAccountIds(Request $request)
    {

        $data = $request->all();
        $action = $request->input('action');
        $days = $data['vipDays'];
        $currentTime = Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s'); 

        if ($action === 'deleteAll') {
            DB::table('vip_accumulated')->truncate();
            return response()->json(['message' => 'Todos os registros foram apagados']);

        }elseif($action == "estetic"){
            $accountIds = Account::pluck('id')->toArray();
            return response()->json($accountIds);

        }elseif($action == "accountId"){

            $accountId = $request->input('accountId');

            DB::table('vip_accumulated')->insert([
                'account_id' => $accountId,
                'days' => $days,
                'date' => $currentTime
            ]);

            return response()->json(['message' => "Vip adicionado a $accountId"]);

        }elseif($action == "newAccount"){

            $subAction = $request->input('subAction');

            if($subAction == 1){

                $jsonData = json_encode(['status' => 'active', 'vipDays' => $days]);

                DB::table('server_config')
                    ->where('config', 'vipDays')
                    ->update(['value' => $jsonData]);


                return response()->json(['message' => "Ligado $subAction"]);

            }else{

                $jsonData = json_encode(['status' => 'disabled', 'vipDays' => 0]);

                DB::table('server_config')
                    ->where('config', 'vipDays')
                    ->update(['value' => 0]);

                return response()->json(['message' => "Desligado $subAction"]);
            }

        }elseif($action == "init"){

            $value = DB::table('server_config')
            ->where('config', 'vipDays')
            ->value('value');

            return response()->json(['value' => $value]);
        }
        

        $accountIds = Account::pluck('id')->toArray();
        $dataToExport = collect(); // Cria uma coleção temporária para armazenar os dados a serem inseridos

        foreach ($accountIds as $accountId) {
            $dataToExport->push([
                'account_id' => $accountId,
                'days' => $days,
                'date' => $currentTime
            ]);

            DB::table('vip_accumulated')->insert([
                'account_id' => $accountId,
                'days' => $days,
                'date' => $currentTime
            ]);
        }

        $export = new AccountExport($dataToExport);
        $fileName = $currentTime . '.xlsx'; // Nome do arquivo
        $tempFilePath = $fileName; // Caminho completo do arquivo
        
        // Exportar o arquivo
        Excel::store($export, $tempFilePath);
        
        $sourcePath = "/var/www/ravenor.online/storage/app/$fileName"; // Caminho completo do arquivo de origem
        $destinationPath = "/var/www/ravenor.online/public/vipLog/$fileName"; // Caminho completo do arquivo de destino
        
        // Mover o arquivo para o novo local
        if (rename($sourcePath, $destinationPath)) {
            // Arquivo movido com sucesso para o novo local
            // Retornar o URL do arquivo movido
            return response()->json($fileName);
        } else {
            // Falha ao mover o arquivo
            // Trate o erro adequadamente
            return response()->json(['error' => 'Erro ao mover o arquivo Excel para o novo local']);
        }

    }
}
