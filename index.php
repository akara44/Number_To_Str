<?php

function sayiyiMetneCevir($sayi, $paraBirimiKodu) {
    $paraBirimiAdlari = array(
        'TL' => array('isim' => 'Türk Lirası', 'altbirim' => 'Kuruş'),
        'EUR' => array('isim' => 'Euro', 'altbirim' => 'Cent'),
        'USD' => array('isim' => 'Dolar', 'altbirim' => 'Cent'),
        'GBP' => array('isim' => 'Sterlin', 'altbirim' => 'Peni')
    );

    $sayiMetin = number_format($sayi, 2, '.', '');
    $basamakSayisi = strlen($sayiMetin);
    if ($basamakSayisi > 15) {
        return "Sayı çok büyük";
    }

    $tamKisim = floor($sayi);
    $kusuratKisim = round(($sayi - $tamKisim) * 100);

    $metin = "";

    if ($tamKisim != 0) {
        $metin .= sayiyiMetneCevirDahili($tamKisim) . " " . $paraBirimiAdlari[$paraBirimiKodu]['isim'] . " ";
    }

    if ($kusuratKisim != 0) {
        $metin .= sayiyiMetneCevirDahili($kusuratKisim) . ($kusuratKisim > 0 ? " " . $paraBirimiAdlari[$paraBirimiKodu]['altbirim'] : " Sıfır " . $paraBirimiAdlari[$paraBirimiKodu]['altbirim']);
    } else {
        $metin .= "Sıfır " . $paraBirimiAdlari[$paraBirimiKodu]['altbirim'];
    }

    if ($metin == "") {
        $metin = "Sıfır " . $paraBirimiAdlari[$paraBirimiKodu]['isim'];
    }

    return $metin;
}

function sayiyiMetneCevirDahili($sayi) {
    $birler = array("", "Bir", "İki", "Üç", "Dört", "Beş", "Altı", "Yedi", "Sekiz", "Dokuz");
    $onlar = array("", "On", "Yirmi", "Otuz", "Kırk", "Elli", "Altmış", "Yetmiş", "Seksen", "Doksan");

    if ($sayi == 0) {
        return "Sıfır";
    } else if ($sayi < 10) {
        return $birler[$sayi];
    } else if ($sayi < 20) {
        $deger = "On " . sayiyiMetneCevirDahili($sayi - 10);
        return $sayi == 10 ? "On" : $deger;
    } else if ($sayi < 100) {
        $onlarBasamagi = floor($sayi / 10);
        $birlerBasamagi = $sayi % 10;

        $metin = $onlar[$onlarBasamagi];
        if ($birlerBasamagi > 0) {
            $metin .= " " . $birler[$birlerBasamagi];
        }

        return $metin;
    } else if ($sayi == 100) {
        return "Yüz";
    } else if ($sayi < 1000) {
        $yuzler = floor($sayi / 100);
        $kalan = $sayi % 100;
        $metin = "";

        if ($yuzler == 1) {
            $metin = "Yüz";
        } else if ($yuzler > 1) {
            $metin = $birler[$yuzler] . " Yüz";
        }

        if ($kalan > 0) {
            $metin .= " " . sayiyiMetneCevirDahili($kalan);
        }

        return $metin;
    } else if ($sayi == 1000) {
        return "Bin";
    } else if ($sayi < 1000000) {
        $binler = floor($sayi / 1000);
        $kalan = $sayi % 1000;
        $metin = "";

        if ($binler == 1) {
            $metin = "Bin";
        } else if ($binler > 1) {
            $metin = sayiyiMetneCevirDahili($binler) . " Bin";
        }

        if ($kalan > 0) {
            $metin .= " " . sayiyiMetneCevirDahili($kalan);
        }

        return $metin;
    } else if ($sayi < 1000000000) {
        $milyonlar = floor($sayi / 1000000);
        $kalan = $sayi % 1000000;
        $metin = sayiyiMetneCevirDahili($milyonlar) . " Milyon";

        if ($kalan > 0) {
            $metin .= " " . sayiyiMetneCevirDahili($kalan);
        }

        return $metin;
    } else if ($sayi < 1000000000000) {
        $milyarlar = floor($sayi / 1000000000);
        $kalan = $sayi % 1000000000;
        $metin = sayiyiMetneCevirDahili($milyarlar) . " Milyar";

        if ($kalan > 0) {
            $metin .= " " . sayiyiMetneCevirDahili($kalan);
        }

        return $metin;
    } else {
        return "";
    }
}

// Fonksiyonu test et
$sayi = 44.44;
$paraBirimiKodu = 'TL';
$metin = sayiyiMetneCevir($sayi, $paraBirimiKodu);
echo $metin;

?>