PGDMP  8                    |            ImHere    16.1    16.1                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            	           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            
           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16502    ImHere    DATABASE     {   CREATE DATABASE "ImHere" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE "ImHere";
                postgres    false            �            1259    16503    alumno    TABLE        CREATE TABLE public.alumno (
    nocontrol character(9) NOT NULL,
    password bytea NOT NULL,
    nombre character varying(45) NOT NULL,
    apellidos character varying(45) NOT NULL,
    sexo boolean NOT NULL,
    direccion character varying(100),
    telefono character(10) NOT NULL
);
    DROP TABLE public.alumno;
       public         heap    postgres    false            �            1259    16529    alumnoclase    TABLE     o   CREATE TABLE public.alumnoclase (
    alumno_nocontrol character(9) NOT NULL,
    clase_id integer NOT NULL
);
    DROP TABLE public.alumnoclase;
       public         heap    postgres    false            �            1259    16518    clase    TABLE       CREATE TABLE public.clase (
    idclase integer NOT NULL,
    codigogrupo character(4) NOT NULL,
    horainicio time(0) without time zone NOT NULL,
    horafin time(0) without time zone NOT NULL,
    nombre character varying(100) NOT NULL,
    profesor_id character(5)
);
    DROP TABLE public.clase;
       public         heap    postgres    false            �            1259    16517    clase_idclase_seq    SEQUENCE     �   CREATE SEQUENCE public.clase_idclase_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.clase_idclase_seq;
       public          postgres    false    218                       0    0    clase_idclase_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.clase_idclase_seq OWNED BY public.clase.idclase;
          public          postgres    false    217            �            1259    16510    profesor    TABLE       CREATE TABLE public.profesor (
    idprofesor character(5) NOT NULL,
    password bytea NOT NULL,
    nombre character varying(45) NOT NULL,
    apellidos character varying(45) NOT NULL,
    telefono character(10),
    direccion character varying(100),
    sexo boolean NOT NULL
);
    DROP TABLE public.profesor;
       public         heap    postgres    false            �            1259    16544    registro    TABLE     �   CREATE TABLE public.registro (
    alumno_nocontrol character(9) NOT NULL,
    clase_id integer NOT NULL,
    asistencia boolean NOT NULL,
    fecha date NOT NULL
);
    DROP TABLE public.registro;
       public         heap    postgres    false            `           2604    16521    clase idclase    DEFAULT     n   ALTER TABLE ONLY public.clase ALTER COLUMN idclase SET DEFAULT nextval('public.clase_idclase_seq'::regclass);
 <   ALTER TABLE public.clase ALTER COLUMN idclase DROP DEFAULT;
       public          postgres    false    217    218    218                       0    16503    alumno 
   TABLE DATA           c   COPY public.alumno (nocontrol, password, nombre, apellidos, sexo, direccion, telefono) FROM stdin;
    public          postgres    false    215   f"                 0    16529    alumnoclase 
   TABLE DATA           A   COPY public.alumnoclase (alumno_nocontrol, clase_id) FROM stdin;
    public          postgres    false    219   �#                 0    16518    clase 
   TABLE DATA           _   COPY public.clase (idclase, codigogrupo, horainicio, horafin, nombre, profesor_id) FROM stdin;
    public          postgres    false    218   $                 0    16510    profesor 
   TABLE DATA           f   COPY public.profesor (idprofesor, password, nombre, apellidos, telefono, direccion, sexo) FROM stdin;
    public          postgres    false    216   ]$                 0    16544    registro 
   TABLE DATA           Q   COPY public.registro (alumno_nocontrol, clase_id, asistencia, fecha) FROM stdin;
    public          postgres    false    220   %                  0    0    clase_idclase_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.clase_idclase_seq', 15, true);
          public          postgres    false    217            b           2606    16509    alumno alumno_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.alumno
    ADD CONSTRAINT alumno_pkey PRIMARY KEY (nocontrol);
 <   ALTER TABLE ONLY public.alumno DROP CONSTRAINT alumno_pkey;
       public            postgres    false    215            i           2606    16533    alumnoclase alumnoclase_pkey 
   CONSTRAINT     r   ALTER TABLE ONLY public.alumnoclase
    ADD CONSTRAINT alumnoclase_pkey PRIMARY KEY (alumno_nocontrol, clase_id);
 F   ALTER TABLE ONLY public.alumnoclase DROP CONSTRAINT alumnoclase_pkey;
       public            postgres    false    219    219            f           2606    16523    clase clase_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.clase
    ADD CONSTRAINT clase_pkey PRIMARY KEY (idclase);
 :   ALTER TABLE ONLY public.clase DROP CONSTRAINT clase_pkey;
       public            postgres    false    218            d           2606    16516    profesor profesor_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.profesor
    ADD CONSTRAINT profesor_pkey PRIMARY KEY (idprofesor);
 @   ALTER TABLE ONLY public.profesor DROP CONSTRAINT profesor_pkey;
       public            postgres    false    216            k           2606    16561    registro registro_pkey 
   CONSTRAINT     s   ALTER TABLE ONLY public.registro
    ADD CONSTRAINT registro_pkey PRIMARY KEY (alumno_nocontrol, clase_id, fecha);
 @   ALTER TABLE ONLY public.registro DROP CONSTRAINT registro_pkey;
       public            postgres    false    220    220    220            g           1259    16559    idx_clase_profesor_id    INDEX     N   CREATE INDEX idx_clase_profesor_id ON public.clase USING btree (profesor_id);
 )   DROP INDEX public.idx_clase_profesor_id;
       public            postgres    false    218            m           2606    16534    alumnoclase fk_alumno    FK CONSTRAINT     �   ALTER TABLE ONLY public.alumnoclase
    ADD CONSTRAINT fk_alumno FOREIGN KEY (alumno_nocontrol) REFERENCES public.alumno(nocontrol) ON UPDATE CASCADE ON DELETE CASCADE;
 ?   ALTER TABLE ONLY public.alumnoclase DROP CONSTRAINT fk_alumno;
       public          postgres    false    4706    215    219            o           2606    16549    registro fk_alumno    FK CONSTRAINT     �   ALTER TABLE ONLY public.registro
    ADD CONSTRAINT fk_alumno FOREIGN KEY (alumno_nocontrol) REFERENCES public.alumno(nocontrol) ON UPDATE CASCADE ON DELETE CASCADE;
 <   ALTER TABLE ONLY public.registro DROP CONSTRAINT fk_alumno;
       public          postgres    false    220    215    4706            n           2606    16539    alumnoclase fk_clase    FK CONSTRAINT     �   ALTER TABLE ONLY public.alumnoclase
    ADD CONSTRAINT fk_clase FOREIGN KEY (clase_id) REFERENCES public.clase(idclase) ON UPDATE CASCADE ON DELETE CASCADE;
 >   ALTER TABLE ONLY public.alumnoclase DROP CONSTRAINT fk_clase;
       public          postgres    false    219    218    4710            p           2606    16554    registro fk_clase    FK CONSTRAINT     �   ALTER TABLE ONLY public.registro
    ADD CONSTRAINT fk_clase FOREIGN KEY (clase_id) REFERENCES public.clase(idclase) ON UPDATE CASCADE ON DELETE CASCADE;
 ;   ALTER TABLE ONLY public.registro DROP CONSTRAINT fk_clase;
       public          postgres    false    220    4710    218            l           2606    16524    clase fk_profesor    FK CONSTRAINT        ALTER TABLE ONLY public.clase
    ADD CONSTRAINT fk_profesor FOREIGN KEY (profesor_id) REFERENCES public.profesor(idprofesor);
 ;   ALTER TABLE ONLY public.clase DROP CONSTRAINT fk_profesor;
       public          postgres    false    216    218    4708                k  x�5��j1Ϛ��=�����ع;|�KKj��]���	�O��%��FU�� �!u:�	��bM�R�54��9�����8T��P)�s�R��N���.�6�P���_��w��v]����A���;�
��No7�pȄ)WG�-�s�(F�n@�r���	Y�NE��T=��6��3u��uP���/�&�ܸo��m������?8�p�m�1`�^�Q�@�T���7�]�sk�Pd���z\��:?�&�wڎv�=Wk���c9KwTA�tΛ��Z��US0N�:g�de����� ���9�XRr��Ң��U�K'u�ܶ}�q]�L=���K������)x�0��M���"��         %   x�624420�0�44�
s�-�8 N� ���         7   x�34�4
v4�44�2 !NCC(�'?=39Q�3/����(31�����Ĕ+F��� \��         �   x��ͽ�0@�<Ew���#���`BbX.��4QA��o���,'�@icE�JF2�����U��e�hd�Q�Pp-4*�4��@��%�6���%̓�h�U������wȖ����l�W�3k����{�ąQ6�F.&��Vh�9>i��mBj��� ����Y�}ͼF(         X   x���A
�0D�us��dl%��[מ���.TU��I�A�d9��Ϭ(JH}�~��S��kܴ_Y|�}K��U�̈�6��[�m�o-0k     