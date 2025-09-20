<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer l'Emploi du Temps</title>
<link rel="stylesheet" href="{{ asset('css/interface.css') }}">
<link rel="stylesheet" href="{{ asset('css/emploi.css') }}">
<style>
    .timetable-container {
        overflow-x: auto;
        margin-top: 20px;
    }
    table.timetable {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 5px;
        overflow: hidden;
    }
    table.timetable th,
    table.timetable td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    table.timetable th {
        background-color: #007bff;
        color: white;
    }
    select, input[type="date"] {
        width: 90%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
</style>
</head>
<body>
<header class="header">
    <div class="title">Pronote Ifran</div>
    <div class="role">Coordinateur</div>
</header>

<div class="layout">
    <aside class="sidebar">
        <ul>
            <li class="menu-item active"><span class="icon">&#128197;</span> Emploi du temps</li>
            <li class="menu-item"><span class="icon">&#128202;</span> Graphiques</li>
            <li class="menu-item"><span class="icon">&#128100;</span> Absences</li>
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

            <div class="timetable-container">
                <table class="timetable">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Date</th>
                            <th>Module Matin</th>
                            <th>Enseignant Matin</th>
                            <th>Module Soir</th>
                            <th>Enseignant Soir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi'] as $day)
                        <tr>
                            <td>{{ $day }}</td>
                            <td><input type="date" name="schedule[{{ strtolower($day) }}][day]" required></td>
                            <td>
                                <select name="schedule[{{ strtolower($day) }}][morning_module_id]">
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ strtolower($day) }}][morning_teacher_id]">
                                    @foreach ($enseignants as $e)
                                        <option value="{{ $e->id }}">{{ $e->nom }} {{ $e->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ strtolower($day) }}][evening_module_id]">
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ strtolower($day) }}][evening_teacher_id]">
                                    @foreach ($enseignants as $e)
                                        <option value="{{ $e->id }}">{{ $e->nom }} {{ $e->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit">Enregistrer l'Emploi du Temps</button>
        </form>
    </main>
</div>
</body>
</html>
