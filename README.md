# Herbie Google Maps Plugin

`Google Maps` ist ein [Herbie](http://github.com/getherbie/herbie) Plugin, mit dem du 
[Google Maps](http://maps.google.com)-Karten in deine Website einbettest.

Du kannst eine Adresse angeben, die geokodiert und mit einem Icon für den Standort versehen wird. Weitere Funktionen 
sind geplant.


## Installation

Das Plugin installierst du via Composer.

	$ composer require getherbie/plugin-googlemaps

Danach aktivierst du das Plugin in der Konfigurationsdatei.

    plugins:
        enable:    
            - googlemaps


Konfiguration
-------------

Unter *plugins.config.googlemaps* stehen dir die folgenden Optionen zur Verfügung:

    # template path to twig template
    template: @plugin/googlemaps/templates/googlemaps.twig
      
    # enable shortcode
    shortcode: true
    
    # enable twig function
    twig: false                                            


Anwendung
---------

Nach der Installation steht dir ein Shortcode `googlemaps` zur Verfügung. Diesen rufst du wie folgt auf:

    [googlemaps id="gmap" width="600 height="450" type="roadmap" class="gmap" zoom="15" address="Baslerstrasse 8048 Zürich"]


Wenn du in der Konfiguration die Twig-Funktion aktivierst, kannst du die gleichnamige Twig-Funktion auch in 
Layoutdateien einsetzen: 

    {{ googlemaps("gmap", 600, 450, "roadmap", "gmap", 15, "Baslerstrasse 8048 Zürich") }}

Die Funktion kannst du auch mit benannten Argumenten aufrufen.

    {{ googlemaps(address="Baslerstrasse 8048 Zürich", type="roadmap") }}


Parameter
---------

Name        | Beschreibung                              | Typ       | Default
:---------- | :---------------------------------------- | :-------- | :------
id          | Das `id` HTML-Attribut                    | string    | gmap  
width       | Die Breite des Videos in Pixel            | int       | 600
height      | Die Höhe des Videos in Pixel              | int       | 450
type        | Der Kartentyp                             | string    | roadmap
class       | Das `class` HTML-Attribut                 | string    | gmap
zoom        | Der Zoomfaktor                            | int       | 15
address     | Die Adresse, die geokodiert werden soll   | string    | *empty* 
