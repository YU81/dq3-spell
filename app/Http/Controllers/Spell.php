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
                if (!isset($datum[$i])) {
                    continue;
                }
                if (preg_match('/Lv\./', $datum[$i]) === 0) {
                    $spell[$colNames[$i]] = $datum[$i];
                } else {
                    $retainInfoList = explode(',', $datum[$i]);
                    foreach ($retainInfoList as $retainInfo) {
                        $eachJobSpell           = $this->getEachJobSpell($retainInfo);
                        $spell[$colNames[$i]][] = $eachJobSpell;
                    }

                }
            }
            $result[] = $spell;
        }

        return response()->json($result);
    }

    public function random()
    {
        list($colNames, $data) = $this->getSpellData();
        $selectedSpell = $data[array_rand($data)];

        $retainInfoList = explode(',', $selectedSpell[2]);
        $spell          = [];
        foreach ($retainInfoList as $retainInfo) {
            $eachJobSpell          = $this->getEachJobSpell($retainInfo);
            $spell[$colNames[2]][] = $eachJobSpell;
        }

        return response()->json([
            $colNames[0] => $selectedSpell[0],
            $colNames[1] => $selectedSpell[1],
            $colNames[2] => $spell['retain_info'],
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
        unset($data[0]);
        $data = array_values($data);

        return [$colNames, $data];
    }

    private function getSingleSpellData()
    {


    }

    /**
     * @param array $retainInfo
     * @return array
     */
    private function getEachJobSpell($retainInfo)
    {
        $eachJobSpell = [];
        $job          = mb_substr($retainInfo, 0, 1);
        preg_match_all('/\.[0-9]+/', $retainInfo, $dotLv);
        $lv                  = (int)mb_substr($dotLv[0][0], 1, mb_strlen($dotLv[0][0]));
        $eachJobSpell['job'] = $job;
        $eachJobSpell['lv']  = $lv;

        return $eachJobSpell;
    }
}