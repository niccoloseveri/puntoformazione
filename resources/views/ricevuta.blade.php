<!doctype html>
<html lang="it" class="w-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Stampa Ricevuta</title>
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
            text-align:left!important;
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
                        PI 03237430545<br><br><br>
                        <span class="titlex bg-blue-200 p-1.5 border border-black">RICEVUTA DI VERSAMENTO</span>
                    </div>

                </div>

        <!-- FINE INTESTAZIONE -->
        <div class="text-left">
            <div class="mt-3">
                <span class="font-bold">
                    Con la presente si attesta che:
                </span>
            </div>
            <div class="mt-3 ml-10">
                <div class="inline-block border border-black m-1 p-1.5">
                    <span class="font-bold">
                        Cognome:
                    </span>
                    <span class="font-normal">
                        {{$user->surname ?? '________________________'}}
                    </span>
                </div><br>
                <div class="inline-block border border-black m-1 p-1.5">
                    <span class="font-bold">
                        Nome:
                    </span>
                    <span class="font-normal">
                        {{$user->name ?? '________________________'}}
                    </span><br>
                </div>
            </div>
            <div class="mt-3">
                <span class="font-bold">
                    Iscritto al:
                </span>
            </div>
            <div class="mt-3 ml-10">
                <div class="inline-block border border-black m-1 p-1.5">
                    <span class="font-bold">
                        Corso di formazione:
                    </span>
                    <span class="font-normal">
                        {{$payment->course->name ?? '________________________'}}
                        @if ($payment->classrooms_id)
                            Sez. {{ $payment->classroom->name ?? '________________________'}}
                        @endif
                    </span>
                </div><br>
            </div>
            <div class="mt-3">
                ha versato in data odierna la somma di:
            </div>
            <div class="mt-3 ml-10">
                <div class="inline-block">
                    <span>
                        Euro:
                    </span>
                    <span class="font-normal border border-black m-1 p-1.5">
                        {{$payment->amount_paid ?? '________________________'}}
                    </span>
                    <span class="ml-3">
                        In lettere:
                    </span>
                    <span class="font-normal border border-black m-1 p-1.5">
                        {{Number::spell($payment->amount_paid)}}
                    </span>
                </div><br>
                <div class="inline-block mt-8">
                    <span>Metodo di pagamento:</span>
                    <span class="font-normal border border-black m-1 p-1.5">
                        {{$payment->payment_method ?? '________________________'}}
                    </span>
                </div><br>
                <div class="inline-block mt-20">
                    <span>per </span>
                    <span class="font-normal border border-black m-1 p-1.5">
                        @if ($sub->paymentoptions->name == 'Rateale')
                            Pagamento rateale – Rata n. {{$payment->n_rata ?? '___'}} di {{$sub->tot_rate ?? '___'}}
                        @elseif ($sub->paymentoptions->name == 'Unica Soluzione')
                            {{'Pagamento in unica soluzione'}}
                        @elseif($sub->paymentoptions->name == 'Iscrizione + Rateale')
                            Quota di iscrizione + Rata n. {{$payment->n_rata ?? '___'}} su {{$sub->tot_rate ?? '___'}}
                        @elseif ($sub->paymentoptions->name == 'MFT Rateale')
                            Rata MFT n. {{$payment->n_rata ?? '___'}} su {{$sub->tot_rate ?? '___'}}
                        @else
                            {{$payment->note ?? '______________________________________________'}}
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <br><br>
        <div class="grid grid-cols-2 justify-between items-center">
            <div class="text-start"><p class="text-base">Foligno, {{date('d/m/Y')}}</p></div>
            <div class="text-end"><p class="text-base text-center">FIRMA <b>PUNTO FORMAZIONE SRL</b><br><br>_____________________________</p></div>
        </div>
