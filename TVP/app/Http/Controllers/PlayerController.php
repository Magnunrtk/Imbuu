<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function showDuplicateAccounts()
    {
        // Consulta para obter account_id duplicados e contar ocorrências
        $duplicateAccounts = DB::table('players')
            ->select('account_id', DB::raw('count(*) as total'))
            ->groupBy('account_id')
            ->having('total', '>', 1)
            ->orderBy('total', 'desc')
            ->get();
    
        // Passa os dados para a view
        return view('admin.irregular.index', compact('duplicateAccounts'));
    }    

    public function searchDuplicateAccounts(Request $request)
    {
        // Captura o termo de busca da query string
        $search = $request->input('search');
    
        // Consulta para obter account_id duplicados e contar ocorrências
        $duplicateAccounts = DB::table('players')
            ->select('account_id', 'name')
            ->where('account_id', $search) // Filtra apenas o account_id igual ao termo de busca
            ->get();
    
        // Passa os dados para a view
        return view('admin.irregular.search', compact('duplicateAccounts', 'search'));
    }
}
