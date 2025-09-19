<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/Accueil.css') }}">
</head>

<body>
    <header>
        <h1>
            Pronote IFRAN
        </h1>
    </header>
    <main>
        <div class="log">
    <ul>
        <li class="list-item">
            <a href="/student-log">
                <img src="{{ asset('img/child-solid.svg') }}" alt="" class="icon-student">
                <h2>Etudiant</h2>
            </a>
        </li>
        <li class="list-item">
            <a href="/parent-log">
                <img src="{{ asset('img/pere-et-fils.png') }}" alt="">
                <h2>Parent</h2>
            </a>
        </li>
        <li class="list-item">
            <a href="/teacher/login">
                <img src="{{ asset('img/livre.png') }}" alt="">
                <h2>Enseignant</h2>
            </a>
        </li>
        <li class="list-item">
            <a href="/coordinator-log">
                <img src="{{ asset('img/chapeau-de-fin-detudes.png') }}" alt="">
                <h2>Coordinateur</h2>
            </a>
        </li>
        <li class="list-item">
            <a href="/admin">
                <img src="{{ asset('img/ordinateur.png') }}" alt="">
                <h2>Admin</h2>
            </a>
        </li>
    </ul>
</div>

    </main>
</body>

</html>
