<?php

namespace Emodyz\Cerberus;

use Exception;
use Illuminate\Support\Collection;

class WildcardAuthorization
{
    /** @var string */
    const WILDCARD_TOKEN = '*';

    /** @var string */
    const PART_DELIMITER = '-';

    /** @var string */
    protected string $authorization;

    /** @var Collection */
    protected Collection $parts;

    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
        $this->parts = collect();

        $this->setParts();
    }

    /**
     * @param string|Wildcardauthorization $authorization
     *
     * @return bool
     */
    public function implies(Wildcardauthorization|string $authorization): bool
    {
        if (is_string($authorization)) {
            $authorization = new self($authorization);
        }

        $otherParts = $authorization->getParts();

        $i = 0;
        foreach ($otherParts as $otherPart) {
            if ($this->getParts()->count() - 1 < $i) {
                return true;
            }

            if (!$this->parts->get($i)->contains(self::WILDCARD_TOKEN)
                && !$this->containsAll($this->parts->get($i), $otherPart)) {
                return false;
            }

            $i++;
        }

        for ($i; $i < $this->parts->count(); $i++) {
            if (!$this->parts->get($i)->contains(self::WILDCARD_TOKEN)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Collection $part
     * @param Collection $otherPart
     *
     * @return bool
     */
    protected function containsAll(Collection $part, Collection $otherPart): bool
    {
        foreach ($otherPart->toArray() as $item) {
            if (!$part->contains($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Collection
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    /**
     * Sets the different parts from authorization string.
     *
     * @return void
     * @throws Exception
     */
    protected function setParts(): void
    {
        if (empty($this->authorization) || $this->authorization == null) {
            throw new Exception('Bad Authorization Formatting: ' . $this->authorization);
        }

        $this->parts->add(collect(explode(self::PART_DELIMITER, $this->authorization)));

        if ($this->parts->isEmpty()) {
            throw new Exception('Bad Authorization Formatting: ' . $this->authorization);
        }
    }
}
