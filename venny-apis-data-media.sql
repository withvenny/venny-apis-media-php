-- public.assets definition

-- Drop table

-- DROP TABLE public.assets;

CREATE TABLE public.assets (
	id int4 NOT NULL DEFAULT nextval('assets_sequence'::regclass),
	asset_id varchar(30) NOT NULL,
	asset_attributes json NULL,
	asset_type varchar(30) NOT NULL,
	asset_status varchar(30) NOT NULL,
	asset_primary int4 NOT NULL,
	asset_object varchar(30) NULL,
	asset_caption varchar(255) NULL,
	asset_filename varchar(255) NOT NULL,
	asset_metadata jsonb NULL,
	profile_id varchar(30) NOT NULL,
	app_id varchar(30) NOT NULL,
	event_id varchar(30) NOT NULL,
	process_id varchar(30) NOT NULL,
	time_started timestamptz NOT NULL DEFAULT now(),
	time_updated timestamptz NOT NULL DEFAULT now(),
	time_finished timestamptz NOT NULL DEFAULT now(),
	active int4 NOT NULL DEFAULT 1,
	CONSTRAINT assets_asset_id_key UNIQUE (asset_id)
);

-- Permissions

ALTER TABLE public.assets OWNER TO dweixbizznulwu;
GRANT ALL ON TABLE public.assets TO dweixbizznulwu;


-- public.images definition

-- Drop table

-- DROP TABLE public.images;

CREATE TABLE public.images (
	id int4 NOT NULL DEFAULT nextval('images_sequence'::regclass),
	image_id varchar(30) NOT NULL,
	image_attributes json NULL,
	image_type varchar(30) NOT NULL,
	image_status varchar(30) NOT NULL,
	image_primary int4 NOT NULL,
	image_object varchar(30) NULL,
	image_caption varchar(255) NULL,
	image_filename varchar(255) NOT NULL,
	image_metadata jsonb NULL,
	profile_id varchar(30) NOT NULL,
	app_id varchar(30) NOT NULL,
	event_id varchar(30) NOT NULL,
	process_id varchar(30) NOT NULL,
	time_started timestamptz NOT NULL DEFAULT now(),
	time_updated timestamptz NOT NULL DEFAULT now(),
	time_finished timestamptz NOT NULL DEFAULT now(),
	active int4 NOT NULL DEFAULT 1,
	CONSTRAINT images_image_id_key UNIQUE (image_id)
);

-- Permissions

ALTER TABLE public.images OWNER TO dweixbizznulwu;
GRANT ALL ON TABLE public.images TO dweixbizznulwu;


