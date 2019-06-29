<?php

namespace App\Services;

class ImageService
{
    /**
     * Lấy tên ảnh
     *
     */
    public function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
     * Lấy đuôi ảnh
     *
     */
    public function getFileType($file)
    {
        return $file->getMimeType();
    }

    /**
     * Lấy size ảnh
     *
     */
    public function getSizeImage($file)
    {
        return $file->getSize();
    }

    /**
     * kiểm tra hợp lệ ảnh
     * @return 1 là ảnh hợp lệ
     * @return 0 là ảnh quá lớn
     * @return -1 không phải là hình
     */
    public function checkFile($file)
    {
        $size = $this->getSizeImage($file);
        $type = $this->getFileType($file);
        $img_type  = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
        if (in_array($type, $img_type)) {
            if ($size <= 1048576) {
                return 1;
            } else {
                return 0;
            }
        }
        return -1;
    }

    /**
     * di chuyển ảnh vào thư mục
     * @return 0 nếu file ko hợp lệ
     * @return $filename nếu đã upload thành công
     */
    public function moveImage($path, $file)
    {
        $filename = $this->getFileName($file);
        if ($this->checkFile($file) == 1) {
            $filename = date('D-mm-yyyy'). rand() . utf8tourl($filename);
            if ($file->move($path, $filename)){
                return $filename;
            }
        }
        return 0;
    }

    /**
     * xóa ảnh củ khỏi thư mục
     * @return 0 nếu file ko hợp lệ
     * @return $filename nếu đã upload thành công
     */
    public function deleteImage($path = "img/upload/product/", $filename)
    {
        if (File::exists($path, $filename)) {
            unlink($path, $filename);
        }
    }


}