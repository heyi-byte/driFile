<?php
/*
 * @Descripttion: 
 * @Author: 荷逸
 * @email: 563428234@qq.com
 * @Date: 2021-01-21 16:49:03
 */

declare(strict_types=1);


namespace DcrPHP\File;


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
        return getSize(dirsize($this->path));
    }

    public function getLastMod()
    {
        return filemtime($this->path);
    }
    // 获取权限
    function getChmod()
    {
        return substr(base_convert(@fileperms($this->path), 10, 8), -3);
    }
}
