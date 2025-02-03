<div>
    {{ config('app.name') }}<br>
    Di seguito i dati per registrare la propria presenza alle lezioni:<br>
    Nome e Cognome: {{$user->name}} {{$user->surname}}<br>
    email: {{$user->email}}<br>
    Password: {{str_replace(' ','',$user->name.'0000')}}<br>
    {{__("Ti consigliamo di salvare la password nel tuo dispositivo, in modo da velocizzare la procedura di accesso alle lezioni.")}}<br>
    {{__("Puoi utilizzare i seguenti link per scoprire come fare.")}}<br>
    <a href="https://support.apple.com/it-it/109016" target="_blank">iPhone/iPad: https://support.apple.com/it-it/109016</a><br>
    <a href="https://support.google.com/accounts/answer/6208650?hl=it&sjid=11351129362915313757-EU&co=GENIE.Platform%3DAndroid&oco=1#zippy=%2Cper-iniziare" target="_blank">Android: https://support.google.com/accounts/answer/6208650?hl=it</a><br>
    <small>{{ __("Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ingora pure il messaggio.") }}</small>
</div>
