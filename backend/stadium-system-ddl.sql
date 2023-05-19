drop table performer;
drop table venue;
drop table stadium_event;
drop table perform_at;
drop table category;
drop table categorize;
drop table seat;
drop table amenity;
drop table customer;
drop table purchase;
drop table ticket;
drop table booking;

create table performer(
    performer_name varchar(20) PRIMARY KEY
);

create table venue(
    venue_name varchar(30),
    venue_address varchar(90),
    PRIMARY KEY (venue_name, venue_address)
);

create table stadium_event (
    event_name varchar(50),
    event_date date,
    venue_name varchar(30) NOT NULL,
    venue_address varchar(90) NOT NULL,
    PRIMARY KEY (event_name, event_date),
    FOREIGN KEY (venue_name, venue_address) REFERENCES
    venue ON DELETE CASCADE
);

create table perform_at (
    performer_name varchar(30),
    event_name varchar(50),
    event_date date,
    PRIMARY KEY (performer_name, event_name, event_date),
    FOREIGN KEY (performer_name) REFERENCES
    performer ON DELETE CASCADE,
    FOREIGN KEY (event_name, event_date) REFERENCES
    stadium_event ON DELETE CASCADE
);

create table category(
    cat_type varchar(15),
    genre varchar(15),
    PRIMARY KEY (cat_type, genre)
);

create table categorize (
    cat_type varchar(15),
    genre varchar(15),
    event_name varchar(50),
    event_date date,
    PRIMARY KEY (cat_type, genre, event_name, event_date),
    FOREIGN KEY (event_name, event_date) REFERENCES
    stadium_event ON DELETE CASCADE,
    FOREIGN KEY (cat_type, genre) REFERENCES
    category ON DELETE CASCADE
);


create table seat(
    seat_avail varchar(5),
    seat_section varchar(3),
    seat_row integer,
    venue_name varchar(30),
    venue_address varchar(90),
    PRIMARY KEY (seat_section, seat_row, venue_name, venue_address),
    FOREIGN KEY (venue_name, venue_address) REFERENCES
    venue ON DELETE CASCADE
);

create table amenity(
    venue_name varchar(30) NOT NULL,
    venue_address varchar(90) NOT NULL,
    amenity_name varchar(30),
    amenity_code varchar(3),
    amenity_type varchar(10),
    PRIMARY KEY (amenity_code),
    FOREIGN KEY (venue_name, venue_address) REFERENCES
    venue ON DELETE CASCADE
);

create table customer(
    customer_name varchar(30),
    email varchar(30),
    customer_id integer,
    customer_password varchar(30),
    PRIMARY KEY (customer_id)
);

create table purchase(
    price integer,
    purchase_id integer,
    customer_id integer NOT NULL,
    PRIMARY KEY (purchase_id),
    FOREIGN KEY (customer_id) REFERENCES
    customer ON DELETE CASCADE
);

create table ticket (
    age_group varchar(10),
    vip_status varchar(15),
    purchase_id integer,
    PRIMARY KEY (purchase_id),
    FOREIGN KEY (purchase_id) REFERENCES
    purchase ON DELETE CASCADE
);

create table booking(
    purchase_id integer,
    event_name varchar(50),
    waitlist_pos integer,
    venue_name varchar(30),
    venue_address varchar(90),
    PRIMARY KEY (purchase_id),
    FOREIGN KEY (venue_name, venue_address) REFERENCES
    venue ON DELETE CASCADE,
    FOREIGN KEY (purchase_id) REFERENCES purchase
    ON DELETE CASCADE
);

insert into performer values('The Weeknd');
insert into performer values('Kendrick Lamar');
insert into performer values('LA Lakers');
insert into performer values('Cirque du Soleil');
insert into performer values('Billie Eilish');

insert into venue values('Michigan Stadium', '1201 S Main St, Ann Arbor, MI 48104, United States');
insert into venue values('Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');
insert into venue values('Staples Center', '1111 S Figueroa St, Los Angeles, CA, 90015');
insert into venue values('Bell Centre', '1909 Av. des Canadiens-de-Montreal, Montreal, QC, H3B 5E8');
insert into venue values('Beaver Stadium', '1 Beaver Stadium, University Park, PA 16802, United States');

insert into stadium_event values('Mr Morale and The Big Steppers Tour', TO_DATE( '28 Apr 2017', 'DD Mon YYYY' ), 'Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');
insert into stadium_event values('The Dawn FM Tour', TO_DATE( '1 Nov 2022', 'DD Mon YYYY' ), 'Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');
insert into stadium_event values('LA Lakers vs. The Golden State Warriors', TO_DATE( '25 Jun 2023', 'DD Mon YYYY' ), 'Staples Center', '1111 S Figueroa St, Los Angeles, CA, 90015');
insert into stadium_event values('The World on Fire', TO_DATE( '18 Aug 2017', 'DD Mon YYYY' ), 'Bell Centre', '1909 Av. des Canadiens-de-Montreal, Montreal, QC, H3B 5E8');
insert into stadium_event values('The Happier Than Ever Tour', TO_DATE( '2 Jan 2023', 'DD Mon YYYY' ), 'Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');

