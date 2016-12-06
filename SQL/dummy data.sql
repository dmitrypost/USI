INSERT tblkeyword (kwd_name)VALUES('Computer');
INSERT tblkeyword (kwd_name)VALUES('Information');
INSERT tblkeyword (kwd_name)VALUES('Systems');
INSERT tblkeyword (kwd_name)VALUES('Science');

INSERT tblmajor (mgr_name) Values ('Computer Information Systems');
INSERT tblMajor (mgr_name) Values ('Computer Science'); 

INSERT tbluser (usr_email,usr_fname,usr_lname,usr_admin,usr_mgr_id,usr_graduate,usr_onetimepass)VALUES('dpost@eagles.usi.edu','Dmitry','Post',False,1,False,False);

INSERT tblproject (pjt_name,pjt_body,pjt_description)VALUES('USI Project Repository','body example...','description example...');
INSERT tblrole (rol_name,rol_usr_id,rol_pjt_id)VALUES('Database Admin',1,1);
INSERT tblrole (rol_usr_id,rol_pjt_id,rol_name)Values(2,1,'Database Admin');

INSERT tblkeywordassociation (key_kwd_id)Values(1);

