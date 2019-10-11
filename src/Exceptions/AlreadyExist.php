<?php


namespace AppsLab\Acl\Exceptions;


class AlreadyExist
{
    public static function exception($item)
    {
        return new static($item." already exist");
    }
}