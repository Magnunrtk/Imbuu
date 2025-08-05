<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\WebHouses;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HousesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view('admin.houses.index');
    }

    public function create(Request $request)
    {
        $housesXML = $request->input('text');
        $xmlObject = simplexml_load_string($housesXML);
        $convertXMLtoJSON = json_encode($xmlObject);
        $housesXMLConvert = json_decode($convertXMLtoJSON, true);
        WebHouses::truncate();
        foreach ($housesXMLConvert['house'] as $key => $house) {
            $houseInDb = House::find($house['@attributes']['houseid']);
            if ($houseInDb) {
                $houseInDb->size = $house['@attributes']['size'];
                $houseInDb->rent = $house['@attributes']['rent'];
                $houseInDb->save();
            }
            WebHouses::create([
                'name' => $house['@attributes']['name'],
                'house_id' => (int) $house['@attributes']['houseid'],
                'entry_x' => (int) $house['@attributes']['entryx'],
                'entry_y' => (int) $house['@attributes']['entryy'],
                'entry_z' => (int) $house['@attributes']['entryz'],
                'rent' => (int) $house['@attributes']['rent'],
                'town_id' => (int) $house['@attributes']['townid'],
                'size' => (int) $house['@attributes']['size'],
            ]);
        }
        return redirect(route('admin.houses.index'))
            ->with(
                'success',
                'Houses has been installed.'
            );
    }
}
