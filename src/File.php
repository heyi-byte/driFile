<?php
/*
 * @Descripttion: 
 * @Author: 荷逸
 * @email: 563428234@qq.com
 * @Date: 2021-01-21 16:49:03
 */
declare(strict_types=1);

namespace DcrPHP\File;

use Symfony\Component\Filesystem\Filesystem;

class File
{
    private $clsFilesystem;

    public function __construct()
    {
        $this->clsFilesystem = new Filesystem();
    }

    public function __call($method, $arguments)
    {
        return $this->clsFilesystem->$method(...$arguments);
    }
}