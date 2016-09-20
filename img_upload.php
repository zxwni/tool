//针对 lumen 的图片 上传类
<?php

namespace QingMei\Model\poster;

class Upload
{
    public $filesize;//定义的文件大小
    public $file;//接收的文件
    public $filename;//自定义的文件名
    public $destinationPath;//自定义上传目录

    //参数：文件流，目录，大小，文件名
    function __construct($file,$destinationPath="",$filesize="1",$filename=""){
        $this->filesize=$filesize*1000000;  //限制最大的上传大小
        $this->file=$file;
        $this->filename=$filename;
        $this->destinationPath=$destinationPath;
    }


    //判断文件大小,并返回
    function is_size(){
        $f_size=$this->file->getClientSize();
        if($f_size <= $this->filesize){
            return $f_size;
        }else{
            return false;
        }
    } //end

    //判断文件类型，返回扩展名
    function is_type(){
        $f_ext=$this->file->getClientOriginalExtension();
        $type = array('jpg', 'gif', 'bmp', 'jpeg', 'png'); //限制上传的类型
        if(!in_array($f_ext,$type)){
            return 0;
        }else{
            return $f_ext;
        }
    }

    //判断文件夹是否存在，并创建
    function is_dirs(){
        if($this->destinationPath){
            if(!is_dir($this->destinationPath)){
                mkdir($this->destinationPath);
            }
            return $this->destinationPath;
        }else{
            $morenPath=base_path().'public/data/'.date("Ymd").'/';
            if(!is_dir($morenPath)){
                mkdir($morenPath);
            }
            return $morenPath;
        }
    }


    //文件名的定义，不定义而使用时间戳
    function is_name(){
        if($this->filename){
            $fn=$this->filename.'.'.$this->is_type();
        }else{
            $fn=time() . '_' . $this->random(3).'.'.$this->is_type();
        }
//        return $this->is_dirs()."/".$fn;
        return $fn;
    }

    //终止函数
    function f_over($n){
        echo $n;
        exit();
    }

    //上传文件
    function f_mv(){
        if($this->file->isValid()){
            $this->is_size()?null:$this->f_over("文件超过大小");
            $this->is_type()?null:$this->f_over("文件类型不正确");
            $destination=$this->destinationPath;
            $imageurl=$this->is_name();
            $this->file->move($destination, $imageurl);
            return $imageurl;
        }else{
            return 0;
        }

    }
    //产生随机数
    function random($length) {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($chars) - 1;
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

}
