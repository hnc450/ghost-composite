<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire avec Fetch</title>
</head>
<body>
  <form id="form">
    <input type="text" name="name" placeholder="name" required>
    <input type="email" name="mail" placeholder="mail" required>
    <input type="password" name="password" placeholder="password" required>
    <button type="submit">Soumettre</button>
  </form>

  <script>
    document.getElementById("form").addEventListener("submit", function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = {
        name: form.name.value,
        mail: form.mail.value,
        password: form.password.value
      };

      fetch("http://localhost/project-php-api/public/sign", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
      })
      .then(response => response.text())
      .then(data => {
        console.log("Réponse du serveur:", data);
        alert("Données envoyées avec succès !");
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Échec de l'envoi des données.");
      });
    });
  </script>
</body>
</html>
