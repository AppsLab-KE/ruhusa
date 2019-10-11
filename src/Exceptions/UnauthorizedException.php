<?php


namespace AppsLab\Acl\Exceptions;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    public static function unauthorizedTo($message)
    {
        return new static(Response::HTTP_FORBIDDEN, $message, null, []);
    }
}