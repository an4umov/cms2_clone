<?php


namespace services;


interface UrlInterface
{
    public function parse($matches);
    public function create($alias);
}