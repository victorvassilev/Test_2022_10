<?php

declare(strict_types=1);

/**
 * Main class to run the application.
 * This class is used to run the application and to execute the commands, methods and actions. The base purpose of this
 * class is to get winner and winner price from auction(s).
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class Main
{
    /**
     * Data path.
     * This is the path where the data auction files are located.
     *
     * @var string
     */
    public const DATA_PATH = 'data';


    /**
     * Array of script arguments.
     * This property contain array of all arguments passed to the script.
     *
     * @var array
     */
    private array $args;

    /**
     * Array of source auctions files.
     * This property contain array of auction source files to be processed.
     *
     * @var array
     */
    private array $files = [];

    /**
     * Collection of auctions.
     * This property contain collection of loaded auctions and ready to be processed.
     *
     * @var array<Auction>
     */
    private array $collection = [];


    /**
     * Base constructor.
     * This method is used on class initialization to set the arguments and properties.
     *
     * @param array $args - Cli arguments
     * @throws Exception
     */
    public function __construct(array $args = [])
    {
        $this->args = $args;
        $this->init();
    }

    /**
     * Initialize the class.
     * This method is used to initialize, setup class and define the auction source data files to be used.
     *
     * @return void
     *
     * @throws Exception
     */
    public function init(): void
    {
        if (!array_key_exists(1, $this->args)) {
            $this->files = Helper::loadPaths(sprintf('%s/%s', __DIR__, self::DATA_PATH));

            return;
        } elseif (file_exists($this->args[1])) {
            $this->files = [$this->args[1]];

            return;
        }

        throw new Exception(sprintf('File "%s" not found', $this->args[1]));
    }

    /**
     * Main run method to get winner and winner price.
     * This method is used as main method to run the application and to get the winner and winner price from auction(s).
     * Method will load auctions, decode them and process them.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function run(): void
    {
        /** Load and decode all auction data. */
        foreach($this->files as $file) {
            $content = Helper::readFile($file);
            $this->collection[] = Helper::processClass(Auction::class, $content);
        }

        /** Process auctions collection for winner and winner prices. */
        /** @var Auction $auction */
        foreach ($this->collection as $auction) {
            /** Define default/initial winner and winner price. */
            /** @var Bid|null $winner */
            $winner   = null;
            $winPrice = 0.0;

            foreach ($auction->getActiveBids() as $bid) {
                /** In case when winner is null(just defined) update values. */
                if (is_null($winner)) {
                    $winner = $bid;
                    $winPrice = $bid->getValue();

                    continue;
                }

                /** If new bid price is lower, skip this bid. */
                if ($bid->getValue() <= $winner->getValue()) {
                    continue;
                }

                /** Update winner price only in case when users are not the same. */
                if ($bid->getUser() !== $winner->getUser()) {
                    $winPrice = $winner->getValue();
                }
                $winner = $bid;
            }

            if (is_null($winner)) {
                printf("No Winner [Auction Id: %d]\n", $auction->getId());
                continue;
            }

            printf("Winner %s with price %s [Auction Id: %d]\n", $winner->getUser(), $winPrice, $auction->getId());
        }
    }
}