INSERT INTO public.images (image_id,image_attributes,image_type,image_status,image_primary,image_object,image_caption,image_filename,image_metadata,profile_id,app_id,event_id,process_id,time_started,time_updated,time_finished,active) VALUES
	 ('30 characters','{}','30 characters','30 characters',1,'30 characters','255 characters','255 characters','{}','30 characters','30 characters','30 characters','30 characters','2020-05-15 08:58:45.52632-05','2020-05-15 08:58:45.52632-05','2020-05-15 08:58:45.52632-05',1),
	 ('img_303b3bf49dc1c',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_d9e5bf7ffcf53','obj_9749431018ebf','2020-05-16 08:33:48.371184-05','2020-05-16 08:33:48.371184-05','2020-05-16 08:33:48.371184-05',1),
	 ('img_b75f231cc618e',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_553da0e0d4b58','obj_d278f5b30ddc7','2020-05-16 08:35:14.696706-05','2020-05-16 08:35:14.696706-05','2020-05-16 08:35:14.696706-05',1),
	 ('img_6901da8fb09d0',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_fef35da758857','obj_55f9c8e4bb8ce','2020-05-16 08:35:22.296899-05','2020-05-16 08:35:22.296899-05','2020-05-16 08:35:22.296899-05',1),
	 ('img_c6a55fc30d60b',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_af30ca7a5fa93','obj_557d75547ae25','2020-05-16 08:44:27.646672-05','2020-05-16 08:44:27.646672-05','2020-05-16 08:44:27.646672-05',1),
	 ('img_157ac8a5ca874',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_bd8186af47b2f','obj_84bb035787ddc','2020-05-16 09:04:40.691645-05','2020-05-16 09:04:40.691645-05','2020-05-16 09:04:40.691645-05',1),
	 ('img_81286e931bfe2',NULL,'JPG','Goog time.',1,'obj_thentrlco','We have a render of you receiving a gift.','FrhtjVec_FrhtjVec_FrhtjVec','{}','prf_adolphusnolan','app_thentrlco','obj_efb3e29b230b1','obj_d155852f15713','2020-05-16 09:06:48.923329-05','2020-05-16 09:06:48.923329-05','2020-05-16 09:06:48.923329-05',1),
	 ('img_5b79cf47f7411',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_7cd10589b2d10','obj_6bd7c24fbde73','2020-05-16 09:08:26.880404-05','2020-05-16 09:08:26.880404-05','2020-05-16 09:08:26.880404-05',1),
	 ('img_d3ecbec8a97e3',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_7c201bd639e77','obj_317c516c8daaf','2020-05-16 09:10:53.829115-05','2020-05-16 09:10:53.829115-05','2020-05-16 09:10:53.829115-05',1),
	 ('img_a977178bcd408',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_37f28ca64cff1','obj_0b1c32da6b5c3','2020-05-16 09:11:36.017898-05','2020-05-16 09:11:36.017898-05','2020-05-16 09:11:36.017898-05',1);
INSERT INTO public.images (image_id,image_attributes,image_type,image_status,image_primary,image_object,image_caption,image_filename,image_metadata,profile_id,app_id,event_id,process_id,time_started,time_updated,time_finished,active) VALUES
	 ('img_73dffcab0c728',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_dc23f6966bb9e','obj_e0c8a02677331','2020-05-16 09:15:42.778507-05','2020-05-16 09:15:42.778507-05','2020-05-16 09:15:42.778507-05',1),
	 ('img_2e5f579188c03',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_93f1b1b33ca52','obj_91c76ebccf2e9','2020-05-16 09:19:31.825812-05','2020-05-16 09:19:31.825812-05','2020-05-16 09:19:31.825812-05',1),
	 ('img_f003daeeb0c01',NULL,'JPG','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','filename.extension','{}','prf_adolphusnolan','app_thentrlco','obj_9c061fa35dc6a','obj_355ecc501f9a1','2020-05-16 09:22:48.950089-05','2020-05-16 09:22:48.950089-05','2020-05-16 09:22:48.950089-05',1),
	 ('img_8880c9091bf42',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','sonofadolphus.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_308dc0911ba7b','obj_79cd4390bb8a9','2020-05-16 11:34:41.642886-05','2020-05-16 11:34:41.642886-05','2020-05-16 11:34:41.642886-05',1),
	 ('img_197c6a9d6be31',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','b37620c7f90f5',NULL,'prf_adolphusnolan','app_thentrlco','obj_ed1f45303d076','obj_716882fab45d4','2020-05-16 11:38:46.628394-05','2020-05-16 11:38:46.628394-05','2020-05-16 11:38:46.628394-05',1),
	 ('img_26a2af28de055',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','5437725895161.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_d7ba902bd205c','obj_0f3a3fbe29e42','2020-05-16 11:42:28.343227-05','2020-05-16 11:42:28.343227-05','2020-05-16 11:42:28.343227-05',1),
	 ('img_84d69edd28e26',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','ae67aa3f318b6',NULL,'prf_adolphusnolan','app_thentrlco','obj_3971b50c2f5d8','obj_5708f57602d1e','2020-05-16 11:43:34.068738-05','2020-05-16 11:43:34.068738-05','2020-05-16 11:43:34.068738-05',1),
	 ('img_38c44c3392730',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','b9119ff6c6c71.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_f9df6fac90725','obj_bda9ad61dcdea','2020-05-16 11:45:52.130456-05','2020-05-16 11:45:52.130456-05','2020-05-16 11:45:52.130456-05',1),
	 ('img_1023e8485c41e',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','3b01d2221983aprf_adolphusnolan.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_904e4f552a02e','obj_9f8e6657a0705','2020-05-16 11:48:12.757425-05','2020-05-16 11:48:12.757425-05','2020-05-16 11:48:12.757425-05',1),
	 ('img_ecb726e9c89df',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','38c3f72bb42b5prf_adolphusnolan.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_1b2aa3c8f61aa','obj_31d9da87b6eaa','2020-05-16 12:03:09.781024-05','2020-05-16 12:03:09.781024-05','2020-05-16 12:03:09.781024-05',1);
INSERT INTO public.images (image_id,image_attributes,image_type,image_status,image_primary,image_object,image_caption,image_filename,image_metadata,profile_id,app_id,event_id,process_id,time_started,time_updated,time_finished,active) VALUES
	 ('img_c24ce47a46ff5',NULL,'image/jpeg','ACTIVE',1,'obj_thentrlco','Future - Real Sisters','623b7465fd95bprf_adolphusnolan.jpg',NULL,'prf_adolphusnolan','app_thentrlco','obj_559803b5e8fda','obj_20692cd891d9d','2020-05-16 12:07:15.968002-05','2020-05-16 12:07:15.968002-05','2020-05-16 12:07:15.968002-05',1);

	 INSERT INTO public.assets (asset_id,asset_attributes,asset_type,asset_status,asset_primary,asset_object,asset_caption,asset_filename,asset_metadata,profile_id,app_id,event_id,process_id,time_started,time_updated,time_finished,active) VALUES
	 ('30 characters','{}','30 characters','30 characters',1,'30 characters','255 characters','255 characters','{}','30 characters','30 characters','30 characters','30 characters','2020-03-28 11:04:45.659307-05','2020-03-28 11:04:45.659307-05','2020-03-28 11:04:45.659307-05',1),
	 ('img_0509551cd2853',NULL,'image','active',1,'pst_domminicanrepublic','Me trying to stay young.','10501625_713694408691647_903602601754647238_n.jpg','{}','prf_adolphus','app_thentrlco','obj_83ab7ff325468','obj_abf2006a889a9','2020-03-28 14:36:19.939183-05','2020-03-28 14:36:19.939183-05','2020-03-28 14:36:19.939183-05',1),
	 ('img_a4f9a02584113',NULL,'image','active',1,'pst_DRlunch','Me at lunch with some folks by the beach','10622786_749558351771919_3826785653284006302_n.jpg','{}','prf_adolphus','app_thentrlco','obj_6e884de7d2a4d','obj_56a74b3cdb3ad','2020-03-28 14:38:39.579641-05','2020-03-28 14:38:39.579641-05','2020-03-28 14:38:39.579641-05',1),
	 ('img_489ea4feaaf79',NULL,'image','active',1,'pst_bedstuy','At my spot bourough in brooklyn','12733378_982149541846131_989720922706446967_n.jpg','{}','prf_adolphus','app_thentrlco','obj_53c6e05bdc5d8','obj_ccfb4eb9002d0','2020-03-28 14:39:29.053046-05','2020-03-28 14:39:29.053046-05','2020-03-28 14:39:29.053046-05',1),
	 ('img_399e4df03cbed',NULL,'image','active',1,'pst_isciaboattrip','Quick trip the isle of Iscia of the coast of Naples','13620067_1079185868809164_6499523857349806377_n.jpg','{}','prf_adolphus','app_thentrlco','obj_b03a6c1c227a3','obj_7638eefc18ab8','2020-03-28 14:40:06.889237-05','2020-03-28 14:40:06.889237-05','2020-03-28 14:40:06.889237-05',1),
	 ('img_ac8c0e6af922b',NULL,'image','active',1,'pst_myonlybathroomselfie','my only bathroom selfie... ever','15825953_1224672534260496_1402235900175611575_n.jpg','{}','prf_adolphus','app_thentrlco','obj_3362f0141286e','obj_11b9bcb89efb4','2020-03-28 14:40:55.41104-05','2020-03-28 14:40:55.41104-05','2020-03-28 14:40:55.41104-05',1),
	 ('img_dec0174eaea2a',NULL,'image','active',1,'pst_foundergymshoot','founder gym press shoot','20933908_1443765669017847_6785311946916514575_o.jpg','{}','prf_adolphus','app_thentrlco','obj_5a4b01b8690a3','obj_0df708c5fad0b','2020-03-28 14:46:26.501969-05','2020-03-28 14:46:26.501969-05','2020-03-28 14:46:26.501969-05',1),
	 ('img_bfa3aab347bb0',NULL,'image','active',1,'pst_ontheroolinbrooklyN','on the roof of my office in dumbo','19225638_1388152034579211_2158345927111181189_n.jpg','{}','prf_adolphus','app_thentrlco','obj_9cec9f20c76da','obj_cc67912a5ceda','2020-03-28 14:47:48.133724-05','2020-03-28 14:47:48.133724-05','2020-03-28 14:47:48.133724-05',1),
	 ('img_f0c73da9f66cc',NULL,'image','active',1,'pst_PARKINGLOTSHOT','in THE PARKING LOT OF TOM THUMB IN DESOTOT','23244458_1519014838159596_1896260447581512729_n.jpg','{}','prf_adolphus','app_thentrlco','obj_ad7775c436d57','obj_e56e88ea9027a','2020-03-28 14:50:09.995719-05','2020-03-28 14:50:09.995719-05','2020-03-28 14:50:09.995719-05',1),
	 ('img_b6a78fbaf4e26',NULL,'image','active',1,'pst_manhattanshoot','profile in manhattan','23659327_1528934337167646_801893493604711908_n (1).jpg','{}','prf_adolphus','app_thentrlco','obj_1866bc8b2c78c','obj_d8eacde5bb4af','2020-03-28 14:53:36.748751-05','2020-03-28 14:53:36.748751-05','2020-03-28 14:53:36.748751-05',1);
INSERT INTO public.assets (asset_id,asset_attributes,asset_type,asset_status,asset_primary,asset_object,asset_caption,asset_filename,asset_metadata,profile_id,app_id,event_id,process_id,time_started,time_updated,time_finished,active) VALUES
	 ('img_d62a993facb65',NULL,'image','active',1,'pst_newORLEANS','ON THE SIDE OF THE BED IN NEW ORLEANS','26230277_1577355962325483_8397617558191117064_n (1).jpg','{}','prf_adolphus','app_thentrlco','obj_bf974aee45944','obj_5c5df76ae0860','2020-03-28 14:54:49.04919-05','2020-03-28 14:54:49.04919-05','2020-03-28 14:54:49.04919-05',1),
	 ('img_7c89b9191b01b',NULL,'image','active',1,'pst_JZTRAIN','waiting on the j-z train in brookylN','38875080_1823993890995021_6807472642459697152_o.jpg','{}','prf_adolphus','app_thentrlco','obj_b71a1de1c6f1d','obj_5357999e0d7f6','2020-03-28 14:56:25.131208-05','2020-03-28 14:56:25.131208-05','2020-03-28 14:56:25.131208-05',1),
	 ('img_d142c326b2f30',NULL,'image','active',1,'pst_caribbeanparade','CARIBbean parade in brooklyn','56236275_2144283922299348_3584879743066963968_n.jpg','{}','prf_adolphus','app_thentrlco','obj_983a224e9ae72','obj_3fc37d27b523c','2020-03-28 14:57:11.9168-05','2020-03-28 14:57:11.9168-05','2020-03-28 14:57:11.9168-05',1),
	 ('img_baa52daa33797',NULL,'image','active',1,'pst_domandalatongreenville','Me and Dominick visit one of his bartender friends.','76944084_2653480534719040_1408275340626755584_o.jpg','{}','prf_adolphus','app_thentrlco','obj_31af484355f10','obj_cb0edbfffff17','2020-03-28 14:57:54.793956-05','2020-03-28 14:57:54.793956-05','2020-03-28 14:57:54.793956-05',1),
	 ('img_6bc380301c492',NULL,'image','active',1,'prf_proudpapaphoto','A proud papa of a budding new photography business.','176181_418521401542284_1507459559_o.jpg','{}','prf_adolphus','app_thentrlco','obj_bab26226405f1','obj_95e2e2f057a8d','2020-03-28 12:03:36.677592-05','2020-03-28 12:03:36.677592-05','2020-03-28 12:03:36.677592-05',1),
	 ('img_cd6ef9064bb2d',NULL,'image','active',1,'prf_mainstreetchristmas','Christmas @ Main Street Park','534703_434148533312904_933257715_n.jpg','{}','prf_adolphus','app_thentrlco','obj_0f6bd318b8263','obj_07c98366c61f4','2020-03-28 12:05:02.633262-05','2020-03-28 12:05:02.633262-05','2020-03-28 12:05:02.633262-05',1),
	 ('img_c5d68cc1f2b0b',NULL,'image','active',1,'prf_kingleonidus','king leonidus','376433_413491008711990_1501381131_n.jpg','{}','prf_adolphus','app_thentrlco','obj_b85904c44017c','obj_ade58966c15a9','2020-03-28 12:06:25.887151-05','2020-03-28 12:06:25.887151-05','2020-03-28 12:06:25.887151-05',1),
	 ('img_aecff77e0c0e4',NULL,'image','active',1,'pst_justmethistime','me down by the school yard','81749502_2670301326364269_5139990253083295744_n.jpg','{}','prf_adolphus','app_thentrlco','obj_f6fdd0c7d02d9','obj_51bc3f5de4a08','2020-03-28 14:58:18.393928-05','2020-03-28 14:58:18.393928-05','2020-03-28 14:58:18.393928-05',1);

	 