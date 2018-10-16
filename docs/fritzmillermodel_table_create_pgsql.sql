CREATE TABLE public.users (
    id SERIAL NOT NULL,
    name character varying (255) NOT NULL,
    is_admin boolean NOT NULL DEFAULT FALSE,
    email character varying (255) UNIQUE NOT NULL,
    PASSWORD character varying (60) NOT NULL,
    remember_token character varying (100),
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.password_resets (
    id SERIAL NOT NULL,
    email character varying (255) NOT NULL,
    token character varying (255) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.password_resets (email);

CREATE TABLE public.articles (
    id SERIAL NOT NULL,
    article_content text NOT NULL,
    publication_date date NOT NULL,
    active BOOLEAN DEFAULT TRUE NOT NULL,
    title varchar(250) NOT NULL,
    subtitle varchar(250) NOT NULL,
    figure_path varchar(500) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.article_specie (
    id SERIAL NOT NULL,
    species_id integer NOT NULL,
    article_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.article_specie (species_id);

CREATE INDEX ON public.article_specie (article_id);

CREATE TABLE public.article_author (
    id SERIAL NOT NULL,
    author_id integer NOT NULL,
    article_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.article_author (author_id);

CREATE INDEX ON public.article_author (article_id);

CREATE TABLE public.article_tag (
    id SERIAL NOT NULL,
    tag_id integer NOT NULL,
    article_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.article_tag (tag_id);

CREATE INDEX ON public.article_tag (article_id);

CREATE TABLE public.author (
    id SERIAL NOT NULL,
    author_name varchar(100) NOT NULL,
    author_surname varchar(100) NOT NULL,
    bio text NOT NULL,
    contact varchar(100) NOT NULL,
    figure_path varchar(500) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.tag (
    id SERIAL NOT NULL,
    word varchar(60) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE public.tag
    ADD UNIQUE (word);

CREATE TABLE public.project (
    id SERIAL NOT NULL,
    project_description text NOT NULL,
    figure_path varchar(500) NOT NULL,
    project_name varchar(200) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.member (
    id SERIAL NOT NULL,
    project_id integer NOT NULL,
    member_name varchar(300) NOT NULL,
    member_description text NOT NULL,
    grad varchar(200) NOT NULL,
    figure_path varchar(500) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.member (project_id);

CREATE TABLE public.merchandise (
    id SERIAL NOT NULL,
    figure_path varchar(500) NOT NULL,
    title varchar(100) NOT NULL,
    activity_description varchar(300) NOT NULL,
    target_url varchar(300) NOT NULL,
    active BOOLEAN DEFAULT TRUE NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.species_detail (
    id SERIAL NOT NULL,
    taxonomy_group_id integer NOT NULL,
    species_description text NOT NULL,
    figure_path varchar(500) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.species_detail (taxonomy_group_id);

CREATE TABLE public.popular_name (
    id SERIAL NOT NULL,
    species_detail_id integer NOT NULL,
    popular_name varchar(200) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.popular_name (species_detail_id);

CREATE TABLE public.taxonomy_rank_family (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_genus (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_kingdom (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_class (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_order (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_phylum (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_rank_specie (
    id SERIAL NOT NULL,
    rank_name varchar(300) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE public.taxonomy_group (
    id SERIAL NOT NULL,
    kingdom_id integer NOT NULL,
    phylum_id integer NOT NULL,
    class_id integer NOT NULL,
    order_id integer NOT NULL,
    family_id integer NOT NULL,
    genus_id integer NOT NULL,
    specie_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    PRIMARY KEY (id)
);

CREATE INDEX ON public.taxonomy_group (kingdom_id);

CREATE INDEX ON public.taxonomy_group (phylum_id);

CREATE INDEX ON public.taxonomy_group (class_id);

CREATE INDEX ON public.taxonomy_group (order_id);

CREATE INDEX ON public.taxonomy_group (family_id);

CREATE INDEX ON public.taxonomy_group (genus_id);

CREATE INDEX ON public.taxonomy_group (specie_id);

ALTER TABLE public.article_specie
    ADD CONSTRAINT FK_article_specie__species_id FOREIGN KEY (species_id) REFERENCES public.species_detail (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.article_specie
    ADD CONSTRAINT FK_article_specie__article_id FOREIGN KEY (article_id) REFERENCES public.articles (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.article_author
    ADD CONSTRAINT FK_article_author__author_id FOREIGN KEY (author_id) REFERENCES public.author (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.article_author
    ADD CONSTRAINT FK_article_author__article_id FOREIGN KEY (article_id) REFERENCES public.articles (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.article_tag
    ADD CONSTRAINT FK_article_tag__tag_id FOREIGN KEY (tag_id) REFERENCES public.tag (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.article_tag
    ADD CONSTRAINT FK_article_tag__article_id FOREIGN KEY (article_id) REFERENCES public.articles (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.member
    ADD CONSTRAINT FK_member__project_id FOREIGN KEY (project_id) REFERENCES public.project (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.species_detail
    ADD CONSTRAINT FK_species_detail__taxonomy_group_id FOREIGN KEY (taxonomy_group_id) REFERENCES public.taxonomy_group (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.popular_name
    ADD CONSTRAINT FK_popular_name__species_detail_id FOREIGN KEY (species_detail_id) REFERENCES public.species_detail (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__kingdom_id FOREIGN KEY (kingdom_id) REFERENCES public.taxonomy_rank_kingdom (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__phylum_id FOREIGN KEY (phylum_id) REFERENCES public.taxonomy_rank_phylum (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__class_id FOREIGN KEY (class_id) REFERENCES public.taxonomy_rank_class (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__order_id FOREIGN KEY (order_id) REFERENCES public.taxonomy_rank_order (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__family_id FOREIGN KEY (family_id) REFERENCES public.taxonomy_rank_family (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__genus_id FOREIGN KEY (genus_id) REFERENCES public.taxonomy_rank_genus (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

ALTER TABLE public.taxonomy_group
    ADD CONSTRAINT FK_taxonomy_group__specie_id FOREIGN KEY (specie_id) REFERENCES public.taxonomy_rank_specie (id) MATCH SIMPLE ON
    UPDATE
        CASCADE ON DELETE CASCADE;

