<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
    /* Styles pour les boutons de graphiques */
    .graph-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px; /* Espacement entre les boutons */
      margin-top: 20px; /* Marge au-dessus des boutons */
    }

    .graph-buttons button {
      background-color: #007bff; /* Couleur de fond */
      color: white; /* Couleur du texte */
      border: none; /* Supprime les bordures par défaut */
      border-radius: 5px; /* Coins arrondis */
      padding: 10px 20px; /* Espacement interne */
      font-size: 16px; /* Taille de la police */
      cursor: pointer; /* Curseur pointeur au survol */
      transition: background-color 0.3s, transform 0.2s; /* Transition pour l'effet de survol */
    }

    .graph-buttons button:hover {
      background-color: #0056b3; /* Couleur de fond au survol */
      transform: scale(1.05); /* Légère augmentation de la taille au survol */
    }

    .graph-buttons button:focus {
      outline: none; /* Supprime le contour par défaut au focus */
    }

    .graph-buttons button:active {
      background-color: #004085; /* Couleur de fond au clic */
    }
  </style>
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="title">Pronote Ifran</div>
      <div class="role">Coordinateur</div>
    </header>

    <div class="layout">
      <aside class="sidebar">
        <ul>
          <li class="menu-item active">
            <a href="/coordinator-interface/{classId?}"><span class="icon">&#128197;</span> Emploi du temps</a>
            
          </li>
          <li class="menu-item">
            <span class="icon">&#128202;</span> Graphiques
          </li>
          <li class="menu-item">
            <a href="/emplois-du-temps/create">Créer emploi du temps</a> 
          </li>
          <li class="menu-item">
            <a href="/modules/create">Créer Module</a> 
          </li>
        </ul>
      </aside>
      <main class="content">
        <h1>Graphiques</h1>
        <div class="graph-buttons">
          <button onclick="window.location.href='{{ route('taux_par_classe') }}'">Taux de Présence par Classe</button>
          <button onclick="window.location.href='{{ route('taux_par_module') }}'">Taux de Présence par Module</button>
        </div>
      </main>
    </div>
  </div>
</body>

</html>
