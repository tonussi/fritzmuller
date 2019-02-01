CREATE TABLE users (
id integer NOT NULL AUTO_INCREMENT,
name character varying (255) NOT NULL,
is_admin boolean NOT NULL DEFAULT FALSE,
email character varying (255) UNIQUE NOT NULL,
password character varying (60) NOT NULL,
remember_token character varying (100),
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE ticket (
id INT NOT NULL AUTO_INCREMENT,
ticket_number VARCHAR(60) UNIQUE NOT NULL,
user_creator_id INT NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE password_resets (
id integer NOT NULL AUTO_INCREMENT,
email character varying (255) NOT NULL,
token character varying (255) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE oauth_providers (
id integer NOT NULL AUTO_INCREMENT,
user_id int (11) NOT NULL,
provider varchar(255) NOT NULL,
provider_user_id varchar(255) NOT NULL,
access_token varchar(255) DEFAULT NULL,
refresh_token varchar(255) DEFAULT NULL,
created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE articles (
id integer NOT NULL AUTO_INCREMENT,
article_content text NOT NULL,
publication_date date NOT NULL,
active BOOLEAN DEFAULT TRUE NOT NULL,
title varchar(250) NOT NULL,
price float DEFAULT 0.25,
rating int DEFAULT 3,
subtitle varchar(250) NOT NULL,
figure_path varchar(500) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE article_author (
id integer NOT NULL AUTO_INCREMENT,
author_id integer NOT NULL,
article_id integer NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE author (
id integer NOT NULL AUTO_INCREMENT,
author_name varchar(100) NOT NULL,
author_surname varchar(100) NOT NULL,
bio text NOT NULL,
contact varchar(100) NOT NULL,
figure_path varchar(500) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE project (
id integer NOT NULL AUTO_INCREMENT,
project_description text NOT NULL,
figure_path varchar(500) NOT NULL,
project_name varchar(200) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE member (
id integer NOT NULL AUTO_INCREMENT,
project_id integer NOT NULL,
member_name varchar(300) NOT NULL,
member_description text NOT NULL,
grad varchar(200) NOT NULL,
figure_path varchar(500) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE merchandise (
id integer NOT NULL AUTO_INCREMENT,
figure_path varchar(500) NOT NULL,
title varchar(100) NOT NULL,
activity_description varchar(300) NOT NULL,
target_url varchar(300) NOT NULL,
active BOOLEAN DEFAULT TRUE NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE article_specie (
id integer NOT NULL AUTO_INCREMENT,
species_id integer NOT NULL,
article_id integer NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE specie_detail (
id integer NOT NULL AUTO_INCREMENT,
taxonomy_group_id integer NOT NULL,
specie_description text NOT NULL,
figure_path varchar(500) NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_family (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_genus (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_kingdom (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_class (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_order (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_phylum (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_rank_specie (
id integer NOT NULL AUTO_INCREMENT,
rank_name varchar(300) NOT NULL UNIQUE,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

CREATE TABLE taxonomy_group (
id integer NOT NULL AUTO_INCREMENT,
kingdom_id integer NOT NULL,
phylum_id integer NOT NULL,
class_id integer NOT NULL,
order_id integer NOT NULL,
family_id integer NOT NULL,
genus_id integer NOT NULL,
specie_id integer NOT NULL,
created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (id)) ENGINE = InnoDB;

ALTER TABLE article_specie
ADD CONSTRAINT fk_articlespecie_speciesdetail_id
FOREIGN KEY (species_id)
REFERENCES species_detail (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE article_specie
ADD CONSTRAINT fk_articlespecie_article_id
FOREIGN KEY (article_id)
REFERENCES articles (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE article_author
ADD CONSTRAINT fk_articleauthor_author_id
FOREIGN KEY (author_id)
REFERENCES author (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE article_author
ADD CONSTRAINT fk_articleauthor_article_id
FOREIGN KEY (article_id)
REFERENCES articles (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE member
ADD CONSTRAINT fk_member_project_id
FOREIGN KEY (project_id)
REFERENCES project (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_kingdom_id
FOREIGN KEY (kingdom_id)
REFERENCES taxonomy_rank_kingdom (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE specie_detail
ADD CONSTRAINT fk_speciedetail_taxonomygroup_id
FOREIGN KEY (taxonomy_group_id)
REFERENCES taxonomy_group (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_phylum_id
FOREIGN KEY (phylum_id)
REFERENCES taxonomy_rank_phylum (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_class_id
FOREIGN KEY (class_id)
REFERENCES taxonomy_rank_class (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_order_id
FOREIGN KEY (order_id)
REFERENCES taxonomy_rank_order (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_family_id
FOREIGN KEY (family_id)
REFERENCES taxonomy_rank_family (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_genus_id
FOREIGN KEY (genus_id)
REFERENCES taxonomy_rank_genus (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE taxonomy_group
ADD CONSTRAINT fk_taxonomygroup_specie_id
FOREIGN KEY (specie_id)
REFERENCES taxonomy_rank_specie (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE oauth_providers
ADD CONSTRAINT fk_oauth_providers_user_id
FOREIGN KEY (user_id)
REFERENCES users (id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ticket
ADD CONSTRAINT fk_ticket_user_creator
FOREIGN KEY (user_creator_id)
REFERENCES users (id)
ON DELETE CASCADE ON UPDATE CASCADE;
