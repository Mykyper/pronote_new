<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
 
    .header-right {
      display: flex;
      align-items: center;
    }

    
    .logout-button {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .logout-button:hover {
      background-color: #c82333;
    }

    /* Style pour le nom de l'élève */
    .student-name {
      font-size: 16px;
      font-weight: bold;
      margin-right: 20px; /* Espacement entre le nom de l'élève et le bouton de déconnexion */
    }
  </style>
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="title">Pronote Ifran</div>
      <div class="header-right">
        <div class="student-name">{{ $studentName }}</div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="logout-button">Déconnexion</button>
        </form>
      </div>
    </header>

    <div class="layout">
      <aside class="sidebar">
        <ul>
          <li class="menu-item active">
            <span class="icon">&#128197;</span> Emploi du temps
          </li>
         
        </ul>
      </aside>

      <main class="main-content">
        <div class="timetable">
          <table>
            <thead>
              <tr>
                <th>Jour</th>
                @foreach(array_keys($emploiDuTemps) as $date)
                  <th>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>MATIN 9H00 - 12H00</td>
                @foreach($emploiDuTemps as $date => $sessions)
                  <td>
                    @foreach($sessions['matin'] as $seance)
                      {{ $seance->module->nom }}<br>
                      {{ $seance->enseignant->nom }}<br>
                    @endforeach
                  </td>
                @endforeach
              </tr>
              <tr>
                <td>APRES-MIDI 14H00 - 17H00</td>
                @foreach($emploiDuTemps as $date => $sessions)
                  <td>
                    @foreach($sessions['soir'] as $seance)
                      {{ $seance->module->nom }}<br>
                      {{ $seance->enseignant->nom }}<br>
                    @endforeach
                  </td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>

</html>
