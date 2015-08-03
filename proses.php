<?php
ini_set('max_execution_time', 30000);

class Individu {
    public static $ukuranKromosom = 0;
    public $gen = array();
    public $fitnes = 0;

    public function __construct () {
        $tempKemungkinan = Sudoku::$kemungkinanRandom;
        foreach ($tempKemungkinan as $i=>$value) {
            $index = 0;
            foreach ($tempKemungkinan[$i] as $j=>$value) {
                $ran = array_rand($tempKemungkinan[$i]);
                $this->gen[$i][$index] = $tempKemungkinan[$i][$ran];
                unset($tempKemungkinan[$i][$ran]);
                $index++;
            }
        }
    }

    public function getGen ($i, $j) {
        return $this->gen[$i][$j];
    }

    public function random ($array, $i) {
        for ($j=0; $j<count($array); $j++) {
            Sudoku::$kemungkinanRandom[$i][$j]=$array[$j];
        }
    }

}

class Sudoku {
    public static $kemungkinanRandom;
    public static $matrik = array();

    public static function jumlahCellKosong () {
        $total = 0;
        for ($i=0; $i<9; $i++) {
            for ($j=0; $j<9; $j++) {
                if (empty($_POST['cell_'.$i.'_'.$j])) {
                    $total++;
                }
            }
        }

        return $total;
    }

    public static function setMatrik () {
        for ($i=0; $i<9; $i++) {
            for ($j=0; $j<9; $j++) {
                Sudoku::$matrik[$i][$j] = $_POST['cell_'.$i.'_'.$j];
            }
        }
    }

    public static function setKemungkinanRandom () {
        for ($i=0; $i<9; $i++) {
            $angka = array(0,1,2,3,4,5,6,7,8,9);
            for ($j=0; $j<9; $j++) {
                $key = array_search(Sudoku::$matrik[$i][$j], $angka);
                unset($angka[$key]);
            }
            Sudoku::$kemungkinanRandom[$i] = $angka;
        }
    }
}

class Populasi {
    public static $ukuranPopulasi = 100;
    public $individu = array();

    public function __construct () {
        for ($i=0; $i<Populasi::$ukuranPopulasi; $i++) {
            $individu = new Individu;
            $this->individu[$i] = $individu;
        }
    }

}

class Fitnes {
    public static $tempMatrik;

    public static function setAngka ($individu) {
        Fitnes::$tempMatrik = Sudoku::$matrik;

        for ($i=0; $i<9; $i++) {
            $index = 0;
            for ($j=0; $j<9; $j++) {
                if (empty(Fitnes::$tempMatrik[$i][$j])) {
                    Fitnes::$tempMatrik[$i][$j] = $individu->getGen($i, $index);
                    $index++;
                }
            }
        }
    }

    public static function hitungFitnes ($individu) {
        Fitnes::setAngka($individu);

        $fitbaris = 0;
        //Baris
        for ($i=0; $i<9; $i++) {
            $count = array_count_values(Fitnes::$tempMatrik[$i]);
            if (count($count)>0) {
                foreach ($count as $key=>$value) {
                    if ($count[$key]>1) {
                        $fitbaris = $fitbaris + $count[$key];
                    }
                }
            }
        }

        Fitnes::$tempMatrik = Fitnes::tranpose();

        //Kolom
        $fitkolom = 0;
        for ($i=0; $i<9; $i++) {
            $count = array_count_values(Fitnes::$tempMatrik[$i]);
            foreach ($count as $key=>$value) {
                if ($count[$key]>1) {
                    $fitkolom = $fitkolom + $count[$key];
                }
            }
        }

        //Area
        $fitarea = 0;
        $area = Fitnes::setArea();
        for ($i=0; $i<9; $i++) {
            $count = array_count_values($area[$i]);
            foreach ($count as $key=>$value) {
                if ($count[$key]>1) {
                    $fitarea = $fitarea + $count[$key];
                }
            }
        }

        return Individu::$ukuranKromosom - ($fitbaris+$fitkolom+$fitarea);

    }

