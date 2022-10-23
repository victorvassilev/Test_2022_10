<?php

declare(strict_types=1);

/**
 * Bid auction class.
 * This class is implemented as model to represent bids data.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class Bid
{
    /**
     * User name.
     * This property contain user name value.
     *
     * @var string
     */
    private string $user;

    /**
     * Bid amount.
     * This property contain bid amount value.
     *
     * @var float
     */
    private float $value = 0.0;


    /**
     * Return user name.
     * This method is used to return user name value.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Update user name.
     * This method is used to update user name value.
     *
     * @param string $user - User name value.
     *
     * @return $this
     */
    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Return bid amount.
     * This method is used to return bid amount value.
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Update bid amount.
     * This method is used to update bid amount value.
     *
     * @param float $value - Bid amount value.
     *
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
