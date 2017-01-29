<?php
	namespace dkhabiya\p3\Application;
	class noteClass {

		public $noteID;
		public $authorName;
		public $subject;
		public $body;
		public $dateCreated;
		public $dateModified;
		public $noOfChars;

		public function __constructor($v1='', $v2='', $v3='', $v4='', $v5='', $v6='', $v7='') {
			$this->noteID = $v1;
			$this->authorName = $v2;
			$this->subject = $v3;
			$this->body = $v4;
			$this->dateCreated = $v5;
			$this->dateModified = $v6;
			$this->noOfChars = $v7;
		}

		public function getNoteDetails() {
	        return array(
	            'noteID' => $this->noteID,
	            'authorName' => $this->authorName,
	            'subject' => $this->subject,
	            'body' => $this->body,
	            'dateCreated' => $this->dateCreated,
	            'dateModified' => $this->dateModified,
	            'noOfChars' => $this->noOfChars,
	        );
	    }

	    public function setNoteDetails($v1, $v2, $v3, $v4, $v5, $v6, $v7) {
			$this->noteID = $v1;
			$this->authorName = $v2;
			$this->subject = $v3;
			$this->body = $v4;
			$this->dateCreated = $v5;
			$this->dateModified = $v6;
			$this->noOfChars = $v7;
		}
	}

?>