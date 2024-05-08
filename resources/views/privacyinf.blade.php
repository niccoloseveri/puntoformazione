<!doctype html>
<html lang="it" class="w-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Stampa Informativa Privacy</title>
        <script src="https://cdn.tailwindcss.com"></script>

<!--
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <link href=" {{--asset('css/bootstrap.min.css')--}} " rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        -->
        <style media="print, screen">
            @page{
                size:a4!important;
                margin-top:2cm!important;
            margin-left: 2.5cm!important;
            margin-right: 2.07cm!important;
            margin-bottom: 1cm!important;
            }
            html,body {

            font-family:Tahoma, sans-serif;
            /*font-weight: normal;
            font-style: normal;*/
            }
/*
            * {
            margin-top:0!important;
            margin-bottom:0!important;
            margin-left:0!important;
            margin-right:0!important;
            padding-top:0!important;
            padding-bottom:0!important;
            padding-left:0!important;
            padding-right:0!important;
            }


            body {
            margin-top:2.3cm!important;
            margin-left: 2.9cm!important;
            margin-right: 2.07cm!important;
            margin-bottom: 0.78cm!important;
            }

            * > div {
            justify-content: center;
            align-items: center;
            }
            */
            * > p {
            font-size:8.5pt;
            }

            .l1 {
            text-align:left;
            }

            .r1 {
            font-size:7pt;
            line-height:1.3;

            }

            .corpotxt {
            font-size:8.5pt;
            }

            .titlex {
            font-family:Arial;
            font-size:12pt;
            }

            .bold {
            font-weight: bold!important;
            }

            .all_container{
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                width: 100%;
            }

            /*

            #fullwrap > p {
            text-align: justify;
            }

            #fullwrap > p::after {
            content: "";
            display: inline-block;
            width: 100%;
            }

            */

            #fullwrap > p {
            text-align: justify;
            text-justify: inter-word;
            justify-content: space-between;
            }

            #logo {
            height: 10.5mm!important;
            }

            #letters {
            margin-left: 15px!important;
            list-style-type: lower-alpha!important;
            text-align: justify;
            text-justify: inter-word;
            justify-content: space-between;
            }
            #numbers {
            margin-left: 37px!important;
            list-style-type: decimal!important;
            text-align: justify;
            text-justify: inter-word;
            justify-content: space-between;
            }

            .l_label {
            font-weight: normal;
            }
            .orow{
                margin-bottom: 2.5mm!important;
            }
            .col_2_grid{
                display: grid;
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }


        </style>


        <script>

            window.print();
            window.onafterprint() = function (){
                window.close();
            }

        </script>

    @csrf
    </head>
    <body>
        <div class="all_container" id="pagec">
            <!-- INTESTAZIONE -->
            <div class="col_2_grid" id="intestazione">
                <div class="w-full text-left ">
                    <img id="logo" alt="image" src="http://www.gestionalepf.pythonsrl.com/Image_001.png"/>
                </div>
                <div class="r1 text-right justify-end w-full " >
                    Punto Formazione SRL<br>
                    Via delle Industrie 5 - 06034 Foligno (PG)<br>
                     Tel/Fax 0742.340904 - <u>info@puntoformazione.net</u><br>
                    PI 03237430545<br><br>
                    Rev.01 del 13/02/2018
                </div>
            </div>
            <!-- FINE INTESTAZIONE -->

            <!-- SEZIONE 1 -->
            <div class="w-full mt-3">
                <span class="titlex font-bold">
                    Informativa Privacy ex art. 13<br/>Regolamento Generale Protezione Dati n. 679/2016
                </span>
                <br>
                <div id="fullwrap" class="w-full">
                    <p>
                        Questo documento ti chiarisce chi utilizza i tuoi dati personali, come li usa e quali sono i tuoi diritti.
                        Ti ricordiamo che per dato personale la legge intende tutte quelle informazioni che identificano o rendono identificabile una persona fisica e che possono fornire dettagli sulle sue caratteristiche, le sue abitudini, il suo stile di vita, le sue relazioni personali, il suo stato di salute, la sua situazione economica, ecc.
                        In particolare i dati che tu ci stai autorizzando a trattare sono:
                    </p>
                    <ul class="list-disc list-inside corpotxt text-justify">
                        <li>Dati personali: anagrafici: come il nome, il cognome, l'indirizzo, il numero di telefono ed in generale tutto quanto è utile e necessario sia per l'erogazione del servizio che per gli oneri di legge.</li>
                        <li>Dati particolari: dati sanitari utili allo svolgimento in sicurezza del corso di formazione da svolgere o altri elementi legati all'apprendimento connessi allo svolgimento del corso da erogare.</li>
                    </ul>
                    <p>
                        Il <span class="font-bold">titolare del trattamento è la Punto Formazione s.r.l.</span>, sede legale in via delle Industrie n. 5, 06034 Foligno (PG), P.iva 03237430545. Potrai contattarci a mezzo della mail info@puntoformazione.net per chiedere qualsiasi informazione che riguardi i tuoi dati personali.
                    </p>
                    <p>
                        È importante che ti spieghiamo e chiariamo alcuni aspetti:
                    </p>
                    <p>
                        <ol id="numbers" class="corpotxt">
                            <li class="font-bold">
                                Finalità:
                                <span class="l_label">
                                    i tuoi dati personali ci servono
                                    <ol id="letters" class="corpotxt">
                                        <li>
                                            per l'utilizzo dei servizi che ti offriamo, quali i cori di formazione e le attività di coaching;
                                        </li>
                                        <li>per adempiere agli obblighi derivanti dal contratto relativi al/ai servizio/i erogato/i, ad es.
                                            per farti accedere ai locali dove viene erogato il corso di formazione in sicurezza e
                                            tutelando al meglio la tua salute;</li>
                                        <li>per adempiere agli obblighi normativi legati ai servizi, quali ad es. la comunicazione alle
                                            autorità dei tuoi dati per dare validità legale al percorso da te svolto;</li>
                                        <li>per contattarti con mailing list od altri canali al fine di tenerti aggiornato sulle nostre
                                            offerte di servizi;</li>
                                        <li>per monitorare i tuoi comportamenti ed il tuo modus operandi quando interagisci con noi
                                            e con i nostri canali di comunicazione;</li>
                                        <li>per inserire i tuoi dati e la tua immagine per poter creare documentazione promozionale
                                            delle attività svolte.</li>
                                    </ol>
                                </span>
                            </li>
                            <li class="font-bold">
                                Base Giuridica:
                                <span class="l_label">
                                    questo lo possiamo fare perché c'è il contratto che regola il tuo percorso di
                                    formazione, gli obblighi normativi connessi ai dati da comunicare agli enti ed agli organi di sicurezza che tracciano la tua frequentazione, altri obblighi connessi alla tracciabilità di pagamenti,
                                    nonché il nostro interesse legittimo ad usare alcune informazioni per migliorare il tuo percorso di formazione e tenerti aggiornato sui servizi che offriamo. Questi elementi sono spesso incrociati con il tuo consenso, che diventa essenziale per le fasi di contatto ed aggiornamento anche successive al completamento del percorso di formazione.
                                </span>
                            </li>
                            <li class="font-bold">
                                Obbligo di comunicazione:
                                <span class="l_label">
                                    ti ricordiamo che i tuoi dati sono fondamentali affinché tu possa fruire del servizio/i e se non presti il tuo consenso oppure li dovessi comunicare in maniera incompleta o non corretta,
                                    questo comporterà l'impossibilità dell'erogazione dello stesso. Nello specifico l'obbligatorietà riguarda le finalità espresse nei punti "a", "b" e "c". Invece sono facoltativi i dati riferiti ai contatti
                                    commerciali o alle attività promozionali sui quali puoi negare il consenso, nello specifico le finalità sopra indicate ai punti "d", "e" ed "f".
                                </span>
                            </li>
                            <li class="font-bold">
                                Destinatari:
                                <span class="l_label">
                                    i tuoi dati personali li utilizzeranno anche una serie di soggetti connessi alla nostra filiera, ovviamente la nostra banca per il pagamento se fatto con strumenti elettronici
                                    (bancomat, bonifici o carte di credito), i nostri docenti che di occupano dell'erogazione delle varie materie del corso che frequenti, il personale didattico
                                    (docenti, tutor, coordinatori etc.) ed amministrativo, soggetti istituzionali (Regione, Inail, Fondi interprofessionali etc.), enti assicurativi, partners
                                     formativi (ad. Associazioni di categoria, agenzie formative) del corso a cui partecipi, i nostri consulenti che si occupano della gestione contabile, della sicurezza o di altri aspetti connessi ai
                                     servizi che noi ti offriamo, per attività promozionali possiamo comunicare i tuoi dati o la tua immagine anche via web. È importante la collaborazione di tutti in maniera coerente con la normativa vigente utilizzando le informazioni in maniera strettamente necessaria all'uso previsto.
                                </span>
                            </li>
                            <li class="font-bold">
                                Durata della conservazione:
                                <span class="l_label">
                                    il periodo del trattamento sarà quello necessario per gli obblighi di legge che sono circa 10 (dieci) anni per la conservazione dei dati relativi agli aspetti contabili del
                                    rapporto instaurato e di frequentazione dei corsi di formazione. Per quanto riguarda le informazioni commerciali e di marketing, per questi dati c'è un interesse legittimo come sopra descritto, per cui a tua richiesta
                                    saranno oggetto di un processo anonimizzazione o pseudonimizzazaione, ma non saranno rimossi dal sistema.
                                </span>
                            </li>
                        </ol>
                    </p>
                    <br>
                    <p class="corpotxt">
                        Di seguito ti elenchiamo i <span class="font-bold">tuoi diritti</span> (art. 15-20 del Regolamento UE 2016/679) che potrai esercitare utilizzando i contatti che ti abbiamo indicato sopra per chiedere di:
                    </p>
                    <br>
                        <ol id="numbers" class="corpotxt">
                            <li>accedere, correggere o aggiornare i tuoi dati personali;</li>
                            <li>bloccare o limitarne l'utilizzo;</li>
                            <li>eliminare i tuoi dati personali in parte o completamente;</li>
                            <li>chiedere la portabilità dei tuoi dati.</li>
                        </ol>
                        <br>
                    <p>
                        <span class="font-bold">Possibilità di Reclamare: </span>
                        ricordati che puoi proporre istanza all'Autorità per la Protezione dei Dati Personali (www.garanteprivacy.it) esercitando il tuo diritto attraverso i diversi canali per reclamare.
                    </p>
                    <p>
                        <span class="font-bold">Revoca del Consenso:</span>
                        se il tuo trattamento è basato sul tuo consenso, hai il pieno diritto di revocarlo in qualsiasi momento con una semplice e chiara comunicazione utilizzando i contatti sopra indicati.
                        Negli altri casi non potrà avvenire la cancellazione del dato in quanto c'è una base giuridica che ne consente il trattamento.
                    </p>
                    <p>
                        <span class="font-bold">Profilazione dell'utente:</span>
                        con i tuoi dati personali cercheremo di capire i tuoi comportamenti e le tue abitudini al fine di definire un profilo che ti riguarda.
                    </p>
                    <p>
                        <span class="font-bold">Trattamento automatizzato:</span>
                        i tuoi dati personali <u>non</u> saranno utilizzati con uno strumento che prevede un processo di valutazione automatizzato a cui puoi opporti.
                    </p>
                    <p>
                        <span class="font-bold">Trasferimento dei dati ad un paese terzo:</span>
                        i tuoi dati non saranno comunicati al di fuori dall'Europa e qualora in futuro dovesse succedere, saremo attenti a verificare che siano rispettate le condizioni di garanzia previste dagli art. 46 e successivi.
                    </p>
                    <p>
                        Ti assicuriamo anche che i tuoi dati personali li utilizziamo solo per quel che c'è scritto qui e se dovessimo utilizzarli per altri scopi te lo comunicheremo prima per chiederti il permesso.
                    </p>
                    <br>
                    <p class="ml-2">
                        <span class="italic">a) Se hai compreso il contenuto della presente informativa, il titolare ti chiede se presti il consenso al trattamento secondo le modalità sopra indicate, per <span class="font-bold">l’esecuzione del presente contratto</span> di servizi.<br/></span>
                        <span class="text-3xl align-sub">&#9744;</span><span class="mr-20">Presto il consenso</span><span class="text-3xl align-sub">&#9744;</span>Non presto il consenso
                    </p>
                    <p class="ml-2">
                        <span class="italic">b) Se hai compreso il contenuto della presente informativa, il titolare ti chiede se presti il consenso al trattamento secondo le modalità sopra indicate, per l’<span class="font-bold">invio di comunicazioni di carattere promozionale</span> dei servizi.<br></span>
                        <span class="text-3xl align-sub">&#9744;</span><span class="mr-20">Presto il consenso</span><span class="text-3xl align-sub">&#9744;</span>Non presto il consenso
                    </p>
                    <p class="ml-2">
                        <span class="italic">c) Se hai compreso il contenuto della presente informativa, il titolare ti chiede se presti il consenso al trattamento secondo le modalità sopra indicate, per <span class="font-bold">attività di profilazione.</span><br/></span>
                        <span class="text-3xl align-sub">&#9744;</span><span class="mr-20">Presto il consenso</span><span class="text-3xl align-sub">&#9744;</span>Non presto il consenso
                    </p>
                    <br><br>
                    <div class="grid grid-cols-2 justify-between items-center">
                        <div class="text-start"><p>Foligno, {{date('d/m/Y')}}</p></div>
                        <div class="text-end"><p class="text-center">FIRMA DEL CLIENTE<br><br>_____________________________</p></div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
