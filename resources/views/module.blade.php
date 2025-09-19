<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Module</title>
    <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="title">Pronote Ifran</div>
         
        </header>

        <div class="layout">
            <aside class="sidebar">
                <ul>
                    <li class="menu-item active">
                        <span class="icon">&#128197;</span> Emploi du temps
                    </li>
                    <li class="menu-item">
                        <span class="icon">&#128202;</span> Graphiques
                    </li>
                    <li class="menu-item">
                        <span class="icon">&#128100;</span> Absences
                    </li>
                </ul>
            </aside>
            <main>
                <h1>Créer un Module</h1>
                <form id="create-module-form" action="{{ route('modules.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="nom">Nom du Module :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <button type="submit">Créer le Module</button>
                </form>
                @if (session('success'))
                    <p>{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>

</html>