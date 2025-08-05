<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function parseVocationXML(): void
    {
        $vocationsXML = Storage::disk('local')->get('vocations.xml');
        $xmlObject = simplexml_load_string($vocationsXML);
        $convertXMLtoJSON = json_encode($xmlObject);
        $vocationsConvert = json_decode($convertXMLtoJSON, true);
        $vocationsList = new \stdClass;
        foreach ($vocationsConvert['vocation'] as $key => $vocation) {
            $vocationsList->vocation[$key] = $vocation['@attributes']['name'];
        }
        Storage::disk('local')->put('vocations.json', serialize($vocationsList));
    }
}
