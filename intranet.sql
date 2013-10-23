-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 30 Septembre 2013 à 11:19
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `intranet`
--

--
-- Contenu de la table `intranet_user_photo`
--

INSERT INTO `intranet_user_photo` (`id`, `path`, `createdAt`, `updatedAt`) VALUES
(1, '1f23ab8cbd41d5d81fdd946a0cd119f0fae3b1d6.png', '2013-04-26 16:52:30', '2013-05-02 20:37:50'),
(2, '254536771c0933ee86dd5986f6ef16feda6b6989.png', '2013-04-26 16:57:03', '2013-05-02 15:37:37'),
(3, 'b5f52063d89f84379dc6de7edab1e0381fbf49e5.jpeg', '2013-05-02 15:31:00', '2013-05-02 17:48:13'),
(4, 'ef96d234ee2120ad9874457ba8e8bf8d0a1bede9.jpeg', '2013-07-17 18:00:42', '2013-07-17 18:01:54'),
(5, 'afb6024b2f738611284314b83048950d4a67ccdc.jpeg', '2013-07-17 18:11:27', '2013-07-17 18:11:27'),
(6, '5dc82f9e978d5cace481b356518d4c95c1e32b2c.jpeg', '2013-07-17 18:16:26', '2013-07-17 18:16:26'),
(7, 'd1003a160be0f940198c768acd58eeabd6f3e6bd.jpeg', '2013-07-17 18:30:30', '2013-07-17 18:30:30'),
(8, 'd9f6b81144459ffbaba1aed996c663caa5af29d5.jpeg', '2013-07-17 18:34:19', '2013-07-17 18:34:19');

--
-- Contenu de la table `intranet_user_studentgroup`
--

INSERT INTO `intranet_user_studentgroup` (`id`, `name`) VALUES
(1, 'Delegues'),
(2, 'AdminSys');

--
-- Contenu de la table `intranet_user`
--

