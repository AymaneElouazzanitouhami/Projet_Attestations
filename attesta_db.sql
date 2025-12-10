-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 24 nov. 2025 à 12:08
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
(1, 2, 'scolarite', 'en_attente', '2025-11-18 17:43:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(2, 'Bennani', 'Youssef', 'youssef.bennani@etu.uae.ac.ma', 'H789012', '19005678', 4, 'Génie Civil', 'inscrit', 0, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(3, 'Chafik', 'Amina', 'amina.chafik@etu.uae.ac.ma', 'K345678', '20009012', 2, NULL, 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(4, 'Drissi', 'Mehdi', 'mehdi.drissi@etu.uae.ac.ma', 'L901234', '17003456', 5, 'Génie Mécatronique', 'non_inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26'),
(5, 'El Fassi', 'Salma', 'salma.elfassi@etu.uae.ac.ma', 'M567890', '21007890', 1, NULL, 'inscrit', 1, '2025-11-18 17:38:26', '2025-11-18 17:38:26');

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
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Index pour la table `historique_actions`
--
ALTER TABLE `historique_actions`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `id_demande` (`id_demande`),
  ADD KEY `id_reclamation` (`id_reclamation`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`id_reclamation`),
  ADD KEY `id_demande_concernee` (`id_demande_concernee`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `historique_actions`
--
ALTER TABLE `historique_actions`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

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