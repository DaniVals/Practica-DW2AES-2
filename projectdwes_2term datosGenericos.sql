-- ======== por si lo copias todo entero ========
USE `projectdwes_2term`;

-- ======= datos =======
-- asegurate de que las ID del usuario coinciden
INSERT INTO `profile`(`userName`, `idUser`, `bio`, `followers`, `following`) 
VALUES ('monstah',4,'Hola SadowGram',0,0);
INSERT INTO `profile`(`userName`, `idUser`, `bio`, `followers`, `following`) 
VALUES ('videosboy',5,'Hola SadowGram',0,0);
INSERT INTO `profile`(`userName`, `idUser`, `bio`, `followers`, `following`) 
VALUES ('nvr',6,'Hola SadowGram',0,0);

-- el post esta en videosboy (yo)
INSERT INTO `post`(`idPoster`, `likes`, `dislikes`, `commentAmount`, `contentRoute`) 
VALUES (5,0,0, 0, '/userData/2/posts/1.png');