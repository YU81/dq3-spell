<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class Spell extends Controller
{
    public function index()
    {
        list($colNames, $data) = $this->getSpellData();
        $colCount = count($colNames);
        $result   = [];
        foreach ($data as $datum) {
            $spell = [];
            for ($i = 0; $i < $colCount; ++$i) {
                $spell[$colNames[$i]] = $datum[$i];
            }
            $result[] = $spell;
        }

        return response()->json($result);
    }

    public function random()
    {
        list($colNames, $data) = $this->getSpellData();
        $selectedSpell = $data[array_rand($data)];

        return response()->json([
            $colNames[0] => $selectedSpell[0],
            $colNames[1] => $selectedSpell[1],
            $colNames[2] => $selectedSpell[2],
            $colNames[3] => $selectedSpell[3],
        ]);
    }

    private function getSpellData()
    {
        $dataPath = __DIR__ . '/../../../storage/textdata/dq3_spells.tsv';
        if (!file_exists($dataPath)) {
            return response()->json(['ResultMessage' => 'No Database.', 'ResultCode' => 'ng']);

        }
        $data1 = explode("\n", file_get_contents($dataPath));
        $data  = [];
        foreach ($data1 as $item) {
            $data[] = explode("\t", $item);
        }

        $colNames = [];
        foreach ($data[0] as $item) {
            $colNames[] = $item;
        }
        array_pop($data);

        return [$colNames, $data];
    }

    private function getSingleSpellData()
    {


    }
}