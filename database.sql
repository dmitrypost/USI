CREATE TABLE tblUser (usr_id INT NOT NULL AUTO_INCREMENT, usr_email TINYTEXT, usr_fname TINYTEXT, usr_lname TINYTEXT, usr_picture TINYTEXT, usr_admin TINYINT, usr_mgr_id INT, usr_graduate TINYINT, usr_onetimepass TINYINT, usr_pageview INT, PRIMARY KEY (usr_id));
CREATE TABLE tblRole (rol_usr_id INT NOT NULL AUTO_INCREMENT, rol_pjt_id INT, rol_name TINYTEXT, CONSTRAINT rol_id PRIMARY KEY (rol_usr_id,rol_pjt_id));
CREATE TABLE tblMajor (mgr_id INT NOT NULL AUTO_INCREMENT, mgr_name TINYTEXT, mgr_key_id INT, PRIMARY KEY (mgr_id));
CREATE TABLE tblKeyword (kwd_id INT NOT NULL AUTO_INCREMENT, kwd_name TINYTEXT, PRIMARY KEY (kwd_id));
CREATE TABLE tblKeywordAssociation (key_id INT, key_kwd_id INT, PRIMARY KEY (key_id,key_kwd_id));
CREATE TABLE tblProject (pjt_id INT NOT NULL AUTO_INCREMENT, pjt_name TINYTEXT, pjt_body LONGTEXT, pjt_description TINYTEXT, pjt_key_id INT, pjt_dep_id INT, pjt_pageview INT, PRIMARY KEY (pjt_id));
CREATE TABLE tblDepartment (dep_id INT NOT NULL AUTO_INCREMENT, dep_name TINYTEXT, dep_key_id INT, dep_pageview INT, PRIMARY KEY (dep_id));
CREATE TABLE tblFile (fle_id INT NOT NULL AUTO_INCREMENT, fle_path TINYTEXT, fle_deleted TINYINT, fle_usr_id INT, fle_pjt_id INT, fle_name TINYTEXT, PRIMARY KEY (fle_id));
ALTER TABLE tblUser ADD FOREIGN KEY (usr_mgr_id) REFERENCES tblMajor(mgr_id);
ALTER TABLE tblRole ADD FOREIGN KEY (rol_pjt_id) REFERENCES tblProject(pjt_id);
ALTER TABLE tblMajor ADD FOREIGN KEY (mgr_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblKeywordAssociation ADD FOREIGN KEY (key_kwd_id) REFERENCES tblKeyword(kwd_id);
ALTER TABLE tblProject ADD FOREIGN KEY (pjt_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblProject ADD FOREIGN KEY (pjt_dep_id) REFERENCES tblDepartment(dep_id);
ALTER TABLE tblDepartment ADD FOREIGN KEY (dep_key_id) REFERENCES tblKeywordAssociation(key_id);
ALTER TABLE tblFile ADD FOREIGN KEY (fle_usr_id) REFERENCES tblUser(usr_id);
ALTER TABLE tblFile ADD FOREIGN KEY (fle_pjt_id) REFERENCES tblProject(pjt_id);
