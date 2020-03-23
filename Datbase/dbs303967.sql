-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Hôte : db5000311574.hosting-data.io
-- Généré le : Dim 22 mars 2020 à 17:25
-- Version du serveur :  5.7.28-log
-- Version de PHP : 7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbs303967`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `contenu` longtext COLLATE utf8_bin,
  `edition_date` date DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `contenu`, `edition_date`, `state`, `users_id`, `post_id`) VALUES
(97, 'L\'origine d\'un langage de programmation est toujours un peu mystérieux, ne trouvez-vous pas ?', '2020-03-21', 1, 98, 31);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `lastName` varchar(100) COLLATE utf8_bin NOT NULL,
  `firstName` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `edition_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `chapo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `contenu` longtext COLLATE utf8_bin,
  `edition_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `chapo`, `contenu`, `edition_date`, `update_date`, `users_id`) VALUES
(31, 'Php, mais d\'où viens-tu ?', 'Les origines, l\'histoire du language du web...', 'Les premières instructions d\'un pseudo php, émanant d\'un langage appelé PHP/FI,  ont été créées par Rasmus Lerdorf. Destiné à  comptabiliser les lecteurs de son CV, il nomme cet ensemble  d\'instructions \"Personnal Home Page Tools\". Le temps passant, d\'autres instructions sont rajoutées, produisant un jeu plus complet. Ce langage, simple au départ, permettait d\'interroger une base de données et de produire des scripts simple destinés par exemple à  la gestion d\'un livre d\'or sur internet.\r\nA partir de 1995, Rasmus offre le code source de sa création et permet ainsi, aux développeurs de mettre au point des bouts de programme destinés à améliorer le langage.\r\nRasmus continua de son coté à élargir les possibilités et instructions du PHP.', '2020-02-13 17:49:58', '2020-03-12 18:45:45', 98),
(34, 'Classe abstraite ou interface ?', 'Classe abstraite VS interface, qui sera vainqueur ?', 'Il ne peut y avoir de vainqueur ou de vaincu, ce ne sont pas des adversaires !\r\nLes différences entre les deux classes :\r\n- L\'interface est un canevas de fonctions abstraites à développer, dans la classe qui va l\'implémenter, elles ne seront donc que déclarées.\r\n- La classe abstraite aura des fonctions abstraites, mais aussi des fonctions communes à toutes les classes héritantes de cette classe abstraite et qui seront développées dans la classe abstraite.\r\n\r\nL\'interface servira donc à garantir que toutes les fonctions qu\'elle contient seront développées dans la classe l\'implémentant. Elle servira aussi de vitrine, d\'inventaire de fonctions d\'une classe. Elle sert à définir un ensemble de services visibles depuis l’extérieur\r\nEt surtout : Une classe peut implémenter plusieurs interfaces, mais ne peut hériter que d\'une seule classe.', '2020-03-11 20:39:05', '2020-03-16 06:59:46', 98),
(35, 'Design pattern Singleton', 'Comment ne délivrer qu\'une seule instance d\'une classe ?', 'Dans certains cas il est nécessaire de ne délivrer qu\'une seule et unique instance d\'une classe, même si dans l\'application une nouvelle instance est demandée.\r\nIl y a de nombreux cas où cela est nécessaire : si la classe présente une distribution de paramètres de configuration, si la classe est un pilote d\'imprimante, ...\r\nLe problème est donc de ne pouvoir délivrer qu\'une seule instance de la classe. Comment faire ?\r\nLors de la première demande, il suffit de vérifier si une instance a déjà été délivrée. Si non, une instance est chargée dans une variable statique puis envoyée au demandeur. Si oui, c\'est à dire si la variable statique n\'est pas nulle, celle-ci est envoyée au demandeur. Il s\'agira ainsi toujours de la même instance de classe. \r\n', '2020-03-12 18:58:22', '2020-03-22 18:16:58', 98);

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

