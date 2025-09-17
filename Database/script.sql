-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 sep. 2025 à 17:08
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formation_db`
--

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `can_user_download` (`p_user_id` INT UNSIGNED, `p_projet_id` INT UNSIGNED) RETURNS TINYINT(1) DETERMINISTIC READS SQL DATA BEGIN
  DECLARE v_categorie ENUM('freemium','premium');
  DECLARE v_has_paid INT DEFAULT 0;
  -- récupérer la catégorie du projet
  SELECT categorie INTO v_categorie FROM projet WHERE id_projet = p_projet_id LIMIT 1;
  IF v_categorie IS NULL THEN
    RETURN 0; -- projet inconnu
  END IF;
  IF v_categorie = 'freemium' THEN
    RETURN 1;
  END IF;
  -- si premium, vérifier paiement
  SELECT COUNT(*) INTO v_has_paid FROM paiement
    WHERE id_utilisateur = p_user_id AND id_projet = p_projet_id;
  IF v_has_paid > 0 THEN
    RETURN 1;
  ELSE
    RETURN 0;
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `admin_log`
--

CREATE TABLE `admin_log` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `date_action` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` bigint(20) UNSIGNED NOT NULL,
  `id_expediteur` int(10) UNSIGNED NOT NULL,
  `id_destinataire` int(10) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT 0,
  `date_envoi` datetime NOT NULL DEFAULT current_timestamp(),
  `id_projet_personnalise` int(10) UNSIGNED DEFAULT NULL,
  `fichier_joint` varchar(511) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `id_module` int(10) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') NOT NULL DEFAULT 'facile',
  `auteur_id` int(10) UNSIGNED DEFAULT NULL,
  `date_publication` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id_paiement` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `id_projet` int(10) UNSIGNED NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_paiement` datetime NOT NULL DEFAULT current_timestamp(),
  `moyen_paiement` varchar(100) DEFAULT NULL,
  `reference_operation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id_projet` int(10) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `categorie` enum('freemium','premium') NOT NULL DEFAULT 'freemium',
  `fichier_zip` varchar(511) DEFAULT NULL,
  `auteur_id` int(10) UNSIGNED DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT 0.00,
  `date_publication` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `projets_accessibles_par_user`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `projets_accessibles_par_user` (
`id_projet` int(10) unsigned
,`titre` varchar(255)
,`categorie` varchar(8)
,`prix` decimal(10,2)
,`id_utilisateur` decimal(10,0)
);

-- --------------------------------------------------------

--
-- Structure de la table `telechargement`
--

CREATE TABLE `telechargement` (
  `id_telechargement` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `id_projet` int(10) UNSIGNED NOT NULL,
  `date_telechargement` datetime NOT NULL DEFAULT current_timestamp(),
  `user_ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_module`
--

CREATE TABLE `user_module` (
  `id_user_module` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `id_module` int(10) UNSIGNED NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `progres_percent` tinyint(3) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `statut` enum('actif','inactif','banni') NOT NULL DEFAULT 'actif',
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `dernier_connexion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la vue `projets_accessibles_par_user`
--
DROP TABLE IF EXISTS `projets_accessibles_par_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `projets_accessibles_par_user`  AS SELECT `p`.`id_projet` AS `id_projet`, `p`.`titre` AS `titre`, `p`.`categorie` AS `categorie`, `p`.`prix` AS `prix`, NULL AS `id_utilisateur` FROM `projet` AS `p` WHERE `p`.`categorie` = 'freemium'union select `p`.`id_projet` AS `id_projet`,`p`.`titre` AS `titre`,`p`.`categorie` AS `categorie`,`p`.`prix` AS `prix`,`pay`.`id_utilisateur` AS `id_utilisateur` from (`projet` `p` join `paiement` `pay` on(`pay`.`id_projet` = `p`.`id_projet`)) where `p`.`categorie` = 'premium'  ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_admin_date` (`admin_id`,`date_action`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `fk_message_destinataire` (`id_destinataire`),
  ADD KEY `fk_message_projet` (`id_projet_personnalise`),
  ADD KEY `idx_expediteur_destinataire` (`id_expediteur`,`id_destinataire`),
  ADD KEY `idx_date_envoi` (`date_envoi`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_module`),
  ADD KEY `idx_niveau` (`niveau`),
  ADD KEY `fk_module_auteur` (`auteur_id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD UNIQUE KEY `ux_user_projet_paiement` (`id_utilisateur`,`id_projet`),
  ADD KEY `fk_paiement_projet` (`id_projet`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id_projet`),
  ADD KEY `idx_categorie` (`categorie`),
  ADD KEY `fk_projet_auteur` (`auteur_id`);

--
-- Index pour la table `telechargement`
--
ALTER TABLE `telechargement`
  ADD PRIMARY KEY (`id_telechargement`),
  ADD KEY `fk_telechargement_projet` (`id_projet`),
  ADD KEY `idx_user_projet_date` (`id_utilisateur`,`id_projet`,`date_telechargement`);

--
-- Index pour la table `user_module`
--
ALTER TABLE `user_module`
  ADD PRIMARY KEY (`id_user_module`),
  ADD UNIQUE KEY `ux_user_module` (`id_utilisateur`,`id_module`),
  ADD KEY `fk_user_module_module` (`id_module`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `id_module` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id_projet` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `telechargement`
--
ALTER TABLE `telechargement`
  MODIFY `id_telechargement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_module`
--
ALTER TABLE `user_module`
  MODIFY `id_user_module` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin_log`
--
ALTER TABLE `admin_log`
  ADD CONSTRAINT `fk_admin_log_user` FOREIGN KEY (`admin_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_destinataire` FOREIGN KEY (`id_destinataire`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_message_expediteur` FOREIGN KEY (`id_expediteur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_message_projet` FOREIGN KEY (`id_projet_personnalise`) REFERENCES `projet` (`id_projet`) ON DELETE SET NULL;

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_module_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `fk_paiement_projet` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_paiement_user` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `fk_projet_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `telechargement`
--
ALTER TABLE `telechargement`
  ADD CONSTRAINT `fk_telechargement_projet` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_telechargement_user` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_module`
--
ALTER TABLE `user_module`
  ADD CONSTRAINT `fk_user_module_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_module_user` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