INSERT INTO `intranet_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `first_name`, `last_name`, `promo`, `photo_id`) VALUES
(127, 'ferdin_v', 'ferdin_v', 'ferdin_v@epita.fr', 'ferdin_v@epita.fr', 1, '4dib7d7zzxwkckwcosgokw88s800csw', 'tDsDkcHhJgc807IXDEOZ8zmey69433g+CgIk4+tP1rKZgsW4Eu5vCvwyQaECcZUbsRxz2aM/wYjY1+b10zyTZg==', '2013-09-11 17:51:20', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Vincent', 'Ferdinand', 2009, NULL),
(128, 'cleo_i', 'cleo_i', 'cleo_i@epita.fr', 'cleo_i@epita.fr', 1, 'fbg1mw1bkr48c0o8s4kcs4wk0wkc84g', 'nFEvMAoY7ipq3Szwe2mrdrxbFddd3iilwAwWx4S4vDCE+jIKUgAtjIxmTrJ16e+eu3GYJGqQyQz++2aY1mFSLA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Ivor', 'Cleo', 2008, NULL),
(129, 'claudi_i', 'claudi_i', 'claudi_i@epita.fr', 'claudi_i@epita.fr', 1, 'cw26z1wq2u8ggo8cs4wcks88wgcskks', 'X7RMYPq6c/gkO5R87KhNRLg9wS6o9bMrvhLjOdnpTLd6WeDYq1/Ru38812cj0aaQyiGTFM4mRcmpE958X0U2Vg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Ian', 'Claudia', 2003, NULL),
(130, 'naomi_m', 'naomi_m', 'naomi_m', 'naomi_m', 1, 'kyh7ms82hnkk8c840s4c0k4gsg4cc84', 'K3lA+0PLqCn5MR6yJk507czNq74MeuZsLj84vWJjNl8oiz6PeBURXe/Ls4v12JVqGt+KL5wayL6mStUugu3X0g==', '2013-07-17 19:32:48', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Merritt', 'Naomi', 2008, 8),
(131, 'carlos_c', 'carlos_c', 'carlos_c@epita.fr', 'carlos_c@epita.fr', 1, 'j2lsunzjvq8kck84okc0swgssk8gwgc', '54vWNv8WhLP8YJqxS7znIVV38FXikyGfCtyPP6wgA1CWGnlTxbCj4izpxXiZ0yJFEzBE2hCAXocdn0Is0lcF8g==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Channing', 'Carlos', 2007, NULL),
(132, 'darius_l', 'darius_l', 'darius_l@epita.fr', 'darius_l@epita.fr', 1, 'fnwh9no3y8g84wwog08o4kcowsgkgk0', '3cULqguMV2qa1tAECW9XXEbR2SzQLOsBcpP5SyBlAW2BSKi98nNFnwITLFe8CE5mgjNEzj3+tj1WgsvcrD4OgA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Lane', 'Darius', 2009, NULL),
(133, 'aiko_v', 'aiko_v', 'aiko_v@epita.fr', 'aiko_v@epita.fr', 1, 'juxm2bnfwtckgg4ks0wk08kw0ssss4g', 'KsboUAFm4BodsjG9jXn94W1nLXyrAo1vNhomqWTKxjoSnh8iWx34YU8pvIFLNsmWdqNOQHwIbhSf8//rXl/W2w==', '2013-07-17 18:47:19', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Victor', 'Aiko', 2009, NULL),
(134, 'abdul_g', 'abdul_g', 'abdul_g@epita.fr', 'abdul_g@epita.fr', 1, 'grf18wn7qugo0800c4okscg4c0kgogk', 'aQTL8mpTD/dHuFGuiJaa345cvboyOwYBeNAd70X3Umtquae3tMgYyO6OGqfloMzn0WY7o/xulC8JW/flvb8CdQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Gabriel', 'Abdul', 2009, NULL),
(135, 'xemnas_l', 'xemnas_l', 'xemnas_l@epita.fr', 'xemnas_l@epita.fr', 1, 'ngldk21a6xw0ocok8gc0s0wow0sco44', '1f+pKRuqyb7Ae/oqDz4mF1GUFPKzqj1utf+5g52AOXxh/wdwE7yjLfHgchOjKHphcTZlcjj9+ZzCuFhneeYa6A==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Laurent', 'Xemnas', 2009, NULL),
(136, 'termin_a', 'termin_a', 'termin_a', 'termin_a', 1, '2g8hmmm9w3ok8s84w8wcc4ogskw0cgg', 'UN58V0jDKehfMiQs6p9rDWcgQz6G/SoYbb/sJ6DUwv+HYJihCd6RkZbP+XNchklFCVLdxieHeEMDBpmcTjj8Gw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Arnaud', 'Terminator', 2009, NULL),
(137, 'hunter_j', 'hunter_j', 'hunter_j@epita.fr', 'hunter_j@epita.fr', 1, 'k96wcjc9vqos4osoc44o4c4c8wcc8w4', '0QVBklJMIWT+3ZJSXU3JWUtjlG0VTqBMQdsOrzpGGSuBZ605RIrwGU7KoUqeaCTpxTgkYYyQ35gqz+bcO4cRrA==', '2013-09-11 18:03:29', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_TEACHER";}', 0, NULL, 'Jean', 'Hunter', 2008, 4),
(138, 'nourry_l', 'nourry_l', 'ludovic.nourry@epita.fr', 'ludovic.nourry@epita.fr', 1, 'q2i9rykqjq8kcswoosgcgwkc4css048', 'tnserURa7zI+8cQazL4Q2ZOqeXNFw0Z5LVp1LoBLwkgdX+Ik/0Y6AzW9+f4hr4EVMjldHwDFvY0kziPX+BoaZQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Ludovic', 'NOURRY', 2014, NULL),
(139, 'dupont_n', 'dupont_n', 'nestor.dupont@epita.fr', 'nestor.dupont@epita.fr', 1, '9gw4v5ysojcw8s8s08go8kk8w0o4ocs', 'VZcIuUeaKCJQZzitONLqlQfuNUf5F+LIi++7EaBc5zUE9s23EYI7GXDgcF8O3q7qYgK2DnLkIcQtL7XlDIsbwA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Nestor', 'DUPONT', 2014, NULL),
(140, 'sauvag_b', 'sauvag_b', 'benoit.sauvage@epita.fr', 'benoit.sauvage@epita.fr', 1, '4tgrbr8peco4swowck8c0s4kswwsg88', 'ngujHJDiyMWzwUCM3R8iR0S9+KX5jHJBqrAFDp5xAg7uhsxTUXVtH88ED1AdSnziPImDVo7lZe2RgIeal4E7kQ==', '2013-09-11 17:47:50', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Benoît', 'SAUVAGE', 2014, 5),
(141, 'louvel_r', 'louvel_r', 'raymond.louvel@epita.fr', 'raymond.louvel@epita.fr', 1, '7q4im2cxm3k0sgo4swsckcgocsgoos8', 'vFRfqfEIfa9UdNjDXXYzvZoEuRLfOI+3aSJbmedwjNGGvsSzX6nJof5UiLTLT4VhsM7qKZTKeuOrA4Xck+wSgQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Raymond', 'LOUVEL', 2014, NULL),
(142, 'grenie_l', 'grenie_l', 'laurent.grenier@epita.fr', 'laurent.grenier@epita.fr', 1, '7h0p8i2tpd8o0ck8woccgok88c0o8go', 'SJ7w4bBtvH92u8SqPWxguWdpZTSs3XFgr+7T94u1YIGSj+wlKGbcg+9BC0S5xUYUS0buOJrP2js7IrWD72rkWg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Laurent', 'GRENIER', 2014, NULL),
(143, 'levesq_l', 'levesq_l', 'louis.levesque@epita.fr', 'louis.levesque@epita.fr', 1, 'dux1x0fksbsoog0g4oc84okc0sc48gw', 'BmQaAZg6AsSPRTRl0b3QcWThytIuDqrrTlZ/IfkvB5Ymn4G/uXSIgWhnfcfvUulFpwN7I/AGhXgHZomdWrcjxQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Louis', 'LEVESQUE', 2014, NULL),
(144, 'servan_j', 'servan_j', 'jacques.servant@epita.fr', 'jacques.servant@epita.fr', 1, 'trcepvo6mqogco08w8cc0sosswookss', 'ikEtfPq8wTetp75UTwzKXOFY++02CsdCjYof0yq5d7g586LXV5fFSHvkg6Q4zh0HScLAtqECgj/92yG4nQSK+Q==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Jacques', 'SERVANT', 2014, NULL),
(145, 'quenel_t', 'quenel_t', 'tom.quenelle@epita.fr', 'tom.quenelle@epita.fr', 1, 'bnmp26ymtd4owcw4g0o0cogcscgwo4w', 'Ibw0TJHNtEmMqNkyMO4GZGjP0CJ84rFW26I3wfXkD/OJgnB3RulqWoAZUNumSug/B53xoNjUJ6EX0Uef1PpjoA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Tom', 'QUENELLE', 2014, NULL),
(146, 'fabre_m', 'fabre_m', 'mickael.fabre@epita.fr', 'mickael.fabre@epita.fr', 1, '467zbidg7awwgg40o4s4g4skk08wsc0', 'y3m6gsf70flt/kvGhb8g0oLzV8+9X2qfYEH/b9B7wjT0hbAaocuyLUW86uh7gVI4xwDGQlAgic5KlURZqx4MqQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Mickaël', 'FABRE', 2014, NULL),
(147, 'baptis_j', 'baptis_j', 'joseph.baptiste@epita.fr', 'joseph.baptiste@epita.fr', 1, '5o5nf7uowdc08sg4048g04w4s888848', 'G5tdOfbkXPSuLJQVFMcI3u00bYGPcVxSrmZLxyCjbIU3R5r2KzW3SUUZlfU8GwzZ10fh1zdW3WPa0W89gfMZsA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Joseph', 'BAPTISTE', 2014, NULL),
(148, 'teyssi_m', 'teyssi_m', 'margaux.teyssier@epita.fr', 'margaux.teyssier@epita.fr', 1, 'bnkm941tlgggg44c8s0s4o4s008okk4', '6qrjpLs2jQV9grq6SnU6TW3QtVaaxKG0/bftoDLqbZZrJ9AsQxEAvaC9JL/M79JLCpg0HC/GJ3HRqXJeisRHwg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Margaux', 'TEYSSIER', 2014, NULL),
(149, 'schwar_n', 'schwar_n', 'noemie.schwartz@epita.fr', 'noemie.schwartz@epita.fr', 1, 'mabphtdwr1wc4cogwcoo0wswgkksskw', '/J78FSaah0ssvh5QJbTBs8l7RaXGbHAXjnfi6PaHspsCZqZEzyGpxO6WlErulaFscStTc/HMfrNYDr4S6luMpg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Noemie', 'SCHWARTZ', 2014, NULL),
(150, 'barth_j', 'barth_j', 'julie.barth@epita.fr', 'julie.barth@epita.fr', 1, '58rwn8lges0sccw84wswog4sg04ck0s', 'C5UkHQ/lF0/iQQaltc11//jN4KIvRGTOwFrvuIWzGL+i1EIRJhJiQS3Tee6pGansqE6eW4Irhw8i2fsG/4ZBHg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Julie', 'BARTH', 2014, NULL),
(151, 'coutur_r', 'coutur_r', 'romane.couture@epita.fr', 'romane.couture@epita.fr', 1, 'h27sw2h8n0g0wwg400kskk8w40ooowc', 'eHqPgfXk9SfD9VEzHjKM6QGLQyoVBx74MUJVQdxuSTOEPD8NxaH+chExc52ggqDR68cmAadW1TA221lwvvwxsw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Romane', 'COUTURE', 2014, NULL),
(152, 'floren_f', 'floren_f', 'franck.florent@epita.fr', 'franck.florent@epita.fr', 1, 'nhh7w51wkjk08c0wc80oggkg8g4o40k', 'AtVXKq7WjNdMRYuGA1IrNgSMBCjuviEyuWI+jYeAQKXf+K9ZVGGTyiIcuF55IBWHs5NrNgOjrBE1iTVAZzDgrA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Franck', 'FLORENT', 2014, NULL),
(153, 'lagran_r', 'lagran_r', 'roger.lagrange@epita.fr', 'roger.lagrange@epita.fr', 1, '3wdqip2l99yc8wsckscgwgw40wgc08c', 'gOej1HUov7Tcnf3LqFuDbtKZfQEoNpscLPABs4YSThm0iR79QOXRyhXJdNwaGB010hSmACUINMrJzBH2+9xZ+A==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Roger', 'LAGRANGE', 2014, NULL),
(154, 'poulai_t', 'poulai_t', 'thomas.poulain@epita.fr', 'thomas.poulain@epita.fr', 1, 'kc6ikzii300oskgokgw0wcscsccw880', 'dRYvPrAhCHIzk5m7AyOOQM5Dom49TIKsOf5Fpw1VuTE+H/1x9q8u9MtAxAidMWe8XWTC/PnR0VwETAAcf3d9jQ==', '2013-07-17 19:47:50', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Thomas', 'POULAIN', 2014, 7),
(155, 'carle-_f', 'carle-_f', 'franck.carle@epita.fr', 'franck.carle@epita.fr', 1, '8eygizupd6ccoc40084oc4swcc40w4k', '9yqAIB15qObOQFI5aeIVUt7XuYhRw6Bntf/prAjjE3r/FINUAcPwrI8N7b4PTidFS54tXcccWOFC7V5td2nHWQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Franck', 'CARLE', 2014, NULL),
(156, 'salvad_c', 'salvad_c', 'christophe.salvador@epita.fr', 'christophe.salvador@epita.fr', 1, 'kui3oerjz7k00owc8ccwkw4804k4cwc', 'WUI7x6P/hMq8h83BDI2gKxXvSmuSFKxRJAYd9oGxfPx/mP7hI0CmfItq7+a3BQbZ1IanTDbOHTstkPkA6oazlg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Christophe', 'SALVADOR', 2014, NULL),
(157, 'torres_p', 'torres_p', 'pierre.torres@epita.fr', 'pierre.torres@epita.fr', 1, 'o7g3x5bkfk0w4c48c4csw4g088ooogo', '2wO2FqJIPwdSzdqChVEBz/vFtl5L/gVRvyhYYndIitNmyGP/oxVtgJfV9fwI/WXHft9R9BDcZqgSd1Gid7UoYg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Pierre', 'TORRES', 2014, NULL),
(158, 'verger_j', 'verger_j', 'jeanne.verger@epita.fr', 'jeanne.verger@epita.fr', 1, '7sdo3h5pubok8gs0socc8s0c4o48wgs', 'VfGk085phAA8ONxOQ95xRsqQd1jjNBzvz8ePDCEi6FmXiWctPFfd/uZjL7LUzN1BBwTuSl4J1PKQhq3wmqrkMw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Jeanne', 'VERGER', 2014, NULL),
(159, 'corrid_l', 'corrid_l', 'leonidas.corridor@epita.fr', 'leonidas.corridor@epita.fr', 1, 'ssl0pgnxty8k0kwo0ks0ww8cc8kckc8', '6UN9Hbj80nZ7W6eAezO80jJPbyKJV0pcMT4pDITWRdLtoLN5tx+FgBwlxZzm9KaCZBAUreC7ErfAVmf1x3ddYg==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Leonidas', 'CORRIDOR', 2014, NULL),
(160, 'gerard_c', 'gerard_c', 'clementine.gerard@epita.fr', 'clementine.gerard@epita.fr', 1, 'tsxl7g9em1w00080c84sgs8gg0wwgkg', '/n+WygmlkZXAhTR7M/QEGoi3FAT6aQXvzUCtm7L0uy95mk512cVePdXLufjsIHy5U452NF1kQc6tFzoPV9DcGw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Clementine', 'GERARD', 2014, NULL),
(161, 'vierge_a', 'vierge_a', 'antoine.vierge@epita.fr', 'antoine.vierge@epita.fr', 1, 'q4fcsmjtccgw444skg4o4go8w00oogw', 'VuCmNDQKPcb94UCk94ZtNQ1DkhkXX50odoPl/QPDol3wD5XqCPmDdrx5CC+eVeE6r3SqwqSy3IDgzNR21jz1UA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Antoine', 'VIERGE', 2014, NULL),
(162, 'fouque_a', 'fouque_a', 'anais.fouquet@epita.fr', 'anais.fouquet@epita.fr', 1, '53dgxotuu1wkgk4wc04ow4g8w0ccok8', 'iOOb+d/m0QRT6bjDlvQtoW4/Javast6UBFlxHQd4AaPpML1w1E/xXnDqBstvD5sWePjsMGEnpd07IMWGwINaNw==', '2013-07-17 18:15:55', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Anais', 'FOUQUET', 2014, 6),
(163, 'poisso_m', 'poisso_m', 'maxime.poisson@epita.fr', 'maxime.poisson@epita.fr', 1, 'b2b1gbtttcg8ckkk4swsw80gooss8og', '6KE48oyDd1/OMNlmLoqpP0etnFjIKnVW8N24URP4fs9cwvL7JuRflEfDWQ8BuzE5FkzwVxPADYeqp3IVicRVzA==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Maxime', 'POISSON', 2014, NULL),
(164, 'soulie_j', 'soulie_j', 'jeremy.soulier@epita.fr', 'jeremy.soulier@epita.fr', 1, 'rhcavcbgadwsswwkwows84kww48swgw', 'U0J/wMjV3koUGfuw6dclU/lW+dtOn+t4CbOMCuFsPFZlmUc7+C/Jdx+S3MI3KJz520YOun9+Uzi7kxB0akVrbw==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_STUDENT";}', 0, NULL, 'Jérémy', 'SOULIER', 2014, NULL);

--
-- Contenu de la table `intranet_user_groupmember`
--

INSERT INTO `intranet_user_groupmember` (`id`, `user_id`, `studentGroup_id`) VALUES
(1, 162, 1),
(2, 142, 1),
(3, 163, 2),
(4, 154, 2),
(5, 148, 2);


--
-- Contenu de la table `intranet_course_type`
--

INSERT INTO `intranet_course_type` (`id`, `name`, `description`) VALUES
(8, 'JavaScript', ''),
(9, 'PFEE MTI', ''),
(10, 'Data Warehouse  Olap ', '');

--
-- Contenu de la table `intranet_forum_category`
--

INSERT INTO `intranet_forum_category` (`id`, `name`, `description`, `createdAt`, `updatedAt`) VALUES
(1, 'Cours', 'Support de cours et aide pour les partiels.', '2013-07-17 16:38:38', '2013-07-17 16:38:38'),
(2, 'Projets', 'Question sur les projets, les soutenances, etc....', '2013-07-17 16:39:13', '2013-07-17 16:39:13'),
(3, 'Evénements', 'Informations sur tous les événements organisés au sein de la majeure.', '2013-07-17 16:40:15', '2013-07-17 16:40:15'),
(4, 'Délégués', 'Communication des délégués, de l''administration, des professeurs, etc...', '2013-07-17 16:41:05', '2013-07-17 16:41:05'),
(5, 'Flood', 'Pour parler de ce qui ne concerne pas directement l''enseignement de la majeure MTI.', '2013-07-17 16:42:42', '2013-07-17 16:42:42');


--
-- Contenu de la table `intranet_forum_topic`
--

INSERT INTO `intranet_forum_topic` (`id`, `author_id`, `category_id`, `title`, `content`, `createdAt`, `updatedAt`) VALUES
(3, 162, 2, 'Groupe de projet .NET', '<p>Bonjour tout le monde !</p>\r\n\r\n<p>Je n&#39;ai pas encore trouv&eacute; de groupe de projet pour le .NET et on doit rendre la liste des groupes dans 2 jours.</p>\r\n\r\n<p>C&#39;est la raison pour laquelle j&#39;aurais voulu savoir s&#39;il restait une place dans un des groupes ?</p>\r\n\r\n<p>Merci d&#39;avance pour vos r&eacute;ponses :)</p>', '2013-07-17 18:18:10', '2013-07-17 18:18:10'),
(4, 162, 2, '[J2EE]Costume/tailleur obligatoire pour la soutenance ?', '<p>Bonsoir &agrave; tous !</p>\r\n\r\n<p>Tous est dans le titre ! Est-ce que nous devons arriver en costume (pour les gar&ccedil;ons) ou tailleur (pour les filles) pour la soutenance de J2EE ?</p>', '2013-07-17 18:19:35', '2013-07-17 18:19:35'),
(5, 162, 4, '[JS] Rendu et soutenances', '<p>Bonjour,</p>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">C&eacute;dric Puig, concernant la date de rendu du projet et des soutenances :</div>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">\r\n<div>&laquo;&nbsp;Merci de transmettre &agrave; la promotion que les soutenances auront lieu le jeudi 18 Juillet de 14h &agrave; 18h.</div>\r\n\r\n<div>Je commencerai par faire ma derni&egrave;re heure de cours pendant 1 heure, puis je ferai passer les 7 groupes un &agrave; un.</div>\r\n\r\n<div>15 minutes de pr&eacute;sentation, 5 minutes de questions, 5 minutes d&#39;installation pour passer d&#39;un groupe &agrave; l&#39;autre = 3 heures.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Comme &eacute;crit pr&eacute;c&eacute;demment, merci de m&#39;envoyer les sources (je vais les lire et v&eacute;rifier qu&#39;il n&#39;y a pas de &quot;quick&#39;n&#39;dirty&quot;...) + le rapport pour le mardi 16 Juillet 2013 &agrave; 23:42 pm.&nbsp;&raquo;</div>\r\n</div>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">Concernant l&#39;ordre de passage des groupes :</div>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">&laquo;&nbsp;Je choisirai (...selon un ensemble de crit&egrave;res sadiques bien d&eacute;fini, comme &agrave; l&#39;accoutum&eacute;...).&nbsp;&raquo;</div>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">Nous attendons maintenant qu&#39;il nous fournisse l&#39;ordre.</div>\r\n\r\n<div style="text-align:start">&nbsp;</div>\r\n\r\n<div style="text-align:start">Cordialement,</div>', '2013-07-17 18:21:02', '2013-07-17 18:21:02'),
(7, 162, 1, 'QCM de JS demain ?!', '<p style="text-align:start">On a vraiment un nouveau QCM de JS demain ?</p>\r\n\r\n<p style="text-align:start">Je ne comprends pas, on en a d&eacute;j&agrave; eu un, pourquoi est-ce qu&#39;on devrait le refaire ?</p>\r\n\r\n<p style="text-align:start">En plus je n&#39;ai plus mes cours et je le sens tr&egrave;s mal... D&#39;autant plus que ce QCM a &eacute;t&eacute; annonc&eacute; un peu tard :&#39;(</p>', '2013-07-17 18:25:13', '2013-07-17 18:25:13'),
(8, 162, 5, 'COUCOU', '<p>COUCOU</p>', '2013-07-17 18:26:27', '2013-07-17 18:26:27'),
(9, 162, 3, 'BBQ MTI !', '<p>Venez nombreux !</p>', '2013-07-17 18:26:58', '2013-07-17 18:26:58'),
(10, 140, 1, 'Cours Android pour le prochain semestre ?', '<p>COUCOU</p>', '2013-07-17 19:46:34', '2013-07-17 19:46:34'),
(11, 154, 1, 'Besoin d''aide TP .NET', '<p>COUCOU</p>', '2013-07-17 19:49:16', '2013-07-17 19:49:16');


--
-- Contenu de la table `intranet_forum_post`
--

INSERT INTO `intranet_forum_post` (`id`, `author_id`, `topic_id`, `content`, `createdAt`, `updatedAt`) VALUES
(1, 140, 4, '<p>Je ne pense pas, en tout cas &ccedil;a me d&eacute;rangerait fortement !</p>\r\n\r\n<p>Le mieux est d&#39;attendre la r&eacute;ponse du prof !</p>', '2013-07-17 18:22:43', '2013-07-17 18:22:43'),
(3, 154, 10, '<p>COUCOUijij</p>', '2013-07-17 19:48:45', '2013-09-11 18:16:14'),
(4, 140, 7, '<p>En m&ecirc;me temps, si &ccedil;a nous permet de rattraper le projet, moi je ne dis pas non ! :)</p>', '2013-07-17 20:49:30', '2013-07-17 20:49:30');

--
-- Contenu de la table `intranet_news_pictonews`
--

INSERT INTO `intranet_news_pictonews` (`id`, `path`, `description`) VALUES
(1, '7aee466702cd79366c5dc6211dafa86e6f6f7da7.png', 'Javascript'),
(3, '67447acd66a371667b2e8c878c49be10a8bc2b79.png', 'Microsoft'),
(4, 'fe0fe6d098cc1e78510370965d9aa301af4da633.png', 'Divers'),
(5, '1774e43220f402e30db2207fe567ba7cfe45eced.png', 'Annonce');

--
-- Contenu de la table `intranet_news_article`
--

INSERT INTO `intranet_news_article` (`id`, `title`, `content`, `date`, `author_id`, `picto_id`) VALUES
(1, 'MS Day', '<p><img alt="" src="http://atdhebuja.files.wordpress.com/2012/11/178680_366600300097400_2066359593_o.jpg" style="height:170px; width:300px" /></p>\r\n\r\n<p>Les <strong>MS Days</strong> ont eu lieu il y a quelques temps et nous sommes heureux que vous y ayez particip&eacute; si nombreux. Je rappelle que si vous souhaitez faire l&#39;acquisition d&#39;une tablette, il faut me contacter rapidement.</p>', '2013-07-17 18:37:07', 130, 3),
(2, 'Eté', '<p>Bonjour, je vous rappelle qu&#39;en p&eacute;riode de grande chaleur, il est conseill&eacute; de boire beaucoup. Toutefois, cela ne vous autorise pas &agrave; boire en salle machine. Le Bocal veille !</p>\r\n\r\n<p><span style="line-height:1.6em">Et puis, vu qu&#39;on m&#39;a demand&eacute; de faire des news plus longue, voici de quoi rassasier votre curiosit&eacute; : Le terme eau d&eacute;rive du latin aqua via les langues d&#39;o&iuml;l comme les mots ewes. Le terme aqua a &eacute;t&eacute; ensuite repris pour former quelques mots comme aquarium. Un m&eacute;lange aqueux est un m&eacute;lange dont le solvant est l&#39;eau. Le pr&eacute;fixe hydro d&eacute;rive quant &agrave; lui du grec ancien ὕ&delta;&omega;&rho; (hud&ocirc;r) et non pas de ὕ&delta;&rho;&omicron;&sigmaf; (hudros) lequel signifie serpent &agrave; eau.</span></p>', '2013-07-17 18:51:40', 133, 4),
(3, 'Soutenances PLIC', '<p>Les soutenances de PLIC auront lieu &agrave; partir de 19h15, ce mardi. Chaque pr&eacute;sentation devra durer 15 minutes, et devra contenir une partie d&eacute;monstration.</p>', '2013-07-17 18:53:20', 133, 5),
(4, 'Cigarette electronique', '<p><img alt="" src="http://www.my-angers.info/wp-content/uploads/2013/05/pack-cigarette-electronique-4.jpg" style="float:right; height:200px; width:267px" /></p>\r\n\r\n<p>Voici une note de l&#39;administration, que vous &ecirc;tes tenus de respecter :<br />\r\nLes cigarettes &eacute;lectroniques subissent les m&ecirc;mes interdictions que les cigarettes : elles sont donc interdites dans tous les bureaux, les salles de classe et tous les lieux couverts. Les contrevenants se verront appliquer les m&ecirc;mes sanctions que les fumeurs de tabac.</p>', '2013-07-17 18:55:16', 130, 5);

--
-- Contenu de la table `intranet_note_exam`
--

INSERT INTO `intranet_note_exam` (`id`, `name`, `date`, `description`, `max_mark`, `courseType_id`) VALUES
(8, 'QCM', '2013-07-18 18:00:00', 'QCM pour rattraper les notes de projet.', 20, 8);

--
-- Contenu de la table `intranet_note_note`
--

INSERT INTO `intranet_note_note` (`id`, `exam_id`, `user_id`, `value`, `comment`) VALUES
(109, 8, 138, 16, ''),
(110, 8, 139, 11, ''),
(111, 8, 140, 7, ''),
(112, 8, 141, 10, ''),
(113, 8, 142, 3, ''),
(114, 8, 143, 1, ''),
(115, 8, 144, 11, ''),
(116, 8, 145, 6, ''),
(117, 8, 146, 3, ''),
(118, 8, 147, 13, ''),
(119, 8, 148, 13, 'Vraiment bon !'),
(120, 8, 149, 18, ''),
(121, 8, 150, 11, ''),
(122, 8, 151, 7, ''),
(123, 8, 152, 2, ''),
(124, 8, 153, 16, 'Peu d''effort, c''est dommage.'),
(125, 8, 154, 1, ''),
(126, 8, 155, 2, ''),
(127, 8, 156, 14, 'C''est mauvais'),
(128, 8, 157, 5, ''),
(129, 8, 158, 20, ''),
(130, 8, 159, 16, ''),
(131, 8, 160, 14, 'Gros soucis !'),
(132, 8, 161, 5, ''),
(133, 8, 162, 16, ''),
(134, 8, 163, 7, ''),
(135, 8, 164, 6, '');

--
-- Contenu de la table `intranet_service_ticket`
--

INSERT INTO `intranet_service_ticket` (`id`, `title`, `state`) VALUES
(1, 'Mon ticket', 'Terminé'),
(2, 'Mon ticket', 'En Cours'),
(3, 'test', 'En Cours');

--
-- Contenu de la table `intranet_service_message`
--

INSERT INTO `intranet_service_message` (`id`, `ticket_id`, `user_id`, `date`, `content`) VALUES
(1, 1, 137, '2013-09-11 17:45:01', '<p>Test</p>\r\n'),
(2, 1, 137, '2013-09-11 17:45:48', ''),
(3, 2, 140, '2013-09-11 17:49:17', '<p>Test</p>\r\n'),
(4, 3, 140, '2013-09-11 18:02:56', '<p>test</p>\r\n');


--
-- Contenu de la table `intranet_service_ticketassignment`
--

INSERT INTO `intranet_service_ticketassignment` (`id`, `ticket_id`, `user_id`) VALUES
(1, 1, 137),
(2, 1, 132),
(3, 2, 140),
(4, 2, 127),
(5, 3, 140),
(6, 3, 129);


--
-- Contenu de la table `intranet_wiki_thematic`
--

INSERT INTO `intranet_wiki_thematic` (`id`, `name`, `description`) VALUES
(6, 'Java', '<p>Le langage Java est un langage de programmation informatique orient&eacute; objet cr&eacute;&eacute; par James Gosling et Patrick Naughton, employ&eacute;s de Sun Microsystems, avec le soutien de Bill Joy (cofondateur de Sun Microsystems en 1982), pr&e'),
(7, 'JavaScript', '<p><strong>JavaScript</strong>&nbsp;(souvent abr&eacute;g&eacute; JS) est un&nbsp;<a href="http://fr.wikipedia.org/wiki/Langage_de_programmation" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Langage de programmation">langage de programmation</a>&nbsp;de&nbsp;<a href="http://fr.wikipedia.org/wiki/Langage_de_script" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Langage de script">scripts</a>&nbsp;principalement utilis&eacute; dans les&nbsp;<a class="mw-redirect" href="http://fr.wikipedia.org/wiki/Pages_web" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Pages web">pages web</a>&nbsp;interactives mais aussi c&ocirc;t&eacute; serveur<a href="http://fr.wikipedia.org/wiki/Javascript#cite_note-1" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;">1</a>. C&#39;est un langage&nbsp;<a href="http://fr.wikipedia.org/wiki/Programmation_orient%C3%A9e_objet" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Programmation orientée objet">orient&eacute; objet</a>&nbsp;&agrave;&nbsp;<a href="http://fr.wikipedia.org/wiki/Programmation_orient%C3%A9e_prototype" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Programmation orientée prototype">prototype</a>, c&#39;est-&agrave;-dire que les bases du langage et ses principales interfaces sont fournies par des&nbsp;<a href="http://fr.wikipedia.org/wiki/Objet_(informatique)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Objet (informatique)">objets</a>&nbsp;qui ne sont pas des&nbsp;<a href="http://fr.wikipedia.org/wiki/Instance_(programmation)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Instance (programmation)">instances</a>&nbsp;de&nbsp;<a href="http://fr.wikipedia.org/wiki/Classe_(informatique)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Classe (informatique)">classes</a>, mais qui sont chacun &eacute;quip&eacute;s de&nbsp;<a class="mw-redirect" href="http://fr.wikipedia.org/wiki/Constructeur_(programmation_informatique)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Constructeur (programmation informatique)">constructeurs</a>&nbsp;permettant de cr&eacute;er leurs propri&eacute;t&eacute;s, et notamment une propri&eacute;t&eacute; de prototypage qui permet d&#39;en cr&eacute;er des objets&nbsp;<a href="http://fr.wikipedia.org/wiki/H%C3%A9ritage_(informatique)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Héritage (informatique)">h&eacute;ritiers</a>&nbsp;personnalis&eacute;s.</p>\r\n\r\n<p>Le langage a &eacute;t&eacute; cr&eacute;&eacute; en 1995 par&nbsp;<a href="http://fr.wikipedia.org/wiki/Brendan_Eich" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Brendan Eich">Brendan Eich</a>&nbsp;(Brendan Eich &eacute;tant membre du conseil d&#39;administration de la fondation Mozilla) pour le compte de&nbsp;<a class="mw-redirect" href="http://fr.wikipedia.org/wiki/Netscape_Communications_Corporation" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Netscape Communications Corporation">Netscape Communications Corporation</a>. Le langage, actuellement &agrave; la version 1.8.2 est une impl&eacute;mentation de la&nbsp;3<sup>e</sup>&nbsp;version de la norme&nbsp;<a href="http://fr.wikipedia.org/wiki/ECMAScript" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="ECMAScript">ECMA-262</a>&nbsp;qui int&egrave;gre &eacute;galement des &eacute;l&eacute;ments inspir&eacute;s du&nbsp;<a class="mw-redirect" href="http://fr.wikipedia.org/wiki/Langage_Python" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Langage Python">langage Python</a>. La version 1.8.5 du langage est pr&eacute;vue pour int&eacute;grer la&nbsp;5<sup>e</sup>&nbsp;version du standard ECMA<a href="http://fr.wikipedia.org/wiki/Javascript#cite_note-2" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;">2</a>.</p>'),
(8, 'C#/.NET', '<p>Le C♯ (prononc&eacute; [siː.ʃɑːp]) est un langage de programmation orient&eacute; objet &agrave; typage fort, cr&eacute;&eacute; par la soci&eacute;t&eacute; Microsoft, et notamment un de ses employ&eacute;s, Anders Hejlsberg, le cr&eacute;ateur du lan'),
(9, 'Android', '<p>COUCOU</p>'),
(10, 'iOS', '<p>COUCOU</p>'),
(11, 'Windows Phone', '<p>COUCOU</p>'),
(12, 'Graphisme', '<p>COUCOU</p>'),
(13, 'Jeu Vidéo', '<p>COUCOU</p>'),
(14, 'PHP', '<p>COUCOU</p>');

--
-- Contenu de la table `intranet_wiki_article`
--

INSERT INTO `intranet_wiki_article` (`id`, `name`, `active`, `thematic_id`) VALUES
(10, 'Maven', 1, 6),
(11, 'Spring framework', 1, 6),
(12, 'Struts', 1, 6),
(13, 'Hibernate', 1, 6),
(14, 'Node.js', 1, 7),
(15, 'RequireJS', 1, 7),
(16, 'jQuery', 1, 7),
(17, 'AngularJS', 1, 7),
(18, 'LINQ', 1, 8),
(19, 'ADO.NET Entity Framework', 1, 8),
(20, 'SQL Server', 1, 8),
(21, 'PowerShell', 1, 8),
(22, 'Bump mapping', 1, 13),
(23, 'Scrolling', 1, 13);

--
-- Contenu de la table `intranet_wiki_modif`
--

INSERT INTO `intranet_wiki_modif` (`id`, `date`, `content`, `type`, `article_id`, `user_id`) VALUES
(1, '2013-07-17 18:59:07', '<p>Apache Maven est un outil logiciel libre pour la gestion et l&#39;automatisation de production des projets logiciels Java en g&eacute;n&eacute;ral et Java EE en particulier. L&#39;objectif recherch&eacute; est comparable au syst&egrave;me Make sous Unix : produire un logiciel &agrave; partir de ses sources, en optimisant les t&acirc;ches r&eacute;alis&eacute;es &agrave; cette fin et en garantissant le bon ordre de fabrication.</p>\r\n\r\n<p><span style="line-height:1.6em">Il est semblable &agrave; l&#39;outil Ant, mais fournit des moyens de configuration plus simples, eux aussi bas&eacute;s sur le format XML. Maven est g&eacute;r&eacute; par l&#39;organisation Apache Software Foundation. Pr&eacute;c&eacute;demment Maven &eacute;tait une branche de l&#39;organisation Jakarta Project.</span><br />\r\nMaven utilise un paradigme connu sous le nom de Project Object Model (POM) afin de d&eacute;crire un projet logiciel, ses d&eacute;pendances avec des modules externes et l&#39;ordre &agrave; suivre pour sa production. Il est livr&eacute; avec un grand nombre de t&acirc;ches pr&eacute;-d&eacute;finies, comme la compilation de code Java ou encore sa modularisation.</p>\r\n\r\n<p><span style="line-height:1.6em">Un &eacute;l&eacute;ment cl&eacute; et relativement sp&eacute;cifique de Maven est son aptitude &agrave; fonctionner en r&eacute;seau. Une des motivations historiques de cet outil est de fournir un moyen de synchroniser des projets ind&eacute;pendants : publication standardis&eacute;e d&#39;information, distribution automatique de modules jar. Ainsi en version de base, Maven peut dynamiquement t&eacute;l&eacute;charger du mat&eacute;riel sur des d&eacute;p&ocirc;ts logiciels connus. Il propose ainsi la synchronisation transparente de modules n&eacute;cessaires.</span><br />\r\nMaven1 et Maven2 ont &eacute;t&eacute; d&eacute;velopp&eacute;s en parall&egrave;le mais les versions futures seront bas&eacute;es sur la structure de la deuxi&egrave;me version. Les parties suivantes de l&#39;article traitent en priorit&eacute; Maven2.</p>', 1, 10, 130),
(2, '2013-07-17 19:00:07', '<p>Spring est un framework libre pour construire et d&eacute;finir l&#39;infrastructure d&#39;une application java2, dont il facilite le d&eacute;veloppement et les tests. En 2004, Rod Johnson a &eacute;crit le livre Expert One-on-One J2EE Design and Development3 qui explique les raisons de la cr&eacute;ation de Spring.</p>', 1, 11, 130),
(3, '2013-07-17 19:01:09', '<p>Apache Struts est un framework libre servant au d&eacute;veloppement d&#39;applications web Java EE. Il utilise et &eacute;tend l&#39;API Servlet Java afin d&#39;encourager les d&eacute;veloppeurs &agrave; adopter l&#39;architecture Mod&egrave;le-Vue-Contr&ocirc;leur. Apache Struts a &eacute;t&eacute; cr&eacute;&eacute; par Craig McClanahan et donn&eacute; &agrave; la fondation Apache en mai 2000. Struts a fait partie du projet Jakarta de mai 2000 jusqu&#39;en mars 20041,2.</p>\r\n\r\n<p><span style="line-height:1.6em">Cette infrastructure permet la conception et l&#39;impl&eacute;mentation d&#39;applications Web de taille importante par diff&eacute;rents groupes de personnes. En d&#39;autres termes, les designers, d&eacute;veloppeurs de composants logiciels peuvent g&eacute;rer leur propre part du projet de mani&egrave;re d&eacute;coupl&eacute;e.</span><br />\r\nStruts permet la structuration d&#39;une application Java sous forme d&#39;un ensemble d&#39;actions repr&eacute;sentant des &eacute;v&eacute;nements d&eacute;clench&eacute;s par les utilisateurs de l&#39;application. Ces actions sont d&eacute;crites dans un fichier de configuration de type XML d&eacute;crivant les cheminements possibles entre les diff&eacute;rentes actions. En plus de cela, Struts permet d&#39;automatiser la gestion de certains aspects comme la validation des donn&eacute;es entr&eacute;es par les utilisateurs via l&#39;interface de l&#39;application. Plus besoin de venir coder le contr&ocirc;le de chaque donn&eacute;e fournie par un utilisateur, il suffit de d&eacute;crire les v&eacute;rifications &agrave; effectuer dans un fichier XML d&eacute;di&eacute; &agrave; cette t&acirc;che.</p>\r\n\r\n<p><span style="line-height:1.6em">En utilisant Struts, le d&eacute;veloppeur simplifie son travail au niveau des vues et des contr&ocirc;leurs du mod&egrave;le MVC. Mais il serait inadapt&eacute; d&#39;utiliser ce framework dans des projets de petite taille car il introduit une certaine complexit&eacute;. Struts montre toute sa puissance dans des applications d&#39;une certaine envergure.</span></p>\r\n\r\n<p>Struts est un logiciel libre distribu&eacute; selon les termes de la licence Apache.</p>', 1, 12, 130),
(4, '2013-07-17 19:02:22', '<p>Hibernate est un framework open source g&eacute;rant la persistance des objets en base de donn&eacute;es relationnelle.</p>\r\n\r\n<p><span style="line-height:1.6em">Hibernate est adaptable en termes d&#39;architecture, il peut donc &ecirc;tre utilis&eacute; aussi bien dans un d&eacute;veloppement client lourd, que dans un environnement web l&eacute;ger de type Apache Tomcat ou dans un environnement J2EE complet : WebSphere, JBoss Application Server et Oracle WebLogic Server.</span></p>\r\n\r\n<p>Hibernate apporte une solution aux probl&egrave;mes d&#39;adaptation entre le paradigme objet et les SGBD en rempla&ccedil;ant les acc&egrave;s &agrave; la base de donn&eacute;es par des appels &agrave; des m&eacute;thodes objet de haut niveau.</p>', 1, 13, 130),
(5, '2013-07-17 19:07:00', '<p>Node.js est un framework &eacute;v&eacute;nementiel pour &eacute;crire des applications r&eacute;seau en JavaScript. Il est fond&eacute; sur la machine virtuelle V8 et impl&eacute;mente sous licence MIT les sp&eacute;cifications Common JS.</p>\r\n\r\n<p><span style="line-height:1.6em">Node.js est utilis&eacute; au c&oelig;ur de Palm webOS1.</span></p>', 1, 14, 130),
(6, '2013-07-17 19:08:37', '<p>RequireJS is a JavaScript file and module loader. It is optimized for in-browser use, but it can be used in other JavaScript environments, like Rhino and Node. Using a modular script loader like RequireJS will improve the speed and quality of your code.</p>', 1, 15, 130),
(7, '2013-07-17 19:09:33', '<p>jQuery est une biblioth&egrave;que JavaScript libre qui porte sur l&#39;interaction entre JavaScript (comprenant Ajax) et HTML, et a pour but de simplifier des commandes communes de JavaScript. La premi&egrave;re version date de janvier 2006.<br />\r\nLa biblioth&egrave;que contient notamment les fonctionnalit&eacute;s suivantes :<br />\r\nParcours et modification du DOM (y compris le support des s&eacute;lecteurs CSS 1 &agrave; 3 et un support basique de XPath) ;<br />\r\n&Eacute;v&eacute;nements ;<br />\r\nEffets visuels et animations ;<br />\r\nManipulations des feuilles de style en cascade (ajout/suppression des classes, d&#39;attributs&hellip;) ;<br />\r\nAjax ;<br />\r\nPlugins ;<br />\r\nUtilitaires (version du navigateur&hellip;).</p>', 1, 16, 130),
(8, '2013-07-17 19:10:16', '<p>AngularJS est un framework open-source1 JavaScript, au m&ecirc;me titre que jQuery, MooTools, Prototype ou Dojo. Il a pour but de simplifier la syntaxe javascript, et de combler les faiblesses de javascript en lui ajoutant de nouvelles fonctionnalit&eacute;s. Et ainsi faciliter la r&eacute;alisation d&#39;applications web monopages.</p>\r\n\r\n<p><span style="line-height:1.6em">AngularJS utilise la biblioth&egrave;que open source jQuery. Si jQuery n&#39;est pas pr&eacute;sent dans le chemin du script, AngularJS reprend sa propre impl&eacute;mentation de jQuery lite. Si jQuery est pr&eacute;sent dans le chemin, AngularJS l&#39;utilise pour manipuler le DOM2.</span></p>', 1, 17, 130),
(9, '2013-07-17 19:13:06', '<p>Language Integrated Query (Requ&ecirc;te int&eacute;gr&eacute;e au langage, aussi connu sous le nom de LINQ) est un composant du Framework .NET de Microsoft qui ajoute des capacit&eacute;s d&#39;interrogation sur des donn&eacute;es aux langages .NET en utilisant une syntaxe proche de celle de SQL. La plupart des concepts mis en place par LINQ ont &eacute;t&eacute; initialement test&eacute;s dans un projet de recherche Microsoft nomm&eacute; C&omega;. LINQ a &eacute;t&eacute; mis en production dans le cadre du Framework NET 3.5, le 19 novembre 2007.</p>\r\n\r\n<p><span style="line-height:1.6em">LINQ d&eacute;finit un ensemble d&rsquo;op&eacute;rateurs de requ&ecirc;tes qui peuvent &ecirc;tre utilis&eacute;s pour effectuer des requ&ecirc;tes, filtrer et projeter des donn&eacute;es dans des collections, dans des classes &eacute;num&eacute;rables, dans des structures XML, dans des bases de donn&eacute;es relationnelles, et dans des sources de donn&eacute;es tierce. Bien qu&rsquo;il permette d&rsquo;effectuer des requ&ecirc;tes sur n&rsquo;importe quelle source de donn&eacute;es, il exige que les donn&eacute;es soient encapsul&eacute;es dans des objets. Par cons&eacute;quent, si la source de donn&eacute;es ne stocke pas nativement les donn&eacute;es en tant qu&rsquo;objets, les donn&eacute;es doivent &ecirc;tre mapp&eacute;es sur le domaine objet correspondant. Les requ&ecirc;tes effectu&eacute;es &agrave; l&rsquo;aide d&rsquo;op&eacute;rateurs LINQ seront ex&eacute;cut&eacute;es soit directement par le moteur de traitement de LINQ, soit par un m&eacute;canisme d&rsquo;extension g&eacute;r&eacute; par les providers LINQ. Ceux-ci impl&eacute;mentent leur propre moteur de traitement de requ&ecirc;te, ou convertissent les donn&eacute;es dans un format appropri&eacute; afin qu&rsquo;ils soient ex&eacute;cut&eacute;s sur un syst&egrave;me de stockage de donn&eacute;es diff&eacute;rent (tel qu&rsquo;une base de donn&eacute;es par exemple). Le r&eacute;sultat de la requ&ecirc;te est renvoy&eacute; sous forme d&rsquo;une collection d&rsquo;objets en m&eacute;moire qui peut &ecirc;tre &eacute;num&eacute;r&eacute;e.</span></p>', 1, 18, 130),
(10, '2013-07-17 19:14:31', '<p>Entity Framework permet aux d&eacute;veloppeurs de cr&eacute;er des applications d&#39;acc&egrave;s aux donn&eacute;es en programmant par rapport &agrave; un mod&egrave;le d&#39;application conceptuel au lieu de programmer directement par rapport &agrave; un sch&eacute;ma de stockage relationnel. L&#39;objectif est de diminuer la quantit&eacute; de code et les besoins en maintenance pour les applications orient&eacute;es objet. Les applications reposant sur Entity Framework pr&eacute;sentent les avantages suivants :</p>\r\n\r\n<p>les applications peuvent fonctionner par rapport &agrave; un mod&egrave;le conceptuel plus centr&eacute; sur les applications, comprenant notamment des types avec h&eacute;ritage, des membres complexes et des relations ;</p>\r\n\r\n<p>les applications sont lib&eacute;r&eacute;es des d&eacute;pendances cod&eacute;es en dur sur un moteur de donn&eacute;es ou un sch&eacute;ma de stockage particulier ;</p>\r\n\r\n<p>les mappages entre le mod&egrave;le conceptuel et le sch&eacute;ma sp&eacute;cifique au stockage peuvent &ecirc;tre modifi&eacute;s sans changer le code de l&#39;application ;</p>\r\n\r\n<p>les d&eacute;veloppeurs peuvent utiliser un mod&egrave;le objet d&#39;application coh&eacute;rent qui peut &ecirc;tre mapp&eacute; &agrave; diff&eacute;rents sch&eacute;mas de stockage impl&eacute;ment&eacute;s dans divers syst&egrave;mes de gestion de bases de donn&eacute;es ;</p>\r\n\r\n<p>plusieurs mod&egrave;les conceptuels peuvent &ecirc;tre mapp&eacute;s &agrave; un sch&eacute;ma de stockage unique ;</p>\r\n\r\n<p>la prise en charge de la fonctionnalit&eacute; LINQ (Language-Integrated Query) permet d&#39;effectuer la validation de la syntaxe au moment de la compilation par rapport &agrave; un mod&egrave;le conceptuel.</p>\r\n\r\n<p>L&#39;Entity Framework a &eacute;t&eacute; introduit la premi&egrave;re fois en tant que partie int&eacute;grante du .NET Framework et de la version finale de Microsoft Visual Studio. &Agrave; partir de l&#39;Entity Framework version 4.1, l&#39;Entity Framework ne fait pas partie du .NET Framework, mais repose sur le .NET. Pour obtenir la version la plus r&eacute;cente de l&#39;Entity Framework, utilisez le package &laquo; Entity Framework &raquo; NuGet. Pour plus d&#39;informations, consultez Nouveaut&eacute;s et Versions et contr&ocirc;le de version d&#39;Entity Framework.</p>', 1, 19, 130),
(11, '2013-07-17 19:15:47', '<p>Microsoft SQL Server est un syst&egrave;me de gestion de base de donn&eacute;es (abr&eacute;g&eacute; en SGBD ou SGBDR pour &laquo; Syst&egrave;me de gestion de base de donn&eacute;es relationnelles &raquo;) d&eacute;velopp&eacute; et commercialis&eacute; par la soci&eacute;t&eacute; Microsoft.<br />\r\nBien qu&#39;il ait &eacute;t&eacute; initialement cod&eacute;velopp&eacute; par Sybase et Microsoft, Ashton-Tate a &eacute;galement &eacute;t&eacute; associ&eacute; &agrave; sa premi&egrave;re version, sortie en 1989. Cette version est sortie sur les plates-formes Unix et OS/2. Depuis, Microsoft a port&eacute; ce syst&egrave;me de base de donn&eacute;es sous Windows et il est d&eacute;sormais uniquement pris en charge par ce syst&egrave;me.<br />\r\nEn 1994, le partenariat entre les deux soci&eacute;t&eacute;s ayant &eacute;t&eacute; rompu, Microsoft a sorti la version 6.0 puis 6.5 seul, sur la plate-forme Windows NT.</p>\r\n\r\n<p><span style="line-height:1.6em">Microsoft a continu&eacute; de commercialiser le moteur de base de donn&eacute;es sous le nom de SQL Server</span><br />\r\nTandis que Sybase, pour &eacute;viter toute confusion, a renomm&eacute; Sybase SQL Server en Sybase Adaptive Server Enterprise.<br />\r\nMicrosoft SQL Server fait d&eacute;sormais partie de la strat&eacute;gie technique de Microsoft en mati&egrave;re de base de donn&eacute;es. Le moteur MSDE, qui est la base de SQL Server, doit &agrave; terme remplacer le moteur Jet (celui qui g&egrave;re les bases Access) dans les applications telles que Exchange et Active Directory.</p>\r\n\r\n<p><span style="line-height:1.6em">La version 2005 de SQL Server est sortie le 3 novembre 2005 en m&ecirc;me temps que Visual Studio 2005. La prise en charge de Windows Vista et de Windows Server 2008 n&#39;a &eacute;t&eacute; ajout&eacute;e qu&#39;&agrave; partir du Service Pack 2 (SP2). Actuellement le Service Pack 3 est disponible.</span><br />\r\nLa version 2008 de SQL Server (nom de code Katma&iuml;) est disponible depuis ao&ucirc;t 2008. Elle est actuellement au niveau de service pack 3. Elle est disponible en 9 langues, dont le fran&ccedil;ais.<br />\r\nLa version 2012 de SQL Server est disponible depuis avril 2012.</p>', 1, 20, 130),
(12, '2013-07-17 19:17:57', '<p>Windows PowerShell, anciennement Microsoft Command Shell (MSH), nom de code Monad, est une interface en ligne de commande et un langage de script d&eacute;velopp&eacute; par Microsoft. Il est inclus dans Windows 7 (y compris la version grand public) et fond&eacute; sur la programmation orient&eacute;e objet (et le framework Microsoft .NET).<br />\r\n&Agrave; l&#39;origine, il &eacute;tait pr&eacute;vu que Windows PowerShell soit inclus dans Windows Vista, mais finalement les deux logiciels ont &eacute;t&eacute; disjoints. Microsoft a publi&eacute; une version beta le 11 septembre 2005, une Release Candidate 1 le 25 avril 2006 et une Release Candidate 2 le 26 septembre 2006. La version finale a &eacute;t&eacute; publi&eacute;e le 14 novembre 2006. Windows PowerShell est &eacute;galement inclus dans Microsoft Exchange Server 2007, sorti au quatri&egrave;me trimestre 2006, ainsi que la plupart des produits Microsoft sortis depuis.<br />\r\nWindows PowerShell est compatible avec toutes les versions de Windows qui supportent la version 2.0 de .NET.<br />\r\nDepuis le 24 mars 2009, Windows PowerShell 1.0 pour Windows XP et Vista est distribu&eacute; comme une mise &agrave; jour logicielle facultative par le service Windows Update de Microsoft. Il est int&eacute;gr&eacute; nativement dans Windows 7 en version 2.01. Cette version propose une console d&#39;&eacute;dition de script int&eacute;gr&eacute; appel&eacute; Windows PowerShell ISE (pour Integrated Scripting Environment en anglais) qui apporte une solution alternative &agrave; l&#39;outil PowerGUI Script Editor d&eacute;velopp&eacute; par la soci&eacute;t&eacute; Quest Software. Comme son homologue Windows PowerShell ISE pr&eacute;sente un environnement graphique qui permet l&rsquo;&eacute;dition de script avec coloration syntaxique, affichage des num&eacute;ros de ligne, d&eacute;bogueur int&eacute;gr&eacute; et aide en ligne.</p>', 1, 21, 130),
(13, '2013-07-17 19:21:32', '<p>COUCOU</p>', 1, 22, 130),
(14, '2013-07-17 19:22:07', '<p>COUCOU</p>', 1, 23, 130);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
