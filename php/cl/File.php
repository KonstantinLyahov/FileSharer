<?

class File{
    private $usernameHash,$filenameHash,$filename;
    public function __construct($username){
        $this->usernameHash=hash("md5",$username);
    }
    public function upload(&$file,$password){
        $fileNameArr=explode(".",$file["name"]);
        $fileType=$fileNameArr[1];
        $this->filename=$file["name"];
        $fileNameHash=hash("md5",$file["name"]).".$fileType";
        $this->filenameHash=$fileNameHash;
        $uploadDir="../ServerFolder/$this->usernameHash/";
        $uploadfile=$uploadDir.basename($fileNameHash);
        $dbLink=new mysqli("localhost","root","","filesharer");
        $tableName=$this->usernameHash;
        if(!$password){
            $str_query="insert into $tableName(filename,filenamehash) values('".$this->filename."','$fileNameHash')";
        }else{
            $str_query="insert into $tableName(password,filename,filenamehash) values('$password','".$this->filename."','$fileNameHash')";
        }
        if(!file_exists($uploadfile)){            
            $dbLink->query($str_query);
            move_uploaded_file($file['tmp_name'], $uploadfile);
        }
    }
    public function getLink(){
        $linkCode=$this->usernameHash."-".$this->filenameHash;
        return "localhost/FileSharer/getFile.php?code=$linkCode";
    }
    public function getName(){
        return $this->filename;
    }
}