insert into perform_at values('The Weeknd', 'Mr Morale and The Big Steppers Tour', TO_DATE( '28 Apr 2017', 'DD Mon YYYY' ));
insert into perform_at values('Kendrick Lamar','The Dawn FM Tour', TO_DATE( '1 Nov 2022', 'DD Mon YYYY' ));
insert into perform_at values('LA Lakers', 'LA Lakers vs. The Golden State Warriors', TO_DATE( '25 Jun 2023', 'DD Mon YYYY' ));
insert into perform_at values('Cirque du Soleil', 'The World on Fire', TO_DATE( '18 Aug 2017', 'DD Mon YYYY' ));
insert into perform_at values('Billie Eilish', 'The Happier Than Ever Tour', TO_DATE( '2 Jan 2023', 'DD Mon YYYY' ));

insert into category values('Sports', 'Basketball');
insert into category values('Theatre', 'Circus');
insert into category values('Music', 'Alternative');
insert into category values('Music', 'Rap');
insert into category values('Music', 'Pop');

insert into categorize values('Sports', 'Basketball', 'Mr Morale and The Big Steppers Tour', TO_DATE( '28 Apr 2017', 'DD Mon YYYY' ));
insert into categorize values('Theatre', 'Circus', 'The Dawn FM Tour', TO_DATE( '1 Nov 2022', 'DD Mon YYYY' ));
insert into categorize values('Music', 'Alternative', 'LA Lakers vs. The Golden State Warriors', TO_DATE( '25 Jun 2023', 'DD Mon YYYY' ));
insert into categorize values('Music', 'Rap', 'The World on Fire', TO_DATE( '18 Aug 2017', 'DD Mon YYYY' ));
insert into categorize values('Music', 'Pop', 'The Happier Than Ever Tour', TO_DATE( '2 Jan 2023', 'DD Mon YYYY' ));

insert into seat values('Yes', 'A1', 18, 'Michigan Stadium', '1201 S Main St, Ann Arbor, MI 48104, United States');
insert into seat values('No', 'A3', 7, 'Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');
insert into seat values('Yes', 'A2', 1, 'Staples Center', '1111 S Figueroa St, Los Angeles, CA, 90015');
insert into seat values('No', 'A1', 7, 'Bell Centre', '1909 Av. des Canadiens-de-Montreal, Montreal, QC, H3B 5E8');
insert into seat values('Yes', 'A1', 5, 'Beaver Stadium', '1 Beaver Stadium, University Park, PA 16802, United States');

insert into amenity values('Michigan Stadium', '1201 S Main St, Ann Arbor, MI 48104, United States', 'Womens Washroom','W21', 'Washroom');
insert into amenity values('Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1', 'Tim Hortons', 'F14', 'Food');
insert into amenity values('Staples Center', '1111 S Figueroa St, Los Angeles, CA, 90015', 'Wine Bar', 'B25','Beverage');
insert into amenity values('Bell Centre', '1909 Av. des Canadiens-de-Montreal, Montreal, QC, H3B 5E8', 'Mens Changeroom', 'C03','Changeroom');
insert into amenity values('Beaver Stadium', '1 Beaver Stadium, University Park, PA 16802, United States', 'TD Bank', 'B01','Banking');

insert into customer values('Shafquat', 'gkid175@gmail.com', 1001, 'bl1hck');
insert into customer values('Josiah', 'josiahkievit@gmail.com', 2002, 'aijbdef');
insert into customer values('Adonis', 'adonis1@gmail.com', 3003, 'asnncdln');
insert into customer values('Jefferey', 'jeffrey100@gmail.com', 4004, 'asndmna');
insert into customer values('Anastasia', 'anastasia1001@gmail.com', 5005, 'sjdlfkj');

insert into purchase values(101, 48574 ,1001);
insert into purchase values(409, 67878 ,2002);
insert into purchase values(143, 19238 ,3003);
insert into purchase values(88, 03984 ,4004);
insert into purchase values(601, 57584 ,5005);

insert into ticket values('0-3', 'No', 48574);
insert into ticket values('3-12', 'No' , 67878);
insert into ticket values('12-17', 'No' , 19238);
insert into ticket values('18-45', 'Yes' , 03984);
insert into ticket values('45-65', 'No' , 57584);

insert into booking values(48574, 'Mr Morale and The Big Steppers Tour', 3, 'Michigan Stadium', '1201 S Main St, Ann Arbor, MI 48104, United States');
insert into booking values(67878, 'The Dawn FM Tour', 75, 'Rogers Arena', '800 Griffiths Way, Vancouver, BC, V6B 6G1');
insert into booking values(19238, 'LA Lakers vs. The Golden State Warriors', 24, 'Staples Center', '1111 S Figueroa St, Los Angeles, CA, 90015');
insert into booking values(03984, 'The World on Fire', 9, 'Bell Centre', '1909 Av. des Canadiens-de-Montreal, Montreal, QC, H3B 5E8');
insert into booking values(57584, 'The Happier Than Ever Tour', 1,'Beaver Stadium', '1 Beaver Stadium, University Park, PA 16802, United States');