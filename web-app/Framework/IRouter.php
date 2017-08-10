<?php

namespace m2i\Framework;

interface IRouter
{
    /**
     * @return string
     */
    public function getControllerName(): string;

    /**
     * @return string
     */
    public function getActionName(): string;

    /**
     * @return array
     */
    public function getActionParameters(): array;
}