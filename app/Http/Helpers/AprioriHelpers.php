<?php 
namespace App\Http\Helpers;

class AprioriHelpers
{
    public static function array_harian($getArray)
    {
        $getArray = [
            'Pemeriksaan, atau penggantian berikut: ' => [
                '1. Gear Reduksi Gandar' => [
                    '4.1.1 Pemeriksaan visual terhadap kebocoran' => [
                        'type' => ['trufalse', 'input'],
                        'column' => ['i1a1', 'i1a2'],
                    ],
                ],
                '2. Gandar' => [
                    '5.6.1 Pemeriksaan visual terhadap kotak gandar' => [
                        'type' => ['trufalse', 'input'],
                        'column' => ['i2a1', 'i2a2'],
                    ],
                ],
            ],
        ];
        return $getArray;
    }
}