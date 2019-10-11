<?php


namespace AppsLab\Acl\Exceptions;


use InvalidArgumentException;

class AlreadyExist extends InvalidArgumentException
{
    public static function exception($item)
    {
        return new static($item." already exist");
    }
}