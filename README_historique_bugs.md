# Historique et correction des bugs du projet PHP API

Ce document récapitule tous les bugs rencontrés lors du développement et de la mise en place de l’API, ainsi que les solutions apportées.

---

## 1. Problème d’envoi de données depuis le front-end
- **Bug :** Le formulaire HTML envoyait les données en `FormData` alors que l’API attendait du JSON.
- **Symptôme :** L’API recevait `null` au lieu d’un tableau, ce qui provoquait des erreurs fatales ou des validations échouées.
- **Correction :** Modification du front-end pour envoyer les données en JSON :
  ```js
  fetch("http://localhost/project-php-api/public/sign", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, mail, password })
  })
  ```

---

## 2. Erreur fatale sur le contrôleur
- **Bug :** La méthode `sign()` du contrôleur attendait un tableau, mais recevait `null` si le body était vide ou mal formé.
- **Symptôme :** Fatal error : Argument #1 ($datas) must be of type array, null given
- **Correction :** Ajout d’une vérification dans les routes pour garantir que `$datas` est toujours un tableau :
  ```php
  if (!is_array($datas)) $datas = [];
  ```

---

## 3. Validation trop stricte des longueurs
- **Bug :** Les méthodes de validation de longueur limitaient les emails et mots de passe à 12 caractères maximum.
- **Symptôme :** Impossible de s’inscrire avec un email ou mot de passe standard.
- **Correction :** Augmentation de la longueur maximale à 64 caractères pour `mail` et `password`.

---

## 4. Double affichage JSON dans la réponse
- **Bug :** La méthode `jsonResponse` du contrôleur affichait deux fois une réponse JSON (une vraie et une vide).
- **Symptôme :** Réponse JSON polluée ou ambiguë.
- **Correction :** Suppression du second `echoJson` inutile.

---

## 5. Factory et constructeurs des modèles
- **Bug :** Les modèles n’acceptaient pas de paramètre `$db` dans leur constructeur, ce qui causait une erreur avec la Factory.
- **Symptôme :** ArgumentCountError lors de l’instanciation via la Factory.
- **Correction :** Harmonisation de tous les modèles pour hériter de `BaseModel` et accepter `$db` en paramètre.

---

## 6. Routes POST commentées
- **Bug :** Les routes `/login` et `/sign` étaient commentées, donc inactives.
- **Symptôme :** Impossible de s’inscrire ou de se connecter via l’API.
- **Correction :** Décommentage et adaptation des routes pour utiliser la Factory et le bon format de données.

---

## 7. Tests avec Postman
- **Bug :** Utilisation de mauvais format ou clés dans Postman.
- **Symptôme :** Réponse `{"status":400,"message":"Tous les champs sont requis"}` ou `Longueur incorrecte`.
- **Correction :** Utilisation du format JSON, bonnes clés (`name`, `mail`, `password`), et valeurs valides.

---

## 8. Résumé des bonnes pratiques pour tester
- Toujours envoyer les données en JSON.
- Vérifier l’orthographe des clés et la présence des valeurs.
- Adapter la longueur des champs selon les contraintes du contrôleur.
- Utiliser la Factory pour instancier les contrôleurs et modèles.
- Relancer `composer dump-autoload` après modification des classes/namespaces.

---

**Ce document permet de comprendre l’origine des bugs, leur impact, et la façon dont ils ont été résolus pour garantir le bon fonctionnement de l’API.**
