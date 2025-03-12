<?php

namespace Overlander\General\Repository;

use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Models\Supportivepages as ModelsSupportivepages;

class SupportivePages
{
    public ModelsSupportivepages $spPage;

    public function __construct(ModelsSupportivepages $spPage)
    {
        $this->spPage = $spPage;
    }

    public function getAll()
    {
        $list = $this->spPage->all();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = $this->convertData($value);
        }
        if (empty($data)) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function convertData($spPage)
    {
        return [
            'title' => $spPage->title,
            'contents' => $spPage->contents,
            'slug' => $spPage->slug,
        ];
    }

    public function getBySlug($slug)
    {
        $data = null;
        $spPage = $this->spPage->getBySlug($slug)->first();
        if (!empty($spPage)) {
            $data = $this->convertData($spPage);
        } else {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function getById($id)
    {
        $data = null;
        $spPage = $this->spPage->getById($id)->first();
        if (!empty($spPage)) {
            $data = $this->convertData($spPage);
        } else {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }
}
