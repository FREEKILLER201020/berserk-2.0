DROP DATABASE IF EXISTS berserk;

CREATE DATABASE IF NOT EXISTS berserk;

USE berserk;

-- CREATE TABLE `Admins` (
--   `id` int
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- ALTER TABLE `Admins`
--   ADD UNIQUE KEY `id` (`id`);


CREATE TABLE `Attacks` (
  `fromm` varchar(100) DEFAULT NULL,
  `too` varchar(100) DEFAULT NULL,
  `attacker` int(11) DEFAULT NULL,
  `defender` int(11) DEFAULT NULL,
  `declared` datetime DEFAULT NULL,
  `resolved` datetime DEFAULT NULL,
  `ended` datetime DEFAULT NULL,
  `winer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Cards`
--

CREATE TABLE `Cards` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` int(11) NOT NULL,
  `file` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Card_type`
--

CREATE TABLE `Card_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(30) NOT NULL,
  `type_full_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Cities`
--

CREATE TABLE `Cities` (
  `timemark` datetime NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `clan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Clans`
--

CREATE TABLE `Clans` (
  `timemark` datetime DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `gone` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Eras`
--

CREATE TABLE `Eras` (
  `id` int(11) NOT NULL,
  `started` date NOT NULL,
  `ended` date NOT NULL,
  `lbz` varchar(150) DEFAULT NULL,
  `pointw` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Logs`
--

CREATE TABLE `Logs` (
  `timemark` datetime NOT NULL,
  `log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Matches`
--

-- CREATE TABLE `Matches` (
--   `forum` int(11) NOT NULL,
--   `game` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Players`
--

-- CREATE TABLE `Players` (
--   `timemark` datetime DEFAULT NULL,
--   `id` int(11) DEFAULT NULL,
--   `nick` varchar(100) DEFAULT NULL,
--   `frags` int(11) DEFAULT NULL,
--   `deaths` int(11) DEFAULT NULL,
--   `level` int(11) DEFAULT NULL,
--   `clan_id` int(11) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Sets`
--

CREATE TABLE `Sets` (
  `timemark` datetime NOT NULL,
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `cards` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cards`
--
ALTER TABLE `Cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `Card_type`
--
ALTER TABLE `Card_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `Clans`
--
ALTER TABLE `Clans`
  ADD KEY `id` (`id`),
  ADD KEY `timemark` (`timemark`);

--
-- Indexes for table `Eras`
--
ALTER TABLE `Eras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Matches`
--
-- ALTER TABLE `Matches`
--   ADD PRIMARY KEY (`forum`);

--
-- Indexes for table `Players`
--
-- ALTER TABLE `Players`
--   ADD KEY `timemark` (`timemark`),
--   ADD KEY `id` (`id`);

--
-- Indexes for table `Sets`
--
ALTER TABLE `Sets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cards`
--
ALTER TABLE `Cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Card_type`
--
ALTER TABLE `Card_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Sets`
--
ALTER TABLE `Sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--   DELIMITER $$
--   CREATE PROCEDURE AddAdmin(in idd int)
--
--   BEGIN
-- insert into Admins (id) values (idd);
--   END$$
--
--   DELIMITER ;
--
--
--     DELIMITER $$
--     CREATE PROCEDURE DeleteAdmin(in idd int)
--
--     BEGIN
--   delete from Admins where id=idd;
--     END$$
--
--     DELIMITER ;



DELIMITER $$
CREATE PROCEDURE cities_all ()


BEGIN

 DECLARE v_finished INTEGER DEFAULT 0;
        DECLARE idd integer;
 -- declare cursor for employee email
 DEClARE ids_cursor CURSOR FOR
 SELECT DISTINCT id FROM Cities;

 -- declare NOT FOUND handler
 DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET v_finished = 1;

 CREATE TEMPORARY TABLE Cities_t LIKE Cities;

 OPEN ids_cursor;

 get_email: LOOP

 FETCH ids_cursor INTO idd;


 IF v_finished = 1 THEN
 LEAVE get_email;
 END IF;

 -- build email list
 INSERT into Cities_t select * FROM Cities where id=idd order by timemark DESC LIMIT 1;


 END LOOP get_email;

 CLOSE ids_cursor;
 -- select orderr;
 -- select * from Players_t order by nick;
 select * from Cities_t order by id;

 DROP TEMPORARY TABLE Cities_t;

END$$

DELIMITER ;







 DELIMITER $$
CREATE PROCEDURE indexx (IN datte date, IN orderr text(500), IN clann_id int)


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Players;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Players_t LIKE Players;

  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and clan_id=clann_id order by timemark DESC LIMIT 1;


  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;








 DELIMITER $$
 CREATE PROCEDURE indexx_all (IN datte date, IN orderr text(500))


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Players;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Players_t LIKE Players;

  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte order by timemark DESC LIMIT 1;


  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;









 DELIMITER $$
CREATE PROCEDURE clans_list (IN datte date)


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Clans;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Clans_t LIKE Clans;

  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list
  INSERT into Clans_t select * FROM Clans where id=idd and timemark<=datte and gone is null order by timemark DESC LIMIT 1;


  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select DISTINCT id,title from Clans_t;

  DROP TEMPORARY TABLE Clans_t;

 END$$

 DELIMITER ;






  DELIMITER $$
 CREATE PROCEDURE clans_list_all ()


  BEGIN

   DECLARE v_finished INTEGER DEFAULT 0;
          DECLARE idd integer;
   -- declare cursor for employee email
   DEClARE ids_cursor CURSOR FOR
   SELECT DISTINCT id FROM Clans;

   -- declare NOT FOUND handler
   DECLARE CONTINUE HANDLER
          FOR NOT FOUND SET v_finished = 1;

   CREATE TEMPORARY TABLE Clans_t LIKE Clans;

   OPEN ids_cursor;

   get_email: LOOP

   FETCH ids_cursor INTO idd;


   IF v_finished = 1 THEN
   LEAVE get_email;
   END IF;

   -- build email list
   INSERT into Clans_t select * FROM Clans where id=idd order by timemark DESC LIMIT 1;


   END LOOP get_email;

   CLOSE ids_cursor;
   -- select orderr;
   -- select * from Players_t order by nick;
   select DISTINCT id,title,points from Clans_t;

   DROP TEMPORARY TABLE Clans_t;

  END$$

  DELIMITER ;




  DELIMITER $$
  CREATE PROCEDURE clans_list_one (IN idd int)


  BEGIN
 select * from Clans where id=idd order by timemark desc limit 1;

  END$$

  DELIMITER ;

  DELIMITER $$
  CREATE PROCEDURE get_city_data_id (IN idd int)


  BEGIN
 select * from Cities where id=idd order by timemark desc limit 1;

  END$$

  DELIMITER ;

    DELIMITER $$
    CREATE PROCEDURE get_city_data (IN titlee text(100))


    BEGIN
   select * from Cities where name=titlee order by timemark desc limit 1;

    END$$

    DELIMITER ;



    DELIMITER $$
    CREATE PROCEDURE clans_list_one_title (IN titlee text(100))


    BEGIN
   select * from Clans where title=titlee order by timemark desc limit 1;

    END$$

    DELIMITER ;


 DELIMITER $$
 CREATE PROCEDURE era_data (IN idd integer)


 BEGIN
select * from Eras where id=idd;

 END$$

 DELIMITER ;




 DELIMITER $$
 CREATE PROCEDURE cards_all ()


 BEGIN
select * from Cards order by id;

 END$$

 DELIMITER ;

 DELIMITER $$
 CREATE PROCEDURE card (in idd integer)


 BEGIN
select * from Cards where id=idd order by id;

 END$$

 DELIMITER ;



 DELIMITER $$
 CREATE PROCEDURE players ()


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Players;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Players_t (id integer,nick text(500));

  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list
  INSERT into Players_t select id,nick FROM Players where id=idd order by timemark DESC LIMIT 1;


  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by id;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;








  DELIMITER $$
  CREATE PROCEDURE players_all ()


  BEGIN

   DECLARE v_finished INTEGER DEFAULT 0;
          DECLARE idd integer;
   -- declare cursor for employee email
   DEClARE ids_cursor CURSOR FOR
   SELECT DISTINCT id FROM Players;

   -- declare NOT FOUND handler
   DECLARE CONTINUE HANDLER
          FOR NOT FOUND SET v_finished = 1;

   CREATE TEMPORARY TABLE Players_t like Players;

   OPEN ids_cursor;

   get_email: LOOP

   FETCH ids_cursor INTO idd;


   IF v_finished = 1 THEN
   LEAVE get_email;
   END IF;

   -- build email list
   INSERT into Players_t select * FROM Players where id=idd order by timemark DESC LIMIT 1;


   END LOOP get_email;

   CLOSE ids_cursor;
   -- select orderr;
   -- select * from Players_t order by nick;
   select * from Players_t order by id;

   DROP TEMPORARY TABLE Players_t;

  END$$

  DELIMITER ;








 DELIMITER $$
CREATE PROCEDURE in_era_data (IN era_id integer, IN datte date, IN orderr text(500), IN clann_id int)


 BEGIN

  DECLARE v_finished INTEGER DEFAULT 0;
         DECLARE idd integer;
         declare startedd date;
         declare endedd date;
  -- declare cursor for employee email
  DEClARE ids_cursor CURSOR FOR
  SELECT DISTINCT id FROM Players;

  -- declare NOT FOUND handler
  DECLARE CONTINUE HANDLER
         FOR NOT FOUND SET v_finished = 1;

  CREATE TEMPORARY TABLE Players_t LIKE Players;

  select started, ended into startedd, endedd from Eras where id=era_id;


  OPEN ids_cursor;

  get_email: LOOP

  FETCH ids_cursor INTO idd;


  IF v_finished = 1 THEN
  LEAVE get_email;
  END IF;

  -- build email list
  INSERT into Players_t select * FROM Players where id=idd and timemark<=datte and timemark>=startedd and timemark<=endedd + INTERVAL 1 DAY and clan_id=clann_id order by timemark ASC;
  INSERT into Players_t select * FROM Players where id=idd and timemark<=startedd and clan_id=clann_id order by timemark ASC limit 1;


  END LOOP get_email;

  CLOSE ids_cursor;
  -- select orderr;
  -- select * from Players_t order by nick;
  select * from Players_t order by nick;

  DROP TEMPORARY TABLE Players_t;

 END$$

 DELIMITER ;




  DELIMITER $$
 CREATE PROCEDURE in_era_data_all (IN era_id integer, IN datte date, IN orderr text(500))


  BEGIN

   DECLARE v_finished INTEGER DEFAULT 0;
          DECLARE idd integer;
          declare startedd date;
          declare endedd date;
   -- declare cursor for employee email
   DEClARE ids_cursor CURSOR FOR
   SELECT DISTINCT id FROM Players;

   -- declare NOT FOUND handler
   DECLARE CONTINUE HANDLER
          FOR NOT FOUND SET v_finished = 1;

   CREATE TEMPORARY TABLE Players_t LIKE Players;

   select started, ended into startedd, endedd from Eras where id=era_id;


   OPEN ids_cursor;

   get_email: LOOP

   FETCH ids_cursor INTO idd;


   IF v_finished = 1 THEN
   LEAVE get_email;
   END IF;

   -- build email list
   INSERT into Players_t select * FROM Players where id=idd and DATE(timemark)<=datte and DATE(timemark)>=startedd and DATE(timemark)<=endedd + INTERVAL 1 DAY order by timemark ASC;
   INSERT into Players_t select * FROM Players where id=idd and DATE(timemark)<=startedd order by timemark desc limit 1;


   END LOOP get_email;

   CLOSE ids_cursor;
   -- select orderr;
   -- select * from Players_t order by nick;
   select * from Players_t order by nick;

   DROP TEMPORARY TABLE Players_t;

  END$$

  DELIMITER ;





    DELIMITER $$
    CREATE PROCEDURE check_id (IN id_game integer)


    BEGIN
    select DISTINCT id from Players where id=id_game limit 1;

    END$$

    DELIMITER ;




        DELIMITER $$
        CREATE PROCEDURE attacks_list_all ()


        BEGIN
        select * from Attacks order by resolved;

        END$$

        DELIMITER ;




  DELIMITER $$
  CREATE PROCEDURE save (IN id_forum integer,IN id_game integer)

  BEGIN

 INSERT into Matches (forum,game) values (id_forum,id_game);
SELECT * from Matches where forum=id_forum and game=id_game;

  END$$

  DELIMITER ;







    DELIMITER $$
   CREATE PROCEDURE fights_history (IN era_id integer)


    BEGIN

     DECLARE v_finished INTEGER DEFAULT 0;
            DECLARE idd integer;
            declare startedd date;
            declare endedd date;
     -- declare cursor for employee email
     -- DEClARE ids_cursor CURSOR FOR
     -- SELECT DISTINCT id FROM Players;

     -- declare NOT FOUND handler
     -- DECLARE CONTINUE HANDLER
     --        FOR NOT FOUND SET v_finished = 1;



     select started, ended into startedd, endedd from Eras where id=era_id;

     --
     -- OPEN ids_cursor;
     --
     -- get_email: LOOP
     --
     -- FETCH ids_cursor INTO idd;
     --
     --
     -- IF v_finished = 1 THEN
     -- LEAVE get_email;
     -- END IF;
     --
     -- -- build email list
     select * FROM Attacks where DATE(resolved)>=startedd and DATE(resolved)<=endedd + INTERVAL 1 DAY  and ended is not null order by resolved ASC;


     --
     -- END LOOP get_email;
     --
     -- CLOSE ids_cursor;
     -- -- select orderr;
     -- -- select * from Players_t order by nick;


    END$$

    DELIMITER ;


    DELIMITER $$
    CREATE PROCEDURE add_cards_set (in datee datetime, in player integer, in json text(10000))

    BEGIN
    insert into Sets (timemark, player_id, cards) values (datee, player, json);

    END$$

    DELIMITER ;



        DELIMITER $$
        CREATE PROCEDURE select_cards_set (in player integer)

        BEGIN
        select * from Sets where player_id=player order by timemark desc;

        END$$

        DELIMITER ;







            DELIMITER $$
           CREATE PROCEDURE fights_timetable ()


            BEGIN

             DECLARE v_finished INTEGER DEFAULT 0;
             -- declare cursor for employee email
             -- DEClARE ids_cursor CURSOR FOR
             -- SELECT DISTINCT id FROM Players;

             -- declare NOT FOUND handler
             -- DECLARE CONTINUE HANDLER
             --        FOR NOT FOUND SET v_finished = 1;



             --
             -- OPEN ids_cursor;
             --
             -- get_email: LOOP
             --
             -- FETCH ids_cursor INTO idd;
             --
             --
             -- IF v_finished = 1 THEN
             -- LEAVE get_email;
             -- END IF;
             --
             -- -- build email list
             select * FROM Attacks where ended is null order by resolved ASC;


             --
             -- END LOOP get_email;
             --
             -- CLOSE ids_cursor;
             -- -- select orderr;
             -- -- select * from Players_t order by nick;


            END$$

            DELIMITER ;




             DELIMITER $$
            CREATE PROCEDURE cities_clan (IN clan_idd int)


             BEGIN

              DECLARE v_finished INTEGER DEFAULT 0;
                     DECLARE idd integer;
              -- declare cursor for employee email
              DEClARE ids_cursor CURSOR FOR
              SELECT DISTINCT id FROM Cities;

              -- declare NOT FOUND handler
              DECLARE CONTINUE HANDLER
                     FOR NOT FOUND SET v_finished = 1;

              CREATE TEMPORARY TABLE Cities_t LIKE Cities;

              OPEN ids_cursor;

              get_email: LOOP

              FETCH ids_cursor INTO idd;


              IF v_finished = 1 THEN
              LEAVE get_email;
              END IF;

              -- build email list
              INSERT into Cities_t select * FROM Cities where id=idd and clan_id=clan_idd order by timemark DESC LIMIT 1;


              END LOOP get_email;

              CLOSE ids_cursor;
              -- select orderr;
              -- select * from Players_t order by nick;
              select * from Cities_t  order by name;

              DROP TEMPORARY TABLE Cities_t;

             END$$

             DELIMITER ;





             DELIMITER $$
            CREATE PROCEDURE cities ()


             BEGIN

              DECLARE v_finished INTEGER DEFAULT 0;
                     DECLARE idd integer;
              -- declare cursor for employee email
              DEClARE ids_cursor CURSOR FOR
              SELECT DISTINCT id FROM Cities;

              -- declare NOT FOUND handler
              DECLARE CONTINUE HANDLER
                     FOR NOT FOUND SET v_finished = 1;

              CREATE TEMPORARY TABLE Cities_t LIKE Cities;

              OPEN ids_cursor;

              get_email: LOOP

              FETCH ids_cursor INTO idd;


              IF v_finished = 1 THEN
              LEAVE get_email;
              END IF;

              -- build email list
              INSERT into Cities_t select * FROM Cities where id=idd order by timemark DESC LIMIT 1;


              END LOOP get_email;

              CLOSE ids_cursor;
              -- select orderr;
              -- select * from Players_t order by nick;
              select * from Cities_t order by name;

              DROP TEMPORARY TABLE Cities_t;

             END$$

             DELIMITER ;
