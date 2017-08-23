
# User Guide für das ElasticExportSchuheDE Plugin

<div class="container-toc"></div>

## 1 Bei Schuhe.de registrieren

Schuhe.de ist eine Online-Plattform der ANWR Group, die Online-Shops und die realen Standorte des stationären Fachhandels verbindet.

## 2 Das Format SchuheDE-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **SchuheDE-Plugin**.
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>SchuheDE-Plugin</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.csv</b> oder <b>.txt</b> enden, damit Shopzilla.de die Datei erfolgreich importieren kann.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            Die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll.
        </td>        
    </tr>
    <tr>
        <td>
            Vorschautext
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            Angebotspreis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
</table>


## 3 Übersicht der verfügbaren Spalten

<table>
    <tr>
        <th>
            Spaltenbezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td>
            Identnummer
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Die <b>Varianten-ID</b> der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            Artikelnummer
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Die <b>Variantennummer</b> der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            Herstellerartikelnummer
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Das <b>Model</b> der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            Artikelname
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 255 Zeichen<br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Artikelname</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Artikelbeschreibung
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Beschreibung</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Bild(er)
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Liste der URLs der Bilder mit Semikolon getrennt. Variantenbilder werden vor Artikelbildern priorisiert.
        </td>        
    </tr>
    <tr>
        <td>
            360 Grad
        </td>
        <td>
            <b>Beschränkung:</b> max. 255 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » 360 Grad</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Bestand
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Ausgabe:</b> Der <b>Nettowarenbestand der Variante</b>. Bei Artikeln, die nicht auf den Nettowarenbestand beschränkt sind, wird <b>999</b> übertragen.
        </td>        
    </tr>
    <tr>
        <td>
            Farbe
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Attributs, bei dem die Attributverknüpfung für <b>Amazon</b> mit <b>Color</b> gesetzt wurde. Alternativ der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Farbe</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Farbe Suche I
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Farbe Suche I</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Farbe Suche II
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Farbe Suche II</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Hersteller Farbbezeichnung
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Hersteller Farbbezeichnung</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            GG Größengang
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » GG Größengang</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Größe
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 20 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Attributs, bei dem die Attributverknüpfung für <b>Amazon</b> mit <b>Size</b> gesetzt wurde. Alternativ der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Größe</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Marke
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der <b>Name des Herstellers</b> des Artikels. Der <b>Externe Name</b> unter <b>Einstellungen » Artikel » Hersteller</b> wird bevorzugt, wenn vorhanden.
        </td>        
    </tr>
    <tr>
        <td>
            Saison
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Saison</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            EAN
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Barcode</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Währung
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der ISO-Code der <b>Währung</b> des Preises.
        </td>        
    </tr>
    <tr>
        <td>
            Versandkosten
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Versandkosten</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Info Versandkosten
        </td>
        <td>
            <b>Beschränkung:</b> max. 255 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Info Versandkosten</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Preis (UVP)
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max. 6 Vorkommastellen<br>
            <b>Ausgabe:</b> Der <b>Verkaufspreis</b> der Variante. Wenn der <b>UVP</b> in den Formateinstellungen aktiviert wurde und höher ist als der Verkaufspreis, wird dieser hier eingetragen.
        </td>        
    </tr>
    <tr>
        <td>
            reduzierter Preis
        </td>
        <td>
            <b>Beschränkung:</b> max. 6 Vorkommastellen<br>
            <b>Ausgabe:</b> Wenn die Formateinstellung <b>UVP</b> aktiviert wurde und höher ist als der Verkaufspreis, steht hier der Verkaufspreis.
        </td>        
    </tr>
    <tr>
        <td>
            Grundpreis
        </td>
        <td>
            <b>Inhalt:</b> Der berechnete Grundpreis bezogen auf die <b>Grundpreis Einheit</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Grundpreis Einheit
        </td>
        <td>
            <b>Inhalt:</b> Die Einheit, auf die sich der <b>Grundpreis</b> bezieht.
        </td>        
    </tr>
    <tr>
        <td>
            Kategorien
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Die Namen der Kategorien getrennt durch Semikolon, die mit der Variante verknüpft sind.
        </td>        
    </tr>
    <tr>
        <td>
            Link
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der <b>URL-Pfad</b> des Artikels abhängig vom gewählten <b>Mandanten</b> in den Formateinstellungen.
        </td>        
    </tr>
    <tr>
        <td>
            Anzahl Verkäufe
        </td>
        <td>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Anzahl Verkäufe</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Schuhbreite
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> breit, normal, schmal<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Schuhbreite</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Absatzhöhe
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> bis 3 cm, 3-5 cm, 5-8 cm, 8-10 cm, über 10 cm<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Absatzhöhe</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Absatzform
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> Block, Keil, Pfennig, Trichter, flach<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Absatzform</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Schuhspitze
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> Karree, offen, rund, spitz<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Schuhspitze</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Obermaterial
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> Fell, Fettleder, Glattleder, Kunststoff/Synthetik, Lack, Lederimitat, Ledermix, Materialmix, Narbenleder, Rauhleder, Textil<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Obermaterial</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Schaftweite
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> normal, schmal, verstellbar, weit<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Schaftweite</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Schafthöhe
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> unter 5 cm, 5 - 15 cm, 15 - 25 cm, 25 - 35 cm, 35 - 45 cm<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Schafthöhe</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Materialzusammensetzung
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Materialzusammensetzung</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Besonderheiten
        </td>
        <td>
            <b>Beschränkung:</b> max. 255 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Besonderheiten</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Verschluss
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> Reißverschluss, Schnürung<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Verschluss</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Innenmaterial
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Innenmaterial</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Sohle
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Erlaubte Werte:</b> Kunststoff, Leder<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Sohle</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Größenhinweis
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Größenhinweis</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Wechselfussbett
        </td>
        <td>
            <b>Beschränkung:</b> 0, 1<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Wechselfussbett</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Wasserdicht
        </td>
        <td>
            <b>Beschränkung:</b> 0, 1<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Wasserdicht</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Promotion
        </td>
        <td>
            <b>Beschränkung:</b> 0, 1<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Promotion</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            URL Video
        </td>
        <td>
            <b>Beschränkung:</b> max. 255 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » URL Video</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            Steuersatz
        </td>
        <td>
            <b>Beschränkung:</b> max. 4 Vorkommastellen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » Steuersatz</b> verknüpft wurde.
        </td>        
    </tr>
    <tr>
        <td>
            ANWR schuh Trend
        </td>
        <td>
            <b>Beschränkung:</b> max. 50 Zeichen<br>
            <b>Inhalt:</b> Der Wert eines Merkmals vom Typ <b>Text</b> oder <b>Auswahl</b>, das mit <b>schuhe.de » ANWR schuh Trend</b> verknüpft wurde.
        </td>        
    </tr>
</table>

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-schuhe-de/blob/master/LICENSE.md).
