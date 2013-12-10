DMS
===

[![Build Status](https://travis-ci.org/kreemer/DMS.png?branch=master)](https://travis-ci.org/kreemer/DMS)


Dieses Projekt ist nur ein Proof-Of-Concept um zu zeigen, dass Mathematische Berechnungen auch mittels Browser
durchgeführt werden können. Dabei ist es das Ziel, dass man:

- Allgemeine Mathematische Formeln automatisch verteilen kann.
- Dass die Browser die Berechnungen durchführen können und auch wieder zurückschicken können.


Installation
------------

Einfach ein `git clone`, nachher die Vagrant Box aufstarten mit `vagrant up`. Alle Abhängigkeiten sollten dann
in der virtuellen Maschine automatisch installiert werden.

Im `/vagrant` Verzeichnis schliesslich noch ein `composer update` und schon ist man am Ziel.

- Vielleicht muss man noch die Datenbank initialisieren mittels `app/console doctrine:database:create` und
  `app/console doctrine:schema:create`


Benutzung
---------

Zuerst muss man eine Berechnungsdatei erstellen, welche dann in die Datenbank gespeichert wird. Einige Beispiele
dazu findet man im `/data` Verzeichnis. Das Kommando zum importieren ist `app/console dms:import pfad-zur-datei`.

Man kann schlussendlich den Browser auf die Index Seite führen, und die Berechnung sollte starten.

Pakete
------

Folgende Pakete wurden eingesetzt:

- Symfony (2.3.x)
- MathJS (0.12.1)
- jQuery (2.0.3)
