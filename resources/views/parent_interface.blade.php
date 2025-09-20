<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran - Espace Parents</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .sessions {
      white-space: pre-wrap; /* Maintenir les sauts de ligne */
    }

    .dropdown {
      margin: 20px 0;
      position: relative;
      display: inline-block;
    }

    .dropdown label {
      font-weight: bold;
      margin-right: 10px;
    }

    .dropdown select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #f9f9f9;
      font-size: 16px;
      transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    .dropdown select:focus {
      outline: none;
      border-color: #007bff;
      background-color: #eaf4ff;
    }

    .dropdown::after {
      content: '\25BC'; /* Code pour une flèche vers le bas */
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      font-size: 12px;
      color: #aaa;
      pointer-events: none;
    }

    
    .header .user-info {
      display: flex;
      align-items: center;
    }

    .header .user-info .parent-name {
      margin-right: 20px;
    }

    .header .user-info .logout-button {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    .header .user-info .logout-button:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
  <div class="app">
    <header class="header">
      <div class="title">Pronote Ifran - Espace Parents</div>
      <div class="user-info">
        <div class="parent-name">{{ $parentNom }} {{ $parentPrenom }}</div>
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
            <span class="icon">&#128100;</span> Absences
          </li>
        </ul>
      </aside>

      <main class="main-content">
        <!-- Dropdown pour sélectionner l'enfant -->
        <div class="dropdown">
          <label for="enfant">Sélectionner un enfant :</label>
         <select id="enfant" name="enfant">
  @foreach ($eleves as $enfant)
    <option value="{{ $enfant->id }}">{{ $enfant->nom }} {{ $enfant->prenom }}</option>
  @endforeach
</select>

        </div>

        <!-- Affichage de l'emploi du temps -->
<div class="timetable">
  <table id="emploi-table">
    <thead>
      <tr>
        <th>Jour</th>
        @foreach(array_keys($emploiDuTemps) as $date)
          <th>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody id="emploi-body">
      <tr>
        <td>MATIN 9H00 - 12H00</td>
        @foreach($emploiDuTemps as $date => $sessions)
          <td class="sessions">
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
          <td class="sessions">
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
<script>
const selectEnfant = document.getElementById('enfant');
const emploiBody = document.getElementById('emploi-body');

selectEnfant.addEventListener('change', async () => {
    const enfantId = selectEnfant.value;

    try {
        const response = await fetch(`/parent/emploi/${enfantId}`);
        const data = await response.json();

        if(data.success){
            // Reconstruire le tbody du tableau
            let html = '';

            // Matin
            html += '<tr><td>MATIN 9H00 - 12H00</td>';
            data.emploiDuTemps.forEach(date => {
                html += '<td class="sessions">';
                date.matin.forEach(seance => {
                    html += seance.module + '<br>' + seance.enseignant + '<br>';
                });
                html += '</td>';
            });
            html += '</tr>';

            // Après-midi
            html += '<tr><td>APRES-MIDI 14H00 - 17H00</td>';
            data.emploiDuTemps.forEach(date => {
                html += '<td class="sessions">';
                date.soir.forEach(seance => {
                    html += seance.module + '<br>' + seance.enseignant + '<br>';
                });
                html += '</td>';
            });
            html += '</tr>';

            emploiBody.innerHTML = html;
        }
    } catch (err) {
        console.error(err);
    }
});
</script>

</html>
