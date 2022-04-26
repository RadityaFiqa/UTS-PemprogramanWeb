<?php

/**
 * Created By Raditya Firman Syaputra
 * https://github.com/RadityaFiqa/UTS-PemprogramanWeb
 * On 23/04/2022
 */


class AngsuranFlat
{
    public $totalPinjaman;
    public $uangMuka;
    public $jangkaWaktu;
    public $bunga;

    function __construct($totalPinjaman, $uangMuka, $tenor, $bunga)
    {
        $this->uangMuka = $uangMuka / 100 * $totalPinjaman;
        $this->totalPinjaman = $totalPinjaman - $this->uangMuka;
        $this->jangkaWaktu = $tenor * 12;
        $this->bunga = $bunga / 100;
    }

    public function angsuranPerbulan()
    {
        $angsuranPokok = $this->totalPinjaman / $this->jangkaWaktu;
        $angsuranBunga = $this->totalPinjaman * ($this->bunga * $this->jangkaWaktu / 12) / $this->jangkaWaktu;
        $angsuranTotal = $angsuranPokok + $angsuranBunga;

        return [
            'pokok' => $angsuranPokok,
            'bunga' => $angsuranBunga,
            'total' => $angsuranTotal
        ];
    }

    public function penghasilanMinimum()
    {
        $angsuran = $this->angsuranPerbulan();

        $tableData = [
            "untuk Angsuran 25 % dari penghasilan" => 0.25,
            "untuk Angsuran 30 % dari penghasilan" => 0.3,
            "untuk Angsuran 1/3 dari penghasilan" => 0.333,
            "untuk Angsuran 35 % dari penghasilan" => 0.35,
            "untuk Angsuran 40 % dari penghasilan" => 0.4,
        ];

        $result = [];

        foreach ($tableData as $key => $value) {
            array_push($result, [
                'key' => $key,
                'value' => $angsuran['total'] * (1 / $value)
            ]);
        }

        return $result;
    }

    public function detailAngsuran()
    {
        $data = [];
        $angsuran = $this->angsuranPerbulan();
        $sisaPinjaman = $this->totalPinjaman;

        for ($i = 0; $i <= $this->jangkaWaktu; $i++) {
            if ($i === 0) {
                $data[$i] = [
                    'bulan' => $i,
                    'pokok' => 0,
                    'bunga' => 0,
                    'total' => 0,
                    'sisa' => $sisaPinjaman
                ];
            } else {
                $sisaPinjaman -= $angsuran['pokok'];

                $data[$i] = [
                    'bulan' => $i,
                    'pokok' => $angsuran['pokok'],
                    'bunga' => $angsuran['bunga'],
                    'total' => $angsuran['total'],
                    'sisa' => $sisaPinjaman
                ];
            }
        }

        array_push($data, [
            'bulan' => "Total",
            'pokok' => $angsuran['pokok'] * $this->jangkaWaktu,
            'bunga' => $angsuran['bunga'] * $this->jangkaWaktu,
            'total' => $angsuran['total'] * $this->jangkaWaktu,
            'sisa' => 0
        ]);

        return $data;
    }
}
