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
                @csrf
                <h1>
                    <img src="{{ asset('img/livre.png') }}" alt="Login Icon" class="login-icon">
                    Espace Enseignant
                </h1>
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
            const token = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch('/teacher-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (data.success) {
                    // Redirection vers le dashboard dynamique
                    window.location.href = data.redirect;
                } else {
                    errorsDiv.style.display = 'block';
                    errorsDiv.innerText = data.message || 'Erreur inconnue';
                }
            } catch (err) {
                errorsDiv.style.display = 'block';
                errorsDiv.innerText = 'Erreur serveur';
                console.error(err);
            }
        });
    </script>
</body>

</html>
