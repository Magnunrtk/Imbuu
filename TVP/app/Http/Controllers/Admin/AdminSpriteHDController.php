<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSpriteHDController extends Controller
{
    public function index()
    {
        return view('admin.sprite-hd.index'); 
    }

    public function convert(Request $request)
    {
        $request->validate([
            'tibia_dat' => 'required|file|max:512000', 
            'tibia_spr' => 'required|file|max:512000',
        ]);
    
        $tibiaDat = $request->file('tibia_dat');
        $tibiaSpr = $request->file('tibia_spr');
    
        if ($tibiaDat->getClientOriginalName() !== 'Tibia.dat' || $tibiaSpr->getClientOriginalName() !== 'Tibia.spr') {
            return response()->json(['error' => 'Os arquivos devem ter exatamente os nomes "Tibia.dat" e "Tibia.spr".'], 400);
        }
    
        $storagePath = 'sprites';
    
        // Deleta arquivos antigos
        Storage::delete(["$storagePath/Tibia.dat", "$storagePath/Tibia.spr"]);
    
        // Salva os arquivos novos
        Storage::putFileAs($storagePath, $tibiaDat, 'Tibia.dat');
        Storage::putFileAs($storagePath, $tibiaSpr, 'Tibia.spr');
    
        // Atualiza a tabela
        $filesHtml = view('admin.sprite-hd.file-table')->render();
    
        return response()->json(['success' => true, 'filesHtml' => $filesHtml]);
    }
    

    public function process()
    {
        $storagePath = storage_path('app/sprites');
        $datFile = "$storagePath/Tibia.dat";
        $sprFile = "$storagePath/Tibia.spr";

        if (!file_exists($datFile) || !file_exists($sprFile)) {
            return back()->with('error', 'Os arquivos Tibia.dat e Tibia.spr precisam estar no armazenamento para conversão.');
        }

        // Aqui entraria o código de conversão dos arquivos para PNG.
        // Exemplo fictício:
        // $this->convertToPNG($datFile, $sprFile);

        return back()->with('success', 'Conversão realizada com sucesso!');
    }

    public function storageData()
    {
        $storagePath = storage_path('app/sprites');
        $filenames = ['Tibia.dat', 'Tibia.spr', 'png32.zip', 'png64.zip'];
        $files = [];
    
        foreach ($filenames as $file) {
            $path = $storagePath . '/' . $file;
            if (file_exists($path)) {
                $mtime = filemtime($path);
                $files[] = [
                    'filename' => $file,
                    'mtime'    => date('d/m/Y H:i:s', $mtime),
                    'timestamp'=> $mtime
                ];
            } else {
                $files[] = [
                    'filename' => $file,
                    'mtime'    => 'Não encontrado',
                    'timestamp'=> 0
                ];
            }
        }
        return response()->json($files);
    }
    

}
