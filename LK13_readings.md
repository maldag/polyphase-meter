# Registertabelle Drehstromzähler und Wechselstromzähler Logarex 


Gebrauchsanweisung Drehstromzähler und Wechselstromzähler Logarex 
Version8 2017-11-30d 

LK13BE8030x9 
LK11BE8030x9
siehe: https://www.stadtwerke-burgdorf-netz.de/_Resources/Persistent/9450d40cdc3d62d8de38a3e4b06ad5d6805c87b4/Gebrauchsanleitung_LK13BE8030x9.pdf

## Beschreibung der Register

| Schlüssel (Wert)                    | Kommentar |
| ----------------------------------- | ----------|
| 1-0:96.1.0*255(001LOG0065800041)    | Hersteller unabhängige Identifikationsnummer – Produktionsnummer
| 1-0:1.8.0*255(000000.0000*kWh)      | Kumulatives Register der aktiven Energie in kWh T1+T2
| 1-0:1.8.1*255(000000.0000*kWh)      | Kumulatives Register der aktiven Energie in kWh T1
| 1-0:1.8.2*255(000000.0000*kWh)      | Kumulatives Register der aktiven Energie in kWh T2
| 1-0:2.8.0*255(000000.0000*kWh)      | -A Enerige
| 1-0:16.7.0*255(000000*W)            | Stromeffektivwert
| 1-0:32.7.0*255(000.0*V)             | Spannung L1, Auflösung 0.1 V
| 1-0:52.7.0*255(000.0*V)             | Spannung L2, Auflösung 0.1 V 
| 1-0:72.7.0*255(228.8*V)             | Spannung L3, Auflösung 0.1 V
| 1-0:31.7.0*255(000.00*A)            | Strom L1, Auflösung 0.01 A 
| 1-0:51.7.0*255(000.00*A)            | Strom L2, Auflösung 0.01 A
| 1-0:71.7.0*255(000.00*A)            | Strom L3, Auflösung 0.01 A
| 1-0:81.7.1*255(000*deg)             | Phasenwinkel UL2 : UL1
| 1-0:81.7.2*255(000*deg)             | Phasenwinkel UL3 : UL1
| 1-0:81.7.4*255(000*deg)             | Phasenwinkel IL1 : UL1 
| 1-0:81.7.15*255(000*deg)            | Phasenwinkel IL2 : UL2
| 1-0:81.7.26*255(000*deg)            | Phasenwinkel IL3 : UL3
| 1-0:14.7.0*255(50.0*Hz)             | Netz Frequenz in Hz 
| 1-0:1.8.0*96(00000.0*kWh)           | Historischer Energieverbrauchswert vom letzten Tag (1d)
| 1-0:1.8.0*97(00000.0*kWh)           | Historischer Energieverbrauchswert der letzten Woche (7d)
| 1-0:1.8.0*98(00000.0*kWh)           | Historischer Energieverbrauchswert des letzten Monats (30d)
| 1-0:1.8.0*99(00000.0*kWh)           | Historischer Energieverbrauchswert des letzten Jahres (365d)
| 1-0:1.8.0*100(00000.0*kWh)          | Historischer Energieverbrauchswert seit letzter Rückstellung
| 1-0:0.2.0*255(ver.03,432F,20170504) | Firmware Version, Firmware Prüfsumme CRC , Datum
| 1-0:96.90.2*255(F0F6)               | Prüfsumme - CRC der eingestellten Parameter
| 1-0:97.97.0*255(00000000)           | FF - Status Register - Interner Gerätefehler 
