<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Etudiant</title>
    <link rel="stylesheet" href="{{ asset('css/Accueil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header>
        <h1>Pronote IFRAN</h1>
    </header>
    <main>
        <div class="log">
           <form class="login-form" id="student-login-form">
               @csrf
               <h1>
                   <img src="{{ asset('img/child-solid.svg') }}" alt="Login Icon" class="login-icon"> 
                   Espace Etudiant
               </h1>
               <label for="email">E-mail :</label>
               <input type="email" id="email" name="email" required>
               <label for="password">Mot de passe :</label>
               <input type="password" id="password" name="password" required>
               <button type="submit">Se connecter</button>
               <p id="error-message" style="color:red;margin-top:10px;"></p>
           </form>
        </div>
    </main>

    <script>
    document.getElementById("student-login-form").addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const errorMessage = document.getElementById("error-message");

        try {
            const response = await fetch("{{ route('student.login') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (data.success) {
                // Redirection automatique vers le dashboard
                window.location.href = data.redirect;
            } else {
                errorMessage.textContent = data.message || "Identifiants incorrects";
            }
        } catch (err) {
            console.error(err);
            errorMessage.textContent = "Erreur serveur, veuillez réessayer.";
        }
    });
    </script>
</body>
</html>