    public static function setArea () {
        //Set Area
        $area = array();
        $z = 0;
        for ($i=0; $i<9; $i=$i+3) {
            for ($j=0; $j<9; $j=$j+3) {
                $temp = array();
                for ($b=$i; $b<$i+3; $b++) {
                    for ($k=$j; $k<$j+3; $k++) {
                        $temp[$z] = Fitnes::$tempMatrik[$b][$k];
                        $z++;
                    }
                }
                array_push($area, $temp);
            }
        }

        return $area;
    }

    public static function tranpose () {
        //Tranpose
        for ($i=0; $i<9; $i++) {
            for ($j=0; $j<9; $j++) {
                $tranpose[$i][$j] = Fitnes::$tempMatrik[$j][$i];
            }
        }

        return $tranpose;
    }

}

class Operator {
    public static $bertahan = array();
    public static $probMutasi = 0.9;
    public static $probPenyilangan = 0.3;

    public static function evaluasi ($populasi) {
        for ($i=0; $i<Populasi::$ukuranPopulasi; $i++) {
            $populasi->individu[$i]->fitnes = Fitnes::hitungFitnes($populasi->individu[$i]);
        }
    }

    public static function seleksiPeringkat ($populasi) {
        //Pengurutan
        for ($i=0; $i<Populasi::$ukuranPopulasi; $i++) {
            for ($j=0; $j<Populasi::$ukuranPopulasi; $j++) {
                if ($populasi->individu[$j]->fitnes<$populasi->individu[$i]->fitnes) {
                    $temp = $populasi->individu[$i];
                    $populasi->individu[$i] = $populasi->individu[$j];
                    $populasi->individu[$j] = $temp;
                }
            }
        }
    }

    public static function randomPosisi () {
        $posisiPotong = array();
        $angka = array(1,2,3,4,5,6,7,8,9);
        while (count($posisiPotong)<4) {
            $random = rand(1,9);
            if (isset($angka[$random])) {
                    array_push($posisiPotong, $angka[$random]);
                unset($angka[$random]);
            }

        }
        return $posisiPotong;
    }

    public static function penyilangan ($populasi) {
        $banyakInduk = ceil(Populasi::$ukuranPopulasi/2);
        $banyakAnak = Populasi::$ukuranPopulasi-$banyakInduk;

        $kemungkinanInduk = Operator::pilihInduk($populasi, $banyakInduk);

        for ($i=$banyakAnak+1; $i<Populasi::$ukuranPopulasi-($banyakAnak/2); $i++) {
            for ($j=0; $j<9; $j++) { // Jumlah baris
                $ran = Operator::random();
                $indexInduk = array_rand($kemungkinanInduk); //Random pasangan induk

                if ($ran<Operator::$probPenyilangan) {
                    $count = count($populasi->individu[0]->gen[$j]);

                    $posisi = Operator::pilihPosisi($count);

                    $tempGem = Operator::newTempGenInduk($count, $posisi, $populasi->individu[$kemungkinanInduk[$indexInduk][0]]->gen[$j], $populasi->individu[$kemungkinanInduk[$indexInduk][1]]->gen[$j]);

                    for ($k=0; $k<$count; $k++) {
                        $anak1[$j][$k] = $populasi->individu[$kemungkinanInduk[$indexInduk][0]]->gen[$j][$k];
                        $anak2[$j][$k]  = $populasi->individu[$kemungkinanInduk[$indexInduk][1]]->gen[$j][$k];
                    }

                    for ($l=0; $l<count($tempGem[0]); $l++) {
                        $anak1[$j][$posisi[$l]] = $tempGem[0][$l];
                        $anak2[$j][$posisi[$l]] = $tempGem[1][$l];
                    }

                    $populasi->individu[$i]->gen[$j] = $anak1[$j];
                    $populasi->individu[$i+1]->gen[$j] = $anak2[$j];

                } else {
                    $populasi->individu[$i]->gen[$j] = $populasi->individu[$kemungkinanInduk[$indexInduk][0]]->gen[$j];
                    $populasi->individu[$i+1]->gen[$j] = $populasi->individu[$kemungkinanInduk[$indexInduk][1]]->gen[$j];
                }

            }
        }
    }

    public static function pilihPosisi ($count) {
        for ($i=0; $i<$count; $i++) {
            $angka[$i] = $i;
        }

        for ($i=0; $i<ceil($count/2); $i++) {
            $ran = array_rand($angka);
            $arrPosisi[$i] = $angka[$ran];
            unset($angka[$ran]);
        }
        return $arrPosisi;
    }

