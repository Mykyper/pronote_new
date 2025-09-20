<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pronote Ifran</title>
  <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
  <style>
    /* Bouton de déconnexion */
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

    /* Conteneur nom + bouton */
    .header-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .student-name {
      font-size: 16px;
      font-weight: bold;
      margin: 0;
    }

    /* Style "Aucun cours" */
    .empty-course {
      color: gray;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="title">Pronote Ifran- Espace Etudiant </div>
      <div class="header-right">
        <div class="student-name" id="student-name">Chargement...</div>
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
          <table id="timetable">
            <thead>
              <tr>
                <th>Jour</th>
                <!-- Colonnes dynamiques -->
              </tr>
            </thead>
            <tbody>
              <tr id="row-matin">
                <td>MATIN 9H00 - 12H00</td>
              </tr>
              <tr id="row-soir">
                <td>APRES-MIDI 14H00 - 17H00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <!-- Axios pour requêtes API -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", async () => {
      try {
        // Appel à l'API pour récupérer l'emploi du temps
        const response = await axios.get("{{ route('student.api.emploi') }}");

        console.log(response.data); // Debug : vérifier la réponse

        if (response.data.success) {
          const student = response.data.student;
          const emploiDuTemps = response.data.emploiDuTemps;

          // Afficher le nom de l'élève
          const studentNameDiv = document.getElementById("student-name");
          if (studentNameDiv && student?.prenom && student?.nom) {
            studentNameDiv.textContent = `${student.prenom} ${student.nom}`;
          } else {
            studentNameDiv.textContent = "Élève non trouvé";
          }

          // Sélection des lignes du tableau
          const headerRow = document.querySelector("#timetable thead tr");
          const rowMatin = document.getElementById("row-matin");
          const rowSoir = document.getElementById("row-soir");

          // Vider les anciennes colonnes
          headerRow.innerHTML = "<th>Jour</th>";
          rowMatin.innerHTML = "<td>MATIN 9H00 - 12H00</td>";
          rowSoir.innerHTML = "<td>APRES-MIDI 14H00 - 17H00</td>";

          // Ajout dynamique des colonnes pour chaque date
          Object.keys(emploiDuTemps).forEach(date => {
            // Ajouter l'entête
            const th = document.createElement("th");
            th.textContent = new Date(date).toLocaleDateString("fr-FR");
            headerRow.appendChild(th);

            // Colonnes matin
            const tdMatin = document.createElement("td");
            if (emploiDuTemps[date].matin.length > 0) {
              emploiDuTemps[date].matin.forEach(seance => {
                tdMatin.innerHTML += `${seance.module.nom}<br>${seance.enseignant.nom}<br>`;
              });
            } else {
              tdMatin.textContent = "Aucun cours";
              tdMatin.classList.add("empty-course");
            }
            rowMatin.appendChild(tdMatin);

            // Colonnes soir
            const tdSoir = document.createElement("td");
            if (emploiDuTemps[date].soir.length > 0) {
              emploiDuTemps[date].soir.forEach(seance => {
                tdSoir.innerHTML += `${seance.module.nom}<br>${seance.enseignant.nom}<br>`;
              });
            } else {
              tdSoir.textContent = "Aucun cours";
              tdSoir.classList.add("empty-course");
            }
            rowSoir.appendChild(tdSoir);
          });

        } else {
          alert(response.data.message || "Impossible de charger l'emploi du temps");
        }

      } catch (error) {
        console.error("Erreur API:", error);
        alert("Erreur lors du chargement de l'emploi du temps");
      }
    });
  </script>
</body>

</html>
