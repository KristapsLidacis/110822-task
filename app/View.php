<?php

namespace App;

class View
{
    private string $templatePath;
    private array $data = [];

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;

    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }
}