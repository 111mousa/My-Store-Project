<?php
namespace PHPMVC\Lib;

class FileUpload
{
    private $name;
    private $type;
    private $size;
    private $error;
    private $tmpPath;
    private $fileExtension;
    private $allowedExtensions = [
        'jpg','png','gif','pdf','doc','docx','xls'
    ];
    
    public function __construct(array $file)
    {
        $this->name = $this->name($file['name']);
        $this->type = $file['type'];
        $this->size = $file['size'];
        $this->error = $file['error'];
        $this->tmpPath = $file['tmp_name'];
    }
    
    private function name($name)
    {
        preg_match('/([a-z]{1,4})$/i',$name,$m);
        $this->fileExtension = $m[0];
        return substr(strtolower(base64_encode($name.APP_SALT)),0,25);
    }
    
    private function IsAllowedType()
    {
        return in_array($this->fileExtension, $this->allowedExtensions);
    }
    
    public function getFileName()
    {
        return $this->name.'.'.$this->fileExtension;
    }
    
    private function isSizeNotAcceptable()
    {
        preg_match_all('/(\d+)([MG])$/i', MAX_FILE_SIZE_ALLOWED,$matches);
        $unitSize = $matches[2];
        $maxFileSizeToUpload = $matches[1];
        $currentFileSize = $unitSize=='M'?($this->size/1024/1024): ($this->size/1024/1024/1024);
        $currentFileSize = ceil($currentFileSize);
        return $currentFileSize > $maxFileSizeToUpload;
    }
    
    private function isImage()
    {
        return preg_match('/image/i', $this->type);
    }
    
    public function upload() 
    {
        if($this->error != 0 ){
            throw new Exception('Sorry File Didn`t Upload Successfully ');
        }elseif(!$this->IsAllowedType()){
            throw new Exception('Files Of Type '.$this->fileExtension.' Are Not Allowed');
        }elseif($this->isSizeNotAcceptable()){
            throw new Exception('Sorry The File Size Exceeds The Maximum Allowed Size ');
        }else{
            $storageFolder = $this->isImage() ? IMAGES_UPLOAD_STORAGE : DOCUMENTS_UPLOAD_STORAGE;
            if(is_writable($storageFolder)){
                move_uploaded_file($this->tmpPath, $storageFolder.DS. $this->getFileName());
            }else{
                throw new Exception('Sorry The Distenation Folder Is Not Writable ');
            }
        }
        return $this;
    }
    
}