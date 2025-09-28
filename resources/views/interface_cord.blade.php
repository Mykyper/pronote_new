<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
</head>

<body>
  <div class="app">
  <header class="header">
    <div class="title">Pronote Ifran</div>
    <div class="role">Coordinateur</div>
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-button">Déconnexion</button>
    </form>
</header>


    <div class="layout">
      <aside class="sidebar">
        <ul>
          <li class="menu-item active">
            <span class="icon">&#128197;</span> Emploi du temps
          </li>
          <li class="menu-item">
            <a href="/graphiques">
              <span class="icon">&#128202;</span> Graphiques
            </a>
          </li>
          <li class="menu-item">
            <a href="/schedule/create">Créer emploi du temps</a> 
          </li>
          <li class="menu-item">
            <a href="/modules/create">Créer Module</a> 
          </li>
        </ul>
      </aside>

      <main class="main-content">
        <div class="tabs">
          <a href="{{ route('coord-inter', ['classId' => 1]) }}">
              <button class="tab {{ $classe && $classe->id == 1 ? 'active' : '' }}">PREPA CREA</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 2]) }}">
              <button class="tab {{ $classe && $classe->id == 2 ? 'active' : '' }}">PREPA COMM</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 3]) }}">
              <button class="tab {{ $classe && $classe->id == 3 ? 'active' : '' }}">PREPA DEV</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 4]) }}">
              <button class="tab {{ $classe && $classe->id == 4 ? 'active' : '' }}">B2 CREA</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 5]) }}">
              <button class="tab {{ $classe && $classe->id == 5 ? 'active' : '' }}">B2 COMM</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 6]) }}">
              <button class="tab {{ $classe && $classe->id == 6 ? 'active' : '' }}">B2 DEV</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 7]) }}">
              <button class="tab {{ $classe && $classe->id == 7 ? 'active' : '' }}">B3 CREA</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 8]) }}">
              <button class="tab {{ $classe && $classe->id == 8 ? 'active' : '' }}">B3 COMM</button>
          </a>
          <a href="{{ route('coord-inter', ['classId' => 9]) }}">
              <button class="tab {{ $classe && $classe->id == 9 ? 'active' : '' }}">B3 DEV</button>
          </a>
        </div>

        @if($classe)
    @if(isset($emploiDuTemps) && !empty($emploiDuTemps))
        <div class="timetable">
            <h2>Emploi du temps pour la classe {{ $classe->niveau }} - {{ $classe->specialite }}</h2>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        @foreach (array_keys($emploiDuTemps) as $date)
                            <th>{{ $date }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Matin -->
                    <tr>
                        <td>MATIN 9H00 - 12H00</td>
                        @foreach ($emploiDuTemps as $date => $seances)
                            <td>
                                @foreach ($seances['matin'] as $seance)
                                    {{ $seance->enseignant->nom }} <br>
                                    @if (in_array($seance->module->nom, ['Workshop', 'E-learning']))
                                        <a href="{{ route('presence_cord.details', ['seance_id' => $seance->id]) }}">
                                            {{ $seance->module->nom }}
                                        </a>
                                    @else
                                        {{ $seance->module->nom }}
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                    
                    <!-- Après-midi -->
                    <tr>
                        <td>APRES-MIDI 14H00 - 17H00</td>
                        @foreach ($emploiDuTemps as $date => $seances)
                            <td>
                                @foreach ($seances['soir'] as $seance)
                                    {{ $seance->enseignant->nom }} <br>
                                    @if (in_array($seance->module->nom, ['Workshop', 'E-learning']))
                                        <a href="{{ route('presence_cord.details', ['seance_id' => $seance->id]) }}">
                                            {{ $seance->module->nom }}
                                        </a>
                                    @else
                                        {{ $seance->module->nom }}
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="no-schedule">
            <p>L'emploi du temps pour la classe {{ $classe->niveau }} - {{ $classe->specialite }} n'est pas encore créé.</p>
        </div>
    @endif
@else
    <div class="no-class-selected">
        <p>Aucune classe sélectionnée. Veuillez sélectionner une classe pour voir l'emploi du temps.</p>
    </div>
@endif

        <button class="modify-button">Modifier</button>
      </main>
    </div>
  </div>
</body>

</html>
