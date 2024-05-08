<!doctype html>
<html lang="it" class="w-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Stampa Autorizzazione Whatsapp</title>
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

            <!-- SEZIONE 1 - ANAGRAFICA -->
            <div class="w-full mt-3">
                <div id="fullwrap" class="w-full">
                    @if ($user->genere == 'M')
                        <p>
                            Il sottoscritto <span class="font-bold">{{$user->full_name}}</span>, nato a <span class="font-bold">{{$user->luogo_nascita}}</span> in provincia di <span class="font-bold">{{$user->prov_nascita}}</span>, il <span class="font-bold">{{date('d/m/Y', strtotime($user->data_nascita))}}</span>, residente a <span class="font-bold">{{$user->citta}}</span>, Via <span class="font-bold">{{$user->via}}</span>, CAP <span class="font-bold">{{$user->cap}}</span>, Cod. Fisc <span class="font-bold">{{$user->cf}}</span>, in possesso del <span class="font-bold">{{$user->titolo_studio}}</span> (d'ora in avanti "Allievo")
                        </p>
                        <span class="font-bold text-sm">
                            Chiede
                        </span>
                        <p class="font-bold mt-2">
                            di essere inserito, con il n telefonico indicato nella Manifestazione di Interesse già sottoscritta, nel gruppo whatsapp di lavoro della Sezione di riferimento
                        </p>
                    @elseif ($user->genere == 'MF')
                        <p>
                            L* sottoscritt* <span class="font-bold">{{$user->full_name}}</span>, nat* a <span class="font-bold">{{$user->luogo_nascita}}</span> in provincia di <span class="font-bold">{{$user->prov_nascita}}</span>, il <span class="font-bold">{{date('d/m/Y', strtotime($user->data_nascita))}}</span>, residente a <span class="font-bold">{{$user->citta}}</span>, Via <span class="font-bold">{{$user->via}}</span>, CAP <span class="font-bold">{{$user->cap}}</span>, Cod. Fisc <span class="font-bold">{{$user->cf}}</span>, in possesso del <span class="font-bold">{{$user->titolo_studio}}</span> (d'ora in avanti "Alliev*")
                        </p>
                        <span class="font-bold text-sm">
                            Chiede
                        </span>
                        <p class="font-bold mt-2">
                            di essere inserit*, con il n telefonico indicato nella Manifestazione di Interesse già sottoscritta, nel gruppo whatsapp di lavoro della Sezione di riferimento
                        </p>
                    @else
                        <p>
                            La sottoscritta <span class="font-bold">{{$user->full_name}}</span>, nata a <span class="font-bold">{{$user->luogo_nascita}}</span> in provincia di <span class="font-bold">{{$user->prov_nascita}}</span>, il <span class="font-bold">{{date('d/m/Y', strtotime($user->data_nascita))}}</span>, residente a <span class="font-bold">{{$user->citta}}</span>, Via <span class="font-bold">{{$user->via}}</span>, CAP <span class="font-bold">{{$user->cap}}</span>, Cod. Fisc <span class="font-bold">{{$user->cf}}</span>, in possesso del <span class="font-bold">{{$user->titolo_studio}}</span> (d'ora in avanti "Allieva")
                        </p>
                        <span class="font-bold text-sm">
                            Chiede
                        </span>
                        <p class="font-bold mt-2">
                            di essere inserita, con il n telefonico indicato nella Manifestazione di Interesse già sottoscritta, nel gruppo whatsapp di lavoro della Sezione di riferimento
                        </p>
                    @endif
                    <br><br>
                    <div class="grid grid-cols-2 justify-between items-center font-bold">
                        <div class="text-start"><p>Foligno, il {{date('d/m/Y')}}</p></div>
                        <div class="text-end"><p class="text-center">In fede,<br><br>__________________________</p></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
