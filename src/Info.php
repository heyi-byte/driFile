<?php
/*
 * @Descripttion: 
 * @Author: 荷逸
 * @email: 563428234@qq.com
 * @Date: 2021-01-21 16:49:03
 */

declare(strict_types=1);


namespace driFile\File;


class Info
{
    private $path;

    public function __construct($path = '')
    {
        $this->setPath($path);
    }

    public function setPath($path)
    {
        if ($path) {
            if (!file_exists($path)) {
                throw new \Exception('文件或目录不存在');
            } else {
                $this->path = realpath($path);
            }
        }
    }

    public function getType()
    {
        if (is_file($this->path)) {
            $fileArr = explode('\\', $this->path);
            $endPath = end($fileArr);
            $typeArr =  explode('.', $endPath);
            return end($typeArr);
        } else {
            return 'directory';
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getBaseName()
    {
        $pathInfo = pathinfo($this->path);
        return $pathInfo['basename'];
    }

    public function getFileName()
    {
        $pathInfo = pathinfo($this->path);
        return $pathInfo['filename'];
    }

    public function getExtensionName()
    {
        $pathInfo = pathinfo($this->path);
        return $pathInfo['extension'];
    }

    /**
     * @param string $type 大小类型
     * @return false|int byte大小的
     */
    public function getSize()
    {
        return $this->setSize($this->dirsize($this->path));
    }

    public function getLastMod()
    {
        return filemtime($this->path);
    }
    // 获取权限
    public function getChmod()
    {
        return substr(base_convert(@fileperms($this->path), 10, 8), -3);
    }
    // 获取所有者 只可以在linux下使用
    public function getChown()
    {
        return posix_getpwuid(fileowner($this->path));
    }
    public function dirsize($dir, $size = 0)
    {
        if (is_dir($dir)) {
            @$dh = opendir($dir);
            while ($file = @readdir($dh)) {
                if ($file != "." and $file != "..") {
                    $path = $dir . "/" . $file;
                    if (is_dir($path)) {
                        $size += $this->dirsize($path, $size);
                    } elseif (is_file($path)) {
                        $size += filesize($path);
                    }
                }
            }
            @closedir($dh);
        } else {
            $size += filesize($dir);
        }
        return $size;
    }
    public function setSize($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . $units[$i];
    }
}
