ALTER DATABASE usiprojectrepository CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE tblUser (usr_id INT NOT NULL AUTO_INCREMENT, usr_email TINYTEXT,usr_password TINYTEXT, usr_salt TINYTEXT, usr_fname TINYTEXT, usr_lname TINYTEXT, usr_picture MEDIUMTEXT, usr_admin TINYINT, usr_mgr_id INT, usr_graduate TINYINT, usr_onetimepass TINYINT, usr_pageview INT, usr_linkedin TINYTEXT, usr_phone TINYTEXT, PRIMARY KEY (usr_id));
CREATE TABLE tblRole (rol_usr_id INT NOT NULL AUTO_INCREMENT, rol_pjt_id INT, rol_name TINYTEXT, CONSTRAINT rol_id PRIMARY KEY (rol_usr_id,rol_pjt_id));
CREATE TABLE tblMajor (mgr_id INT NOT NULL AUTO_INCREMENT, mgr_name TINYTEXT, mgr_key_id INT, mgr_clg_id INT, PRIMARY KEY (mgr_id));
CREATE TABLE tblKeyword (kwd_id INT NOT NULL AUTO_INCREMENT, kwd_name TINYTEXT, PRIMARY KEY (kwd_id));
CREATE TABLE tblKeywordAssociation (key_id INT, key_kwd_id INT, PRIMARY KEY (key_id,key_kwd_id));
CREATE TABLE tblProject (pjt_id INT NOT NULL AUTO_INCREMENT, pjt_name TINYTEXT, pjt_body LONGTEXT, pjt_description LONGTEXT, pjt_key_id INT, pjt_picture MEDIUMTEXT, pjt_mgr_id INT, pjt_pageview INT, pjt_year YEAR, PRIMARY KEY (pjt_id));
CREATE TABLE tblCollege (clg_id INT NOT NULL AUTO_INCREMENT, clg_name TINYTEXT, clg_key_id INT, clg_pageview INT, PRIMARY KEY (clg_id));
CREATE TABLE tblFile (fle_id INT NOT NULL AUTO_INCREMENT, fle_data MEDIUMTEXT, fle_deleted TINYINT, fle_usr_id INT, fle_pjt_id INT, fle_name TINYTEXT, PRIMARY KEY (fle_id));
CREATE TABLE tblProjectHistory (pjh_id INT NOT NULL AUTO_INCREMENT, pjh_description LONGTEXT, pjh_body LONGTEXT, pjh_modified DATETIME, pjh_approved TINYINT, pjh_usr_id INT, pjh_pjt_id INT, PRIMARY KEY (pjh_id));
CREATE TABLE tblSession (ses_id INT NOT NULL AUTO_INCREMENT, ses_session TINYTEXT, ses_usr_id INT, ses_date DATETIME, ses_expired TINYINT, PRIMARY KEY (ses_id));
CREATE TABLE tblImage (img_id INT NOT NULL AUTO_INCREMENT, img_image MEDIUMTEXT, PRIMARY KEY (img_id));
CREATE TABLE tblRoleState (rst_id INT NOT NULL AUTO_INCREMENT, rst_name TINYTEXT NOT NULL, PRIMARY KEY (rst_id));
ALTER TABLE tblUser ADD FOREIGN KEY (usr_mgr_id) REFERENCES tblMajor(mgr_id);
ALTER TABLE tblRole ADD FOREIGN KEY (rol_pjt_id) REFERENCES tblProject(pjt_id);
ALTER TABLE tblRole ADD FOREIGN KEY (rol_usr_id) REFERENCES tblUser(usr_id);
ALTER TABLE tblMajor ADD FOREIGN KEY (mgr_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblKeywordAssociation ADD FOREIGN KEY (key_kwd_id) REFERENCES tblKeyword(kwd_id);
ALTER TABLE tblProject ADD FOREIGN KEY (pjt_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblProject ADD FOREIGN KEY (pjt_mgr_id) REFERENCES tblMajor(mgr_id);
ALTER TABLE tblCollege ADD FOREIGN KEY (clg_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblFile ADD FOREIGN KEY (fle_usr_id) REFERENCES tblUser(usr_id);
ALTER TABLE tblFile ADD FOREIGN KEY (fle_pjt_id) REFERENCES tblProject(pjt_id);
ALTER TABLE tblProjectHistory ADD FOREIGN KEY (pjh_usr_id) REFERENCES tblUser(usr_id);
ALTER TABLE tblProjectHistory ADD FOREIGN KEY (pjh_pjt_id) REFERENCES tblProject(pjt_id);
ALTER TABLE tblSession ADD FOREIGN KEY (ses_usr_id) REFERENCES tblUser(usr_id);
ALTER TABLE tblMajor ADD FOREIGN KEY (mgr_clg_id) REFERENCES tblCollege(clg_id);

-- Database required entries --

INSERT INTO tblRoleState (rst_name)VALUES('PENDING REMOVAL');
INSERT INTO tblRoleState (rst_name)VALUES('PENDING ADDITION');
INSERT INTO tblRoleState (rst_name)VALUES('NORMAL'); 