    public static function newTempGenInduk ($count, $arrPosisi, $induk1, $induk2) {
        for ($i=0; $i<count($arrPosisi); $i++) {
            $tempInduk1[$i] = $induk1[$arrPosisi[$i]];
        }

        for ($i=0; $i<count($arrPosisi); $i++) {
            $tempInduk2[$i] = $induk2[$arrPosisi[$i]];
        }

        //Gen anak ke 1
        $index = 0;
        for ($i=0; $i<$count; $i++) {
            foreach ($tempInduk1 as $key=>$value) {
                if ($induk2[$i]==$tempInduk1[$key]) {
                    $newTempInduk1[$index] = $tempInduk1[$key];
                    unset($tempInduk1[$key]);
                    $index++;
                }
            }
        }

        $index = 0;
        for ($i=0; $i<$count; $i++) {
            foreach ($tempInduk2 as $key=>$value) {
                if ($induk1[$i]==$tempInduk2[$key]) {
                    $newTempInduk2[$index] = $tempInduk2[$key];
                    unset($tempInduk2[$key]);
                    $index++;
                }
            }
        }

        return array($newTempInduk1, $newTempInduk2);
    }

    public static function pilihInduk ($populasi, $banyakInduk) {

        //Tampung index induk
        for ($i=0; $i<$banyakInduk; $i++) {
            $arrInduk[$i] = $i;
        }

        //Kombinasi induk yg mungkin
        $index = 0;
        for ($i=0; $i<$banyakInduk; $i++) {
            for ($j=0; $j<$banyakInduk; $j++) {
                if ($i!=$j) {
                    $arrInduk[$index] = array($i,$j);
                    $index++;
                }
            }
        }

        return $arrInduk;
    }

    public static function gantiGen ($gen1, $gen2, $anak1, $anak2) {
        for ($i=0; $i<9; $i++) {
            $gen1->gen[$i] = $anak1[$i];
            $gen2->gen[$i] = $anak2[$i];
        }
    }

    public static function mutasi ($populasi) {
        for ($k=0; $k<Populasi::$ukuranPopulasi; $k++) {
            for ($i=0; $i<9; $i++) {
                $count = count($populasi->individu[0]->gen[$i]);

                if ($count>2) {
                    $arrayPosisi = Operator::pilihPosisi($count);

                    for ($j=0; $j<2; $j++) {
                        $ran = array_rand($arrayPosisi);

                        $posisi[$j] = $arrayPosisi[$ran];
                        unset($arrayPosisi[$ran]);
                    }

                }

            }

        }
    }

    public static function random () {
        return rand(0, 10000) / 10000;
    }
}

Populasi::$ukuranPopulasi = $_POST['populasi'];
Operator::$probPenyilangan = $_POST['penyilangan'];
Operator::$probMutasi = $_POST['mutasi'];
$generasiBanyak = $_POST['generasi'];
Sudoku::setMatrik();
Sudoku::setKemungkinanRandom ();
Individu::$ukuranKromosom = Sudoku::jumlahCellKosong();
$generasi = array();
$populasi = new Populasi;

array_push($generasi,$populasi);
$max = $populasi;
if ($_POST['ketemu']=='1') {
  do {
      Operator::evaluasi($populasi);
      array_push($generasi,$populasi);
      if ($max->individu[0]->fitnes<$populasi->individu[0]->fitnes) {
        $max = $populasi;
      }
      Operator::seleksiPeringkat($populasi);
      Operator::penyilangan($populasi);
      Operator::mutasi($populasi);
      if ($populasi->individu[0]->fitnes==Individu::$ukuranKromosom) {
        break;
      }
  } while($populasi->individu[0]->fitnes<=Individu::$ukuranKromosom);
} else {
  $j=0;
  do {
      Operator::evaluasi($populasi);
      array_push($generasi,$populasi);
      if ($max->individu[0]->fitnes<$populasi->individu[0]->fitnes) {
        $max = $populasi;
      }
      Operator::seleksiPeringkat($populasi);
      Operator::penyilangan($populasi);
      Operator::mutasi($populasi);
      $j++;
  } while($j<$generasiBanyak);
}

print_r(json_encode($max));
?>
