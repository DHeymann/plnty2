
# ElasticExportSchuheDE plugin user guide

<div class="container-toc"></div>

## 1 Registering with Schuhe.de

Schuhe.de is an online platform by the ANWR Group that links online stores with stationary specialist shops. Please note that this website is currently only available in German.

## 2 Setting up the data format SchuheDE-Plugin in plentymarkets

The plugin Elastic Export is required to use this format.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **SchuheDE-Plugin**.

<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>SchuheDE-Plugin</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            Choose <b>URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.csv</b> or <b>.txt</b> for Shopzilla.de to be able to import the file successfully.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Active
        </td>
        <td>
            Choose <b>active</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose one or multiple order referrer. The chosen order referrer has to be active at the variation for the item to be exported.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
            Choose the order referrer that should be assigned during the order import.
        </td>        
    </tr>
    <tr>
        <td>
            Preview text
        </td>
        <td>
            This option does not affect this format.
        </td>        
    </tr>
    <tr>
        <td>
            Offer price
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
    <tr>
        <td>
            VAT note
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
</table>

## 3 Overview of available columns

<table>
    <tr>
        <th>
            Column name
        </th>
        <th>
            Explanation
        </th>
    </tr>
        <tr>
            <td>
                Identnummer
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> The <b>variation ID</b> of the variation.
            </td>        
        </tr>
        <tr>
            <td>
                Artikelnummer
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The <b>Variation No.</b> within <b>Items » Edit item » Open item » Open variation » Settings » Basic settings</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Herstellerartikelnummer
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The <b>Model</b> within <b>Items » Edit item » Open item » Open variation » Settings » Basic settings</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Artikelname
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 255 characters<br>
                <b>Content:</b> According to the format setting <b>item name</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Artikelbeschreibung
            </td>
            <td>
                <b>Content:</b> According to the format setting <b>Description</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Bild(er)
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> A list of all image urls seprated with semicolon. Variation images are prioritizied over item images.
            </td>        
        </tr>
        <tr>
            <td>
                360 Grad
            </td>
            <td>
                <b>Limitation:</b> max. 255 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » 360 degrees</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Bestand
            </td>
            <td>
                <b>Required</b><br>
                <b>Ausgabe:</b> The <b>net stock</b> of the variation. If a variation is not limited to its net stock, b>999</b> übertragen.
            </td>        
        </tr>
        <tr>
            <td>
                Farbe
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of an attribute, with an attribute link for <b>Amazon</b> to  <b>Color</b>. As an alternative the value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Farbe</b> can also be used.
            </td>        
        </tr>
        <tr>
            <td>
                Farbe Suche I
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Colour search I</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Farbe Suche II
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Colour search II</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Hersteller Farbbezeichnung
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Manufacturer colour name</b>.
            </td>        
        </tr>
        <tr>
            <td>
                GG Größengang
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » GG size range</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Größe
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 20 characters<br>
                <b>Content:</b> The value of an attribute, with an attribute link for <b>Amazon</b> to  <b>Size</b>. As an alternative the value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Size</b> can also be used.
            </td>        
        </tr>
        <tr>
            <td>
                Marke
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The <b>name of the manufacturer</b> of the item. The <b>external name</b> within <b>Settings » Items » Manufacturer</b> will be preferred if existing.
            </td>        
        </tr>
        <tr>
            <td>
                Saison
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Season</b>.
            </td>        
        </tr>
        <tr>
            <td>
                EAN
            </td>
            <td>
                <b>Content:</b> According to the format setting <b>Barcode</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Währung
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> The ISO code of the <b>currency</b> of the price.
            </td>        
        </tr>
        <tr>
            <td>
                Versandkosten
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> According to the format setting <b>shipping costs</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Info Versandkosten
            </td>
            <td>
                <b>Limitation:</b> max. 255 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Shipping costs info</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Preis (UVP)
            </td>
            <td>
                <b>Required</b><br>
                <b>Limitation:</b> max. 6 pre-decimals<br>
                <b>Content:</b> The <b>sales price</b> of the variation. If the <b>RRP</b> is activated in the format setting and is higher than the <b>sales price</b>, the <b>RRP</b> will be exported.
            </td>        
        </tr>
        <tr>
            <td>
                reduzierter Preis
            </td>
            <td>
                <b>Limitation:</b> max. 6 pre-decimals<br>
                <b>Content:</b> If the <b>RRP</b> is activated in the format setting and is higher than the <b>sales price</b>, the <b>sales price</b> will be exported.
            </td>        
        </tr>
        <tr>
            <td>
                Grundpreis
            </td>
            <td>
                <b>Content:</b> The base price based on the column <b>Grundpreis Einheit</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Grundpreis Einheit
            </td>
            <td>
                <b>Content:</b> The content and unit on which the <b>base price</b> is based.
            </td>        
        </tr>
        <tr>
            <td>
                Kategorien
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> The names of the categories that are linked to the variation separeted with semicolon.
            </td>        
        </tr>
        <tr>
            <td>
                Link
            </td>
            <td>
                <b>Required</b><br>
                <b>Content:</b> The <b>URL path</b> of the item depending on the chosen <b>client</b> in the format settings.
            </td>        
        </tr>
        <tr>
            <td>
                Anzahl Verkäufe
            </td>
            <td>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Number of sales</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Schuhbreite
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> breit, normal, schmal<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Shoe width</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Absatzhöhe
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> bis 3 cm, 3-5 cm, 5-8 cm, 8-10 cm, über 10 cm<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Heel height</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Absatzform
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> Block, Keil, Pfennig, Trichter, flach<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Heel shape</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Schuhspitze
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> Karree, offen, rund, spitz<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » shoe point</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Obermaterial
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> Fell, Fettleder, Glattleder, Kunststoff/Synthetik, Lack, Lederimitat, Ledermix, Materialmix, Narbenleder, Rauhleder, Textil<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Upper material</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Schaftweite
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> normal, schmal, verstellbar, weit<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Shaft width</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Schafthöhe
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> unter 5cm, 5-15cm, 15-25cm, 25-35cm, 35-45cm<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Shaft height</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Materialzusammensetzung
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Material composition</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Besonderheiten
            </td>
            <td>
                <b>Limitation:</b> max. 255 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Particularities</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Verschluss
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> Reißverschluss, Schnürung<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Closure</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Innenmaterial
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Inner material</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Sohle
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Allowed values:</b> Kunststoff, Leder<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Sole</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Größenhinweis
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Size note</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Wechselfussbett
            </td>
            <td>
                <b>Allowed values:</b> 0, 1<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Removable insoles</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Wasserdicht
            </td>
            <td>
                <b>Allowed values:</b> 0, 1<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Watertight</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Promotion
            </td>
            <td>
                <b>Allowed values:</b> 0, 1<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Promotion</b>.
            </td>        
        </tr>
        <tr>
            <td>
                URL Video
            </td>
            <td>
                <b>Limitation:</b> max. 255 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » URL video</b>.
            </td>        
        </tr>
        <tr>
            <td>
                Steuersatz
            </td>
            <td>
                <b>Limitation:</b> max. 4 pre-decimals<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » Tax rate</b>.
            </td>        
        </tr>
        <tr>
            <td>
                ANWR schuh Trend
            </td>
            <td>
                <b>Limitation:</b> max. 50 characters<br>
                <b>Content:</b> The value of a property of the type <b>Text</b> or <b>Selection</b>, that is linked to <b>schuhe.de » ANWR schuh Trend</b>.
            </td>        
        </tr>
</table>

## 4 License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-schuhe-de/blob/master/LICENSE.md).
