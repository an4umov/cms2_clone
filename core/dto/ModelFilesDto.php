<?php

namespace core\dto;


class ModelFilesDto
{
    public $modelId;
    public $files;

    /**
     * ModelFilesDto constructor.
     * @param $modelId
     * @param $files
     */
    public function __construct($modelId, $files)
    {
        $this->modelId = $modelId;
        $this->files = $files;
    }
}