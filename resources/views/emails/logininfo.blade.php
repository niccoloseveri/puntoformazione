
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-100 py-4 text-center">
            <h1 class="text-gray-800 text-lg font-semibold">PuntoFormazione</h1>
        </div>

        <!-- Body -->
        <div class="p-6 text-gray-700">
            <p class="mb-4">Di seguito i dati per registrare la propria presenza alle lezioni:</p>
            <p class="mb-2"><strong>Nome:</strong> {{$user->name}}</p>
            <p class="mb-2"><strong>Cognome:</strong> {{$user->surname}}</p>
            <p class="mb-2"><strong>Email:</strong> {{$user->email}}</p>
            <p class="mb-4"><strong>Password:</strong> {{str_replace(' ','',$user->name.'0000')}}</p>
            <p class="mb-4">
            {{__("Ti consigliamo di salvare la password nel tuo dispositivo, in modo da velocizzare la procedura di accesso alle lezioni.")}}<br>
            {{__("Puoi utilizzare i seguenti link per scoprire come fare.")}}<br>
            iPhone/iPad: <a href="https://support.apple.com/it-it/109016" target="_blank">https://support.apple.com/it-it/109016</a><br>
            Android:<a href="https://support.google.com/accounts/answer/6208650?hl=it&sjid=11351129362915313757-EU&co=GENIE.Platform%3DAndroid&oco=1#zippy=%2Cper-iniziare" target="_blank">https://support.google.com/accounts/answer/6208650?hl=it</a><br>
            </p>
            <p class="text-sm text-gray-600">
                Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ignora pure il messaggio.
            </p>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 py-3 text-center text-gray-500 text-xs">
            © 2025 PuntoFormazione. All rights reserved.
        </div>
    </div>
</body>
</html>
