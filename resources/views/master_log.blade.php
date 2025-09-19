<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Enseignant</title>
    <link rel="stylesheet" href="{{ asset('css/Accueil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header>
        <h1>Pronote IFRAN</h1>
    </header>
    <main>
        <div class="log">
            <form class="login-form" id="teacher-login-form">
                <h1><img src="{{ asset('img/livre.png') }}" alt="Login Icon" class="login-icon"> Espace Enseignant</h1>
                <div id="errors" class="alert alert-danger" style="display:none;"></div>

                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </main>

    <script>
        const form = document.getElementById('teacher-login-form');
        const errorsDiv = document.getElementById('errors');

        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Empêche le submit classique

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/api/teacher-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Connexion réussie
                    alert(data.message);
                    // Redirection possible vers une page front ou SPA
                    window.location.href = '/teacher-interface';
                } else {
                    // Affiche les erreurs
                    errorsDiv.style.display = 'block';
                    errorsDiv.innerHTML = data.message || 'Erreur inconnue';
                }
            } catch (error) {
                errorsDiv.style.display = 'block';
                errorsDiv.innerHTML = 'Erreur de connexion au serveur';
                console.error(error);
            }
        });
    </script>
</body>

</html>
