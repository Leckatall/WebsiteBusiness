<?php

namespace Core\Middleware;

class ChainedAccess implements Authoriser
{
    protected array $authorisers = [];

    public function __construct(Authoriser ...$authorisers)
    {
        $this->authorisers = $authorisers;
    }

    public function authorise(?int $id): bool
    {
        if (empty($this->authorisers)) {
            return false; // No authorisers means no access. Could raise exception here
        }
        foreach ($this->authorisers as $authoriser) {
            if(!$authoriser->authorise($id)) {
                dd($authoriser);
                return false;
            }
        }
        return true;
    }
}