CREATE TABLE articles (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` mediumtext NOT NULL,
  `descrip` mediumtext NOT NULL,
  `contenu` mediumtext NOT NULL,
  `auteur` mediumtext NOT NULL,
  `date_publication` date NOT NULL,
  `img` mediumtext NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE debat (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` mediumtext,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `creer_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE  inscription (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(30) NOT NULL,
  `nom_utilisateur` varchar(30) NOT NULL,
  `mot_de_passe` varchar(30) NOT NULL,
  `def` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


