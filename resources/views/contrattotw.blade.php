<!doctype html>
<html lang="it" class="w-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Stampa Contratto</title>
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

    </head>
    <body>
        <div class="all_container" id="pagec">
                <!-- INTESTAZIONE -->
                <div class="col_2_grid" id="intestazione">
                    <div class="w-full text-left ">
                        <img id="logo" alt="image" src="{{asset('Image_001.png') }}"/>
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
        <!-- SEZIONE 1 - ANAGRAFICA -->
                <div class="w-full">
                    <div class="w-full mt-3">
                        <span class="titlex font-bold">
                            ISCRIZIONE AI CORSI DI FORMAZIONE PROFESSIONALE
                        </span>
                        <br>
                        <br>
                        <div id="fullwrap" class="w-full">
                            <p>
                                Il sottoscritto <strong>{{__('Nome e Cognome')}}</strong>, nato a <strong>{{__('Città Nascita')}}</strong>, il <strong>{{__('31/12/1999')}}</strong>,
                                residente a <strong>{{__('Città Resid.')}}</strong>,<br> Via <strong>{{__('Residenza')}}</strong>,
                                CAP <strong>{{__('12345')}}</strong>, Cod. Fisc <strong>{{__('ASQWER45R43D323E')}}</strong>, email <strong>indirizzo@email.com</strong>, tel. <strong>3209874433</strong>,<br> in possesso del Licenza Scuola
                                dell'Obbligo (d'ora in avanti "Allievo")
                            </p>
                            <span class="font-bold">
                                chiede
                            </span>
                            <br>
                            <p class="mt-3.5 mb-3.5">
                                di essere iscritto al Corso per <strong> NOME DEL CORSO</strong><!-- di cui alla legge 17/07/2002 n.13 corso accreditato con DGR
                                n. 1005 del 04/08/2014 e inserito nel piano DGR n. 879 del 02/08/2018--> - <strong>COD. CORSO X/XXXX SEZ XXXX</strong> gestito, <strong><i>come da normativa di riferimento*</i></strong>, dall'ente
                                formativo “Punto Formazione s.r.l.” con sede in Foligno, via delle Industrie, 5 (d'ora in avanti soltanto "Società"). A tal
                                fine espressamente
                            </p>
                            <span class="font-bold">
                                dichiara
                            </span>
                            <br>
                            <p class="mt-3.5 mb-3.5">
                                <ol id="letters" class="corpotxt">
                                    <li class="font-bold">
                                        <span class="l_label">
                                            di aver preso visione del Regolamento del Corso e del Regolamento relativo al tirocinio e di accettarne senza
                                            alcuna eccezione e/o riserva, tutte le norme di carattere didattico, disciplinare e amministrativo,
                                            espressamente impegnandosi (con la sottoscrizione del presente contratto) all'integrale rispetto delle stesse,
                                            integrate dalle presenti norme contrattuali
                                        </span>
                                    </li>
                                    <li class="font-bold">
                                        <span class="l_label">
                                            di essere a conoscenza del fatto che l'iscrizione al Corso di cui sopra risulta perfezionata a seguito della
                                            sottoscrizione del presente contratto;
                                        </span>
                                    </li>
                                    <li class="font-bold">
                                        <span class="l_label">
                                            di impegnarsi alla frequenza del corso per tutta la sua durata, pari a <span class="font-bold">tot. monte ore del corso</span>,
                                            e di assumere l'obbligo di pagare, nei termini di seguito stabiliti, l'intero costo del corso che
                                            è fissato in <span class="font-bold">€ prezzo</span>, <!-- PIU' <strong> 200 EURO</strong> QUOTA ESAME E PIU <strong>58 EURO</strong> ANNUE di QUOTA ASSICURATIVA della--> del
                                            quale pertanto si riconosce interamente debitore. Ciò, anche nel caso di mancata frequenza per qualsiasi
                                            motivo o ragione, ivi compreso l'eventuale allontanamento d'autorità per indisciplina o altro, fatto salvo
                                            l'esercizio del diritto di recesso dal presente contratto, da esercitarsi entro e non oltre quindici giorni dalla
                                            data di inizio delle lezioni, a mezzo lettera raccomandata (anche anticipata via mail) da inoltrarsi a: Punto
                                            Formazione s.r.l. Via delle Industrie, 5 – 06034 Foligno;
                                        </span>
                                        <p class="l_label" style="margin-top: 7px!important;">
                                            il versamento della rata di frequenza sarà regolato in una delle seguenti 4 modalità, a scelta:
                                        </p><br>
                                        <div class="grid grid-cols-12 border orow ">
                                            <div class="col-1 l_label text-center">1</div>
                                            <div class="col-span-11 border-l"><span class="ps-1">Quota totale della rata di frequenza di €______ entro il __/__/____</span></div>
                                        </div>
                                        <div class="grid grid-cols-12 border orow ">
                                            <div class="col-1 l_label text-center">2</div>
                                            <div class="col-span-11 border-l">
                                                <div class="border-bottom ps-1" style="text-align: left">Quota d'iscrizione di €___________________ all'atto della stipula del contratto</div>
                                                <div class="ps-1" style="text-align: left">Rimanente importo di € _______________su totale del corso, al netto della quota di iscrizione (come sopra quantificata), da versare entro il__________________</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-12 border orow ">
                                            <div class="col-1 l_label text-center">3</div>
                                            <div class="col-span-11 border-l">
                                                <div class="ps-1 border-bottom" style="text-align: left">Quota di iscrizione €________________</div>
                                                <div class="ps-1" style="text-align: left;">n. ____ rate mensili di cui ___ da € ___ e l'ultima da _____€ da versare entro il __ del mese</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-12 border ">
                                            <div class="col-1 l_label text-center">4</div>
                                            <div class="col-span-11 border-l">
                                                <div class="ps-1 border-b" style="text-align: left"> <small class="uppercase text-red-600">(Riservato MFT)</small><br>
                                                    Quota iscrizione ogni anno formativo di € ______________</div>
                                                <div class="ps-1" style="text-align: left">n. __ rate mensili/anno da € ______________ da versare entro il 5 del mese</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-12 orow">
                                            <div class="col-span-1"></div>
                                            <div class="col-span-11"><span class="text-red-600" style="font-size:6.5pt;">BARRARE TABELLA DI INTERESSE</span></div>
                                        </div>
                                        <span class="l_label ms-4">I versamenti possono essere fatti diratamente presso la Segreteria Amministrativa del corso ovvero a mezzo bonifico bancario - <span class="font-bold ml-1">IBAN: IT21 I030 6921 7051 0000 0003 197</span></span>
                                    </li>
                                    <br>
                                    <li class="font-bold">
                                        <span class="l_label">
                                            di essere consapevole che il mancato adempimento, nei termini di cui sopra, anche di un solo pagamento può comportare, ad esclusiva discrezionalità della Società, la propria sospensione dal corso e/o la non ammissione agli esami finali fino alla regolarizzazione delle inadempienze amministrative; di essere, altresì, consapevole che il mancato adempimento contrattuale potrà comportare anche la possibilità per la Società di agire immediatamente in sede giudiziale e/o esecutiva, per il recupero dell'intero importo dovuto;
                                        </span>
                                    </li>
                                    <li class="font-bold"><span class="l_label">di esonerare la Società da ogni responsabilità e/o richiesta anche risarcitoria in merito al punto precedente;</span></li>
                                    <li class="font-bold"><span class="l_label">di accettare la competenza esclusiva del Foro di Perugia per ogni controversia possa insorgere,
                                        nell'interpretazione e/o esecuzione del presente contratto;</span></li><br>
                                    <li class="font-bold"><span class="l_label">di aver ricevuto informativa sul trattamento dei dati personali a norma del D.Lgs. 196/2003 e successive modifiche da cui risulta che titolare del trattamento dei dati personali è il legale rappresentante p.t. di Punto Formazione s.r.l con sede a Foligno via delle Industrie n. 5 e di esprimere il proprio consenso rispetto alla raccolta ed al trattamento dei dati personali, anche sensibili, da parte della citata Società, anche allo specifico fine di dare attuazione alle convenzioni stipulate con Enti pubblici e/o privati per l'espletamento del periodo di tirocinio pratico necessario al completamento dell'iter formativo del Corso;</span></li>
                                    <li class="font-bold"><span class="l_label">di esprimere il consenso alla trasmissione dei propri dati personali, anche sensibili, da parte di Punto Formazione s.r.l. agli Enti pubblici e/o privati con i quali sono state stipulate convenzioni per l'espletamento del periodo di tirocinio pratico, allo specifico fine di consentire lo svolgimento di tale periodo di tirocinio, nonché a soggetti pubblici, quando ne facciano richiesta, per il perseguimento dei propri fini istituzionali ed a soggetti pubblici e/o privati che — successivamente al conseguimento del diploma — inoltrino all'istituto richieste relative alla selezione, ricerca e/o assunzione di odontotecnici diplomati.</span></li>
                                </ol>
                            </p>
                            <div id="fullwrap" class="mt-4 ">
                                <p class="pt-3 font-bold">Letto, confermato e sottoscritto.</p>
                            </div>
                            <div id="fullwrap" class="mt-4 ">
                                <p class="pt-3 font-bold">Foligno, lì __/__/____</p>
                            </div>
                            <div id="fullwrap" class="mt-4 ">
                                <p class="pt-3 font-bold">FIRMA ___________________</p>
                            </div>
                            <p class="mt-2">Confermo integralmente quanto sopra dichiarato e l'accettazione, anche ai sensi degli artt. 1341 e 1342 c.c., di ogni specifico punto, ivi compreso il riconoscimento del debito di cui al punto c); la presa visione ed accettazione del contenuto del Regolamento del corso e del Regolamento relativo al periodo di tirocinio; l'obbligo, di pagamento dell'intera rata, anche in caso di ritiro dalla frequenza del corso; le modalità di esercizio della facoltà di -recesso; la possibilità della sospensione dalle lezioni e/o della non ammissione agli esami da parte della Società anche in caso di mancato pagamento di una sola rata della rata nonché la possibilità per la stessa di agire immediatamente per il recupero del credito; il foro competente per le controversie.</p>
                            <div id="fullwrap" class="mt-4 ">
                                <p class="pt-3 font-bold">Foligno, lì __/__/____</p>
                            </div>
                            <div id="fullwrap" class="ms-0 mt-4 container text-start">

                                <div class="row pt-3 ms-0 font-bold ">
                                    <div class="col ms-0"><p>FIRMA ___________________</p></div>
                                </div>
                                <div class="row pt-3 ms-0 font-bold text-end">
                                    <div class="col ms-0"><p>Visto per PUNTO FORMAZIONE _________________________</p></div>
                                </div>
                            </div>
                            <div class="mt-5 pt-3 text-start font-bold">Per accettazione dell'iscrizione da parte della Società</div>
                            <div id="fullwrap" class="mt-4 ">
                                <p class="pt-3 font-bold">Foligno, lì __/__/____</p>
                            </div>
                            <div id="fullwrap" class="ms-0 mt-4 container text-start">
                                <div class="row pt-3 ms-0 font-bold ">
                                    <div class="col ms-0"><p>TIMBRO E FIRMA ___________________</p></div>
                                </div>
                                <div class="row pt-3 ms-0 font-bold text-end">
                                    <div class="col ms-0"><p>Visto per PUNTO FORMAZIONE _________________________</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
{{-- if per norme in footer/pie di pagina, attendere pf per testo corretto --}}
