-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 03 avr. 2025 à 12:36
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
-- Base de données : `latemate`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `date_like` timestamp NOT NULL DEFAULT current_timestamp(),
  `usr_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`like_id`, `date_like`, `usr_id`, `post_id`) VALUES
(55, '2023-12-12 01:48:51', 35, 20),
(56, '2023-12-12 07:27:56', 35, 22),
(57, '2023-12-12 08:27:33', 42, 22),
(59, '2025-04-03 10:34:29', 35, 23);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `author_name` text DEFAULT NULL,
  `author_surname` text DEFAULT NULL,
  `titre` varchar(30) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `raison` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `utilisateur_id`, `author_name`, `author_surname`, `titre`, `contenu`, `document`, `raison`, `date_creation`, `likes`) VALUES
(20, 32, 'Eydis', 'Eydis', 'J&#39;ai eu un accident', 'Je vous jure on ma laisser pour mort', 'posts_img/img_9533991b4910caed9f22de6c696d691f.jpg', 'Un accident sur la A5 à cause d&#39;un chauffard, j\'ai cru que j\'allais clamser omg', '2023-12-11 17:40:33', NULL),
(22, 31, 'test3', 'test3', 'batterie de teste avec like', 'J&#39;ai glissé sur un Flamby', 'posts_img/img_24d9da4a57ef71fc244d42ae93a78bdf.png', 'j&#39;ai glissé chef', '2023-12-11 23:11:34', 'like/6a6201404aa1ea8cefed3e3f62c58d46.json'),
(23, 35, 'Alexis', 'Alex', 'Problème de bus', 'Le bus ma skip comme une pub youtube', 'posts_img/img_046d3d4ec8b082d0147ccf9be822ccc9.png', 'Bus raté, retard, car le prochain bus est dans un moment', '2023-12-12 08:31:41', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo_profil` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `etablissement` varchar(20) DEFAULT NULL,
  `date_creation_profil` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `date_naissance`, `bio`, `photo_profil`, `email`, `mot_de_passe`, `etablissement`, `date_creation_profil`) VALUES
(31, 'Nom', 'Prenom', NULL, 'test', 'pdp/img_e1e91a599f84f08c2c4f59f23b8e1e5f.png', 'test3@test3', '$2y$10$nH2MTGTy3mAxnHhSUVWVi.qItq6R.c3h.nY5eKIBmuy4.l47tpXuK', 'test', '2023-12-11 17:28:39'),
(32, 'Eydis', 'Eydis', NULL, 'J&#039;ai plus de voiture ptdr', 'pdp/img_de4d3e9efe08c945ce829af6ab953807.png', 'test4@test4', '$2y$10$k7kemRxRuutUn.Zd40bANO2tCVnBu6eeyE7rypggCQUeb5RuL7QhK', 'Le poteau', '2023-12-11 17:33:04'),
(33, 'Bourpi', 'Bourpi', NULL, 'mdp = bourpi', 'pdp/img_2d034348b022b1854c3a53ba667c1aa3.png', 'test3@test3', '$2y$10$E6x10PYGUToyWejRZ1Q2Lu3ACHKrnPg9L5WdzvA0qR6y2VQEnqHGi', 'Sur le canap&eacute;', '2023-12-11 18:12:52'),
(35, 'Bourpi', 'Bourpi', NULL, 'mdp = test', 'pdp/img_410e6f9537d31b084658065b89e4aeba.png', 'test3@test4', '$2y$10$PrYrTIexZBCEthMe1Rq3PuIb5k8OFf9lUZugeze51UrH4zGF3dvvi', 'Sur le canap&eacute;', '2023-12-11 18:14:31'),
(40, 'Bob', 'Lennon', NULL, 'a', 'pdp/img_0d68cbec05e8d83a70db05ac65910e6a.CT', 'test3@test3', '$2y$10$Nv24g5X1UeJklqnS2h84fe3YqtWVfr365JleO4IeoBnBQoaEtqCGa', 'a', '2023-12-11 18:34:49'),
(41, 'Bob', 'Lennon', NULL, 'a', 'pdp/img_83768d85984bb971e164f06e12eaeb6c.zip', 'test3@test3', '$2y$10$/t6k/QhZ6tqCR0QjYvG5zOQbKAoMG1mcJgER/.xIDoMXN2DD/ZlDe', 'a', '2023-12-11 18:35:18'),
(42, 'zjdnq', 'qzdqd', NULL, 'salut', 'pdp/img_b911c5317e841fe10770f8136026b409.png', 'oui@gmail.com', '$2y$10$iMlqMZDDhD92PpwQiN3kZeQpEOyZonkFflYw5URypIhm94GIaoEb2', 'Lycee', '2023-12-12 08:26:33');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `usr_id` (`usr_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
