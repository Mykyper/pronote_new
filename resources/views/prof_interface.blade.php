<!DOCTYPE html>
<html lang="en">

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

    /* Style pour le nom du professeur */
    .role {
      font-size: 16px;
      font-weight: bold;
      margin-right: 20px;
    }

    /* Style pour le bouton de déconnexion */
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
  </style>
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="title">Pronote Ifran</div>
      <div class="header-right">
        <div class="role">{{ $teacherName }}</div>
        <form action="{{ route('logout') }}" method="POST">
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
          <li class="menu-item">
            <span class="icon">&#128202;</span> Graphiques
          </li>
          <li class="menu-item">
            <span class="icon">&#128100;</span> Absences
          </li>
        </ul>
      </aside>

      <main class="main-content">
        <div class="timetable">
          <h2>Emploi du temps</h2>
          <table id="timetable-content">
            <thead>
              <tr>
                <th>Jour</th>
                <th>Matin</th>
                <th>Après-midi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($emploiDuTemps as $date => $sessions)
                <tr>
                  <td>{{ $date }}</td>
                  <td>
                    @foreach($sessions as $session)
                      @if($session->periode === 'matin')
                        <a href="{{ url('presence/' . $session->id) }}">
                          {{ $session->module->nom }}<br>
                          {{ $session->classe->niveau }} {{ $session->classe->specialité }}<br>
                        </a>
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach($sessions as $session)
                      @if($session->periode === 'soir')
                        <a href="{{ url('presence/' . $session->id) }}">
                          {{ $session->module->nom }}<br>
                          {{ $session->classe->niveau }} {{ $session->classe->specialité }}<br>
                        </a>
                      @endif
                    @endforeach
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>
    <button class="modify-button">Modifier</button>
  </div>
</body>

</html>
