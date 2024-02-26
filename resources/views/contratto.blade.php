<!doctype html>
<html lang="it" class="full">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stampa Contratto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
          font-weight: normal;
          font-style: normal;
        }

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

        /*
        body {
          margin-top:2.3cm!important;
          margin-left: 2.9cm!important;
          margin-right: 2.07cm!important;
          margin-bottom: 0.78cm!important;
        }
        */
        * > div {
          justify-content: center;
          align-items: center;
        }

        * > p {
          font-size:8.5pt;
        }

        .full {
          width: 100%!important;
        }

        .l1 {
          text-align:left;
          float: left;
        }

        .r1 {
          float: right;
          text-align:right;
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


    </style>

  </head>

  <body class="full">
    <div class="container-fluid text-center full" id="pagec">
      <!-- INTESTAZIONE -->
      <div class="row full" id="intestazione">
        <div class="col l1 full">
          <img id="logo" alt="image" src="{{asset('Image_001.png') }}"/>
        </div>
        <div class="col r1 full" style="width:fit-content;">
          Punto Formazione SRL<br>
          Via delle Industrie 5 - 06034 Foligno (PG)<br>
          Tel/Fax 0742.340904 - <u>info@puntoformazione.net</u><br>
          PI 03237430545<br><br>
          Rev.01 del 13/02/2018
        </div>
      </div>
      <br>
      <!-- FINE INTESTAZIONE -->
      <!-- SEZIONE 1 - ANAGRAFICA -->
      <div class="row full">
        <div class="col full" style="transform: translateY(-1mm)!important;">
          <span class="titlex bold">
            ISCRIZIONE AI CORSI DI FORMAZIONE PROFESSIONALE
          </span>
          <br>
          <br>
          <div id="fullwrap" class="full">
            <p style="margin-top:10px; text-align:justify;">
              Il sottoscritto <strong>{{__('ciao')}}</strong>, nato a <strong>{{__('ciao')}}</strong>, il <strong>{{__('ciao')}}</strong>,<br>
              residente a <strong>{{__('ciao')}}</strong>, Via <strong>{{__('ciao')}}</strong>,
              CAP <strong>{{__('ciao')}}</strong>,<br> Cod. Fisc <strong>{{__('ciao')}}</strong>, in possesso del Licenza Scuola
              dell'Obbligo (d'ora in avanti "Allievo")
            </p>
            <span class="bold">
              chiede
            </span>
            <br>
            <p style="margin-top: 15px!important; margin-bottom:15px!important;">
              di essere iscritto al Corso per OPERATORE SOCIO SANITARIO di cui alla legge 17/07/2002 n.13 corso accreditato con DGR
              n. 1005 del 04/08/2014 e inserito nel piano DGR n. 879 del 02/08/2018, COD. CORSO 2/2021 SEZ U , gestito dall'ente
              formativo “Punto Formazione s.r.l.” con sede in Foligno, via delle Industrie, 5 (d'ora in avanti soltanto "Società"). A tal
              fine espressamente
            </p>
            <span class="bold">
              dichiara
            </span>
            <br>
            <p style="margin-top: 15px!important; margin-bottom:15px!important;">
              <ol id="letters" class="corpotxt">
                <li class="bold">
                  <span class="l_label">
                    di aver preso visione del Regolamento del Corso e del Regolamento relativo al tirocinio e di accettarne senza
                    alcuna eccezione e/o riserva, tutte le norme di carattere didattico, disciplinare e amministrativo,
                    espressamente impegnandosi (con la sottoscrizione del presente contratto) all'integrale rispetto delle stesse,
                    integrate dalle presenti norme contrattuali
                  </span>
                </li>
                <li class="bold">
                  <span class="l_label">
                    di essere a conoscenza del fatto che l'iscrizione al Corso di cui sopra risulta perfezionata a seguito della
                    sottoscrizione del presente contratto;
                  </span>
                </li>
                <li class="bold">
                  <span class="l_label">
                    di impegnarsi alla frequenza del corso per tutta la sua durata, pari a <span class="bold">__________________ore__________</span>,
                    e di assumere l'obbligo di pagare, nei termini di seguito stabiliti l'intera retta di frequenza, che
                    è fissata in <span class="bold">€ 3000/00</span>, PIU' 200 EURO QUOTA ESAME E PIU 58 EURO ANNUE di QUOTA ASSICURATIVA della
                    quale pertanto si riconosce interamente debitore. Ciò, anche nel caso di mancata frequenza per qualsiasi
                    motivo o ragione, ivi compreso l'eventuale allontanamento d'autorità per indisciplina o altro, fatto salvo
                    l'esercizio del diritto di recesso dal presente contratto, da esercitarsi entro e non oltre quindici giorni dalla
                    data di inizio delle lezioni, a mezzo lettera raccomandata (anche anticipata via mail) da inoltrarsi a: Punto
                    Formazione s.r.l. Via delle Industrie, 5 – 06034 Foligno;
                  </span>
                  <p class="l_label" style="margin-top: 7px!important;">
                    il versamento della retta di frequenza sarà regolato in una delle seguenti 4 modalità, a scelta:
                  </p><br>
                  <div class="row border orow">
                    <div class="col-1 l_label text-center ">1</div>
                    <div class="col-11 border-start"><span class="ps-1">Quota totale della retta di frequenza di €______ entro il __/__/____</span></div>
                  </div>
                  <div class="row border orow">
                    <div class="col-1 l_label text-center">2</div>
                    <div class="col border-start ">
                        <div class="border-bottom ps-1" style="text-align: left">Quota d'iscrizione di €___________________ all'atto della stipula del contratto</div>
                        <div class="ps-1" style="text-align: left">Rimanente importo di € _______________su totale del corso, al netto della quota di iscrizione (come sopra quantificata), da versare entro il__________________</div>
                    </div>
                  </div>
                  <div class="row border orow">
                    <div class="col-1 l_label text-center">3</div>
                    <div class="col border-start">
                        <div class="ps-1 border-bottom" style="text-align: left">Quota di iscrizione €________________</div>
                        <div class="ps-1" style="text-align: left;">n. ____ rate mensili di cui ___ da € ___ e l'ultima da _____€ da versare entro il __ del mese</div>
                    </div>
                  </div>
                  <div class="row border">
                    <div class="col-1 l_label text-center">4</div>
                    <div class="col border-start">
                        <div class="ps-1 border-bottom" style="text-align: left"> <small class="text-uppercase text-danger">(Riservato MFT)</small><br>
                            Quota iscrizione ogni anno formativo di € ______________</div>
                        <div class="ps-1" style="text-align: left">n. __ rate mensili/anno da € ______________ da versare entro il 5 del mese</div>
                    </div>
                  </div>
                  <div class="row orow">
                    <div class="col-1"></div>
                    <div class="col"><span class="text-danger" style="font-size:6.5pt;">BARRARE TABELLA DI INTERESSE</span></div>
                  </div>
                  <span class="l_label ms-4">I versamenti possono essere fatti direttamente presso la Segreteria Amministrativa del corso ovvero a mezzo bonifico bancario - <span class="fw-bold ms-4">IBAN: IT21 I030 6921 7051 0000 0003 197</span></span>
              </li><br>
              <li class="bold">
                <span class="l_label">
                    di essere consapevole che il mancato adempimento, nei termini di cui sopra, anche di un solo pagamento può comportare, ad esclusiva discrezionalità della Società, la propria sospensione dal corso e/o la non ammissione agli esami finali fino alla regolarizzazione delle inadempienze amministrative; di essere, altresì, consapevole che il mancato adempimento contrattuale potrà comportare anche la possibilità per la Società di agire immediatamente in sede giudiziale e/o esecutiva, per il recupero dell'intero importo dovuto;
                </span>
              </li>
              <li class="bold"><span class="l_label">di esonerare la Società da ogni responsabilità e/o richiesta anche risarcitoria in merito al punto precedente;</span></li>
              <li class="bold"><span class="l_label">di accettare la competenza esclusiva del Foro di Perugia per ogni controversia possa insorgere,
                nell'interpretazione e/o esecuzione del presente contratto;</span></li>
              <li class="bold"><span class="l_label">di aver ricevuto informativa sul trattamento dei dati personali a norma del D.Lgs. 196/2003 e successive modifiche da cui risulta che titolare del trattamento dei dati personali è il legale rappresentante p.t. di Punto Formazione s.r.l con sede a Foligno via delle Industrie n. 5 e di esprimere il proprio consenso rispetto alla raccolta ed al trattamento dei dati personali, anche sensibili, da parte della citata Società, anche allo specifico fine di dare attuazione alle convenzioni stipulate con Enti pubblici e/o privati per l'espletamento del periodo di tirocinio pratico necessario al completamento dell'iter formativo del Corso;</span></li>
              <li class="bold"><span class="l_label">di esprimere il consenso alla trasmissione dei propri dati personali, anche sensibili, da parte di Punto Formazione s.r.l. agli Enti pubblici e/o privati con i quali sono state stipulate convenzioni per l'espletamento del periodo di tirocinio pratico, allo specifico fine di consentire lo svolgimento di tale periodo di tirocinio, nonché a soggetti pubblici, quando ne facciano richiesta, per il perseguimento dei propri fini istituzionali ed a soggetti pubblici e/o privati che — successivamente al conseguimento del diploma — inoltrino all'istituto richieste relative alla selezione, ricerca e/o assunzione di odontotecnici diplomati.</span></li>
            </ol>

        </p>

        <div id="fullwrap" class="mt-4 ">
            <p class="pt-3 fw-bold">Letto, confermato e sottoscritto.</p>
        </div>
        <div id="fullwrap" class="mt-4 ">
            <p class="pt-3 fw-bold">Foligno, lì __/__/____</p>
        </div>
        <div id="fullwrap" class="mt-4 ">
            <p class="pt-3 fw-bold">FIRMA ___________________</p>
        </div>

        <p class="mt-2">Confermo integralmente quanto sopra dichiarato e l'accettazione, anche ai sensi degli artt. 1341 e 1342 c.c., di ogni specifico punto, ivi compreso il riconoscimento del debito di cui al punto c); la presa visione ed accettazione del contenuto del Regolamento del corso e del Regolamento relativo al periodo di tirocinio; l'obbligo, di pagamento dell'intera retta, anche in caso di ritiro dalla frequenza del corso; le modalità di esercizio della facoltà di -recesso; la possibilità della sospensione dalle lezioni e/o della non ammissione agli esami da parte della Società anche in caso di mancato pagamento di una sola rata della retta nonché la possibilità per la stessa di agire immediatamente per il recupero del credito; il foro competente per le controversie.</p>
        <div id="fullwrap" class="mt-4 ">
            <p class="pt-3 fw-bold">Foligno, lì __/__/____</p>
        </div>
        <div id="fullwrap" class="ms-0 mt-4 container text-start">

            <div class="row pt-3 ms-0 fw-bold ">
                <div class="col ms-0"><p>FIRMA ___________________</p></div>
            </div>
            <div class="row pt-3 ms-0 fw-bold text-end">
                <div class="col ms-0"><p>Visto per PUNTO FORMAZIONE _________________________</p></div>
            </div>
        </div>
        <div class="mt-5 pt-3 text-start fw-bold">Per accettazione dell'iscrizione da parte della Società</div>
        <div id="fullwrap" class="mt-4 ">
            <p class="pt-3 fw-bold">Foligno, lì __/__/____</p>
        </div>
        <div id="fullwrap" class="ms-0 mt-4 container text-start">

            <div class="row pt-3 ms-0 fw-bold ">
                <div class="col ms-0"><p>TIMBRO E FIRMA ___________________</p></div>
            </div>
            <div class="row pt-3 ms-0 fw-bold text-end">
                <div class="col ms-0"><p>Visto per PUNTO FORMAZIONE _________________________</p></div>
            </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
