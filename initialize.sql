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
create table author_master (
    authorid int(11) not null auto_increment primary key,
    author varchar(255) not null unique key,
    author_application varchar(500)
);

/* Book Master */
create table book_master (
    bookid int(11) not null auto_increment primary key,
    book varchar(255) not null unique key,
    authorid int(11) , 
    shelfid int(11) ,
    len int(11),
    brd int(11),
    wdh int(11),
    foreign key (authorid) references author_master (authorid) on delete set null,
    foreign key (shelfid) references shelf_master (shelfid)  on delete set null
);  