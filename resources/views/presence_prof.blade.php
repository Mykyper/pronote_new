<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
    .form-group {
      margin-bottom: 20px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f9f9f9;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }
    .form-group div {
      margin-bottom: 15px;
    }
    .form-group input[type="radio"] {
      margin-right: 10px;
    }
    .form-group .radio-label {
      display: inline-block;
      margin-right: 15px;
    }
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #0056b3;
    }
    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
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
            <a href="/teacher/interface"><span class="icon">&#128197;</span> Emploi du temps</a>
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
        <h2>Gestion des Présences</h2>

        <!-- Formulaire pour marquer les présences -->
        <form id="presenceForm">
          @csrf
          <input type="hidden" name="seance_id" value="{{ $sessionId }}">

          @foreach($eleves as $eleve)
            <div class="form-group">
              <label for="eleve_{{ $eleve->id }}">{{ $eleve->nom }}</label>
              <div>
                <label class="radio-label">
                  <input type="radio" name="presences[{{ $eleve->id }}]" value="présent" required> Présent
                </label>
                <label class="radio-label">
                  <input type="radio" name="presences[{{ $eleve->id }}]" value="absent" required> Absent
                </label>
                <label class="radio-label">
                  <input type="radio" name="presences[{{ $eleve->id }}]" value="retard" required> Retard
                </label>
              </div>
            </div>
          @endforeach

          <button type="submit">Enregistrer</button>
        </form>

        <!-- Zone pour afficher le message de retour -->
        <div id="response-message"></div>
      </main>
    </div>
  </div>

  <script>
    const form = document.getElementById('presenceForm');
    const responseMessage = document.getElementById('response-message');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(form);
      const json = { presences: {}, seance_id: formData.get('seance_id') };

      formData.forEach((value, key) => {
        const match = key.match(/^presences\[(\d+)\]$/);
        if (match) {
          json.presences[match[1]] = value;
        }
      });

      try {
        const response = await fetch('/api/presences/store', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify(json)
        });

        const data = await response.json();
        responseMessage.innerHTML = '';

        if (data.success) {
          responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }

      } catch (err) {
        console.error(err);
        responseMessage.innerHTML = `<div class="alert alert-danger">Erreur serveur</div>`;
      }
    });
  </script>
</body>
</html>
