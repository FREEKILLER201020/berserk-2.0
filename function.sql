

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
CREATE PROCEDURE indexx (IN datte date, IN orderr varchar(500), IN clann_id int)


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
 CREATE PROCEDURE indexx_all (IN datte date, IN orderr varchar(500))


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
 select * from clans where id=idd order by timemark desc limit 1;

  END$$

  DELIMITER ;

  DELIMITER $$
  CREATE PROCEDURE get_city_data_id (IN idd int)


  BEGIN
 select * from cities where id=idd order by timemark desc limit 1;

  END$$

  DELIMITER ;

    DELIMITER $$
    CREATE PROCEDURE get_city_data (IN titlee varchar(100))


    BEGIN
   select * from cities where name=titlee order by timemark desc limit 1;

    END$$

    DELIMITER ;



    DELIMITER $$
    CREATE PROCEDURE clans_list_one_title (IN titlee varchar(100))


    BEGIN
   select * from clans where title=titlee order by timemark desc limit 1;

    END$$

    DELIMITER ;


 DELIMITER $$
 CREATE PROCEDURE era_data (IN idd integer)


 BEGIN
select * from eras where id=idd;

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

  CREATE TEMPORARY TABLE Players_t (id integer,nick nvarchar(500));

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
CREATE PROCEDURE in_era_data (IN era_id integer, IN datte date, IN orderr varchar(500), IN clann_id int)


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

  select started, ended into startedd, endedd from eras where id=era_id;


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
 CREATE PROCEDURE in_era_data_all (IN era_id integer, IN datte date, IN orderr varchar(500))


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

   select started, ended into startedd, endedd from eras where id=era_id;


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

 INSERT into matches (forum,game) values (id_forum,id_game);
SELECT * from matches where forum=id_forum and game=id_game;

  END$$

  DELIMITER ;
