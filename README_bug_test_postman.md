# Correction du bug d'inscription et guide de test Postman

## 1. Bug rencontré

Lors de l'envoi d'une requête POST sur `/sign`, l'API retournait :
- `{"status":400,"message":"Tous les champs sont requis"}`
- Ou une erreur fatale si le body était vide ou mal formé.

**Causes :**
- Les données envoyées n'étaient pas au format JSON ou les clés étaient incorrectes.
- Le code PHP attendait un tableau, mais recevait `null` si le body était vide ou mal formé.
- La validation de longueur était trop stricte pour les emails et mots de passe.

## 2. Corrections apportées

- Ajout d'une vérification dans les routes pour que `$datas` soit toujours un tableau :
  ```php
  $datas = json_decode(file_get_contents('php://input'), true);
  if (!is_array($datas)) $datas = [];
  ```
- Ajout d'un `return` après la réponse d'erreur dans le contrôleur pour éviter les accès à des clés non définies :
  ```php
  if (!$this->isNotEmpty($datas) || !$this->verifyFields($datas, $fields)) {
      $this->jsonResponse([
          'status' => 400,
          'message' => 'Tous les champs sont requis'
      ]);
      return;
  }
  ```
- Assouplissement de la validation de longueur pour les emails et mots de passe :
  ```php
  if (
      !$this->valideLength($datas['name'], 6, 16) ||
      !$this->valideLength($datas['mail'], 6, 64) ||
      !$this->valideLength($datas['password'], 6, 64)
  ) {
      $this->jsonResponse([
          'status' => 400,
          'message' => 'Longueur incorrecte'
      ]);
      return;
  }
  ```
- Explication dans le README sur le format attendu et la gestion des erreurs.

## 3. Comment tester l'API avec Postman

### a. Pré-requis
- Serveur Apache et MySQL démarrés (XAMPP).
- Base de données et tables créées.
- Dépendances installées avec Composer.

### b. Tester l'inscription (POST /sign)
1. Ouvre Postman.
2. Méthode : POST
3. URL : `http://localhost/project-php-api/public/sign`
4. Onglet Body : Choisis `raw` et le format `JSON`.
5. Exemple de contenu :
   ```json
   {
     "name": "HenockT",
     "mail": "henock@email.com",
     "password": "Password@123"
   }
   ```
6. Clique sur Send.
7. Résultat attendu :
   - Si tout est correct : `{"status":200,"message":"Inscription réussie"}`
   - Si un champ est manquant : `{"status":400,"message":"Tous les champs sont requis"}`
   - Si la longueur est incorrecte : `{"status":400,"message":"Longueur incorrecte"}`

### c. Tester la connexion (POST /login)
1. Méthode : POST
2. URL : `http://localhost/project-php-api/public/login`
3. Body :
   ```json
   {
     "mail": "henock@email.com",
     "password": "Password@123"
   }
   ```
4. Résultat attendu :
   - Succès : `{"status":200,"message":"Connexion réussie", ...}`
   - Erreur : `{"status":401,"message":"Email ou mot de passe incorrect"}`

### d. Conseils
- Vérifie l’orthographe des clés (`name`, `mail`, `password`).
- Utilise toujours le format JSON (pas form-data).
- Vérifie la longueur des champs.

---

**En résumé :**
- Le bug était lié à la gestion des données reçues et à la validation.
- Il a été corrigé par des vérifications et une meilleure gestion des erreurs.
- Les tests avec Postman doivent se faire en JSON, avec les bons champs et des valeurs valides.
