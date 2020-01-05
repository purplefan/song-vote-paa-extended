<?php

namespace App\Domain\Entity;

use App\Domain\Exception\ScoreOutOfBoundsException;

class Song
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var float|null
     */
    private ?float $score;

    /**
     * @var int
     */
    private int $songId;

    /**
     * @var int
     */
    private int $votesCount = 0;

    /**
     * @var string
     */
    private string $songDetails;

    /**
     * @param int $songId
     * @param string $songDetails
     */
    public function __construct(int $songId, string $songDetails)
    {
        $this->songId = $songId;
        $this->songDetails = $songDetails;
    }

    public function score(): ?float
    {
        return $this->score;
    }

    public function songId(): int
    {
        return $this->songId;
    }

    public function songDetails(): string
    {
        return $this->songDetails;
    }

    public function vote(int $score)
    {
        if ($score < 1 || $score > 10) {
            throw new ScoreOutOfBoundsException();
        }
        if (is_null($this->score)) {
            $this->score = $score;
        } else {
            //calculate average:
            $currentCount = $this->votesCount;
            $this->score = ($this->score * $currentCount + $score) / ($currentCount +1);
        }
        $this->votesCount++;
    }
}
