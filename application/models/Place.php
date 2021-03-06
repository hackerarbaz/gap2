<?php

/*
 
Class for adding, removing, retrieving and updating tokens

*/
class Tokens {
 
    
    public $db; //database connection object
    
	 
	 
	 //check to see if the document is already in
	 function getTokensByDocID($docID){
		  $db = $this->startDB();
		  $sql = "SELECT * FROM gap_tokens WHERE docID = $docID ";
		  $result = $db->fetchAll($sql, 2);
		  if($result){
				return $result;
		  }
		  else{
				return false;
		  }
	 }
	 
	 
	 function addRecord($data){
		  $db = $this->startDB();
		  
		  try{
				$db->insert('gap_tokens', $data);
				$n = $db->lastInsertId();
				return $n;
		  }
		  catch (Exception $e) {
				//echo (string)$e;
				return false;
		  }  
	 }
	 
	 //check to see if the document is already in
	 function checkDocumentDone($docID){
		  $db = $this->startDB();
		  $sql = "SELECT count(id) as idCount FROM gap_tokens WHERE docID = $docID ";
		  $result = $db->fetchAll($sql, 2);
		  if($result){
				return $result[0]["idCount"];
		  }
		  else{
				return false;
		  }
	 }
	 
	 function initializeTab(){
		  
		  $db = $this->startDB();
		  $sql = "
		  CREATE TABLE IF NOT EXISTS gap_tokens (
				id int(11) NOT NULL AUTO_INCREMENT,
				docID int(11) NOT NULL,
				batchID int(11) NOT NULL,
				sentID varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
				tokenID varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
				pws tinyint(1) NOT NULL,
				gazRef varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
				token varchar(200) NOT NULL,
				updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (id),
				KEY docID (docID,batchID),
				KEY token (token),
				KEY gazRef (gazRef)
			 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;
		  ";
		  $db->query($sql, 2);
	 }
	 
    function startDB(){
		  if(!$this->db){
				$db = Zend_Registry::get('db');
				$this->setUTFconnection($db);
				$this->db = $db;
		  }
		  else{
				$db = $this->db;
		  }
		  
		  return $db;
	 }
	 
	 function setUTFconnection($db){
		  $sql = "SET collation_connection = utf8_unicode_ci;";
		  $db->query($sql, 2);
		  $sql = "SET NAMES utf8;";
		  $db->query($sql, 2);
    }


}//end class


?>
