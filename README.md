# books
WebDatenbank zur Verwaltung meiner Bücher
# Books Server Website für eine Private Bücherdatenbank

### Datenbankspezifikationen:

Alle Inhalte sowohl im HTML als auch der DB basieren auf Charset: UTF-8

Hauptdatenbank: books
erstellen in der Wunsch DB auf UTF-8 achten.

Alle verwendeten SQL Befehlsstring folgen dem SQL99 Standard.

Die Tabellen in der DB sind folgend Definert.

## SQL Server

### Tabelle autor

    CREATE TABLE autor
    (
    au_id        INT IDENTITY,
    au_lastname  VARCHAR(50) NOT NULL,
    au_firstname VARCHAR(50),
    au_biografie VARCHAR(255)
    )
    
### Tabelle bind

    CREATE TABLE bind
    (
    bi_id   INT IDENTITY,
    bi_type VARCHAR(20) NOT NULL
    )

### Tabelle book

    CREATE TABLE book
    (
    bo_id        INT IDENTITY,
    bo_co_id     INT NOT NULL,
    bo_ge_id     INT NOT NULL,
    bo_pb_id     INT NOT NULL,
    bo_st_id     INT NOT NULL,
    bo_st_id_dc  INT NOT NULL,
    bo_has_dc    INT NOT NULL,
    bo_has_read  TYNYINT NOT NULL,
    bo_bi_id     INT NOT NULL,
    bo_bs_id     INT NOT NULL,
    bo_title     VARCHAR(100) NOT NULL,
    bo_print_run VARCHAR(50) NOT NULL,
    bo_isbn      CHAR(20) NOT NULL,
    bo_height    FLOAT NOT NULL,
    bo_width     FLOAT NOT NULL,
    bo_deep      FLOAT NOT NULL,
    bo_price     FLOAT NOT NULL,
    bo_weight_gr FLOAT NOT NULL,
    bo_conferred VARCHAR(40) NOT NULL,
    bo_comment   VARCHAR(200) NOT NULL
    )


### Tabelle book_series

    CREATE TABLE book_series
    (
    bs_id    INT IDENTITY,
    bs_name  VARCHAR(60) NOT NULL
    )

### Tabelle cover

    CREATE TABLE cover
    (
    co_id    INT IDENTITY,
    co_type  VARCHAR(20) NOT NULL
    )

### Tabelle genre

    CREATE TABLE genre
    (
    ge_id    INT IDENTITY,
    ge_type  VARCHAR(20)
    )

### Tabelle ll_bo_au

    CREATE TABLE ll_bo_au
    (
    ll_bo_au_id     INT IDENTITY,
    ll_bo_au_au_id 	INT NOT NULL,
    ll_bo_au_bo_id 	INT NOT NULL
    )
    

### Tabelle publisher

    CREATE TABLE publisher
    (
    pb_id         INT IDENTITY,
    pb_name       VARCHAR(255) NOT NULL,
    pb_street     VARCHAR(40),
    pb_location   VARCHAR(40),
    pb_postindex  VARCHAR(5)
    )

### Tabelle storage

    CREATE TABLE storage
    (
    st_id       INT IDENTITY,
    st_name     VARCHAR(50) NOT NULL,
    st_height   FLOAT NOT NULL,
    st_width    FLOAT NOT NULL,
    st_deep     FLOAT NOT NULL,
    st_location VARCHAR(50) NOT NULL,
    st_capa     SMALLINT(6) NOT NULL
    )

### Tabelle user

    CREATE TABLE user
    (
    us_id       INT IDENTITY,
    us_name     VARCHAR(20) NOT NULL UNIQUE,
    us_pass     VARCHAR(32) NOT NULL,
    us_working  VARCHAR(10) NOT NULL,
    us_level    TINYINT(4) NOT NULL
    )


## MySQl/MariaDB

### Tabelle autor

    CREATE TABLE `autor` (
    `au_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `au_lastname` varchar(50) COLLATE latin1_german2_ci NOT NULL,
    `au_firstname` varchar(50) COLLATE latin1_german2_ci DEFAULT NULL,
    `au_biografie` varchar(255) COLLATE latin1_german2_ci DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;    CREATE TABLE 'autor'
    
### Tabelle bind

    CREATE TABLE `bind` (
    `bi_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `bi_type` varchar(20) COLLATE latin1_german2_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle book

    CREATE TABLE `book` (
    `bo_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `bo_co_id` int(11) NOT NULL,
    `bo_ge_id` int(11) NOT NULL,
    `bo_pb_id` int(11) NOT NULL,
    `bo_st_id` int(11) NOT NULL,
    `bo_st_id_dc` int(11) NOT NULL,
    `bo_has_dc` int(11) NOT NULL,
    `bo_has_read` tinyint(1) NOT NULL,
    `bo_bi_id` int(11) NOT NULL,
    `bo_bs_id` int(11) NOT NULL,
    `bo_title` varchar(100) COLLATE latin1_german2_ci NOT NULL,
    `bo_print_run` varchar(50) COLLATE latin1_german2_ci NOT NULL,
    `bo_isbn` char(20) COLLATE latin1_german2_ci NOT NULL,
    `bo_height` float NOT NULL,
    `bo_width` float NOT NULL,
    `bo_deep` float NOT NULL,
    `bo_price` float NOT NULL,
    `bo_weight_gr` float NOT NULL,
    `bo_conferred` varchar(40) COLLATE latin1_german2_ci NOT NULL,
    `bo_comment` varchar(200) COLLATE latin1_german2_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle book_series

    CREATE TABLE `book_series` (
    `bs_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `bs_name` varchar(60) COLLATE latin1_german2_ci NOT NULL UNIQUE KEY
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle cover

    CREATE TABLE `cover` (
    `co_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `co_type` varchar(20) COLLATE latin1_german2_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle genre

    CREATE TABLE `genre` (
    `ge_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `ge_type` varchar(20) COLLATE latin1_german2_ci NOT NULL UNIQUE KEY
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle ll_bo_au

    CREATE TABLE `ll_bo_au` (
    `ll_bo_au_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `ll_bo_au_au_id` int(11) NOT NULL,
    `ll_bo_au_bo_id` int(11) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle publisher

    CREATE TABLE `publisher` (
    `pb_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `pb_name` varchar(255) COLLATE latin1_german2_ci NOT NULL,
    `pb_street` varchar(40) COLLATE latin1_german2_ci NOT NULL,
    `pb_location` varchar(40) COLLATE latin1_german2_ci NOT NULL,
    `pb_postindex` varchar(5) COLLATE latin1_german2_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle storage

    CREATE TABLE `storage` (
    `st_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `st_name` varchar(50) COLLATE latin1_german2_ci NOT NULL,
    `st_height` float NOT NULL,
    `st_width` float NOT NULL,
    `st_deep` float NOT NULL,
    `st_location` varchar(50) COLLATE latin1_german2_ci NOT NULL,
    `st_capa` smallint(6) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

### Tabelle user

    CREATE TABLE `user` (
    `us_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `us_name` varchar(20) COLLATE latin1_german2_ci NOT NULL UNIQUE KEY,
    `us_pass` varchar(32) COLLATE latin1_german2_ci NOT NULL,
    `us_working` varchar(10) COLLATE latin1_german2_ci NOT NULL,
    `us_level` tinyint(4) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

