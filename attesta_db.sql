-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 15 déc. 2025 à 10:05
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
-- Base de données : `attesta_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id_admin` int(11) NOT NULL,
  `nom_complet` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id_admin`, `nom_complet`, `email`, `mot_de_passe`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Principal', 'admin@attesta.ma', '$2y$12$j7roxSFf3pSDNEYfdYJz9.J/tViR1nIpc6HnEwIAWAHnC.1wR6jPK', NULL, '2025-11-18 17:38:26', '2025-11-18 17:38:26');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conventions_stage`
--

CREATE TABLE `conventions_stage` (
  `id_convention` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `nom_entreprise` varchar(255) NOT NULL,
  `adresse_entreprise` text NOT NULL,
  `email_entreprise` varchar(255) NOT NULL,
  `nom_encadrant_entreprise` varchar(100) NOT NULL,
  `nom_encadrant_ecole` varchar(100) NOT NULL,
  `sujet_stage` text NOT NULL,
  `duree_stage` varchar(100) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` enum('en_attente','approuvee','refusee') DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id_demande` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `type_document` enum('scolarite','releve_notes','reussite','non_redoublement') NOT NULL,
  `statut` enum('en_attente','validee','refusee') NOT NULL DEFAULT 'en_attente',
  `date_demande` datetime NOT NULL DEFAULT current_timestamp(),
  `annee_universitaire` varchar(50) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `id_admin_traitant` int(11) DEFAULT NULL,
  `date_traitement` datetime DEFAULT NULL,
  `motif_refus` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id_demande`, `id_etudiant`, `type_document`, `statut`, `date_demande`, `annee_universitaire`, `semestre`, `id_admin_traitant`, `date_traitement`, `motif_refus`, `created_at`, `updated_at`) VALUES
(3, 1, 'scolarite', 'refusee', '2025-11-24 18:38:40', NULL, NULL, 1, '2025-12-03 12:51:07', 'sdfhgj', NULL, NULL),
(8, 1, 'non_redoublement', 'en_attente', '2025-12-07 20:34:02', '2025-2026', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, 'non_redoublement', 'validee', '2025-12-07 20:54:19', '2025-2026', NULL, 1, '2025-12-09 14:25:45', NULL, NULL, NULL),
(11, 2, 'reussite', 'validee', '2025-12-09 14:54:50', '2025-2026', NULL, 1, '2025-12-09 14:55:15', NULL, NULL, NULL),
(14, 2, 'releve_notes', 'validee', '2025-12-13 07:38:54', '2024-2025', NULL, 1, '2025-12-13 07:39:21', NULL, NULL, NULL),
(15, 2, 'scolarite', 'en_attente', '2025-12-13 10:16:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id_etudiant` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `numero_apogee` varchar(50) NOT NULL,
  `niveau_actuel` int(11) NOT NULL,
  `filiere_actuelle` varchar(100) DEFAULT NULL,
  `statut_inscription` enum('inscrit','non_inscrit') NOT NULL DEFAULT 'inscrit',
  `parcours_sans_redoublement` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id_etudiant`, `nom`, `prenom`, `email`, `cin`, `numero_apogee`, `niveau_actuel`, `filiere_actuelle`, `statut_inscription`, `parcours_sans_redoublement`, `created_at`, `updated_at`) VALUES
(1, 'Alaoui', 'Fatima', 'fatima.alaoui@etu.uae.ac.ma', 'G123456', '18001234', 5, 'Génie Informatique', 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(2, 'El ouazzani touhami', 'Aymane', 'elouazzanitouhami.aymane@etu.uae.ac.ma', 'LE33677', '19005678', 4, 'Génie Civil', 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(3, 'Chafik', 'Amina', 'amina.chafik@etu.uae.ac.ma', 'K345678', '20009012', 2, NULL, 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(4, 'Drissi', 'Mehdi', 'mehdi.drissi@etu.uae.ac.ma', 'L901234', '17003456', 5, 'Génie Mécatronique', 'non_inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(5, 'El Fassi', 'Salma', 'salma.elfassi@etu.uae.ac.ma', 'M567890', '21007890', 1, NULL, 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_actions`
--

CREATE TABLE `historique_actions` (
  `id_historique` int(11) NOT NULL,
  `id_demande` int(11) DEFAULT NULL,
  `id_reclamation` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `action_effectuee` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `date_action` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_actions`
--

INSERT INTO `historique_actions` (`id_historique`, `id_demande`, `id_reclamation`, `id_admin`, `action_effectuee`, `details`, `date_action`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 1, 'Refus', 'Motif: sdfhgj', '2025-12-03 12:51:07', NULL, NULL),
(2, NULL, NULL, 1, 'Validation', 'Type: scolarite', '2025-12-07 15:01:32', NULL, NULL),
(3, NULL, NULL, 1, 'Validation', 'Type: scolarite', '2025-12-07 15:05:39', NULL, NULL),
(4, NULL, NULL, 1, 'Refus', 'Motif: Sorry', '2025-12-07 15:20:50', NULL, NULL),
(5, NULL, NULL, 1, 'Validation', 'Type: scolarite', '2025-12-07 15:41:32', NULL, NULL),
(6, NULL, NULL, 1, 'Validation', 'Type: scolarite', '2025-12-07 15:49:22', NULL, NULL),
(7, 9, NULL, 1, 'Validation', 'Type: non_redoublement', '2025-12-09 14:25:48', NULL, NULL),
(8, 11, NULL, 1, 'Validation', 'Type: reussite', '2025-12-09 14:55:19', NULL, NULL),
(9, NULL, NULL, 1, 'Validation', 'Type: releve_notes', '2025-12-10 10:17:43', NULL, NULL),
(10, 14, NULL, 1, 'Validation', 'Type: releve_notes', '2025-12-13 07:39:25', NULL, NULL),
(11, NULL, NULL, 1, 'Clôture Réclamation', 'Réponse envoyée.', '2025-12-13 10:47:34', NULL, NULL),
(12, NULL, 3, 1, 'Clôture Réclamation', 'Réponse envoyée.', '2025-12-13 10:57:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_08_120443_create_notes_table_final', 2);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_etudiant` bigint(20) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `note` decimal(5,2) NOT NULL,
  `semestre` varchar(255) NOT NULL DEFAULT 'S1',
  `annee_universitaire` varchar(255) NOT NULL DEFAULT '2024/2025',
  `resultat` char(1) NOT NULL DEFAULT 'V',
  `remarques` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `id_etudiant`, `module_name`, `note`, `semestre`, `annee_universitaire`, `resultat`, `remarques`, `created_at`, `updated_at`) VALUES
(1, 1, 'Algorithmes et Structures de Données', 15.50, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(2, 1, 'Analyse 1', 12.25, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(3, 1, 'Programmation C', 17.00, 'S1', '2024/2025', 'V', 'Très bon travail', NULL, NULL),
(4, 2, 'Résistance des Matériaux', 11.75, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(5, 2, 'Topographie', 14.20, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(6, 2, 'Mathématiques 1', 9.50, 'S1', '2024/2025', 'R', 'Doit repasser', NULL, NULL),
(7, 3, 'Communication', 13.00, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(8, 3, 'Initiation à l’Informatique', 16.40, 'S1', '2024/2025', 'V', 'Participation active', NULL, NULL),
(9, 4, 'Électronique Analogique', 10.75, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(10, 4, 'Automatique 1', 8.90, 'S1', '2024/2025', 'R', 'Rattrapage conseillé', NULL, NULL),
(11, 5, 'Mathématiques de base', 14.60, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(12, 5, 'Introduction à la Programmation', 15.20, 'S1', '2024/2025', 'V', NULL, NULL, NULL),
(13, 1, 'Bases de Données', 16.30, 'S2', '2024/2025', 'V', NULL, NULL, NULL),
(14, 2, 'Matériaux de Construction', 12.70, 'S2', '2024/2025', 'V', NULL, NULL, NULL),
(15, 3, 'Programmation Python', 14.80, 'S2', '2024/2025', 'V', NULL, NULL, NULL),
(16, 4, 'Capteurs et Actionneurs', 10.20, 'S2', '2024/2025', 'V', NULL, NULL, NULL),
(17, 5, 'Analyse 2', 13.90, 'S2', '2024/2025', 'V', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

CREATE TABLE `reclamations` (
  `id_reclamation` int(11) NOT NULL,
  `id_demande_concernee` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `statut` enum('soumise','cloturee') NOT NULL DEFAULT 'soumise',
  `date_reclamation` datetime NOT NULL DEFAULT current_timestamp(),
  `reponse_admin` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reclamations`
--

INSERT INTO `reclamations` (`id_reclamation`, `id_demande_concernee`, `id_etudiant`, `sujet`, `description`, `statut`, `date_reclamation`, `reponse_admin`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Reclamation', 'Pourquoi', 'soumise', '2025-12-03 12:52:30', NULL, NULL, NULL),
(3, 15, 2, 'dfghj', 'fdgghjk', 'cloturee', '2025-12-13 10:56:34', 'sdfghj', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-12-09 13:23:47', '$2y$12$IiO2kJLxqNThDdXkxHTyueRm5NdNZ/.xL4oEpTnN5EJZQF541le8q', 'KgZrwHTweX', '2025-12-09 13:23:47', '2025-12-09 13:23:47');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `conventions_stage`
--
ALTER TABLE `conventions_stage`
  ADD PRIMARY KEY (`id_convention`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_admin_traitant` (`id_admin_traitant`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cin` (`cin`),
  ADD UNIQUE KEY `numero_apogee` (`numero_apogee`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `historique_actions`
--
ALTER TABLE `historique_actions`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `id_demande` (`id_demande`),
  ADD KEY `id_reclamation` (`id_reclamation`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_id_etudiant_index` (`id_etudiant`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`id_reclamation`),
  ADD KEY `id_demande_concernee` (`id_demande_concernee`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `conventions_stage`
--
ALTER TABLE `conventions_stage`
  MODIFY `id_convention` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique_actions`
--
ALTER TABLE `historique_actions`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `conventions_stage`
--
ALTER TABLE `conventions_stage`
  ADD CONSTRAINT `conventions_stage_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `demandes_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE,
  ADD CONSTRAINT `demandes_ibfk_2` FOREIGN KEY (`id_admin_traitant`) REFERENCES `administrateurs` (`id_admin`) ON DELETE SET NULL;

--
-- Contraintes pour la table `historique_actions`
--
ALTER TABLE `historique_actions`
  ADD CONSTRAINT `historique_actions_ibfk_1` FOREIGN KEY (`id_demande`) REFERENCES `demandes` (`id_demande`) ON DELETE SET NULL,
  ADD CONSTRAINT `historique_actions_ibfk_2` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamations` (`id_reclamation`) ON DELETE SET NULL,
  ADD CONSTRAINT `historique_actions_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `administrateurs` (`id_admin`) ON DELETE SET NULL;

--
-- Contraintes pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD CONSTRAINT `reclamations_ibfk_1` FOREIGN KEY (`id_demande_concernee`) REFERENCES `demandes` (`id_demande`) ON DELETE CASCADE,
  ADD CONSTRAINT `reclamations_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
