# phpMyAdmin MySQL-Dump

# --------------------------------------------------------
#
# Table structure for table 'CACHEDATA'
#

CREATE TABLE CACHEDATA (
   CACHEKEY varchar(255) NOT NULL,
   CACHEEXPIRATION int(11) NOT NULL,
   GZDATA blob,
   DATASIZE int(11),
   DATACRC int(11),
   PRIMARY KEY (CACHEKEY)
 ); 
