# Dossier `models` – Documentation et Utilisation

Ce dossier contient toutes les classes qui gèrent l’accès et la manipulation des données de la base MySQL. Chaque fichier correspond à un modèle métier ou à une classe utilitaire pour la base de données.

## 1. `Database.php`
Classe de base qui gère la connexion PDO à la base de données, en utilisant la configuration du dossier `config`. Elle propose des méthodes génériques pour exécuter des requêtes, récupérer des résultats, et gérer la connexion.

**Principales méthodes :**
- `connect()` : établit la connexion PDO
- `disconnect()` : ferme la connexion
- `query($sql, $params)` : exécute une requête préparée
- `fetchAll($sql, $params)` : récupère plusieurs enregistrements
- `fetchOne($sql, $params)` : récupère un seul enregistrement
- `execute($sql, $params)` : exécute une requête d’écriture
- `lastInsertId()` : récupère le dernier ID inséré

## 2. `MysqlDatabase.php`
Hérite de `Database`. Fournit des méthodes supplémentaires pour gérer les transactions (begin, commit, rollback) et permet d’exécuter des requêtes personnalisées. C’est la classe à utiliser pour des opérations SQL avancées ou des transactions globales.

**Principales méthodes :**
- `beginTransaction()` : démarre une transaction
- `commit()` : valide la transaction
- `rollback()` : annule la transaction
- `query($sql, $params)` : exécute une requête préparée
- `lastInsertId()` : ID du dernier enregistrement inséré

**Utilisation dans un contrôleur :**
- Pour gérer une transaction sur plusieurs modèles ou requêtes personnalisées.
- Pour exécuter des requêtes SQL qui ne sont pas couvertes par les modèles métier.

**Exemple :**
```php
$db = new MysqlDatabase();
$db->beginTransaction();
try {
    // opérations sur plusieurs modèles ou requêtes directes
    $db->commit();
} catch (Exception $e) {
    $db->rollback();
}
```

## 3. Modèles métier
Chaque modèle correspond à une table ou un ensemble de tables de la base de données. Ils héritent tous de `MysqlDatabase` et proposent des méthodes pour manipuler les données métier.

### `UserModel.php`
Gère les utilisateurs (`utilisateur`).
- `createUser`, `getUserById`, `getUserByEmail`, `authenticate`, `updateUser`, `deleteUser`, `listUsers`, etc.

### `ModulesModel.php`
Gère les modules de formation (`module`).
- `createModule`, `getModuleById`, `listModules`, `updateModule`, `deleteModule`, `getModulesByLevel`

### `ProjetModel.php`
Gère les projets (`projet`).
- `createProjet`, `getProjetById`, `listProjets`, `listFreemiumProjets`, `listPremiumProjets`, `updateProjet`, `deleteProjet`

### `DownloadModel.php`
Gère les téléchargements (`telechargement`).
- `createDownload`, `getDownloadById`, `getDownloadsByUser`, `getDownloadsByProject`, `listDownloads`, `deleteDownload`

### `Payement.php`
Gère les paiements (`paiement`).
- `createPayement`, `getPayementById`, `getPayementsByUser`, `listPayements`, `updatePayementStatus`, `deletePayement`

### `UserModuleModel.php`
Gère la relation entre utilisateurs et modules suivis (`user_module`).
- `addUserModule`, `deleteUserModule`, `getModulesByUser`, `getUsersByModule`, `isUserFollowingModule`

## Utilisation des modèles dans les contrôleurs
Dans un contrôleur, on instancie le modèle correspondant pour manipuler les données. Exemple :

```php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    public function createUser($nom, $email, $mot_de_passe) {
        $userModel = new UserModel();
        $userModel->createUser($nom, $email, $mot_de_passe);
    }
}
```

## Pourquoi utiliser `MysqlDatabase` dans un contrôleur ?
- Pour gérer des transactions qui impliquent plusieurs modèles (ex : création d’un utilisateur + d’un module dans la même opération).
- Pour exécuter des requêtes SQL personnalisées qui ne sont pas prévues dans les modèles métier.
- Pour garantir la cohérence des données lors d’opérations complexes.

**Exemple : transaction sur plusieurs modèles**
```php
require_once __DIR__ . '/../models/MysqlDatabase.php';
require_once __DIR__ . '/../models/UserModel.php';

class ExempleController {
    public function operationComplexe($nom, $email, $mot_de_passe) {
        $db = new MysqlDatabase();
        $userModel = new UserModel();
        $db->beginTransaction();
        try {
            $userModel->createUser($nom, $email, $mot_de_passe);
            $db->query("UPDATE statistique SET total_users = total_users + 1");
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }
}
```

---

**En résumé :**
- Utilisez les modèles pour la logique métier standard.
- Utilisez `MysqlDatabase` dans les contrôleurs pour les transactions globales ou les requêtes personnalisées.
- Toute la logique d’accès aux données est centralisée dans le dossier `models` pour une meilleure organisation et maintenabilité.
