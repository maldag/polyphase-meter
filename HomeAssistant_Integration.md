# Integration mit Homeassistant

Der folgende Abschnitt kann in Homeassistant verwendet werden.
Es werden keine weiteren Addons oder ähnliches benötigt.

Getestet mit Version Homeassistant Core 2023.12.1, Homeassistant OS 11.2

```
# configuration.yaml
rest:
  - resource: http://<address>/smartmeter/
    scan_interval: 10
    sensor:
      - name: "Stromzähler - Energie total"
        value_template: "{{ value_json[0]['value']}}"
        unit_of_measurement: "kWh"
      - name: "Stromzähler - aktuelle Leistung"
        value_template: "{{ value_json[4]['value']}}"
        unit_of_measurement: "W"
      - name: "Stromzähler - Energie letzter Tag"
        value_template: "{{ value_json[17]['value']}}"
        unit_of_measurement: "kWh"
```
