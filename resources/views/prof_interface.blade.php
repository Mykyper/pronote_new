<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran - Enseignant</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
    .header-right {
      display: flex;
      align-items: center;
    }

    .role {
      font-size: 16px;
      font-weight: bold;
      margin-right: 20px;
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

    .modify-button {
      margin: 20px;
      padding: 10px 20px;
      border-radius: 4px;
      border: none;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }

    .modify-button:hover {
      background-color: #0069d9;
    }
  </style>
</head>

<body>
  <div class="app">
    <!-- Header -->
    <header class="header">
      <div class="title">Pronote Ifran</div>
      <div class="header-right">
        <div class="role">{{ $teacherName }}</div>
        <form action="{{ route('teacher.logout') }}" method="POST">
          @csrf
          <button type="submit" class="logout-button">Déconnexion</button>
        </form>
      </div>
    </header>

    <!-- Layout -->
    <div class="layout">
      <!-- Sidebar -->
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

      <!-- Main content -->
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

                  <!-- Matin -->
                  <td>
                    @if(isset($sessions['matin']))
                      @foreach($sessions['matin'] as $session)
                        <a href="{{ url('presence/' . $session->id) }}">
                          {{ $session->module->nom ?? 'Module inconnu' }}<br>
                          {{ $session->classe->niveau ?? '' }} {{ $session->classe->specialité ?? '' }}<br>
                        </a>
                      @endforeach
                    @endif
                  </td>

                  <!-- Après-midi -->
                  <td>
                    @if(isset($sessions['soir']))
                      @foreach($sessions['soir'] as $session)
                        <a href="{{ url('presence/' . $session->id) }}">
                          {{ $session->module->nom ?? 'Module inconnu' }}<br>
                          {{ $session->classe->niveau ?? '' }} {{ $session->classe->specialité ?? '' }}<br>
                        </a>
                      @endforeach
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>

   
  </div>
</body>

</html>
