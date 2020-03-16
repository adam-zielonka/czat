<?php

class UploadFile
{
    public $NameOfFile = "";
    public $DirectoryOfFile = "";
    public $ErrorMessage = "";
    public $TypeOfFile = "";
    public $SuccesMessage = "";
 
    public function __toString()
    {
        return $this->DirectoryOfFile.$this->NameOfFile;
        //return $this->SuccesMessage;
    }

    function _fileErrorCodeToMessage($code)
    {
        global $languageText;
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = $languageText['fileUploadErrorMessage']['tooSize']." (1)";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = $languageText['fileUploadErrorMessage']['tooSize']." (2)";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = $languageText['fileUploadErrorMessage']['partialSend'];
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = $languageText['fileUploadErrorMessage']['noFile'];
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = $languageText['fileUploadErrorMessage']['lostTempDirectory'];
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = $languageText['fileUploadErrorMessage']['cantWrite'];
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = $languageText['fileUploadErrorMessage']['sendStopedByExtension'];
                break;
            default:
                $message = $languageText['fileUploadErrorMessage']['unknownUploadError'];
                break;
        }
        return $message;
    }

    function _validFileErrorCodeToMessage($code)
    {
        global $languageText;
        switch ($code) {
            case 1:
                $message = $languageText['fileUploadErrorMessage']['tooSize']." (0)";
                break;
            case 2:
                $message = $languageText['fileUploadErrorMessage']['wrongTypeFile'];
                break;
            default:
                $message = $languageText['fileUploadErrorMessage']['unknownValidFileError'];
                break;
        }
        return $message;
    }

    function _checkFileSize($fileSize,$maxFileSizeByte)
    {
        return $fileSize < $maxFileSizeByte;
    }

    function _checkFileType($fileType,$correctFileType)
    {
        return substr($fileType,0,strlen($correctFileType)) == $correctFileType;
    }

    function _validFile($fileDatalist,$maxFileSizeByte,$correctFileType)
    {
        $errorCode = 0;

        if(!($this->_checkFileSize($fileDatalist['size'],$maxFileSizeByte)))
	    {
	        $errorCode = 1;
	    }

        if(!($this->_checkFileType($fileDatalist['type'],$correctFileType)))
        {
            $errorCode = 2;
        }

        return $errorCode;
    }

    function _getFileExtension($fileName)
    {
        $extension = $fileName;
        do {
            $extension = substr($extension,strpos($extension,".")+1);
        } while(strpos($extension,".") != "");
    
        return $extension;
    }

    function _getFileNameWithOutExtension($fileName)
    {
        $lenght = 0;
        $extension = $fileName;
        do {
            $lenght += strpos($extension,".")+1;
            $extension = substr($extension,strpos($extension,".")+1);
        } while(strpos($extension,".") != "");
    
        return substr($fileName,0,$lenght-1);
    }

    function _newFileName($oldFileName,$directoryIntoFile)
    {
        $fileName = str_replace(" ","",strtolower(_replacePolishLetters(addslashes($oldFileName))));
        $fileNameFirst = $this->_getFileNameWithOutExtension($fileName);
        $fileNameLast = $this->_getFileExtension($fileName);

        $number = 1;
        $fileName = $fileNameFirst.'.'.$fileNameLast;
        while (file_exists($directoryIntoFile.$fileName)) 
        {
            $fileName = $fileNameFirst.$number.'.'.$fileNameLast;
            $number++;
        }

        return $fileName;
    }

    function _successMessage($fileDatalist,$typeMessage,$newFileName,$directoryIntoFile)
    {
        global $languageText;
        $succesMessageText = $languageText['fileUploadSuccessMessage']['text'].'<br>';
        $succesMessageOldName = $languageText['fileUploadSuccessMessage']['oldName'].$fileDatalist['name'].'<br>';
        $succesMessageName = $languageText['fileUploadSuccessMessage']['name'].$newFileName.'<br>';
        $succesMessageSize = $languageText['fileUploadSuccessMessage']['size'].round($fileDatalist['size']/1024,2).' KB<br>';
        $succesMessageType = $languageText['fileUploadSuccessMessage']['type'].$fileDatalist['type'].'<br>';
    
        if($this->_checkFileType($fileDatalist['type'],'image'))
            $succesMessageHyperlink = '<img src="'.substr($directoryIntoFile,1).$newFileName.'" alt="'.$fileDatalist['name'].'" width="200" />';
        else
            $succesMessageHyperlink = '<a href="'.substr($directoryIntoFile,1).$newFileName.'">'.$fileDatalist['name'].'</a>';

        $succesMessage = $succesMessageText
                        .$succesMessageOldName
                        .$succesMessageName
                        .$succesMessageSize
                        .$succesMessageType
                        .$succesMessageHyperlink;

        return $succesMessage;
    }

    public function _sendFileToServer($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName)
    {
        global $languageText;
        if(isset($_FILES[$fileFormInputName]))
        {
            $fileDatalist = $_FILES[$fileFormInputName];
        
            if(!$fileDatalist['error'])
	        {
		        $newFileName = $this->_newFileName($fileDatalist['name'],$directoryIntoFile);
                $this->NameOfFile = $newFileName;
                $validFile = $this->_validFile($fileDatalist,$maxFileSizeByte,$correctFileType);

		        if(!($validFile))
		        {
			        move_uploaded_file($fileDatalist['tmp_name'], $directoryIntoFile.$newFileName);
			        $this->SuccesMessage = $this->_successMessage($fileDatalist,$fileFormInputName,$newFileName,$directoryIntoFile);
                    $message = "";
		        }
                else
                {
                    $message = $this->_validFileErrorCodeToMessage($validFile);
                }
	        }
	        else
	        {
		        $message = $this->_fileErrorCodeToMessage($fileDatalist['error']);
	        }
        }
        else
        {
            $message = $languageText['fileUploadErrorMessage']['noSendFileSet'];
        }
        $this->ErrorMessage = $message;
        $this->DirectoryOfFile = $directoryIntoFile;
        $this->TypeOfFile = $fileDatalist['type'];
        //return $message; 
    }


    public function _checkFileBeforSend($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName)
    {
        global $languageText;
        if(isset($_FILES[$fileFormInputName]))
        {
            $fileDatalist = $_FILES[$fileFormInputName];
        
            if(!$fileDatalist['error'])
	        {
		        //$newFileName = $this->_newFileName($fileDatalist['name'],$directoryIntoFile);
               // $this->NameOfFile = $newFileName;
                $validFile = $this->_validFile($fileDatalist,$maxFileSizeByte,$correctFileType);

		        if(!($validFile))
		        {
			        //move_uploaded_file($fileDatalist['tmp_name'], $directoryIntoFile.$newFileName);
			        //$this->SuccesMessage = $this->_successMessage($fileDatalist,$fileFormInputName,$newFileName,$directoryIntoFile);
                    $message = "";
		        }
                else
                {
                    $message = $this->_validFileErrorCodeToMessage($validFile);
                }
	        }
	        else
	        {
		        $message = $this->_fileErrorCodeToMessage($fileDatalist['error']);
	        }
        }
        else
        {
            $message = $languageText['fileUploadErrorMessage']['noSendFileSet'];
        }
        $this->ErrorMessage = $message;
        //$this->DirectoryOfFile = $directoryIntoFile;
        //$this->TypeOfFile = $fileDatalist['type'];
        return $message; 
    }
}

?>