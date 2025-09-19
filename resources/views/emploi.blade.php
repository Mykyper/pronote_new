<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer l'Emploi du Temps</title>
    <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
    <link rel="stylesheet" href="{{ asset('css/emploi.css') }}">
</head>
<body>
    <header class="header">
        <div class="title">Pronote Ifran</div>
        <div class="role">Coordinateur</div>
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
            <h1>Créer l'Emploi du Temps</h1>
            <form action="{{ route('schedule.store') }}" method="POST" id="schedule-form">
                @csrf
                <div class="form-section">
                    <label for="class">Classe :</label>
                    <select id="class" name="class_id" required style="width: 150px;">
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->niveau }} - {{ $classe->specialité }}</option>
                        @endforeach
                    </select>
                </div>
                <fieldset>
                    <legend>Emploi du Temps</legend>
                    <div id="schedule-days">
                        <!-- Les jours seront automatiquement affichés ici -->
                    </div>
                </fieldset>

                <button type="submit">Enregistrer l'Emploi du Temps</button>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scheduleDaysContainer = document.getElementById('schedule-days');
            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

            days.forEach(day => {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('day-schedule');
                dayDiv.innerHTML = `
                    <div class="form-section">
                        <label for="${day.toLowerCase()}">${day} :</label>
                        <input type="date" id="${day.toLowerCase()}" name="schedule[${day.toLowerCase()}][day]" required>
                    </div>
                    <div class="form-section">
                        <label for="${day.toLowerCase()}-morning-module">Module Matin :</label>
                        <select id="${day.toLowerCase()}-morning-module" name="schedule[${day.toLowerCase()}][morning_module_id]">
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->nom }}</option>
                            @endforeach
                        </select>
                        <label for="${day.toLowerCase()}-morning-teacher">Enseignant Matin :</label>
                        <select id="${day.toLowerCase()}-morning-teacher" name="schedule[${day.toLowerCase()}][morning_teacher_id]">
                            @foreach ($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-section">
                        <label for="${day.toLowerCase()}-evening-module">Module Soir :</label>
                        <select id="${day.toLowerCase()}-evening-module" name="schedule[${day.toLowerCase()}][evening_module_id]">
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->nom }}</option>
                            @endforeach
                        </select>
                        <label for="${day.toLowerCase()}-evening-teacher">Enseignant Soir :</label>
                        <select id="${day.toLowerCase()}-evening-teacher" name="schedule[${day.toLowerCase()}][evening_teacher_id]">
                            @foreach ($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                `;
                scheduleDaysContainer.appendChild(dayDiv);
            });
        });
    </script>
</body>
</html>