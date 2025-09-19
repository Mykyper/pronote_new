<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur</title>
    <link rel="stylesheet" href="{{ asset('css/Accueil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_teacher.css') }}">
</head>

<body>
    <header>
        <h1>Créer un nouvel utilisateur</h1>
    </header>
    <main>
        <div class="form-container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form id="userForm" class="user-form">
                @csrf

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <label for="role">Rôle :</label>
                <select id="role" name="role" required>
                    <option value="coordinateur">Coordinateur</option>
                    <option value="enseignant">Enseignant</option>
                </select>

                <button type="submit">Créer utilisateur</button>
            </form>

            <div id="message"></div>

        </div>
    </main>
    <script>
document.getElementById("userForm").addEventListener("submit", async function(e) {
    e.preventDefault(); // Empêche l’envoi classique du formulaire

    const formData = {
        nom: document.getElementById("nom").value,
        prenom: document.getElementById("prenom").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
        role: document.getElementById("role").value,
    };

    try {
        const response = await fetch("/api/users", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value // si besoin
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            document.getElementById("message").innerHTML = `<p style="color:green">${data.message}</p>`;
            document.getElementById("userForm").reset();
        } else {
            document.getElementById("message").innerHTML = `<p style="color:red">${data.message ?? 'Erreur'}</p>`;
        }
    } catch (error) {
        console.error(error);
        document.getElementById("message").innerHTML = `<p style="color:red">Erreur serveur</p>`;
    }
});
</script>

</body>

</html>