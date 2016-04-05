/* creation of database
CREATE USER 'u993810798_hari'@'localhost' IDENTIFIED BY  '***';

GRANT USAGE ON * . * TO  'u993810798_hari'@'localhost' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

GRANT ALL PRIVILEGES ON  `u993810798_hari` . * TO  'u993810798_hari'@'localhost';

*/



/* language master */
create table db_language_master (
    languageid int(11) not null auto_increment primary key,
    language varchar(255) not null unique key
);

/* shelf master */
create table db_shelf_master (
    shelfid int(11) not null auto_increment primary key,
    shelf varchar(255) not null unique key,
    shelf_address varchar(500)
);

/* author master */
create table db_author_master (
    authorid int(11) not null auto_increment primary key,
    author varchar(255) not null unique key,
    author_application varchar(500)
);

/* Book Master */
create table db_book_master (
    bookid int(11) not null auto_increment primary key,
    book varchar(255) not null unique key,
    publicationid int(11) ,
    authorid int(11) , 
    shelfid int(11) ,
    publication_series varchar(255),
    len int(11),
    brd int(11),
    wdh int(11),
    foreign key (publicationid) references db_publication_master (publicationid) on delete set null,
    foreign key (authorid) references db_author_master (authorid) on delete set null,
    foreign key (shelfid) references db_shelf_master (shelfid)  on delete set null
); 

create table db_publication_master (
    publicationid int(11) not null auto_increment primary key,
    publication varchar(255) not null unique key,
    publication_series varchar(255) comment 'ex. monthly : in books will write Mar05' 
);
    