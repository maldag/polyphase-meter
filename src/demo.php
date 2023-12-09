<?php
declare(strict_types = 1);

namespace ws\loewe\polyphase_meter;

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

$logger_raw = new Logger('polyphase_meter');
$logger_raw->pushHandler(new RotatingFileHandler(__DIR__.'/../log/log_raw.log',1, Logger::INFO));

$logger_csv = new Logger('polyphase_meter');
$stream = new RotatingFileHandler(__DIR__.'/../log/data.csv',1, Logger::INFO,);

$dateFormat = "Y-m-d\TH:i:s";
$output = "%datetime%;%message%\n";

// finally, create a formatter
$formatter = new LineFormatter($output, $dateFormat);
$stream->setFormatter($formatter);
$logger_csv->pushHandler($stream);


$connector = new PolyphaseMeterConnector('/dev/ttyUSB0');

$reading = $connector->read();
$logger_raw->info('raw data: ' . $reading . PHP_EOL);

class LK13Data
{
    public readonly string $id;
    public readonly string $shortName;
    public readonly string $unit;
    public readonly string $description;

    public float $value;

    function __construct(string $id, string $shortName, string $unit, string $description)
    {
        $this->id=$id;
        $this->shortName=$shortName;
        $this->unit=$unit;
        $this->description=$description;
        $this->value=0.0;
    }
}

$mapping = array(
    # new LK13Data("1-0:96.1.0*255","Identifikationsnummer","Hersteller unabhängige Identifikationsnummer-Produktionsnummer")
    new LK13Data("1-0:1.8.0*255","Energie T1+T2","kWh","Kumulatives Register der aktiven Energie in kWh T1+T2")
    ,new LK13Data("1-0:1.8.1*255","Energie T1","kWh","Kumulatives Register der aktiven Energie in kWh T1")
    ,new LK13Data("1-0:1.8.2*255","Energie T2","kWh","Kumulatives Register der aktiven Energie in kWh T2")
    ,new LK13Data("1-0:2.8.0*255","?","?","-A Enerige")
    ,new LK13Data("1-0:16.7.0*255","Momentanleistung","W","Stromeffektivwert")
    ,new LK13Data("1-0:32.7.0*255","Spannung L1","V","Spannung L1, Auflösung 0.1 V")
    ,new LK13Data("1-0:52.7.0*255","Spannung L2","V","Spannung L2, Auflösung 0.1 V ")
    ,new LK13Data("1-0:72.7.0*255","Spannung L3","V","Spannung L3, Auflösung 0.1 V")
    ,new LK13Data("1-0:31.7.0*255","Strom L1","A","Strom L1, Auflösung 0.01 A ")
    ,new LK13Data("1-0:51.7.0*255","Strom L2","A","Strom L2, Auflösung 0.01 A")
    ,new LK13Data("1-0:71.7.0*255","Strom L3","A","Strom L3, Auflösung 0.01 A")
    ,new LK13Data("1-0:81.7.1*255","Phasenwinkel UL2 : UL1","deg.","Phasenwinkel UL2 : UL1")
    ,new LK13Data("1-0:81.7.2*255","Phasenwinkel UL3 : UL1","deg.","Phasenwinkel UL3 : UL1")
    ,new LK13Data("1-0:81.7.4*255","Phasenwinkel IL1 : UL1","deg.","Phasenwinkel IL1 : UL1 ")
    ,new LK13Data("1-0:81.7.15*255","Phasenwinkel IL2 : UL2","deg.","Phasenwinkel IL2 : UL2")
    ,new LK13Data("1-0:81.7.26*255","Phasenwinkel IL3 : UL3","deg.","Phasenwinkel IL3 : UL3")
    ,new LK13Data("1-0:14.7.0*255","Netz Frequenz","Hz","Netz Frequenz in Hz ")
    ,new LK13Data("1-0:1.8.0*96","Hist. Energie (1d)","kWh","Historischer Energieverbrauchswert vom letzten Tag (1d)")
    ,new LK13Data("1-0:1.8.0*97","Hist. Energie (7d)","kWh","Historischer Energieverbrauchswert der letzten Woche (7d)")
    ,new LK13Data("1-0:1.8.0*98","Hist. Energie (30d)","kWh","Historischer Energieverbrauchswert des letzten Monats (30d)")
    ,new LK13Data("1-0:1.8.0*99","Hist. Energie (365d)","kWh","Historischer Energieverbrauchswert des letzten Jahres (365d)")
    ,new LK13Data("1-0:1.8.0*100","Hist. Energie (maxd)","kWh","Historischer Energieverbrauchswert seit letzter Rückstellung")
    #,new LK13Data("1-0:0.2.0*255","Version","Firmware Version, Firmware Prüfsumme CRC , Datum")
    #,new LK13Data("1-0:96.90.2*255","Prüfsumme","Prüfsumme - CRC der eingestellten Parameter")
    #,new LK13Data("1-0:97.97.0*255","Status","FF - Status Register - Interner Gerätefehler ")
);

$log_string="";
foreach ($mapping as $item){
    $possible_match  = $reading->extract($item->id);
    if($possible_match){ 
        # Wir interessieren uns hier nur für die Zahlen, nicht für die Strings   
        $item->value = (double)$possible_match[1];
    }
    else{
        $item->value = 0.0;
    }
    $log_string = $log_string . ";" . $item->value;
}

$logger_csv->info($log_string);

$json_string=json_encode($mapping,JSON_PRETTY_PRINT);

$json_path = "log/index.html";
$fp = fopen($json_path,"w");
fwrite($fp,$json_string);
fclose($fp);
