<?php

declare(strict_types=1);

use CollectionAttribute as Collection;

/**
 * Auction model class.
 * This class is implemented as model to represent auction data.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class Auction
{
    /**
     * Auction id.
     * This property contain auction identifier id value.
     *
     * @var int
     */
    private int $id = 0;

    /**
     * Auction reserve price.
     * This property contain minim price value to win the auction.
     *
     * @var float
     */
    private float $reservePrice = 0.0;

    /**
     * Auction bids.
     * This property contain collection of all bids for the auction.
     *
     * @var array<Bid>
     */
    #[Collection(Bid::class)]
    private array $bids = [];


    /**
     * Return auction id.
     * This method is used to return auction id value.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Update auction id.
     * This method is used to update auction id value.
     *
     * @param int $id - Auction identifier id value.
     *
     * return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return auction reserve price.
     * This method is used to return auction reserve price value. Reserve price is the minim price to win the auction.
     *
     * @return float
     */
    public function getReservePrice(): float
    {
        return $this->reservePrice;
    }

    /**
     * Update auction reserve price.
     * This method is used to update auction reserve price value. Reserve price is the minim price to win the auction.
     *
     * @param float $reservePrice - Auction reserve price value (min to win).
     *
     * @return $this
     */
    public function setReservePrice(float $reservePrice): self
    {
        $this->reservePrice = $reservePrice;

        return $this;
    }

    /**
     * Return array of all bids.
     * This method is used to return array of all bids.
     *
     * @return array<Bid>
     */
    public function getBids(): array
    {
        return $this->bids;
    }

    /**
     * Update array of all bids.
     * This method is used to update array of all bids.
     *
     * @param array<Bid> $bids - Array of all bids.
     *
     * @return $this
     */
    public function setBids(array $bids): self
    {
        $this->bids = $bids;

        return $this;
    }

    /**
     * Return active bids.
     * This method is used to return valid and active bids. Active and valid are bids with value more or equal to
     * reserve price.
     *
     * @return array<Bid>
     */
    public function getActiveBids(): array
    {
        return array_filter($this->bids, function(Bid $bid) {

            return $bid->getValue() >= $this->reservePrice;
        });
    }
}
