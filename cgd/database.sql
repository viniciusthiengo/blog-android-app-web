CREATE DATABASE blog_android;


CREATE TABLE `ba_categoria` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `rotulo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rotulo` (`rotulo`)
)
ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `ba_post` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `sumario` varchar(200) NOT NULL,
  `uri_imagem` varchar(160) NOT NULL,
  `id_categoria` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `ba_user` (
  `id` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(30) NOT NULL DEFAULT '',
  `profissao` varchar(100) NOT NULL DEFAULT '',
  `ultimo_login` int(10) unsigned NOT NULL,
  `uri_imagem` varchar(160) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `ba_user_system` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password` (`password`)
)
ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `ba_token` (
  `id_user` varchar(20) NOT NULL,
  `token` varchar(160) NOT NULL,
  PRIMARY KEY (`id_user`,`token`)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8;






/* INSERT ba_categoria */
INSERT INTO
  ba_categoria(
    rotulo
  )
VALUES
  ("Para iniciantes"),
  ("Para intermediários"),
  ("Para profissionais"),
  ("Web e Android"),
  ("Padrões");


/* INSERT ba_post */
INSERT INTO
  ba_post (titulo, sumario, uri_imagem, id_categoria)
VALUES
  ("MVP Android",
   "Entenda o que é e como utilizar o padrão de arquitetura Model-View-Presenter em aplicativos Android, confira.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/mvp-android.png",
  5),

  ("Como Colocar Notificaões Bolha em Seu Aplicativo Android",
   "Aprenda, passo a passo, como colocar notificações bolha (Floating Windows) em seus aplicativos Android, para melhor apresentar conteúdos não visualizados. Confira.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/como-colocar-notificacoes-bolha-em-seu-aplicativo-android.png",
  3),

  ("Top 10 leituras de 2016 que são boas pedidas para 2017",
   "10 excelentes leituras de 2016, do Blog, que podem fazer parte de sua biblioteca e aumento de produção em 2017, confira.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/top-10-leituras-de-2016-que-sao-boas-pedidas-para-2017.png",
  4),

  ("AndroidAnnotations, Entendendo e Utilizando",
   "Melhore a leitura do código de sua APP Android utilizando anotações para construção de scripts padrões que não fazem parte da lógica de negócio, confira.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/androidannotations-entendendo-e-utilizando.png",
  2),

  ("Estudando Android - Lista de Conteúdos do Blog",
   "Estude pela lista, ordenada, de conteúdos em texto e em vídeo, do Blog, para você aprender a construir seus próprios aplicativos Android.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/estudando-android-lista-de-conteudos-do-blog.png",
  1),

  ("GCMNetworkManager Para Execução de Tarefas no Background Android",
   "Aprenda a criar um simples aplicativo Android, de GPS tracking, utilizando, para tarefas de background, o GCMNetworkManager.",
   "http:\/\/www.thiengo.com.br\/img\/post\/80-80\/gcmnetworkmanager-para-execucao-de-tarefas-no-background-android.png",
  2);


/* INSERT ba_user_system */
INSERT INTO
  ba_user_system(
    email,
    password
  )
  VALUES(
    "seu_email@host.com.br",
    "sua_hash_de_senha"
  );