CREATE TABLE `rights` (
  `id` int(11) NOT NULL,
  `app` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `module` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `action` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `role` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `rights`
--

INSERT INTO `rights` (`id`, `app`, `module`, `action`, `role`) VALUES
(1, 'Frontend', 'Post', 'showPosts', 1),
(2, 'Frontend', 'Post', 'show', 1),
(3, 'Frontend', 'Post', 'index', 0),
(4, 'Frontend', 'Post', 'insertComment', 1),
(5, 'Frontend', 'Post', 'updateComment', 1),
(6, 'Frontend', 'Post', 'deleteComment', 2),
(7, 'Frontend', 'Users', 'connexion', 0),
(8, 'Frontend', 'Users', 'registration', 0),
(9, 'Frontend', 'Users', 'deconnect', 0),
(10, 'Frontend', 'Post', 'cv', 0),
(11, 'Backend', 'Connexion', 'index', 2),
(12, 'Backend', 'Post', 'index', 2),
(13, 'Backend', 'Post', 'showPosts', 2),
(14, 'Backend', 'Post', 'insert', 2),
(15, 'Backend', 'Post', 'update', 2),
(16, 'Backend', 'Post', 'delete', 2),
(17, 'Backend', 'Post', 'show', 2),
(18, 'Backend', 'Post', 'insertComment', 2),
(19, 'Backend', 'Post', 'refuseComment', 2),
(20, 'Backend', 'Post', 'validateComment', 2),
(21, 'Backend', 'Post', 'updateComment', 2),
(22, 'Backend', 'Users', 'show', 2),
(23, 'Backend', 'Users', 'upgrade', 2),
(24, 'Backend', 'Users', 'delete', 2),
(25, 'Backend', 'Users', 'showAdmin', 3),
(26, 'Backend', 'Users', 'adminUpgrade', 3),
(27, 'Backend', 'Users', 'deconnect', 2),
(29, 'Backend', 'Users', 'adminDelete', 2),
(30, 'Backend', 'Users', 'adminDowngrade', 3),
(31, 'Backend', 'Users', 'downgrade', 2);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(0, 'visiteur'),
(1, 'membre'),
(2, 'admin'),
(3, 'superadmin');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(16) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `create_date` date DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  `role_id` int(11) DEFAULT '0',
  `vkey` varchar(32) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `create_date`, `status`, `role_id`, `vkey`) VALUES
(85, 'bernadette', 'fr.libs@gmail.com', '$2y$10$YKvReP5wW7mWWs7Aoofe7eTsOs2H/gKFMyGHdwPpFnDWIpcQIGrHK', '2020-02-16', 1, 2, '75507c49a332ed5ffc699921df45694c'),
(86, 'francis', 'fr.libs@gmail.com', '$2y$10$zRa4RiGCY6o3XZYckat42uhEH4pAgdHlX8.q0AsTvoCd9CCrlT4aq', '2020-02-16', 1, 1, 'c2b9829053815d785d97e3ca33b5a098'),
(98, 'fips', 'fr.libs@gmail.com', '$2y$10$TVCpybanzumGvYaG.Nz40OGehSOy2OhSVMfVvwMHjnwtV4gooNtpq', '2020-03-08', 1, 3, '91ea80bc969a8b736acc'),
(99, 'nina', 'fr.libs@gmail.com', '$2y$10$CxrFju.pnJYtDJClOV2jnetAo3B13DjUw0p3dRvvDtng2HZ3EpAiW', '2020-03-11', 1, 2, '16ca0881a7acf81b171c'),
(100, 'popi', 'fr.libs@gmail.com', '$2y$10$Sl/Zff6L6sAdzJXt8ybuM./ZD6KvYM0KbNjiHclrf9G4BT6Bp2a4O', '2020-03-21', 0, 1, '099d9e2eaa0e1f7e8c73'),
(101, 'cathy', 'fr.libs@gmail.com', '$2y$10$B10WELRh/eoNxBt4G6jXrudDlTVzzpqTLVzNoB2UMQRZI0reCHWbe', '2020-03-21', 0, 1, '2247e1e71e641812541e'),
(103, 'lapin', 'fr.libs@gmail.com', '$2y$10$nGOzBuj8WYZYbK0zYHBu5OtL6b5dMkprCtawHmCrYOJybQHasKfji', '2020-03-22', 1, 1, 'b9895830bbfb57b20a78');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Comments_users1_idx` (`users_id`),
  ADD KEY `fk_Comments_Posts1_idx` (`post_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Posts_users1_idx` (`users_id`);

--
-- Index pour la table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_Comments_Posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Comments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_Posts_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
